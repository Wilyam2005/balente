<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RekomendasiController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'user_lat' => 'required|numeric',
            'user_long' => 'required|numeric',
            'max_radius' => 'required|numeric', // dalam Kilometer
        ]);

        $userId = $request->user_id;
        $userLat = $request->user_lat;
        $userLong = $request->user_long;
        $maxRadius = $request->max_radius;

        // Q&A / AUDIT LOG: Memastikan endpoint terpanggil dengan parameter yang benar
        Log::info("[SPK-AUDIT] Request diterima - User: {$userId}, Lat: {$userLat}, Lng: {$userLong}, Radius: {$maxRadius}KM");

        // Ambil Bobot Konfigurasi (Fallback Logic)
        $bobotPath = storage_path('app/public/bobot_spk.json');
        $bobot = ['jarak' => 40, 'riwayat' => 35, 'rating' => 25]; // Nilai default (fallback)
        if (file_exists($bobotPath)) {
            $bobot = json_decode(file_get_contents($bobotPath), true);
        }

        // TAHAP 1: Filter Spasial (True Haversine Formula)
        // Menggunakan rumus Haversine asli (d = 2 * r * arcsin(sqrt(hav(Δlat) + cos(lat1)*cos(lat2)*hav(Δlong))))
        // Konstanta 6371 adalah jari-jari bumi dalam KM
        $haversineSql = "(6371 * 2 * ASIN(SQRT(
                            POWER(SIN((radians(destinasi.latitude) - radians(?)) / 2), 2) +
                            COS(radians(?)) * COS(radians(destinasi.latitude)) *
                            POWER(SIN((radians(destinasi.longitude) - radians(?)) / 2), 2)
                        )))";

        // TAHAP 2: Agregasi Riwayat Interaksi
        $subQueryRiwayat = DB::table('riwayat_interaksi')
            ->select('kategori_id', DB::raw('SUM(bobot) as total_bobot'))
            ->where('user_id', $userId)
            ->whereNotNull('kategori_id')
            ->groupBy('kategori_id');

        $destinasi = DB::table('destinasi')
            ->select('destinasi.*')
            ->selectRaw("{$haversineSql} AS jarak_km", [$userLat, $userLong, $userLat])
            // Fallback Null/Empty: COALESCE mengubah null (user baru tanpa riwayat) menjadi 0
            ->selectRaw("COALESCE(riwayat.total_bobot, 0) as skor_personalisasi")
            // Join dengan kategori (opsional jika ingin mengambil nama_kategori di Flutter)
            ->leftJoin('kategori_wisata', 'kategori_wisata.id', '=', 'destinasi.kategori_id')
            ->selectRaw("kategori_wisata.nama_kategori as kategori_nama")
            ->leftJoinSub($subQueryRiwayat, 'riwayat', 'riwayat.kategori_id', '=', 'destinasi.kategori_id')
            ->having('jarak_km', '<=', $maxRadius)
            ->get();

        if ($destinasi->isEmpty()) {
            Log::info("[SPK-AUDIT] Tidak ada destinasi dalam radius {$maxRadius}KM.");
            return response()->json(['status' => 'success', 'data' => []]);
        }

        // TAHAP 3: Simple Additive Weighting (SAW)
        // Cari max/min untuk proses Normalisasi (Cost / Benefit)
        $minJarak = $destinasi->min('jarak_km') ?: 0.1; // Cost Criteria (Makin kecil makin bagus)
        $maxRiwayat = $destinasi->max('skor_personalisasi') ?: 1; // Benefit Criteria (Fallback ke 1 jika 0)
        $maxRating = 5; // Asumsi rating maksimal 5

        $logJarak = []; // Array untuk menampung hasil validasi haversine

        foreach ($destinasi as $item) {
            // Normalisasi (C1 - Cost)
            $normJarak = $minJarak / ($item->jarak_km ?: 0.1);
            
            // Normalisasi (C2 - Benefit)
            $normRiwayat = $item->skor_personalisasi / $maxRiwayat;
            
            // Normalisasi (C3 - Benefit)
            $itemRating = $item->rating ?? 4.0; // Fallback dummy jika DB belum ada field rating
            $normRating = $itemRating / $maxRating;

            // Konversi bobot persen ke desimal
            $wJarak = $bobot['jarak'] / 100;
            $wRiwayat = $bobot['riwayat'] / 100;
            $wRating = $bobot['rating'] / 100;

            // Total Nilai Preferensi (V)
            $item->skor_saw = round(($normJarak * $wJarak) + ($normRiwayat * $wRiwayat) + ($normRating * $wRating), 4);
            $item->jarak_km = round($item->jarak_km, 2);

            $logJarak[] = "{$item->nama_tempat}: {$item->jarak_km}KM";
        }

        // Q&A / AUDIT LOG: Cetak hasil kalkulasi Haversine
        Log::info("[SPK-AUDIT] Validasi Haversine Result: " . implode(" | ", $logJarak));

        // Urutkan berdasarkan Skor SAW tertinggi
        $destinasi = $destinasi->sortByDesc('skor_saw')->values();

        return response()->json([
            'status' => 'success',
            'data' => $destinasi
        ]);
    }
}

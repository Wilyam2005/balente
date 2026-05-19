<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InteractionController extends Controller
{
    public function logInteraction(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'kategori_id' => 'nullable|integer',
            'jenis_interaksi' => 'required|string'
        ]);

        $jenis = $request->jenis_interaksi;
        
        // Penentuan bobot secara otomatis berdasarkan jenis interaksi pengguna
        $bobot = 0;
        switch ($jenis) {
            case 'scan_yolo':
                $bobot = 30;
                break;
            case 'chat_nlp':
                $bobot = 20;
                break;
            case 'view_detail':
                $bobot = 10;
                break;
            default:
                $bobot = 5;
                break;
        }

        // Menyimpan aktivitas log interaksi ke dalam tabel
        DB::table('riwayat_interaksi')->insert([
            'user_id' => $request->user_id,
            'kategori_id' => $request->kategori_id,
            'jenis_interaksi' => $jenis,
            'bobot' => $bobot,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Log interaksi berhasil disimpan',
            'data' => [
                'bobot_ditambahkan' => $bobot
            ]
        ]);
    }
}

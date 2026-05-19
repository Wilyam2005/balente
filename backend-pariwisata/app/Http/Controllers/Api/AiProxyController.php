<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class AiProxyController extends Controller
{
    // Arahkan ke endpoint server microservice Python (Flask)
    private $flaskBaseUrl = 'http://127.0.0.1:5000';

    public function chat(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'message' => 'required|string',
        ]);

        // Meneruskan request JSON ke microservice Flask
        $response = Http::timeout(60)->post("{$this->flaskBaseUrl}/api/chat", [
            'message' => $request->message
        ]);

        if ($response->successful()) {
            // Pencatatan aktivitas ke RiwayatInteraksi secara otomatis (bobot: 20)
            DB::table('riwayat_interaksi')->insert([
                'user_id' => $request->user_id,
                'kategori_id' => null, // Biarkan null kecuali di-detect kategori tertentu oleh AI
                'jenis_interaksi' => 'chat_nlp',
                'bobot' => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'status' => 'success',
                'data' => $response->json()
            ]);
        }

        return response()->json(['status' => 'error', 'message' => 'Gagal terhubung ke AI Service'], 500);
    }

    public function scan(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'image' => 'required|file|image|max:5120', // Validasi file image, maks 5MB
        ]);

        $imageFile = $request->file('image');

        // Meneruskan file fisik dengan mode multipart/form-data ke microservice Flask
        $response = Http::timeout(60)
            ->attach(
                'image', 
                file_get_contents($imageFile->getRealPath()), 
                $imageFile->getClientOriginalName()
            )
            ->post("{$this->flaskBaseUrl}/api/scan-makanan");

        if ($response->successful()) {
            // Pencatatan aktivitas scan gambar ke RiwayatInteraksi (bobot: 30)
            DB::table('riwayat_interaksi')->insert([
                'user_id' => $request->user_id,
                'kategori_id' => null, // Biarkan null kecuali Flask merespons ID kategori makanan terkait
                'jenis_interaksi' => 'scan_yolo',
                'bobot' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'status' => 'success',
                'data' => $response->json()
            ]);
        }

        return response()->json(['status' => 'error', 'message' => 'Gagal memproses gambar AI Service'], 500);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Destinasi;

class DestinasiController extends Controller
{
    public function index()
    {
        $destinasi = Destinasi::with(['kategori', 'kuliner'])->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data Otoritatif Destinasi Berhasil Diambil',
            'data' => $destinasi,
        ], 200);
    }
}

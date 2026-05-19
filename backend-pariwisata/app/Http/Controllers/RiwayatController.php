<?php

namespace App\Http\Controllers;

use App\Models\RiwayatInteraksi;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $query = RiwayatInteraksi::with(['kategori']);

        if ($request->filled('jenis_interaksi')) {
            $query->where('jenis_interaksi', $request->jenis_interaksi);
        }

        $riwayats = $query->latest()->get();
        $totalInteractions = RiwayatInteraksi::count();
        $totalChat = RiwayatInteraksi::where('jenis_interaksi', 'chat_nlp')->count();
        $totalScan = RiwayatInteraksi::where('jenis_interaksi', 'scan_yolo')->count();

        return view('riwayat.index', compact('riwayats', 'totalInteractions', 'totalChat', 'totalScan'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Destinasi;
use App\Models\Kuliner;
use App\Models\RiwayatInteraksi;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDestinasi = Destinasi::count();
        $totalKuliner = Kuliner::count();
        $todayInteractions = RiwayatInteraksi::whereDate('created_at', now())->count();
        $recentActivities = RiwayatInteraksi::latest()->take(5)->get();

        return view('dashboard', compact('totalDestinasi', 'totalKuliner', 'todayInteractions', 'recentActivities'));
    }
}

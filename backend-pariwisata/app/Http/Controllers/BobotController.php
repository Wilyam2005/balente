<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BobotController extends Controller
{
    private $configFile = 'bobot_spk.json';

    public function index()
    {
        // Default values
        $bobot = [
            'jarak' => 40,
            'riwayat' => 35,
            'rating' => 25,
            'radius_km' => 10
        ];

        if (Storage::disk('local')->exists($this->configFile)) {
            $bobot = json_decode(Storage::disk('local')->get($this->configFile), true);
        }

        return view('bobot.index', compact('bobot'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'jarak' => 'required|numeric|min:0|max:100',
            'riwayat' => 'required|numeric|min:0|max:100',
            'rating' => 'required|numeric|min:0|max:100',
            'radius_km' => 'required|numeric|min:1'
        ]);

        Storage::disk('local')->put($this->configFile, json_encode($data));

        return redirect()->route('bobot.index')->with('success', 'Konfigurasi parameter dan bobot SPK berhasil diperbarui. Nilai bobot langsung efektif digunakan pada rekomendasi.');
    }
}

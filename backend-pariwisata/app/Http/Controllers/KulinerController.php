<?php

namespace App\Http\Controllers;

use App\Models\Destinasi;
use App\Models\Kuliner;
use Illuminate\Http\Request;

class KulinerController extends Controller
{
    public function index(Request $request)
    {
        $query = Kuliner::with('destinasi');

        if ($request->filled('q')) {
            $query->where('nama_makanan', 'like', '%' . $request->q . '%');
        }

        if ($request->filled('destinasi')) {
            $query->where('destinasi_id', $request->destinasi);
        }

        $kuliner = $query->get();
        $destinations = Destinasi::all();
        $foodCount = Kuliner::count();

        return view('kuliner.index', compact('kuliner', 'destinations', 'foodCount'));
    }

    public function create()
    {
        $destinations = Destinasi::all();

        return view('kuliner.create', compact('destinations'));
    }

    public function edit(Kuliner $kuliner)
    {
        $destinations = Destinasi::all();

        return view('kuliner.create', compact('kuliner', 'destinations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_makanan' => 'required|string|max:255',
            'destinasi_id' => 'required|exists:destinasis,id',
            'foto_sampel' => 'required|image|max:2048',
        ]);

        $path = $request->file('foto_sampel')->store('kuliner', 'public');

        Kuliner::create([
            'nama_makanan' => $request->nama_makanan,
            'destinasi_id' => $request->destinasi_id,
            'foto_sampel' => $path,
        ]);

        return redirect()->route('kuliner.index');
    }

    public function update(Request $request, Kuliner $kuliner)
    {
        $request->validate([
            'nama_makanan' => 'required|string|max:255',
            'destinasi_id' => 'required|exists:destinasis,id',
            'foto_sampel' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['nama_makanan', 'destinasi_id']);
        if ($request->hasFile('foto_sampel')) {
            $data['foto_sampel'] = $request->file('foto_sampel')->store('kuliner', 'public');
        }

        $kuliner->update($data);

        return redirect()->route('kuliner.index');
    }

    public function destroy(Kuliner $kuliner)
    {
        $kuliner->delete();

        return redirect()->route('kuliner.index');
    }
}

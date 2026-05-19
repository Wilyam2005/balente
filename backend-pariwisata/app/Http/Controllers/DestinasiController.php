<?php

namespace App\Http\Controllers;

use App\Models\Destinasi;
use App\Models\KategoriWisata;
use Illuminate\Http\Request;

class DestinasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Destinasi::with('kategori');

        if ($request->filled('q')) {
            $query->where('nama_tempat', 'like', '%' . $request->q . '%');
        }

        if ($request->filled('category')) {
            $query->where('kategori_id', $request->category);
        }

        $destinasi = $query->get();
        $categories = KategoriWisata::all();
        $destinasiCount = Destinasi::count();

        return view('destinasi.index', compact('destinasi', 'categories', 'destinasiCount'));
    }

    public function create()
    {
        $categories = KategoriWisata::all();

        return view('destinasi.create', compact('categories'));
    }

    public function edit(Destinasi $destinasi)
    {
        $categories = KategoriWisata::all();

        return view('destinasi.create', compact('destinasi', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori_wisatas,id',
            'nama_tempat' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'deskripsi' => 'nullable|string',
        ]);

        Destinasi::create(array_merge($request->only(['kategori_id', 'nama_tempat', 'latitude', 'longitude', 'deskripsi']), [
            'sumber_dinas' => 'Dinas Pariwisata Lombok Timur',
        ]));

        return redirect()->route('destinasi.index');
    }

    public function update(Request $request, Destinasi $destinasi)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori_wisatas,id',
            'nama_tempat' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'deskripsi' => 'nullable|string',
        ]);

        $destinasi->update($request->only(['kategori_id', 'nama_tempat', 'latitude', 'longitude', 'deskripsi']));

        return redirect()->route('destinasi.index');
    }

    public function destroy(Destinasi $destinasi)
    {
        $destinasi->delete();

        return redirect()->route('destinasi.index');
    }
}

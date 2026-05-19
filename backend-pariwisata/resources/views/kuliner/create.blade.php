@extends('layouts.app')

@section('title', isset($kuliner) ? 'Edit Kuliner' : 'Tambah Kuliner')
@section('page-title', isset($kuliner) ? 'Edit Kuliner' : 'Tambah Kuliner')
@section('page-description', 'Tambahkan kuliner lokal baru lengkap dengan foto sampel dan destinasi.')

@section('content')
<div class="grid gap-6 lg:grid-cols-3">
    <aside class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <p class="text-sm uppercase tracking-[0.3em] text-teal-700">Panduan Upload</p>
        <h2 class="mt-4 text-xl font-semibold text-slate-900">Tambahkan Kuliner Popular</h2>
        <p class="mt-3 text-sm leading-6 text-slate-500">Pastikan foto yang diunggah menampilkan makanan secara jelas dan tajam. Gunakan nama makanan sesuai istilah lokal agar pengguna mobile mudah menemukan.</p>
        <div class="mt-6 space-y-4 rounded-3xl bg-emerald-50 p-4 text-sm text-slate-700">
            <p class="font-semibold text-teal-700">Fitur:</p>
            <ul class="list-inside list-disc space-y-1">
                <li>Hubungkan kuliner dengan destinasi yang relevan.</li>
                <li>Unggah foto sampel berkualitas tinggi.</li>
                <li>Laporkan kuliner baru untuk publikasi cepat.</li>
            </ul>
        </div>
    </aside>

    <section class="lg:col-span-2 rounded-3xl bg-white p-8 shadow-sm ring-1 ring-slate-200">
        <form action="{{ isset($kuliner) ? route('kuliner.update', $kuliner) : route('kuliner.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($kuliner))
                @method('PUT')
            @endif

            <div class="grid gap-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Nama Makanan</label>
                    <input type="text" name="nama_makanan" value="{{ old('nama_makanan', $kuliner->nama_makanan ?? '') }}" placeholder="Contoh: Ayam Taliwang" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-100" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Destinasi</label>
                    <select name="destinasi_id" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-100">
                        @foreach($destinations as $destination)
                            <option value="{{ $destination->id }}" {{ isset($kuliner) && $kuliner->destinasi_id == $destination->id ? 'selected' : '' }}>{{ $destination->nama_tempat }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Foto Sampel</label>
                    <input type="file" name="foto_sampel" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none file:text-teal-700 file:rounded-full file:border-0 file:bg-teal-100" />
                    <p class="mt-2 text-xs text-slate-500">Unggah gambar makanan lokal dengan ukuran maksimal 2MB.</p>
                </div>

                @if(isset($kuliner) && $kuliner->foto_sampel)
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                        <p class="text-sm font-semibold text-slate-900">Preview Foto Saat Ini</p>
                        <img src="{{ asset('storage/' . $kuliner->foto_sampel) }}" alt="{{ $kuliner->nama_makanan }}" class="mt-4 h-44 w-full rounded-3xl object-cover" />
                    </div>
                @endif
            </div>

            <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-end">
                <a href="{{ route('kuliner.index') }}" class="inline-flex items-center justify-center rounded-3xl border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">Batal</a>
                <button type="submit" class="inline-flex items-center justify-center rounded-3xl bg-teal-600 px-6 py-3 text-sm font-semibold text-white hover:bg-teal-700">Simpan Kuliner</button>
            </div>
        </form>
    </section>
</div>
@endsection

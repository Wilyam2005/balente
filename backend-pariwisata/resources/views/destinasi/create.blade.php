@extends('layouts.app')

@section('title', isset($destinasi) ? 'Edit Destinasi' : 'Tambah Destinasi')
@section('page-title', isset($destinasi) ? 'Edit Destinasi' : 'Tambah Destinasi')
@section('page-description', 'Isi detail destinasi lengkap dengan kategori dan koordinat.')

@section('content')
<div class="grid gap-6 lg:grid-cols-3">
    <aside class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <p class="text-sm uppercase tracking-[0.3em] text-teal-700">Petunjuk</p>
        <h2 class="mt-4 text-xl font-semibold text-slate-900">Form Destinasi Lengkap</h2>
        <p class="mt-3 text-sm leading-6 text-slate-500">Isi setiap field dengan informasi akurat agar destinasi ditampilkan dengan benar di aplikasi mobile. Pastikan koordinat menggunakan format desimal.</p>
        <div class="mt-6 space-y-4 rounded-3xl bg-teal-50 p-4 text-sm text-slate-700">
            <p class="font-semibold text-teal-700">Tips:</p>
            <ul class="list-inside list-disc space-y-1">
                <li>Tuliskan nama tempat sesuai data resmi Dinas Pariwisata.</li>
                <li>Gunakan deskripsi singkat dan informatif.</li>
                <li>Periksa ulang latitude dan longitude sebelum menyimpan.</li>
            </ul>
        </div>
    </aside>

    <section class="lg:col-span-2 rounded-3xl bg-white p-8 shadow-sm ring-1 ring-slate-200">
        <form action="{{ isset($destinasi) ? route('destinasi.update', $destinasi) : route('destinasi.store') }}" method="POST">
            @csrf
            @if(isset($destinasi))
                @method('PUT')
            @endif

            <div class="grid gap-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Kategori</label>
                    <select name="kategori_id" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-100">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ isset($destinasi) && $destinasi->kategori_id == $category->id ? 'selected' : '' }}>{{ $category->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid gap-6 lg:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Nama Tempat</label>
                        <input type="text" name="nama_tempat" value="{{ old('nama_tempat', $destinasi->nama_tempat ?? '') }}" placeholder="Contoh: Pantai Tangsi" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-100" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Sumber Dinas</label>
                        <input type="text" value="Dinas Pariwisata Lombok Timur" readonly class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-100 px-4 py-3 text-sm text-slate-500 outline-none" />
                    </div>
                </div>

                <div class="grid gap-6 lg:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Latitude</label>
                        <input type="text" name="latitude" value="{{ old('latitude', $destinasi->latitude ?? '') }}" placeholder="-8.8604" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-100" />
                        <p class="mt-2 text-xs text-slate-500">Masukkan koordinat desimal, contoh -8.8604.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Longitude</label>
                        <input type="text" name="longitude" value="{{ old('longitude', $destinasi->longitude ?? '') }}" placeholder="116.5242" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-100" />
                        <p class="mt-2 text-xs text-slate-500">Masukkan koordinat desimal, contoh 116.5242.</p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Deskripsi</label>
                    <textarea name="deskripsi" rows="6" placeholder="Deskripsi singkat destinasi" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-100">{{ old('deskripsi', $destinasi->deskripsi ?? '') }}</textarea>
                </div>
            </div>

            <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-end">
                <a href="{{ route('destinasi.index') }}" class="inline-flex items-center justify-center rounded-3xl border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">Batal</a>
                <button type="submit" class="inline-flex items-center justify-center rounded-3xl bg-teal-600 px-6 py-3 text-sm font-semibold text-white hover:bg-teal-700">Simpan Destinasi</button>
            </div>
        </form>
    </section>
</div>
@endsection

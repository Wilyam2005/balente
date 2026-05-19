@extends('layouts.app')

@section('title', 'Form Kategori')
@section('page-title', isset($kategori) ? 'Edit Kategori' : 'Tambah Kategori')

@section('content')
<div class="max-w-2xl bg-white rounded-2xl card-shadow border border-slate-100 p-8">
    <form action="{{ isset($kategori) ? route('kategori.update', $kategori) : route('kategori.store') }}" method="POST" class="space-y-6">
        @csrf
        @if(isset($kategori)) @method('PUT') @endif

        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2">Nama Kategori <span class="text-rose-500">*</span></label>
            <input type="text" name="nama_kategori" required value="{{ old('nama_kategori', $kategori->nama_kategori ?? '') }}" class="input-field">
        </div>

        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi</label>
            <textarea name="deskripsi" rows="4" class="input-field resize-none">{{ old('deskripsi', $kategori->deskripsi ?? '') }}</textarea>
        </div>

        <div class="pt-6 mt-6 border-t border-slate-100 flex justify-end gap-3">
            <a href="{{ route('kategori.index') }}" class="rounded-xl border border-slate-200 px-6 py-2.5 text-sm font-bold text-slate-600 bg-white hover:bg-slate-50 transition-colors">Batal</a>
            <button type="submit" class="rounded-xl bg-indigo-600 px-8 py-2.5 text-sm font-bold text-white hover:bg-indigo-700 transition-colors shadow-sm">Simpan Data</button>
        </div>
    </form>
</div>
@endsection

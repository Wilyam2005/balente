@extends('layouts.app')

@section('title', 'Data Destinasi')
@section('page-title', 'Destinasi Pariwisata')
@section('page-description', 'Kelola informasi destinasi wisata dan koordinat spasial untuk Haversine Formula.')

@section('content')
<div class="bg-white rounded-2xl card-shadow border border-slate-100 p-6 mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-bold text-slate-800">Daftar Destinasi</h2>
            <p class="text-sm text-slate-500 font-medium">Data utama untuk perhitungan sistem rekomendasi.</p>
        </div>
        <div>
            <a href="{{ route('destinasi.create') }}" class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Destinasi
            </a>
        </div>
    </div>
</div>

<div class="card-surface rounded-2xl card-shadow border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-left text-sm whitespace-nowrap">
            <thead class="bg-blue-50/60 border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4 font-semibold text-slate-500 uppercase tracking-wider text-[11px]">Destinasi</th>
                    <th class="px-6 py-4 font-semibold text-slate-500 uppercase tracking-wider text-[11px]">Kategori</th>
                    <th class="px-6 py-4 font-semibold text-slate-500 uppercase tracking-wider text-[11px]">Koordinat (Lat, Lng)</th>
                    <th class="px-6 py-4 font-semibold text-slate-500 uppercase tracking-wider text-[11px] text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($destinasi as $item)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="h-10 w-10 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center font-bold">
                                    {{ substr($item->nama_tempat, 0, 2) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800">{{ $item->nama_tempat }}</p>
                                    <p class="text-xs text-slate-500 truncate max-w-[200px]">{{ $item->deskripsi }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-md bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700 border border-amber-100">
                                {{ $item->kategori->nama_kategori ?? 'Umum' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-xs">
                                <span class="font-semibold text-slate-500 block mb-0.5">Lat: <span class="text-slate-800">{{ $item->latitude }}</span></span>
                                <span class="font-semibold text-slate-500">Lng: <span class="text-slate-800">{{ $item->longitude }}</span></span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('destinasi.edit', $item) }}" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                                <form action="{{ route('destinasi.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                            Belum ada data destinasi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

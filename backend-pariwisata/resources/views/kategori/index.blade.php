@extends('layouts.app')

@section('title', 'Kategori Wisata')
@section('page-title', 'Kategori Wisata')
@section('page-description', 'Kelola pengelompokan jenis destinasi wisata untuk kemudahan filter.')

@section('content')
<div class="grid gap-6 xl:grid-cols-3 mb-6">
    <div class="xl:col-span-2 bg-white rounded-2xl card-shadow border border-slate-100 p-6 flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h2 class="text-lg font-bold text-slate-800">Semua Kategori</h2>
            <p class="text-sm text-slate-500 font-medium mt-1">Gunakan kategori untuk mengklasifikasi destinasi wisata.</p>
        </div>
        <form method="GET" action="{{ route('kategori.index') }}" class="flex gap-2 w-full md:w-auto">
            <div class="relative w-full md:w-64">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari..." class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-700 outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 transition-all" />
            </div>
            <button type="submit" class="rounded-xl bg-slate-800 px-5 py-2.5 text-sm font-bold text-white hover:bg-slate-900 transition-colors shrink-0">Cari</button>
        </form>
    </div>

    <div class="bg-indigo-600 rounded-2xl p-6 shadow-lg shadow-indigo-600/20 text-white relative overflow-hidden flex flex-col justify-center">
        <div class="absolute right-0 top-0 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl -translate-y-10 translate-x-10"></div>
        <p class="text-xs font-bold uppercase tracking-wider text-indigo-200 mb-1">Total Kategori</p>
        <p class="text-4xl font-extrabold">{{ $totalKategori ?? 0 }}</p>
        <a href="{{ route('kategori.create') }}" class="mt-4 inline-flex w-max items-center gap-2 bg-white text-indigo-600 px-4 py-2 rounded-lg text-sm font-bold hover:bg-indigo-50 transition-colors">
            + Kategori Baru
        </a>
    </div>
</div>

<div class="bg-white rounded-2xl card-shadow border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-left text-sm whitespace-nowrap">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4 font-semibold text-slate-500 uppercase tracking-wider text-[11px]">Kategori</th>
                    <th class="px-6 py-4 font-semibold text-slate-500 uppercase tracking-wider text-[11px]">Deskripsi</th>
                    <th class="px-6 py-4 font-semibold text-slate-500 uppercase tracking-wider text-[11px]">Jumlah Destinasi</th>
                    <th class="px-6 py-4 font-semibold text-slate-500 uppercase tracking-wider text-[11px] text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($kategori as $kat)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-800">{{ $kat->nama_kategori }}</td>
                        <td class="px-6 py-4 text-slate-500 text-wrap max-w-[250px]">{{ $kat->deskripsi ?: '-' }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 rounded-md bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-700 border border-slate-200">
                                {{ $kat->destinasi_count }} Tempat
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('kategori.edit', $kat) }}" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                                <form action="{{ route('kategori.destroy', $kat) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
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
                            Belum ada data kategori.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

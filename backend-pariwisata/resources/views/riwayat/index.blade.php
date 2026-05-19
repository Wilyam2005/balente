@extends('layouts.app')

@section('title', 'Riwayat Interaksi AI')
@section('page-title', 'Riwayat Interaksi AI')
@section('page-description', 'Pencatatan interaksi pengguna dengan Chatbot NLP dan YOLO Scanner.')

@section('content')
<div class="grid gap-6 md:grid-cols-3 mb-6">
    <div class="bg-white rounded-2xl p-6 card-shadow border border-slate-100 flex items-center gap-5">
        <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center shrink-0">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
        </div>
        <div>
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Interaksi</p>
            <p class="text-2xl font-extrabold text-slate-800 mt-1">{{ $totalInteractions ?? 0 }}</p>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl p-6 card-shadow border border-slate-100 flex items-center gap-5">
        <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-500 flex items-center justify-center shrink-0">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
        </div>
        <div>
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Chatbot NLP</p>
            <p class="text-2xl font-extrabold text-slate-800 mt-1">{{ $totalChat ?? 0 }}</p>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl p-6 card-shadow border border-slate-100 flex items-center gap-5">
        <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-500 flex items-center justify-center shrink-0">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Scanner YOLO</p>
            <p class="text-2xl font-extrabold text-slate-800 mt-1">{{ $totalScan ?? 0 }}</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl card-shadow border border-slate-100 overflow-hidden">
    <div class="p-6 border-b border-slate-100">
        <h2 class="text-lg font-bold text-slate-800">Daftar Lengkap Log Interaksi</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full text-left text-sm whitespace-nowrap">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4 font-semibold text-slate-500 uppercase tracking-wider text-[11px]">Pengguna</th>
                    <th class="px-6 py-4 font-semibold text-slate-500 uppercase tracking-wider text-[11px]">Jenis Interaksi</th>
                    <th class="px-6 py-4 font-semibold text-slate-500 uppercase tracking-wider text-[11px]">Kategori Preferensi</th>
                    <th class="px-6 py-4 font-semibold text-slate-500 uppercase tracking-wider text-[11px]">Bobot Pts</th>
                    <th class="px-6 py-4 font-semibold text-slate-500 uppercase tracking-wider text-[11px] text-right">Waktu</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($riwayats as $riwayat)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="h-8 w-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 font-bold text-xs">U{{ $riwayat->user_id }}</div>
                                <span class="font-bold text-slate-700">{{ $riwayat->user->name ?? 'User #' . $riwayat->user_id }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($riwayat->jenis_interaksi === 'chat_nlp')
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-purple-50 px-2.5 py-1 text-xs font-semibold text-purple-700 border border-purple-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span> NLP Chat
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 border border-emerald-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> YOLO Scan
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-semibold text-slate-600">{{ $riwayat->kategori->nama_kategori ?? 'Umum' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-emerald-600">+{{ $riwayat->bobot }} pts</span>
                        </td>
                        <td class="px-6 py-4 text-right text-slate-400 font-medium text-xs">
                            {{ $riwayat->created_at->format('d M Y, H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">Belum ada riwayat interaksi AI.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

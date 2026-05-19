@extends('layouts.app')

@section('title', 'Konfigurasi SPK')
@section('page-title', 'Konfigurasi Bobot SPK')
@section('page-description', 'Atur preferensi perhitungan Multi-Criteria Decision Making (SAW & Haversine).')

@section('content')
<div class="grid gap-6 xl:grid-cols-3">
    <!-- Form Konfigurasi -->
    <div class="xl:col-span-2">
        @if(session('success'))
        <div class="mb-6 rounded-xl bg-green-50 p-4 border border-green-200 text-green-700 font-bold flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
        @endif

        <div class="bg-white rounded-2xl card-shadow border border-slate-100 p-8">
            <form action="{{ route('bobot.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-8">
                    <h3 class="text-lg font-bold text-slate-800 mb-1">Simple Additive Weighting (SAW)</h3>
                    <p class="text-sm text-slate-500 mb-6 font-medium">Tentukan bobot kriteria persentase (total ideal: 100%).</p>
                    
                    <div class="grid gap-6 md:grid-cols-3">
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Jarak Lokasi (C1)</label>
                            <div class="relative">
                                <input type="number" name="jarak" value="{{ $bobot['jarak'] ?? 40 }}" class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-slate-800 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 font-bold text-lg">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">%</span>
                            </div>
                        </div>
                        
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Riwayat Interaksi (C2)</label>
                            <div class="relative">
                                <input type="number" name="riwayat" value="{{ $bobot['riwayat'] ?? 35 }}" class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-slate-800 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 font-bold text-lg">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">%</span>
                            </div>
                        </div>

                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Rating Publik (C3)</label>
                            <div class="relative">
                                <input type="number" name="rating" value="{{ $bobot['rating'] ?? 25 }}" class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-slate-800 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 font-bold text-lg">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 mb-8">
                    <h3 class="text-lg font-bold text-slate-800 mb-1">Filter Spasial (Haversine)</h3>
                    <p class="text-sm text-slate-500 mb-4 font-medium">Batas maksimal rekomendasi destinasi dari posisi pengguna.</p>
                    
                    <div class="max-w-xs">
                        <div class="relative">
                            <input type="number" name="radius_km" value="{{ $bobot['radius_km'] ?? 10 }}" class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-slate-800 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 font-bold text-lg pr-16">
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">KM</span>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="rounded-xl bg-indigo-600 px-8 py-3 text-sm font-bold text-white hover:bg-indigo-700 transition-colors shadow-sm">Simpan Konfigurasi</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Info Card -->
    <div class="bg-gradient-to-br from-indigo-600 to-blue-700 rounded-2xl p-8 text-white relative overflow-hidden shadow-lg h-max">
        <div class="absolute right-0 top-0 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl -translate-y-10 translate-x-10"></div>
        <div class="absolute left-0 bottom-0 w-32 h-32 bg-blue-400 opacity-20 rounded-full blur-2xl translate-y-10 -translate-x-10"></div>
        
        <h3 class="text-xl font-bold mb-6 relative z-10 flex items-center gap-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Panduan Variabel
        </h3>
        
        <div class="space-y-6 relative z-10 text-sm text-indigo-100">
            <div>
                <p class="font-bold text-white text-base mb-1">C1: Jarak Lokasi (Cost)</p>
                <p>Prioritas kedekatan lokasi. Sistem memprioritaskan jarak terdekat menggunakan rumus Haversine.</p>
            </div>
            
            <div class="h-px bg-indigo-500/50"></div>
            
            <div>
                <p class="font-bold text-white text-base mb-1">C2: Riwayat Interaksi (Benefit)</p>
                <p>Tingkat personalisasi preferensi pengguna yang dicatat saat mereka berinteraksi dengan NLP/YOLO.</p>
            </div>
            
            <div class="h-px bg-indigo-500/50"></div>
            
            <div>
                <p class="font-bold text-white text-base mb-1">C3: Rating Publik (Benefit)</p>
                <p>Rating umum dari database untuk menjaga objektivitas kualitas destinasi.</p>
            </div>
        </div>

        <div class="mt-8 p-4 rounded-xl bg-white/10 border border-white/20 relative z-10 text-xs font-medium">
            Perubahan bobot secara langsung (real-time) diaplikasikan ke algoritma Mobile App pengguna.
        </div>
    </div>
</div>
@endsection

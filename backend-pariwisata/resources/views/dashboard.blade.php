@extends('layouts.app')

@section('title', 'Dashboard | Admin SPK')
@section('page-title', 'Overview Dashboard')
@section('page-description', 'Pantau aktivitas sistem, destinasi, dan performa AI hari ini.')

@section('content')
<!-- Banner Profesional -->
<div class="mb-8 rounded-2xl bg-gradient-to-r from-amber-600 to-orange-500 p-8 shadow-lg shadow-amber-600/30 relative overflow-hidden flex flex-col md:flex-row justify-between items-center gap-6" style="background: linear-gradient(135deg, #d97706 0%, #ea580c 100%);">
    <div class="absolute right-0 top-0 w-96 h-96 bg-white opacity-10 rounded-full blur-3xl -translate-y-20 translate-x-20"></div>
    <div class="absolute left-0 bottom-0 w-64 h-64 bg-amber-400 opacity-20 rounded-full blur-2xl translate-y-10 -translate-x-10"></div>
    
    <div class="relative z-10 text-white">
        <h2 class="text-2xl lg:text-3xl font-bold tracking-tight mb-2 text-white" style="color: white; text-shadow: 0 1px 2px rgba(0,0,0,0.1);">Pantau Ekosistem Pariwisata Anda!</h2>
        <p class="font-medium max-w-xl text-sm lg:text-base text-amber-50" style="color: #fef3c7;">Dapatkan insight mendalam dari penggunaan SPK dan Chatbot AI yang terintegrasi. Semua data divisualisasikan dengan rapi dan real-time.</p>
    </div>
    
    <div class="relative z-10 shrink-0">
        <a href="{{ route('destinasi.create') }}" class="btn-primary">
            <svg class="w-4 h-4 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Destinasi
        </a>
    </div>
</div>

<!-- Statistik Cards (Clean & Colorful Badges) -->
<div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
    <!-- Card 1 -->
    <div class="bg-white rounded-2xl p-6 card-shadow border border-slate-100 flex items-center gap-5 hover:-translate-y-1 transition-transform">
        <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-500 flex items-center justify-center shrink-0">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <p class="text-sm font-semibold text-slate-500">Destinasi Aktif</p>
            <p class="text-2xl font-bold text-slate-800">{{ $totalDestinasi ?? 24 }}</p>
        </div>
    </div>

    <!-- Card 2 -->
    <div class="bg-white rounded-2xl p-6 card-shadow border border-slate-100 flex items-center gap-5 hover:-translate-y-1 transition-transform">
        <div class="w-14 h-14 rounded-2xl bg-orange-50 text-orange-500 flex items-center justify-center shrink-0">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z"></path></svg>
        </div>
        <div>
            <p class="text-sm font-semibold text-slate-500">Data Kuliner</p>
            <p class="text-2xl font-bold text-slate-800">{{ $totalKuliner ?? 45 }}</p>
        </div>
    </div>

    <!-- Card 3 -->
    <div class="bg-white rounded-2xl p-6 card-shadow border border-slate-100 flex items-center gap-5 hover:-translate-y-1 transition-transform">
        <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-500 flex items-center justify-center shrink-0">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
        </div>
        <div>
            <p class="text-sm font-semibold text-slate-500">Log Interaksi AI</p>
            <p class="text-2xl font-bold text-slate-800">{{ $todayInteractions ?? 138 }}</p>
        </div>
    </div>
    
    <!-- Card 4 -->
    <div class="bg-white rounded-2xl p-6 card-shadow border border-slate-100 flex items-center gap-5 hover:-translate-y-1 transition-transform">
        <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-500 flex items-center justify-center shrink-0">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
        </div>
        <div>
            <p class="text-sm font-semibold text-slate-500">Akurasi SPK</p>
            <p class="text-2xl font-bold text-slate-800">94<span class="text-lg text-slate-400">%</span></p>
        </div>
    </div>
</div>

<div class="grid gap-6 lg:grid-cols-3">
    <!-- Chart Section -->
    <div class="lg:col-span-2 bg-white rounded-2xl card-shadow border border-slate-100 p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-bold text-slate-800">Grafik Penggunaan AI & SPK</h2>
            <select class="bg-slate-50 border border-slate-200 text-sm font-semibold text-slate-600 rounded-lg py-2 pl-3 pr-8 focus:ring-2 focus:ring-indigo-500 outline-none">
                <option>Minggu Ini</option>
                <option>Bulan Ini</option>
            </select>
        </div>
        <div class="relative h-80 w-full">
            <canvas id="interactionChart"></canvas>
        </div>
    </div>

    <!-- Sistem SPK Overview -->
    <div class="bg-white rounded-2xl card-shadow border border-slate-100 p-6 flex flex-col">
        <h2 class="text-lg font-bold text-slate-800 mb-6">Konfigurasi Sistem</h2>
        
        <div class="space-y-4 flex-1">
            <div class="flex items-center justify-between p-4 rounded-xl border border-slate-100 hover:border-blue-200 bg-slate-50/50">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">🗺️</div>
                    <div>
                        <p class="font-bold text-sm text-slate-700">Filter Haversine</p>
                        <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Radius Aktif</p>
                    </div>
                </div>
                <span class="px-2.5 py-1 bg-green-100 text-green-700 rounded-md text-[10px] font-bold">ON</span>
            </div>
            
            <div class="flex items-center justify-between p-4 rounded-xl border border-slate-100 hover:border-orange-200 bg-slate-50/50">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center">⚖️</div>
                    <div>
                        <p class="font-bold text-sm text-slate-700">SAW Weighting</p>
                        <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Pembobotan</p>
                    </div>
                </div>
                <span class="px-2.5 py-1 bg-green-100 text-green-700 rounded-md text-[10px] font-bold">ON</span>
            </div>

            <div class="flex items-center justify-between p-4 rounded-xl border border-slate-100 hover:border-purple-200 bg-slate-50/50">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center">🤖</div>
                    <div>
                        <p class="font-bold text-sm text-slate-700">Flask AI Server</p>
                        <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">YOLO & NLP</p>
                    </div>
                </div>
                <span class="px-2.5 py-1 bg-amber-100 text-amber-700 rounded-md text-[10px] font-bold">STANDBY</span>
            </div>
        </div>

        <a href="{{ route('bobot.index') }}" class="mt-6 w-full py-3 bg-amber-50 hover:bg-amber-100 text-amber-700 font-bold text-sm rounded-xl text-center transition-colors">
            Sesuaikan Parameter SPK
        </a>
    </div>
</div>

<!-- Table Preview -->
<div class="mt-6 bg-white rounded-2xl card-shadow border border-slate-100 p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-lg font-bold text-slate-800">Log Aktivitas Terbaru</h2>
        <a href="{{ route('riwayat.index') }}" class="text-sm font-semibold text-amber-600 hover:text-amber-700">Lihat Semua &rarr;</a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full text-left text-sm whitespace-nowrap">
            <thead class="border-b border-slate-100 text-slate-500">
                <tr>
                    <th class="px-4 py-3 font-semibold">User</th>
                    <th class="px-4 py-3 font-semibold">Jenis Interaksi</th>
                    <th class="px-4 py-3 font-semibold">Perubahan Bobot</th>
                    <th class="px-4 py-3 font-semibold text-right">Waktu</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($recentActivities ?? [] as $activity)
                    <tr class="hover:bg-slate-50/50">
                        <td class="px-4 py-4 font-semibold text-slate-700 flex items-center gap-3">
                            <span class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 text-xs">U{{ $activity->user_id }}</span>
                            User #{{ $activity->user_id }}
                        </td>
                        <td class="px-4 py-4">
                            @if($activity->jenis_interaksi === 'chat_nlp')
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-purple-50 px-2.5 py-1 text-xs font-semibold text-purple-700 border border-purple-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span> NLP
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 border border-emerald-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> YOLO
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-4 text-emerald-600 font-bold">+{{ $activity->bobot ?? 10 }} pts</td>
                        <td class="px-4 py-4 text-right text-slate-400 text-xs">{{ isset($activity->created_at) ? $activity->created_at->diffForHumans() : 'Baru saja' }}</td>
                    </tr>
                @empty
                    <tr class="hover:bg-slate-50/50">
                        <td class="px-4 py-4 font-semibold text-slate-700 flex items-center gap-3"><span class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 text-xs">U8</span>User #8</td>
                        <td class="px-4 py-4"><span class="inline-flex items-center gap-1.5 rounded-full bg-purple-50 px-2.5 py-1 text-xs font-semibold text-purple-700 border border-purple-100"><span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span> Chatbot NLP</span></td>
                        <td class="px-4 py-4 text-emerald-600 font-bold">+20 pts</td>
                        <td class="px-4 py-4 text-right text-slate-400 text-xs">10 menit lalu</td>
                    </tr>
                    <tr class="hover:bg-slate-50/50">
                        <td class="px-4 py-4 font-semibold text-slate-700 flex items-center gap-3"><span class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 text-xs">U1</span>User #1</td>
                        <td class="px-4 py-4"><span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 border border-emerald-100"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Visual YOLO</span></td>
                        <td class="px-4 py-4 text-emerald-600 font-bold">+35 pts</td>
                        <td class="px-4 py-4 text-right text-slate-400 text-xs">45 menit lalu</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('interactionChart').getContext('2d');
        
        const gradBlue = ctx.createLinearGradient(0, 0, 0, 300);
        gradBlue.addColorStop(0, 'rgba(79, 70, 229, 0.2)'); 
        gradBlue.addColorStop(1, 'rgba(79, 70, 229, 0.0)');
        
        const gradTeal = ctx.createLinearGradient(0, 0, 0, 300);
        gradTeal.addColorStop(0, 'rgba(16, 185, 129, 0.2)'); 
        gradTeal.addColorStop(1, 'rgba(16, 185, 129, 0.0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                datasets: [
                    {
                        label: 'Chatbot NLP',
                        data: [12, 19, 15, 25, 22, 30, 28],
                        borderColor: '#d97706', 
                        backgroundColor: gradBlue,
                        borderWidth: 3,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#d97706',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Scan YOLO',
                        data: [8, 15, 12, 18, 16, 24, 20],
                        borderColor: '#10b981', 
                        backgroundColor: gradTeal,
                        borderWidth: 3,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#10b981',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'end',
                        labels: {
                            usePointStyle: true,
                            boxWidth: 8,
                            padding: 20,
                            font: { family: "'Plus Jakarta Sans', sans-serif", size: 12, weight: '600' }
                        }
                    },
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: "'Plus Jakarta Sans', sans-serif" } }
                    },
                    y: {
                        border: { display: false },
                        grid: { color: '#f1f5f9' },
                        ticks: { font: { family: "'Plus Jakarta Sans', sans-serif" }, stepSize: 10 }
                    }
                },
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
            }
        });
    });
</script>
@endsection

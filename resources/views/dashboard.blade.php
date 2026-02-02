@extends('layouts.master')

@section('title', 'Investor Dashboard - Castle Royal Agro')

@section('content')
<div class="flex min-h-screen bg-gray-100 font-sans relative">
    
    {{-- Mobile Sidebar Overlay --}}
    <div id="mobile-sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden" onclick="toggleDashboardSidebar()"></div>

    {{-- Sidebar --}}
    <aside id="dashboard-sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-stone-900 text-gray-300 flex flex-col transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out md:relative md:flex">
        <div class="h-20 flex items-center px-8 border-b border-stone-800">
            <span class="text-xl font-black text-white tracking-tight">CRA<span class="text-ghana-gold">.Invest</span></span>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="#" class="flex items-center px-4 py-3 bg-moringa-leaf text-white rounded-lg transition shadow-md">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Dashboard
            </a>
            <a href="#" class="flex items-center px-4 py-3 hover:bg-stone-800 hover:text-white rounded-lg transition">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                My Portfolio
            </a>
            <a href="#" class="flex items-center px-4 py-3 hover:bg-stone-800 hover:text-white rounded-lg transition">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                Transaction History
            </a>
            <a href="#" class="flex items-center px-4 py-3 hover:bg-stone-800 hover:text-white rounded-lg transition">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                Documents
            </a>
        </nav>

        <div class="p-4 border-t border-stone-800">
            <div class="flex items-center">
                <img class="h-10 w-10 rounded-full border border-stone-700" src="https://ui-avatars.com/api/?name=Kofi+Mensah&background=FFD700&color=5D4037" alt="Kofi">
                <div class="ml-3">
                    <p class="text-sm font-medium text-white">Kofi Mensah</p>
                    <p class="text-xs text-gray-500">View Profile</p>
                </div>
            </div>
        </div>
    </aside>

    {{-- Main Content --}}
    <main class="flex-1 flex flex-col">
        {{-- Top Bar --}}
        <header class="h-20 bg-white shadow-sm flex items-center justify-between px-4 md:px-8 z-10 sticky top-0">
            <div class="flex items-center">
                <button onclick="toggleDashboardSidebar()" class="md:hidden mr-4 text-gray-500 hover:text-moringa-leaf focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div>
                    <h2 class="text-xl md:text-2xl font-bold text-gray-800">Welcome, Kofi</h2>
                    <span class="text-[10px] md:text-xs font-bold text-ghana-gold bg-stone-800 px-2 py-0.5 rounded uppercase tracking-wider block md:inline-block">Gold Tier Investor</span>
                </div>
            </div>
            <div class="flex items-center space-x-2 md:space-x-4">
                 <button class="p-2 text-gray-400 hover:text-moringa-leaf transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                 </button>
                 <a href="{{ url('/') }}" class="text-sm font-bold text-red-500 hover:text-red-700">Logout</a>
            </div>
        </header>

        {{-- Scrollable Content --}}
        <div class="flex-1 overflow-y-auto p-8">
            
            {{-- Row 1: Financial Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                {{-- Card 1 --}}
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-gray-500 text-sm font-bold uppercase">Total Invested</h3>
                        <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                    </div>
                    <div class="flex items-baseline">
                        <span class="text-3xl font-black text-gray-900">GHS 50,000</span>
                    </div>
                    <p class="text-sm text-gray-400 mt-2">Initial Capital</p>
                </div>

                {{-- Card 2 --}}
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-gray-500 text-sm font-bold uppercase">Current Value</h3>
                        <div class="p-2 bg-green-50 text-moringa-leaf rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        </div>
                    </div>
                    <div class="flex items-baseline">
                        <span class="text-3xl font-black text-gray-900">GHS 62,400</span>
                        <span class="ml-3 text-sm font-bold text-green-600 bg-green-50 px-2 py-0.5 rounded-full">+24.8%</span>
                    </div>
                    <p class="text-sm text-gray-400 mt-2">Updated Today</p>
                </div>

                {{-- Card 3 --}}
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-gray-500 text-sm font-bold uppercase">Next Dividend</h3>
                        <div class="p-2 bg-yellow-50 text-yellow-600 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    <div class="flex items-baseline">
                        <span class="text-3xl font-black text-gray-900">GHS 3,200</span>
                    </div>
                    <p class="text-sm text-gray-400 mt-2">Due: <span class="font-bold text-gray-600">March 30th, 2026</span></p>
                </div>
            </div>

            {{-- Row 2: Performance Chart --}}
            <div class="bg-white rounded-xl shadow-sm p-8 border border-gray-100 mb-8">
                <h3 class="text-lg font-bold text-gray-800 mb-6">Investment Growth</h3>
                <div class="w-full h-80">
                    <canvas id="roiChart"></canvas>
                </div>
            </div>

            {{-- Row 3: Recent Activity --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-50 bg-gray-50 flex flex-col md:flex-row justify-between items-start md:items-center">
                    <h3 class="text-lg font-bold text-gray-800 mb-2 md:mb-0">Recent Transactions</h3>
                    <a href="#" class="text-sm font-bold text-moringa-leaf hover:underline">View All</a>
                </div>
                <div class="overflow-x-auto">
                <table class="w-full text-left min-w-[600px]">
                    <thead>
                        <tr class="text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">
                            <th class="px-6 py-4">Transaction</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-bold text-gray-800">Dividend Payout (Q1 2026)</td>
                            <td class="px-6 py-4 text-gray-500">Jan 15, 2026</td>
                            <td class="px-6 py-4"><span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Completed</span></td>
                            <td class="px-6 py-4 text-right font-bold text-green-600">+ GHS 2,800.00</td>
                        </tr>
                        <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-bold text-gray-800">Additional Capital Injection</td>
                            <td class="px-6 py-4 text-gray-500">Dec 02, 2025</td>
                            <td class="px-6 py-4"><span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Completed</span></td>
                            <td class="px-6 py-4 text-right font-bold text-gray-800">GHS 10,000.00</td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-bold text-gray-800">Dividend Payout (Q4 2025)</td>
                            <td class="px-6 py-4 text-gray-500">Oct 15, 2025</td>
                            <td class="px-6 py-4"><span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Completed</span></td>
                            <td class="px-6 py-4 text-right font-bold text-green-600">+ GHS 2,150.00</td>
                        </tr>
                    </tbody>
                </table>
                </div>
            </div>

        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('roiChart').getContext('2d');
    const roiChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jun 2025', 'Jul 2025', 'Aug 2025', 'Sep 2025', 'Oct 2025', 'Nov 2025', 'Dec 2025', 'Jan 2026', 'Feb 2026'],
            datasets: [{
                label: 'Portfolio Value (GHS)',
                data: [40000, 42000, 43500, 44000, 48000, 50000, 55000, 58000, 62400],
                backgroundColor: 'rgba(46, 125, 50, 0.1)',
                borderColor: '#2E7D32',
                borderWidth: 3,
                pointBackgroundColor: '#FFD700',
                pointRadius: 5,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: { 
                    backgroundColor: '#1C1917',
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            return 'Value: GHS ' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: false,
                    grid: { borderDash: [4, 4], color: '#f3f4f6' },
                    ticks: {
                        callback: function(value) { return 'GHS ' + value/1000 + 'k'; }
                    }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });

    function toggleDashboardSidebar() {
        const sidebar = document.getElementById('dashboard-sidebar');
        const overlay = document.getElementById('mobile-sidebar-overlay');
        
        if (sidebar.classList.contains('-translate-x-full')) {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        } else {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }
    }
</script>
@endsection

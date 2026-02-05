<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-soil-brown leading-tight">
            {{ __('Investor Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Section 1: Welcome & Status --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8 border-t-4 border-ghana-gold">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <div>
                            <h3 class="text-2xl font-bold text-moringa-leaf">
                                Welcome back, {{ Auth::user()->name }}!
                            </h3>
                            <p class="text-gray-500 mt-1">Here is the overview of your Castle Royal portfolio.</p>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                Account Active
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section 2: Financial Stats Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                {{-- Card 1: Total Investment --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 relative">
                    <div class="absolute top-0 right-0 p-4 opacity-10">
                        <svg class="w-16 h-16 text-soil-brown" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Invested</p>
                    <p class="text-3xl font-bold text-soil-brown mt-2">GH₵ 0.00</p>
                    <div class="mt-4">
                        <a href="#" class="text-sm text-ghana-gold hover:text-yellow-600 font-semibold flex items-center">
                            View History <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>

                {{-- Card 2: Projected ROI --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 relative">
                    <div class="absolute top-0 right-0 p-4 opacity-10">
                        <svg class="w-16 h-16 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    </div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Projected ROI (Annual)</p>
                    <p class="text-3xl font-bold text-moringa-leaf mt-2">-- %</p>
                    <p class="text-xs text-gray-400 mt-1">Based on active acres</p>
                </div>

                {{-- Card 3: Action Required --}}
                <div class="bg-soil-brown overflow-hidden shadow-sm sm:rounded-lg p-6 text-white relative">
                    <div class="absolute inset-0 bg-moringa-leaf opacity-20" style="background-image: url('{{ asset('images/backgrounds/moringa_pattern.png') }}'); background-size: 100px;"></div>
                    <div class="relative z-10">
                        <p class="text-sm font-medium text-gray-300 uppercase tracking-wider">Next Steps</p>
                        <p class="text-xl font-bold mt-2 mb-4">Complete Your Profile</p>
                        <button class="bg-ghana-gold text-soil-brown font-bold py-2 px-4 rounded shadow hover:bg-white transition duration-300 text-sm">
                            Finish Setup
                        </button>
                    </div>
                </div>
            </div>

            {{-- Section 3: Investment Packages Preview --}}
            <h3 class="text-lg font-bold text-gray-700 mb-4 ml-1">Available Opportunities</h3>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-6">
                    <div class="flex items-center justify-center h-48 bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg">
                        <div class="text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No Active Packages</h3>
                            <p class="mt-1 text-sm text-gray-500">New investment rounds will appear here.</p>
                            <div class="mt-6">
                                <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-moringa-leaf hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Contact Admin
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
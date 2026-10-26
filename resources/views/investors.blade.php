@extends('layouts.master')

@section('title', 'Holder Portal - Castle Royal Agro')

@section('content')
<div class="flex flex-col md:flex-row min-h-[calc(100vh-80px)]"> {{-- Subtract nav height --}}
    
    {{-- Left Side: Secure Login Form --}}
    <div class="md:w-1/2 bg-white flex flex-col justify-center items-center p-8 md:p-16 relative">
        {{-- Background Pattern (Subtle) --}}
        <div class="absolute inset-0 z-0 bg-repeat bg-[length:300px_300px] opacity-10" style="background-image: url('{{ asset('images/backgrounds/moringa_pattern.png') }}');"></div>
        
        <div class="w-full max-w-md relative z-10">
            <div class="mb-10 text-center md:text-left">
                <span class="inline-block py-1 px-3 bg-green-50 text-moringa-leaf text-xs font-bold tracking-widest uppercase mb-4 rounded-full border border-green-200">Secure Gateway</span>
                <h1 class="text-4xl font-black text-gray-900 mb-2">Holder Portal Access</h1>
                <p class="text-gray-500">Welcome back, Partner. Please authenticate to continue.</p>
            </div>

            <form class="space-y-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input type="email" id="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-moringa-leaf focus:border-moringa-leaf transition outline-none" placeholder="partner@example.com">
                </div>
                
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <a href="#" class="text-sm text-moringa-leaf hover:text-green-800 font-semibold">Forgot Password?</a>
                    </div>
                    <input type="password" id="password" name="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-moringa-leaf focus:border-moringa-leaf transition outline-none" placeholder="••••••••">
                </div>

                <a href="{{ url('/dashboard') }}" class="w-full bg-moringa-leaf text-white font-bold py-4 rounded-lg shadow-lg hover:bg-green-800 transition transform hover:scale-[1.02] flex justify-center items-center text-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                    Access Dashboard
                </a>
            </form>

            <div class="mt-8 text-center text-sm text-gray-500">
                Not a partner yet? <a href="{{ url('/initiative') }}" class="text-ghana-gold font-bold hover:underline">Request Access</a>
            </div>
            
            <div class="mt-12 flex items-center justify-center space-x-4 grayscale opacity-50 hover:grayscale-0 hover:opacity-100 transition duration-500">
                 <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/Google_%22G%22_logo.svg/1200px-Google_%22G%22_logo.svg.png" class="h-6 w-auto" alt="Security Partner">
                 <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/58/Uber_logo_2018.svg/2560px-Uber_logo_2018.svg.png" class="h-5 w-auto" alt="Tech Partner">
            </div>
        </div>
    </div>

    {{-- Right Side: The Value Proposition --}}
    <div class="hidden md:flex md:w-1/2 bg-stone-900 relative items-center justify-center overflow-hidden">
        {{-- Background Image --}}
        <img src="https://images.unsplash.com/photo-1553729459-efe14ef6055d?q=80" class="absolute inset-0 w-full h-full object-cover opacity-60">
        
        {{-- Overlays --}}
        <div class="absolute inset-0 bg-gradient-to-br from-black/80 via-moringa-leaf/30 to-ghana-gold/20 mix-blend-multiply"></div>
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>

        <div class="relative z-10 max-w-lg px-12 text-white">
            <h2 class="text-4xl font-black mb-6 leading-tight">Partner in the <br/><span class="text-ghana-gold">Green Revolution</span></h2>
            
            <ul class="space-y-6 text-lg">
                <li class="flex items-start">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-green-500/20 flex items-center justify-center text-green-400 mr-4 mt-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <span class="text-gray-200"><strong>Real-time ROI Tracking</strong><br/><span class="text-sm text-gray-400">Monitor your plot yields and financial growth daily.</span></span>
                </li>
                <li class="flex items-start">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-green-500/20 flex items-center justify-center text-green-400 mr-4 mt-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <span class="text-gray-200"><strong>Quarterly Impact Reports</strong><br/><span class="text-sm text-gray-400">Detailed ecological and social impact metrics.</span></span>
                </li>
                <li class="flex items-start">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-green-500/20 flex items-center justify-center text-green-400 mr-4 mt-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <span class="text-gray-200"><strong>Direct Dividend Payouts</strong><br/><span class="text-sm text-gray-400">Secure, automated transfers to your verified accounts.</span></span>
                </li>
            </ul>

            <div class="mt-12 p-6 bg-white/10 backdrop-blur-md rounded-xl border border-white/10">
                <div class="flex items-center space-x-4">
                     <div class="flex -space-x-2">
                         <img class="w-10 h-10 rounded-full border-2 border-stone-800" src="https://randomuser.me/api/portraits/men/32.jpg" alt="Partner">
                         <img class="w-10 h-10 rounded-full border-2 border-stone-800" src="https://randomuser.me/api/portraits/women/44.jpg" alt="Partner">
                         <img class="w-10 h-10 rounded-full border-2 border-stone-800" src="https://randomuser.me/api/portraits/men/85.jpg" alt="Partner">
                     </div>
                     <div class="text-sm">
                         <strong class="block text-white">Join 120+ Partners</strong>
                         <span class="text-gray-400">Funding the future of Ghana.</span>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>

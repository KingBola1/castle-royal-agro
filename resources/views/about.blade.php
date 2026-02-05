@extends('layouts.master')

@section('title', 'About The Revolution - Castle Royal Agro')

@section('content')
    {{-- Section 1: Hero Banner (Enhanced) --}}
    <section class="relative min-h-[60vh] flex items-center justify-center overflow-hidden py-20">
        {{-- Background Image with Overlay --}}
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1628194481650-3233c0994d84?q=80&w=2070&auto=format&fit=crop" 
                 alt="Moringa Farm Overview" 
                 class="w-full h-full object-cover">
            {{-- Homepage-style Gradient Overlay --}}
            <div class="absolute inset-0 bg-black/60 bg-gradient-to-b from-moringa-leaf/50 to-transparent"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10 text-center">
            <h1 class="text-4xl md:text-7xl font-bold text-white mb-6 drop-shadow-2xl tracking-tight leading-tight">
                The <span class="text-ghana-gold">Green Gold</span> Blueprint
            </h1>
            <p class="text-xl md:text-2xl text-gray-100 max-w-4xl mx-auto font-light leading-relaxed drop-shadow-md">
                We are not just farming. We are building the industrial engine that will power Ghana's 24-hour economy and employ millions.
            </p>
        </div>
    </section>

    {{-- Section 2: The Vision (Problem vs Solution) --}}
    <section class="py-24 bg-white relative overflow-hidden">
        {{-- Texture Background --}}
        <div class="absolute inset-0 z-0 bg-repeat bg-[length:400px_400px] opacity-40 mix-blend-multiply" style="background-image: url('{{ asset('images/backgrounds/moringa_pattern.png') }}');"></div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                {{-- Left: The Story --}}
                <div class="w-full lg:w-1/2 space-y-8">
                    <div class="flex items-center gap-4 text-soil-brown font-semibold uppercase tracking-widest text-sm">
                        <span class="h-px w-12 bg-ghana-gold"></span>
                        <span>Our Mission</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-bold text-moringa-leaf leading-tight">
                        Transforming Arable Land into <br/><span class="text-ghana-gold">Economic Power</span>
                    </h2>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        Ghana sits on millions of acres of fertile land, yet unemployment remains a critical challenge. The solution lies in <strong>Industrialized Agriculture</strong>.
                    </p>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        Castle Royal Agro has developed the <strong>3GR (Ghana Green Gold Revolution)</strong> framework. By focusing on <strong>Moringa Oleifera</strong>—a drought-resistant "miracle tree"—we can generate revenue in just 6 months, create sustainable jobs, and feed industries ranging from pharmaceuticals to biofuels.
                    </p>
                </div>

                {{-- Right: The Stats Grid (Refined) --}}
                <div class="w-full lg:w-1/2">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition duration-300">
                            <div class="text-4xl font-black text-ghana-gold mb-2">1.6M</div>
                            <div class="text-sm text-soil-brown font-bold uppercase tracking-wide">Jobs Target</div>
                        </div>
                        <div class="bg-gray-50 p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition duration-300">
                            <div class="text-4xl font-black text-moringa-leaf mb-2">$40B</div>
                            <div class="text-sm text-soil-brown font-bold uppercase tracking-wide">Market Potential</div>
                        </div>
                        <div class="bg-gray-50 p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition duration-300">
                            <div class="text-4xl font-black text-soil-brown mb-2">11+</div>
                            <div class="text-sm text-soil-brown font-bold uppercase tracking-wide">Industries Served</div>
                        </div>
                        <div class="bg-gray-50 p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition duration-300">
                            <div class="text-4xl font-black text-green-600 mb-2">24/7</div>
                            <div class="text-sm text-soil-brown font-bold uppercase tracking-wide">Production Cycle</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Section 3: The Industrial Process --}}
    <section class="py-24 bg-gray-50 relative">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-moringa-leaf mb-4">From Seed to Shelf</h2>
                <div class="w-20 h-1 bg-ghana-gold mx-auto rounded-full mb-4"></div>
                <p class="text-gray-600 max-w-2xl mx-auto text-lg">Our integrated value chain ensures quality control and maximum revenue capture.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                {{-- Step 1 --}}
                <div class="bg-white p-10 rounded-2xl shadow-sm hover:shadow-2xl transition duration-500 transform hover:-translate-y-2 group">
                    <div class="w-20 h-20 bg-ghana-gold/10 rounded-full flex items-center justify-center mx-auto mb-6 text-ghana-gold group-hover:bg-ghana-gold group-hover:text-white transition-colors duration-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-soil-brown mb-3">1. Large-Scale Cultivation</h3>
                    <p class="text-gray-500 leading-relaxed">Partnering with thousands of farmers to cultivate high-yield Moringa acres.</p>
                </div>
                {{-- Step 2 --}}
                <div class="bg-white p-10 rounded-2xl shadow-md hover:shadow-2xl transition duration-500 transform md:-translate-y-4 relative z-10 group">
                    <div class="w-20 h-20 bg-moringa-leaf/10 rounded-full flex items-center justify-center mx-auto mb-6 text-moringa-leaf group-hover:bg-moringa-leaf group-hover:text-white transition-colors duration-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-soil-brown mb-3">2. Industrial Processing</h3>
                    <p class="text-gray-500 leading-relaxed">State-of-the-art factories converting leaves into powder, oil, and biofuels.</p>
                </div>
                {{-- Step 3 --}}
                <div class="bg-white p-10 rounded-2xl shadow-sm hover:shadow-2xl transition duration-500 transform hover:-translate-y-2 group">
                    <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-6 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-soil-brown mb-3">3. Global Export</h3>
                    <p class="text-gray-500 leading-relaxed">Delivering premium organic products to international markets.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Section 4: Leadership / Team --}}
    <section class="py-24 bg-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-moringa-leaf mb-16">Executive Leadership</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                {{-- Leader 1 --}}
                <div class="group cursor-pointer">
                    <div class="h-96 w-full bg-gray-200 rounded-2xl overflow-hidden mb-6 relative shadow-lg">
                        <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&q=80" 
                             class="w-full h-full object-cover transition transform group-hover:scale-105 duration-700 filter grayscale group-hover:grayscale-0">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-6 opacity-0 group-hover:opacity-100 transition duration-300">
                             <p class="text-white text-sm">"Leading the charge for sustainable agriculture in West Africa."</p>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-soil-brown group-hover:text-ghana-gold transition-colors">Executive Chairman</h3>
                    <p class="text-gray-400 text-sm uppercase tracking-widest font-semibold mt-1">Leadership</p>
                </div>

                {{-- Leader 2 --}}
                <div class="group cursor-pointer">
                    <div class="h-96 w-full bg-gray-200 rounded-2xl overflow-hidden mb-6 relative shadow-lg">
                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&q=80" 
                             class="w-full h-full object-cover transition transform group-hover:scale-105 duration-700 filter grayscale group-hover:grayscale-0">
                         <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-6 opacity-0 group-hover:opacity-100 transition duration-300">
                             <p class="text-white text-sm">"Optimizing our supply chain for maximum efficiency."</p>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-soil-brown group-hover:text-ghana-gold transition-colors">Director of Operations</h3>
                    <p class="text-gray-400 text-sm uppercase tracking-widest font-semibold mt-1">Operations</p>
                </div>

                {{-- Leader 3 --}}
                <div class="group cursor-pointer">
                    <div class="h-96 w-full bg-gray-200 rounded-2xl overflow-hidden mb-6 relative shadow-lg">
                        <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&q=80" 
                             class="w-full h-full object-cover transition transform group-hover:scale-105 duration-700 filter grayscale group-hover:grayscale-0">
                         <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-6 opacity-0 group-hover:opacity-100 transition duration-300">
                             <p class="text-white text-sm">"Cultivating excellence in every acre."</p>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-soil-brown group-hover:text-ghana-gold transition-colors">Head of Agriculture</h3>
                    <p class="text-gray-400 text-sm uppercase tracking-widest font-semibold mt-1">Field Ops</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Section 5: CTA --}}
    <section class="py-24 bg-soil-brown text-white text-center relative overflow-hidden">
        {{-- Background Pattern --}}
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/wood-pattern.png')]"></div>
        
        <div class="container mx-auto px-4 relative z-10">
            <h2 class="text-3xl md:text-5xl font-bold mb-8">Ready to Join the Revolution?</h2>
            <p class="text-xl text-gray-300 mb-10 max-w-3xl mx-auto font-light leading-relaxed">
                Become a partner today and be part of the most significant agricultural transformation in Ghana's history.
            </p>
            <a href="{{ route('register') }}" class="inline-block bg-ghana-gold text-soil-brown font-bold py-5 px-12 rounded-full shadow-2xl hover:bg-white hover:text-moringa-leaf hover:scale-105 transition transform duration-300 uppercase tracking-wider">
                Partner With Us
            </a>
        </div>
    </section>
@endsection

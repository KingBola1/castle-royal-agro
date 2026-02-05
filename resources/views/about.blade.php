@extends('layouts.master')

@section('title', 'About The Revolution - Castle Royal Agro')

@section('content')
    {{-- Section 1: Hero Banner --}}
    <section class="relative py-32 flex items-center justify-center overflow-hidden">
        {{-- Background Image with Overlay --}}
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1628194481650-3233c0994d84?q=80&w=2070&auto=format&fit=crop" 
                 alt="Moringa Farm Overview" 
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-moringa-leaf/90 mix-blend-multiply"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10 text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 drop-shadow-lg">
                The <span class="text-ghana-gold">Green Gold</span> Blueprint
            </h1>
            <p class="text-xl text-gray-100 max-w-3xl mx-auto font-light leading-relaxed">
                We are not just farming. We are building the industrial engine that will power Ghana's 24-hour economy and employ millions.
            </p>
        </div>
    </section>

    {{-- Section 2: The Vision (Problem vs Solution) --}}
    <section class="py-24 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                {{-- Left: The Story --}}
                <div class="w-full lg:w-1/2 space-y-8">
                    <div class="flex items-center gap-4 text-soil-brown font-semibold uppercase tracking-widest text-sm">
                        <span class="h-px w-12 bg-ghana-gold"></span>
                        <span>Our Mission</span>
                    </div>
                    <h2 class="text-4xl font-bold text-moringa-leaf leading-tight">
                        Transforming Arable Land into <br/><span class="text-ghana-gold">Economic Power</span>
                    </h2>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        Ghana sits on millions of acres of fertile land, yet unemployment remains a critical challenge. The solution lies in <strong>Industrialized Agriculture</strong>.
                    </p>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        Castle Royal Agro has developed the <strong>3GR (Ghana Green Gold Revolution)</strong> framework. By focusing on <strong>Moringa Oleifera</strong>—a drought-resistant "miracle tree"—we can generate revenue in just 6 months, create sustainable jobs, and feed industries ranging from pharmaceuticals to biofuels.
                    </p>
                </div>

                {{-- Right: The Stats Grid --}}
                <div class="w-full lg:w-1/2">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-8 rounded-2xl border-l-4 border-ghana-gold">
                            <div class="text-4xl font-black text-soil-brown mb-2">1.6M</div>
                            <div class="text-sm text-gray-500 font-bold uppercase">Jobs Target</div>
                        </div>
                        <div class="bg-gray-50 p-8 rounded-2xl border-l-4 border-moringa-leaf">
                            <div class="text-4xl font-black text-soil-brown mb-2">$40B</div>
                            <div class="text-sm text-gray-500 font-bold uppercase">Market Potential</div>
                        </div>
                        <div class="bg-gray-50 p-8 rounded-2xl border-l-4 border-soil-brown">
                            <div class="text-4xl font-black text-soil-brown mb-2">11+</div>
                            <div class="text-sm text-gray-500 font-bold uppercase">Industries Served</div>
                        </div>
                        <div class="bg-gray-50 p-8 rounded-2xl border-l-4 border-green-600">
                            <div class="text-4xl font-black text-soil-brown mb-2">24/7</div>
                            <div class="text-sm text-gray-500 font-bold uppercase">Production Cycle</div>
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
                <h2 class="text-3xl font-bold text-moringa-leaf mb-4">From Seed to Shelf</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Our integrated value chain ensures quality control and maximum revenue capture.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                {{-- Step 1 --}}
                <div class="bg-white p-10 rounded-xl shadow-sm hover:shadow-xl transition duration-300">
                    <div class="w-16 h-16 bg-ghana-gold/20 rounded-full flex items-center justify-center mx-auto mb-6 text-ghana-gold">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-soil-brown mb-3">1. Large-Scale Cultivation</h3>
                    <p class="text-gray-500">Partnering with thousands of farmers to cultivate high-yield Moringa acres.</p>
                </div>
                {{-- Step 2 --}}
                <div class="bg-white p-10 rounded-xl shadow-sm hover:shadow-xl transition duration-300 relative z-10 transform md:-translate-y-4">
                    <div class="w-16 h-16 bg-moringa-leaf/20 rounded-full flex items-center justify-center mx-auto mb-6 text-moringa-leaf">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-soil-brown mb-3">2. Industrial Processing</h3>
                    <p class="text-gray-500">State-of-the-art factories converting leaves into powder, oil, and biofuels.</p>
                </div>
                {{-- Step 3 --}}
                <div class="bg-white p-10 rounded-xl shadow-sm hover:shadow-xl transition duration-300">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6 text-blue-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-soil-brown mb-3">3. Global Export</h3>
                    <p class="text-gray-500">Delivering premium organic products to international markets.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Section 4: Leadership / Team --}}
    <section class="py-24 bg-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-moringa-leaf mb-12">Executive Leadership</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                {{-- Leader 1 (CEO Placeholder) --}}
                <div class="group">
                    <div class="h-80 w-full bg-gray-200 rounded-2xl overflow-hidden mb-6 relative">
                         {{-- You can replace this src with a real team photo later --}}
                        <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&q=80" 
                             class="w-full h-full object-cover transition transform group-hover:scale-110 duration-500 filter grayscale group-hover:grayscale-0">
                    </div>
                    <h3 class="text-xl font-bold text-soil-brown">Executive Chairman</h3>
                    <p class="text-ghana-gold text-sm uppercase tracking-widest font-semibold">Leadership</p>
                </div>

                {{-- Leader 2 --}}
                <div class="group">
                    <div class="h-80 w-full bg-gray-200 rounded-2xl overflow-hidden mb-6 relative">
                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&q=80" 
                             class="w-full h-full object-cover transition transform group-hover:scale-110 duration-500 filter grayscale group-hover:grayscale-0">
                    </div>
                    <h3 class="text-xl font-bold text-soil-brown">Director of Operations</h3>
                    <p class="text-ghana-gold text-sm uppercase tracking-widest font-semibold">Operations</p>
                </div>

                {{-- Leader 3 --}}
                <div class="group">
                    <div class="h-80 w-full bg-gray-200 rounded-2xl overflow-hidden mb-6 relative">
                        <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&q=80" 
                             class="w-full h-full object-cover transition transform group-hover:scale-110 duration-500 filter grayscale group-hover:grayscale-0">
                    </div>
                    <h3 class="text-xl font-bold text-soil-brown">Head of Agriculture</h3>
                    <p class="text-ghana-gold text-sm uppercase tracking-widest font-semibold">Field Ops</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Section 5: CTA --}}
    <section class="py-20 bg-soil-brown text-white text-center">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">Ready to Join the Revolution?</h2>
            <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                Become a partner today and be part of the most significant agricultural transformation in Ghana's history.
            </p>
            <a href="{{ route('register') }}" class="inline-block bg-ghana-gold text-soil-brown font-bold py-4 px-12 rounded-full hover:bg-white hover:text-moringa-leaf transition duration-300 uppercase tracking-wider">
                Partner With Us
            </a>
        </div>
    </section>
@endsection
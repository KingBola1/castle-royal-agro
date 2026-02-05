@extends('layouts.master')

@section('title', 'Ghana Green Gold Revolution - Castle Royal Agro')

@section('content')
    {{-- Section A: Hero (The 'Wow' Factor) --}}
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden py-20" id="hero-section">
        {{-- Dynamic Background Slider --}}
        <div class="absolute inset-0 z-0 bg-moringa-leaf">
            {{-- Slide 1: Green Gold Tea --}}
            <div class="hero-slide absolute inset-0 opacity-100 transition-opacity duration-1000 ease-in-out">
                <img src="{{ asset('images/hero/slide1.png') }}" class="w-full h-full object-cover">
            </div>
            {{-- Slide 2: Tea in Cup --}}
            <div class="hero-slide absolute inset-0 opacity-0 transition-opacity duration-1000 ease-in-out">
                <img src="{{ asset('images/hero/slide2.jpg') }}" class="w-full h-full object-cover">
            </div>
            {{-- Slide 3: Animal Pellet --}}
            <div class="hero-slide absolute inset-0 opacity-0 transition-opacity duration-1000 ease-in-out">
                <img src="{{ asset('images/hero/slide3.jpg') }}" class="w-full h-full object-cover">
            </div>
            {{-- Slide 4: Animal Pellet (Livestock) --}}
            <div class="hero-slide absolute inset-0 opacity-0 transition-opacity duration-1000 ease-in-out">
                <img src="{{ asset('images/hero/slide4.png') }}" class="w-full h-full object-cover">
            </div>
            {{-- Slide 5: Product Lineup --}}
            <div class="hero-slide absolute inset-0 opacity-0 transition-opacity duration-1000 ease-in-out">
                <img src="{{ asset('images/hero/slide5.jpg') }}" class="w-full h-full object-cover">
            </div>
            {{-- Dark Overlay --}}
            <div class="absolute inset-0 bg-black/60 bg-gradient-to-b from-moringa-leaf/50 to-transparent z-10"></div>
        </div>

        {{-- Content --}}
        <div class="relative z-20 container mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-7xl font-bold text-white mb-6 drop-shadow-2xl tracking-tight leading-tight min-h-[160px] flex items-center justify-center">
                <span id="hero-text" class="transition-opacity duration-500">
                    Ghana <span class="text-ghana-gold">Green Gold</span> Revolution
                </span>
            </h1>
            <p class="text-xl md:text-2xl text-gray-200 mb-10 max-w-3xl mx-auto font-light leading-relaxed">
                Industrializing Moringa to create 1.6 Million Jobs and Power the 24-Hour Economy.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-6">
                {{-- Partner Button: Linked to Register/Investor Login --}}
                <a href="{{ route('register') }}" class="bg-ghana-gold text-soil-brown font-bold py-4 px-10 rounded-full shadow-xl hover:bg-yellow-400 hover:scale-105 transition transform duration-300 uppercase tracking-wider text-sm">
                    Partner With Us
                </a>
                {{-- Impact Button: Linked to the About/Impact Page --}}
                <a href="{{ url('/about') }}" class="bg-transparent border-2 border-white text-white font-bold py-4 px-10 rounded-full hover:bg-white hover:text-moringa-leaf hover:scale-105 transition transform duration-300 uppercase tracking-wider text-sm backdrop-blur-sm">
                    View Impact Data
                </a>
            </div>
        </div>
        
        {{-- Scroll Indicator --}}
        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce text-white/70 z-20">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
        </div>
    </section>

    {{-- Section B: The Initiative (Texture & Depth) --}}
    <section class="py-24 bg-white relative overflow-hidden">
        {{-- Subtle Texture --}}
        <div class="absolute inset-0 z-0 bg-repeat bg-[length:400px_400px] opacity-40 mix-blend-multiply" style="background-image: url('{{ asset('images/backgrounds/moringa_pattern.png') }}');"></div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="flex flex-col md:flex-row items-center gap-16">
                {{-- Left Text --}}
                <div class="w-full md:w-1/2 space-y-8">
                    <h2 class="text-4xl md:text-5xl font-bold text-moringa-leaf leading-tight">
                        Cultivating the Future of <br/><span class="text-soil-brown italic">Sustainable Industry</span>
                    </h2>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        The 3GR Initiative isn't just about farming—it's about building an ecosystem. By integrating industrial processing with large-scale cultivation, we unlock the full potential of Moringa to drive economic growth and environmental restoration.
                    </p>
                    <div class="flex items-center gap-4 text-soil-brown font-semibold">
                        <span class="h-px w-12 bg-ghana-gold"></span>
                        <span>A Castle Royal Agro Ghana</span>
                    </div>
                </div>

                {{-- Right Floating Image --}}
                <div class="w-full md:w-1/2">
                    <div class="relative group">
                        <div class="absolute inset-0 bg-ghana-gold rounded-2xl transform translate-x-3 translate-y-3 transition-transform group-hover:translate-x-4 group-hover:translate-y-4"></div>
                        <img src="{{ asset('images/sections/initiative_products.png') }}" 
                             alt="Castle Royal Agro Products" 
                             class="relative rounded-2xl shadow-2xl w-full object-cover h-[500px] transform transition-transform group-hover:-translate-y-2">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Section C: Impact Stats (Glassmorphism) --}}
    <section class="relative py-32 bg-fixed bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1518531933037-91b2f5f229cc?auto=format&fit=crop&q=80');">
        <div class="absolute inset-0 bg-black/60"></div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">The 3GR Advantage</h2>
                <div class="w-20 h-1 bg-ghana-gold mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    $stats = [
                        ['value' => '6-8', 'unit' => 'Months', 'label' => 'Time to Revenue'],
                        ['value' => '1.6M', 'unit' => 'Target Jobs', 'label' => 'Direct & Indirect'],
                        ['value' => '45k', 'unit' => 'Acres', 'label' => 'Land Restored'],
                        ['value' => '11+', 'unit' => 'Industries', 'label' => 'Powered by Moringa'],
                    ];
                @endphp

                @foreach($stats as $stat)
                    <div class="bg-white/10 backdrop-blur-md border border-white/20 p-8 rounded-2xl text-center text-white hover:bg-white/20 transition duration-300 transform hover:scale-105">
                        <div class="text-5xl font-black text-ghana-gold mb-2 drop-shadow-lg">{{ $stat['value'] }}</div>
                        <div class="text-xs font-bold uppercase tracking-widest opacity-80 mb-2">{{ $stat['unit'] }}</div>
                        <p class="text-sm font-light opacity-90">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Section D: The Impact Calculator (Professional) --}}
    <section class="py-24 bg-white relative">
        <div class="absolute inset-0 z-0 bg-repeat bg-[length:400px_400px] opacity-40 mix-blend-multiply" style="background-image: url('{{ asset('images/backgrounds/moringa_pattern.png') }}');"></div>
        <div class="container mx-auto px-4 max-w-4xl relative z-10">
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border-2 border-soil-brown/10">
                {{-- Header --}}
                <div class="bg-soil-brown text-white p-8 text-center relative overflow-hidden">
                    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/wood-pattern.png')]"></div>
                    <div class="relative z-10">
                        <h2 class="text-3xl font-bold font-serif mb-2">Calculate Your Impact</h2>
                        <p class="text-ghana-gold text-sm uppercase tracking-widest">Visualize the change you can make</p>
                    </div>
                </div>

                {{-- Calculator Body --}}
                <div class="flex flex-col lg:flex-row">
                    {{-- Input --}}
                    <div class="w-full lg:w-5/12 p-8 lg:p-10 border-b lg:border-b-0 lg:border-r border-gray-100 bg-gray-50/50">
                        <label for="acres-slider" class="block text-lg font-bold text-soil-brown mb-6">
                            Acres Sponsored
                        </label>
                        
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm text-gray-400 font-semibold">10</span>
                            <span id="acres-display" class="text-4xl font-black text-moringa-leaf">100</span>
                            <span class="text-sm text-gray-400 font-semibold">5k</span>
                        </div>

                        <input id="acres-slider" type="range" min="10" max="5000" value="100" step="10" 
                            class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-moringa-leaf hover:accent-green-700 transition-all mb-8">
                        
                        <p class="text-xs text-gray-500 leading-relaxed border-l-2 border-ghana-gold pl-3">
                            Adjust the slider to see how increasing acreage scales up job creation, revenue, and environmental impact.
                        </p>
                    </div>

                    {{-- Output --}}
                    <div class="w-full lg:w-7/12 p-8 lg:p-10 flex flex-col justify-between space-y-6">
                        @php
                            $outputs = [
                                ['id' => 'revenue-display', 'label' => 'Projected Revenue (GH₵)', 'color' => 'text-soil-brown'],
                                ['id' => 'jobs-display', 'label' => 'Jobs Created', 'color' => 'text-moringa-leaf'],
                                ['id' => 'carbon-display', 'label' => 'Carbon Offset (Tons)', 'color' => 'text-green-600'],
                            ];
                        @endphp

                        @foreach($outputs as $output)
                            <div class="flex items-center justify-between border-b border-gray-100 pb-4 last:border-0 last:pb-0 group hover:bg-gray-50 transition p-2 rounded-lg">
                                <span class="text-gray-500 font-medium uppercase text-xs tracking-wider">{{ $output['label'] }}</span>
                                <span class="text-3xl font-black {{ $output['color'] }} transition-transform group-hover:scale-110" id="{{ $output['id'] }}">0</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Calculator Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Impact Calculator Logic
            const slider = document.getElementById('acres-slider');
            const acresDisplay = document.getElementById('acres-display');
            const outputs = {
                revenue: document.getElementById('revenue-display'),
                jobs: document.getElementById('jobs-display'),
                carbon: document.getElementById('carbon-display')
            };

            const formatNumber = (num) => new Intl.NumberFormat('en-GH').format(Math.round(num));

            const calculate = () => {
                const acres = parseInt(slider.value);
                acresDisplay.textContent = formatNumber(acres);

                outputs.revenue.textContent = formatNumber(acres * 4000);
                outputs.jobs.textContent = formatNumber(acres * 1.6);
                outputs.carbon.textContent = formatNumber(acres * 6);
            };

            slider.addEventListener('input', calculate);
            calculate();

            // Hero Animation Logic
            const heroSlides = document.querySelectorAll('.hero-slide');
            const heroText = document.getElementById('hero-text');
            const textOptions = [
                'Ghana <span class="text-ghana-gold">Green Gold</span> Revolution',
                'Powering the <span class="text-ghana-gold">24-Hour</span> Economy',
                '<span class="text-ghana-gold">1.6 Million</span> Jobs Created',
                'Sustainable <span class="text-ghana-gold">Industrialization</span>'
            ];
            
            let currentSlide = 0;
            let currentText = 0;

            const nextSlide = () => {
                // Background Transition
                const next = (currentSlide + 1) % heroSlides.length;
                
                // Make next slide visible (stacked on top or same level)
                heroSlides[next].style.zIndex = '1';
                heroSlides[next].classList.replace('opacity-0', 'opacity-100');
                
                // Wait for fade in, then hide previous
                setTimeout(() => {
                    heroSlides[currentSlide].classList.replace('opacity-100', 'opacity-0');
                    heroSlides[currentSlide].style.zIndex = '0';
                    currentSlide = next;
                }, 1000); // Transitions take 1000ms, so swap after

                // Text Transition
                heroText.style.opacity = '0';
                setTimeout(() => {
                    currentText = (currentText + 1) % textOptions.length;
                    heroText.innerHTML = textOptions[currentText];
                    heroText.style.opacity = '1';
                }, 500); // Wait for fade out
            };

            setInterval(nextSlide, 5000); // Change every 5 seconds
        });
    </script>
@endsection
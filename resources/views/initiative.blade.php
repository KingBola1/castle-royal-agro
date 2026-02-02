@extends('layouts.master')

@section('title', 'The 3GR Strategy - White Paper')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Section 1: Strategic Hero (Animated) --}}
    <section class="relative py-32 bg-stone-900 text-white overflow-hidden" id="initiative-hero">
        {{-- Background Slider --}}
        <div class="absolute inset-0 z-0">
            {{-- Slide 1 --}}
            <div class="hero-slide absolute inset-0 bg-cover bg-center transition-opacity duration-2000 ease-in-out opacity-100" 
                 style="background-image: url('{{ asset('images/initiative_hero/slide1.jpg') }}');"></div>
            {{-- Slide 2 --}}
            <div class="hero-slide absolute inset-0 bg-cover bg-center transition-opacity duration-2000 ease-in-out opacity-0" 
                 style="background-image: url('{{ asset('images/initiative_hero/slide2.jpg') }}');"></div>
            {{-- Slide 3 --}}
            <div class="hero-slide absolute inset-0 bg-cover bg-center transition-opacity duration-2000 ease-in-out opacity-0" 
                 style="background-image: url('{{ asset('images/initiative_hero/slide3.jpg') }}');"></div>
        </div>

        {{-- Overlays --}}
        <div class="absolute inset-0 bg-black/60 z-0"></div>
        <div class="absolute inset-0 bg-moringa-leaf mix-blend-multiply opacity-40 z-0"></div>
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 z-0"></div>
        
        <div class="container mx-auto px-4 relative z-10 text-center max-w-5xl">
            <span class="inline-block py-1 px-3 border border-ghana-gold text-ghana-gold text-xs font-bold tracking-widest uppercase mb-4 rounded-full">Strategic Initiative</span>
            <h1 class="text-4xl md:text-6xl font-black mb-6 tracking-tight leading-none text-white drop-shadow-lg">
                The 3GR Strategy: <br/><span class="text-transparent bg-clip-text bg-gradient-to-r from-ghana-gold to-yellow-200">Beyond Agriculture</span>
            </h1>
            <p class="text-xl text-gray-100 font-light max-w-3xl mx-auto leading-relaxed drop-shadow-md">
                A comprehensive framework addressing Ghana’s tripartite crisis: <strong class="text-white block sm:inline">Youth Unemployment</strong>, <strong class="text-white block sm:inline">Environmental Degradation</strong>, and <strong class="text-white block sm:inline">Economic Instability</strong>.
            </p>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const slides = document.querySelectorAll('#initiative-hero .hero-slide');
                let currentSlide = 0;
                
                setInterval(() => {
                    // Fade out current
                    slides[currentSlide].classList.remove('opacity-100');
                    slides[currentSlide].classList.add('opacity-0');
                    
                    // Move to next
                    currentSlide = (currentSlide + 1) % slides.length;
                    
                    // Fade in next
                    slides[currentSlide].classList.remove('opacity-0');
                    slides[currentSlide].classList.add('opacity-100');
                }, 5000); // Change every 5 seconds
            });
        </script>
    </section>

    {{-- Section 2: Executive Summary (3 Pillars) --}}
    <section class="py-24 bg-white relative overflow-hidden">
        {{-- Background Pattern --}}
        <div class="absolute inset-0 bg-white z-0"></div>
        <div class="absolute inset-0 z-0 bg-repeat bg-[length:400px_400px]" style="background-image: url('{{ asset('images/backgrounds/moringa_pattern.png') }}');"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <div class="text-center mb-16">
                <h2 class="text-base text-moringa-leaf font-semibold tracking-wide uppercase">The Core Strategy</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Three Pillars of the <span class="text-ghana-gold">Green Gold Revolution</span>
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                    Click on any pillar below to explore the operational data and projected impact.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-3">

                {{-- Card 1: RESTORATION (Restored Local Image) --}}
                <div class="group relative bg-white border border-gray-200 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden min-h-[24rem] h-auto flex flex-col">
                    <div class="h-48 relative w-full">
                        {{-- YOUR CUSTOM IMAGE IS BACK HERE --}}
                        <img src="{{ asset('images/strategy_pillars/restoration.jpg') }}" 
                             alt="Restoration" 
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-moringa-leaf/60 group-hover:bg-moringa-leaf/40 transition"></div>
                        <div class="absolute bottom-4 left-4 text-white font-bold text-2xl drop-shadow-md">01. Restoration</div>
                    </div>
                    <div class="p-6 flex-grow flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Ecological Reclamation</h3>
                            <p class="text-gray-600 text-sm">Reclaiming 45,000+ acres of Galamsey-degraded lands through phytoremediation.</p>
                        </div>
                        <button onclick="window.openModal('modal-restoration')" class="mt-4 w-full py-3 px-4 bg-gray-50 text-moringa-leaf font-bold rounded-lg border border-gray-200 hover:bg-moringa-leaf hover:text-white transition flex justify-center items-center cursor-pointer">
                            View Strategic Details <span class="ml-2">→</span>
                        </button>
                    </div>
                </div>

                {{-- Card 2: EMPLOYMENT (Restored Local Image) --}}
                <div class="group relative bg-white border border-gray-200 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden min-h-[24rem] h-auto flex flex-col">
                    <div class="h-48 relative w-full">
                        {{-- YOUR CUSTOM IMAGE IS BACK HERE --}}
                        <img src="{{ asset('images/strategy_pillars/employment.jpg') }}" 
                             alt="Employment" 
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-blue-900/60 group-hover:bg-blue-900/40 transition"></div>
                        <div class="absolute bottom-4 left-4 text-white font-bold text-2xl drop-shadow-md">02. Employment</div>
                    </div>
                    <div class="p-6 flex-grow flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">The 24-Hour Economy</h3>
                            <p class="text-gray-600 text-sm">Creating 1.6 Million dignified jobs via the 3-shift operational model.</p>
                        </div>
                        <button onclick="window.openModal('modal-jobs')" class="mt-4 w-full py-3 px-4 bg-gray-50 text-blue-700 font-bold rounded-lg border border-gray-200 hover:bg-blue-700 hover:text-white transition flex justify-center items-center cursor-pointer">
                            View Job Breakdown <span class="ml-2">→</span>
                        </button>
                    </div>
                </div>

                {{-- Card 3: INDUSTRIALIZATION (Restored Local Image) --}}
                <div class="group relative bg-white border border-gray-200 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden min-h-[24rem] h-auto flex flex-col">
                    <div class="h-48 relative w-full">
                         {{-- YOUR CUSTOM IMAGE IS BACK HERE --}}
                        <img src="{{ asset('images/strategy_pillars/industrialization.jpg') }}" 
                             alt="Industrialization" 
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-ghana-gold/80 group-hover:bg-ghana-gold/60 transition"></div>
                        <div class="absolute bottom-4 left-4 text-white font-bold text-2xl drop-shadow-md">03. Industrialization</div>
                    </div>
                    <div class="p-6 flex-grow flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Agro-Processing Hubs</h3>
                            <p class="text-gray-600 text-sm">Transforming Yilo Krobo & Yendi into global export engines for 'Green Gold'.</p>
                        </div>
                        <button onclick="window.openModal('modal-industry')" class="mt-4 w-full py-3 px-4 bg-gray-50 text-yellow-700 font-bold rounded-lg border border-gray-200 hover:bg-ghana-gold hover:text-white transition flex justify-center items-center cursor-pointer">
                            View Factory Specs <span class="ml-2">→</span>
                        </button>
                    </div>
                </div>

            </div>
        </div>

        {{-- Modals --}}
        <div id="modal-restoration" class="fixed inset-0 z-[100] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity cursor-pointer" onclick="window.closeModal('modal-restoration')"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-2xl font-bold text-moringa-leaf border-b pb-4 mb-4">🌱 Deep Dive: Ecological Restoration</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <h4 class="font-bold text-gray-800">The Science</h4>
                                <p class="text-sm text-gray-600 mt-2">Moringa Oleifera is a hyper-accumulator. Its roots absorb heavy metals (Mercury, Lead) left by Galamsey, while dropping nitrogen-rich leaves that restore topsoil fertility within 2 years.</p>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800">Key Metrics</h4>
                                <ul class="list-disc list-inside text-sm text-gray-600 mt-2">
                                    <li><strong>Target Area:</strong> 45,000 Acres</li>
                                    <li><strong>Carbon Capture:</strong> 20x higher than typical forests</li>
                                    <li><strong>Water Table:</strong> Stabilized by deep taproots</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" onclick="window.closeModal('modal-restoration')" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-moringa-leaf text-base font-medium text-white hover:bg-green-800 sm:ml-3 sm:w-auto sm:text-sm">Close Analysis</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="modal-jobs" class="fixed inset-0 z-[100] hidden overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-900 bg-opacity-75 cursor-pointer" onclick="window.closeModal('modal-jobs')"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                        <h3 class="text-2xl font-bold text-blue-800 border-b pb-4 mb-4">👷 Deep Dive: The 24-Hour Economy</h3>
                        <p class="text-gray-600 mb-4">Traditional farming offers 1 shift. The 3GR model runs **three 8-hour shifts** daily, tripling employment capacity per acre.</p>
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="font-bold text-blue-900">Shift Structure Breakdown:</h4>
                            <ul class="mt-2 space-y-2 text-sm text-blue-800">
                                <li>• <strong>06:00 - 14:00:</strong> Harvesting & Farm Maintenance (Youth)</li>
                                <li>• <strong>14:00 - 22:00:</strong> Processing & Quality Control (Technical)</li>
                                <li>• <strong>22:00 - 06:00:</strong> Logistics, Packaging & Security (Logistics)</li>
                            </ul>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" onclick="window.closeModal('modal-jobs')" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-800 text-white hover:bg-blue-900 sm:ml-3 sm:w-auto sm:text-sm">Close Analysis</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="modal-industry" class="fixed inset-0 z-[100] hidden overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-900 bg-opacity-75 cursor-pointer" onclick="window.closeModal('modal-industry')"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                        <h3 class="text-2xl font-bold text-yellow-700 border-b pb-4 mb-4">🏭 Deep Dive: Industrial Hubs</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="border-r border-gray-200 pr-4">
                                <h4 class="font-bold text-gray-800">Yilo Krobo Hub</h4>
                                <p class="text-sm text-gray-600 mt-1">Focus: <strong>Leaf Processing</strong></p>
                                <p class="text-xs text-gray-500 mt-2">Equipped with solar-powered dehydration tunnels to produce export-grade Moringa powder (Ringa Brand) while retaining 95% of nutrients.</p>
                            </div>
                            <div class="pl-4">
                                <h4 class="font-bold text-gray-800">Yendi Hub</h4>
                                <p class="text-sm text-gray-600 mt-1">Focus: <strong>Seed Oil Extraction</strong></p>
                                <p class="text-xs text-gray-500 mt-2">Cold-press facilities for extracting 'Ben Oil' (Moringa Oil) for the high-value cosmetic and pharmaceutical international markets.</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" onclick="window.closeModal('modal-industry')" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-yellow-700 text-white hover:bg-yellow-800 sm:ml-3 sm:w-auto sm:text-sm">Close Analysis</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            window.openModal = function(modalId) {
                var modal = document.getElementById(modalId);
                if (modal) {
                    modal.classList.remove('hidden');
                } else {
                    console.error("Modal not found: " + modalId);
                }
            }
            
            window.closeModal = function(modalId) {
                var modal = document.getElementById(modalId);
                if (modal) {
                    modal.classList.add('hidden');
                }
            }
        </script>

    </section>

    {{-- Section 3: The Crisis (Galamsey) - MOBILE FIXED --}}
    <section class="py-24 bg-stone-100 overflow-hidden">
        <div class="container mx-auto px-4">
            {{-- Updated Layout: flex-col-reverse ensures stack on mobile, Row on Desktop --}}
            <div class="flex flex-col-reverse lg:flex-row items-center gap-8 lg:gap-16">
                <div class="w-full lg:w-1/2">
                     <span class="text-red-600 font-bold uppercase tracking-widest text-xs mb-2 block">The Challenge</span>
                    <h2 class="text-4xl font-bold text-gray-900 mb-6">The Unseen Crisis: <br/><span class="text-red-700">Environmental Collapse</span></h2>
                    <p class="text-gray-600 text-lg leading-relaxed mb-6">
                        Illegal mining (Galamsey) has stripped our topsoil, poisoned our water bodies with mercury, and left thousands of acres barren. This is not just an environmental disaster; it is a threat to national security and food sovereignty.
                    </p>
                    <div class="p-6 bg-red-50 border-l-4 border-red-600 rounded-r-lg">
                        <h4 class="font-bold text-red-900 mb-2">Impact Metrics</h4>
                        <ul class="space-y-2 text-red-800 text-sm">
                            <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 bg-red-500 rounded-full"></div> High Mercury & Turbidity Levels</li>
                            <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 bg-red-500 rounded-full"></div> Complete Topsoil Destruction</li>
                            <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 bg-red-500 rounded-full"></div> Long-term Economic Poverty</li>
                        </ul>
                    </div>
                </div>
                {{-- Updated Image Container: w-full forced on mobile --}}
                <div class="w-full lg:w-1/2 relative">
                    <div class="absolute inset-0 bg-red-900 transform translate-x-4 translate-y-4 rounded-3xl opacity-10 hidden lg:block"></div>
                    <div class="bg-gray-300 w-full h-64 md:h-[400px] rounded-3xl overflow-hidden shadow-xl relative z-10" id="crisis-carousel">
                        {{-- Slides - RESTORED YOUR CUSTOM IMAGES --}}
                        <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-100 carousel-slide" style="background-image: url('{{ asset('images/initiative_crisis/slide2.png') }}'); background-size: cover; background-position: center;"></div>
                        <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-0 carousel-slide" style="background-image: url('{{ asset('images/initiative_crisis/slide3.png') }}'); background-size: cover; background-position: center;"></div>
                        <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-0 carousel-slide" style="background-image: url('{{ asset('images/initiative_crisis/slide4.png') }}'); background-size: cover; background-position: center;"></div>
                        <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-0 carousel-slide" style="background-image: url('{{ asset('images/initiative_crisis/slide5.jpg') }}'); background-size: cover; background-position: center;"></div>

                        {{-- Fallback/Loading State --}}
                         <div class="absolute inset-0 bg-stone-400 flex items-center justify-center text-stone-600 font-bold text-xl -z-10">Loading Visuals...</div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            // Crisis Carousel
                            const crisisSlides = document.querySelectorAll('#crisis-carousel .carousel-slide');
                            let currentCrisisSlide = 0;
                            
                            if (crisisSlides.length > 0) {
                                setInterval(() => {
                                    crisisSlides[currentCrisisSlide].classList.remove('opacity-100');
                                    crisisSlides[currentCrisisSlide].classList.add('opacity-0');
                                    currentCrisisSlide = (currentCrisisSlide + 1) % crisisSlides.length;
                                    crisisSlides[currentCrisisSlide].classList.remove('opacity-0');
                                    crisisSlides[currentCrisisSlide].classList.add('opacity-100');
                                }, 3000);
                            }

                            // Solution Carousel (New)
                            const solutionSlides = document.querySelectorAll('#solution-carousel .carousel-slide');
                            let currentSolutionSlide = 0;

                            if (solutionSlides.length > 0) {
                                setInterval(() => {
                                    solutionSlides[currentSolutionSlide].classList.remove('opacity-100');
                                    solutionSlides[currentSolutionSlide].classList.add('opacity-0');
                                    currentSolutionSlide = (currentSolutionSlide + 1) % solutionSlides.length;
                                    solutionSlides[currentSolutionSlide].classList.remove('opacity-0');
                                    solutionSlides[currentSolutionSlide].classList.add('opacity-100');
                                }, 3500); 
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </section>

    {{-- Section 4: The Solution (Green Gold) - MOBILE FIXED --}}
    <section class="py-24 bg-white relative overflow-hidden">
        {{-- Background Pattern --}}
        <div class="absolute inset-0 bg-white z-0"></div>
        <div class="absolute inset-0 z-0 bg-repeat bg-[length:400px_400px] opacity-30" style="background-image: url('{{ asset('images/backgrounds/moringa_pattern.png') }}');"></div>

        {{-- Pattern --}}
        <div class="absolute right-0 top-0 bottom-0 w-1/3 bg-green-50 z-0 opacity-80"></div>

        <div class="container mx-auto px-4 relative z-10">
            {{-- Updated Layout: flex-col ensures stack on mobile, Row-Reverse on Desktop --}}
            <div class="flex flex-col lg:flex-row-reverse items-center gap-8 lg:gap-16">
                <div class="w-full lg:w-1/2">
                    <span class="text-moringa-leaf font-bold uppercase tracking-widest text-xs mb-2 block">The Solution</span>
                    <h2 class="text-4xl font-bold text-moringa-leaf mb-6">The Green Gold Cure: <br/><span class="text-ghana-gold">Scientific Restoration</span></h2>
                    <p class="text-gray-600 text-lg leading-relaxed mb-6">
                        Moringa Oleifera is nature's most powerful phytoremediator. Its seeds act as a natural coagulant, removing 98.6% of impurities from water, while its deep taproots fix nitrogen, restoring soil fertility and stability.
                    </p>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-5 bg-green-50 rounded-xl border border-green-100">
                             <div class="text-3xl font-black text-moringa-leaf mb-1">98.6%</div>
                             <div class="text-xs text-gray-500 uppercase font-bold">Impurity Removal</div>
                        </div>
                        <div class="p-5 bg-green-50 rounded-xl border border-green-100">
                             <div class="text-3xl font-black text-moringa-leaf mb-1">20x</div>
                             <div class="text-xs text-gray-500 uppercase font-bold">Faster Carbon Sequestration</div>
                        </div>
                    </div>
                </div>
                {{-- Updated Image Container: w-full forced on mobile --}}
                <div class="w-full lg:w-1/2 relative">
                    <div class="absolute inset-0 bg-moringa-leaf transform -translate-x-4 translate-y-4 rounded-3xl opacity-10 hidden lg:block"></div>
                     <div class="bg-gray-200 w-full h-64 md:h-[400px] rounded-3xl overflow-hidden shadow-xl relative z-10" id="solution-carousel">
                         {{-- Slides - RESTORED YOUR CUSTOM IMAGES --}}
                         <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-100 carousel-slide" style="background-image: url('{{ asset('images/sections/moringa_restoration_landscape.jpg') }}'); background-size: cover; background-position: center;"></div>
                         <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-0 carousel-slide" style="background-image: url('{{ asset('images/hero/slide5.jpg') }}'); background-size: cover; background-position: center;"></div>
                         <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-0 carousel-slide" style="background-image: url('{{ asset('images/hero/slide2.jpg') }}'); background-size: cover; background-position: center;"></div>
                         
                         {{-- Fallback --}}
                         <div class="absolute inset-0 bg-green-800 flex items-center justify-center text-green-200 font-bold text-xl -z-10">Green Gold</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Section 5: Comparative Analysis Table --}}
    <section class="py-24 bg-cloud-white">
        <div class="container mx-auto px-4 max-w-5xl">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-soil-brown">Comparative Agricultural Analysis</h2>
                <div class="w-20 h-1 bg-ghana-gold mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
                 <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-800 text-white uppercase text-xs tracking-wider">
                                <th class="p-6 font-semibold">Crop</th>
                                <th class="p-6 font-semibold">Harvest Time</th>
                                <th class="p-6 font-semibold">Frequency</th>
                                <th class="p-6 font-semibold bg-green-800">CO2 Absorption</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm md:text-base">
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                <td class="p-6 font-bold text-gray-800">Cocoa</td>
                                <td class="p-6 text-gray-600">3-5 Years</td>
                                <td class="p-6 text-gray-600">Seasonal</td>
                                <td class="p-6 text-red-500 font-medium">Low</td>
                            </tr>
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                <td class="p-6 font-bold text-gray-800">Oil Palm</td>
                                <td class="p-6 text-gray-600">4-6 Years</td>
                                <td class="p-6 text-gray-600">Seasonal</td>
                                <td class="p-6 text-yellow-600 font-medium">Medium</td>
                            </tr>
                            <tr class="bg-green-50 border-l-4 border-moringa-leaf">
                                <td class="p-6 font-bold text-moringa-leaf">Moringa (Green Gold)</td>
                                <td class="p-6 font-bold text-moringa-leaf">6 Months</td>
                                <td class="p-6 font-bold text-moringa-leaf">Daily / Continuous</td>
                                <td class="p-6 font-bold text-white bg-moringa-leaf">High (20x Standard)</td>
                            </tr>
                        </tbody>
                    </table>
                 </div>
            </div>
        </div>
    </section>

    {{-- Section 6: Market Outlook --}}
    <section class="py-24 bg-white relative overflow-hidden">
        {{-- Background Pattern --}}
        <div class="absolute inset-0 bg-white z-0"></div>
        <div class="absolute inset-0 z-0 bg-repeat bg-[length:400px_400px]" style="background-image: url('{{ asset('images/backgrounds/moringa_pattern.png') }}');"></div>

        <div class="container mx-auto px-4 max-w-4xl relative z-10">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Global Market Projections</h2>
                <p class="text-gray-500">Forecasting the $18.2 Billion Opportunity</p>
            </div>

            <div class="p-6 bg-white rounded-2xl border border-gray-100 shadow-lg">
                <canvas id="marketChart" class="w-full" style="max-height: 400px;"></canvas>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('marketChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['2022', '2024', '2026', '2028', '2030'],
                    datasets: [{
                        label: 'Global Market (Billions USD)',
                        data: [9.5, 11.0, 13.5, 15.8, 18.2],
                        borderColor: '#2E7D32',
                        backgroundColor: 'rgba(46, 125, 50, 0.05)',
                        borderWidth: 3,
                        pointBackgroundColor: '#FFD700',
                        pointBorderColor: '#5D4037',
                        pointRadius: 6,
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top', align: 'end' },
                        tooltip: { backgroundColor: '#333', padding: 12 }
                    },
                    scales: {
                        y: { 
                            beginAtZero: false, 
                            grid: { borderDash: [2, 4] },
                            ticks: { callback: function(value){return '$'+value+'B'} }
                        },
                        x: { grid: { display: false } }
                    }
                }
            });
        });
    </script>
@endsection
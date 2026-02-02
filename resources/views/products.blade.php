@extends('layouts.master')

@section('title', 'Green Gold Products - Castle Royal Agro')

@section('content')
    {{-- Header Section --}}
    <section class="relative bg-soil-brown py-20 overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/wood-pattern.png')]"></div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <h1 class="text-5xl md:text-6xl font-bold text-ghana-gold mb-4 font-serif tracking-wide">
                Green Gold Organic Product
            </h1>
            <p class="text-xl text-gray-300 font-light h-8">
                <span id="header-rotator" class="transition-opacity duration-500">From Soil to Shelf - 100% Organic</span>
            </p>
        </div>
    </section>

    {{-- Interactive Marquee Section --}}
    <section class="bg-moringa-leaf py-4 overflow-hidden border-b-4 border-ghana-gold">
        <div class="marquee-container flex space-x-8 animate-marquee hover:pause cursor-pointer">
            {{-- Duplicated items for seamless loop --}}
            @php
                $marqueeItems = [
                    ['img' => 'images/products/moringa_oil_new.jpg', 'name' => 'Healthy Oil'],
                    ['img' => 'images/products/moringa_powder_new.jpg', 'name' => 'Organic Powder'],
                    ['img' => 'images/products/moringa_leaves_new.jpg', 'name' => 'Dehydrated Leaves'],
                    ['img' => 'images/hero/slide1.png', 'name' => 'Green Gold Tea'],
                    ['img' => 'images/hero/slide3.jpg', 'name' => 'Animal Feed'],
                    ['img' => 'images/products/moringa_cosmetics_new.jpg', 'name' => 'Body Lotion'],
                ];
            @endphp

            @for ($i = 0; $i < 2; $i++) {{-- Repeat twice for seamless scrolling --}}
                @foreach($marqueeItems as $item)
                    <div class="flex-shrink-0 flex items-center space-x-3 bg-white/10 px-6 py-2 rounded-full border border-white/20 backdrop-blur-sm hover:bg-white/20 transition transform hover:scale-105" onclick="scrollToGrid()">
                        <img src="{{ asset($item['img']) }}" class="w-10 h-10 rounded-full object-cover border-2 border-ghana-gold">
                        <span class="text-white font-bold text-sm tracking-widest uppercase">{{ $item['name'] }}</span>
                    </div>
                @endforeach
            @endfor
        </div>
    </section>

    {{-- Main Product Grid --}}
    <section class="py-20 relative" id="product-grid">
        {{-- Background Pattern --}}
        <div class="absolute inset-0 bg-white z-0"></div>
        <div class="absolute inset-0 z-0 bg-repeat bg-[length:400px_400px]" style="background-image: url('{{ asset('images/backgrounds/moringa_pattern.png') }}');"></div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @php
                    $products = [
                        [
                            'id' => 1,
                            'name' => 'Green Gold Organic Healthy Oil',
                            'category' => 'Cosmetic / Edible',
                            'image' => 'images/products/moringa_oil_new.jpg',
                            'desc' => '100% Pure Cold-Pressed Moringa Oil. A powerhouse of antioxidants and oleic acid, perfect for radiant skin, healthy hair, and heart-healthy cooking.',
                            'benefits' => ['Anti-Aging & Deep Moisturizing', 'Promotes Hair Growth', 'Heart Healthy (High Oleic Acid)'],
                            'weight' => '100ml / 250ml'
                        ],
                        [
                            'id' => 2,
                            'name' => 'Green Gold Moringa Organic Powder',
                            'category' => 'Nutritional Superfood',
                            'image' => 'images/products/moringa_powder_new.jpg',
                            'desc' => 'The ultimate nutrient booster. Packed with vitamins, minerals, and amino acids. Add to smoothies, soups, or porridge for daily vitality.',
                            'benefits' => ['Boosts Immunity & Energy', 'Rich in Iron & Calcium', 'Supports Detoxification'],
                            'weight' => '250g / 500g'
                        ],
                        [
                            'id' => 3,
                            'name' => 'Green Gold Dehydrated Leaves',
                            'category' => 'Raw & Organic',
                            'image' => 'images/products/moringa_leaves_new.jpg',
                            'desc' => 'Premium shade-dried Moringa leaves. Retains max nutrients. Perfect for brewing tea, cooking, or making your own fresh powder.',
                            'benefits' => ['Rich in Antioxidants', 'Balances Blood Sugar', 'Anti-Inflammatory'],
                            'weight' => '100g / 1kg'
                        ],
                        [
                            'id' => 4,
                            'name' => 'Green Gold Tea',
                            'category' => 'Wellness / Infusions',
                            'image' => 'images/hero/slide1.png',
                            'desc' => 'Rich in antioxidants, our organic Moringa tea boosts immunity and energy levels. Hand-picked leaves dried to perfection.',
                            'benefits' => ['Stress Relief', 'Digestion Aid', 'Caffeine Free'],
                            'weight' => '25 Tea Bags'
                        ],
                        [
                            'id' => 5,
                            'name' => 'Green Gold Animal Feed',
                            'category' => 'Livestock Nutrition',
                            'image' => 'images/hero/slide3.jpg',
                            'desc' => 'Premium pellet feed for poultry and livestock. Enhances growth rate and health without synthetic additives.',
                            'benefits' => ['Faster Growth Rate', 'Improved immunity', 'Cost Effective'],
                            'weight' => '50kg'
                        ],
                        [
                            'id' => 6,
                            'name' => 'Green Gold Cosmetics',
                            'category' => 'Body Lotion',
                            'image' => 'images/products/moringa_cosmetics_new.jpg',
                            'desc' => 'Luxurious Moringa Body Lotion that deeply hydrates and restores skin elasticity. Infused with natural vitamins for a soft, glowing complexion.',
                            'benefits' => ['Restores Skin Elasticity', 'Deep 24h Hydration', 'Protects Against UV Damage'],
                            'weight' => '250ml / 500ml'
                        ],
                    ];
                @endphp

                @foreach($products as $product)
                    {{-- Product Card --}}
                    <div class="group bg-white rounded-3xl shadow-lg hover:shadow-2xl transition duration-500 transform hover:-translate-y-2 cursor-pointer overflow-hidden border border-ghana-gold/20 relative"
                         onclick="openModal({{ $product['id'] }})">
                         {{-- Card Background Pattern --}}
                         <div class="absolute inset-0 z-0 bg-repeat bg-[length:300px_300px] opacity-60" style="background-image: url('{{ asset('images/backgrounds/moringa_pattern.png') }}');"></div>
                        
                        <div class="h-64 overflow-hidden bg-gray-50 relative z-10">
                            <div class="absolute inset-0 bg-moringa-leaf/10 group-hover:bg-transparent transition duration-500"></div>
                            <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}" class="w-full h-full object-cover transition duration-700 transform group-hover:scale-110">
                            {{-- Highlight Overlay --}}
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                                <span class="bg-ghana-gold text-soil-brown font-bold py-2 px-6 rounded-full transform scale-90 group-hover:scale-100 transition duration-300">View Details</span>
                            </div>
                        </div>
                        <div class="p-8 relative z-10">
                            <div class="text-xs font-bold text-ghana-gold uppercase tracking-widest mb-2">{{ $product['category'] }}</div>
                            <h3 class="text-2xl font-bold text-moringa-leaf mb-3 group-hover:text-green-700 transition">{{ $product['name'] }}</h3>
                            <p class="text-gray-500 text-sm line-clamp-2 leading-relaxed">{{ $product['desc'] }}</p>
                        </div>
                    </div>

                    {{-- DETAIL MODAL (With Updated Commercial Buttons) --}}
                    <div id="modal-{{ $product['id'] }}" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        {{-- Backdrop --}}
                        <div class="fixed inset-0 bg-black/80 transition-opacity backdrop-blur-sm" onclick="closeModal({{ $product['id'] }})"></div>

                        {{-- Modal Panel --}}
                        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                            <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-4xl border-t-8 border-ghana-gold">
                                <div class="absolute right-4 top-4 z-10">
                                    <button type="button" class="bg-white rounded-full p-2 text-gray-400 hover:text-gray-500 hover:bg-gray-100 transition" onclick="closeModal({{ $product['id'] }})">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                    </button>
                                </div>
                                <div class="flex flex-col md:flex-row">
                                    {{-- Image Side --}}
                                    <div class="md:w-1/2 h-64 md:h-auto relative">
                                        <img src="{{ asset($product['image']) }}" class="w-full h-full object-cover">
                                    </div>
                                    {{-- Content Side --}}
                                    <div class="md:w-1/2 p-8 md:p-12 relative overflow-hidden">
                                         {{-- Pattern Overlay inside Modal --}}
                                        <div class="absolute inset-0 z-0 bg-repeat bg-[length:200px_200px]" style="background-image: url('{{ asset('images/backgrounds/moringa_pattern.png') }}');"></div>
                                        
                                        <div class="relative z-10">
                                            <div class="text-sm font-bold text-ghana-gold uppercase tracking-widest mb-2">{{ $product['category'] }}</div>
                                            <h3 class="text-3xl font-bold text-soil-brown mb-6">{{ $product['name'] }}</h3>
                                            <p class="text-gray-600 leading-relaxed mb-6">{{ $product['desc'] }}</p>
                                            
                                            <div class="bg-white/90 backdrop-blur-sm p-6 rounded-xl border border-gray-100 mb-8 shadow-sm">
                                                <h4 class="font-bold text-moringa-leaf mb-3 text-sm uppercase">Key Benefits</h4>
                                                <ul class="space-y-2">
                                                    @foreach($product['benefits'] as $benefit)
                                                        <li class="flex items-center text-sm text-gray-700">
                                                            <svg class="w-4 h-4 text-ghana-gold mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                                            {{ $benefit }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>

                                            <div class="text-2xl font-black text-gray-900 mb-4">{{ $product['weight'] }}</div>
                                            
                                            {{-- COMMERCIAL ACTION BUTTONS --}}
                                            <div class="flex flex-col space-y-3">
                                                {{-- 1. WhatsApp Button --}}
                                                <a href="https://wa.me/233244776834?text=Hello%20Castle%20Royal,%20I%20am%20interested%20in%20ordering%20{{ urlencode($product['name']) }}" target="_blank" class="w-full bg-green-500 text-white font-bold py-3 px-6 rounded-full shadow-lg hover:bg-green-600 transition flex items-center justify-center">
                                                    <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                                    Order via WhatsApp
                                                </a>
                                                {{-- 2. Request Quote Button --}}
                                                <button onclick="openInquiryForm('{{ $product['name'] }}', {{ $product['id'] }})" class="w-full bg-soil-brown text-white font-bold py-3 px-6 rounded-full shadow-lg hover:bg-gray-800 transition">
                                                    Request Formal Quote
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ORDER INQUIRY FORM MODAL (Hidden by default) --}}
    <div id="inquiryModal" class="fixed inset-0 z-[100] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" onclick="closeInquiryForm()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border-t-8 border-moringa-leaf">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-xl font-bold text-soil-brown mb-4" id="inquiry-title">Request Quote</h3>
                    <p class="text-sm text-gray-500 mb-6">Complete this form for bulk pricing. A pro-forma invoice will be sent to your email.</p>
                    
                    <form id="quoteForm" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Company / Full Name</label>
                            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-moringa-leaf focus:border-moringa-leaf sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-moringa-leaf focus:border-moringa-leaf sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Quantity Required</label>
                            <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-moringa-leaf focus:border-moringa-leaf sm:text-sm">
                                <option>Retail (1-10 Units)</option>
                                <option>Wholesale (10-100 Units)</option>
                                <option>Industrial (100+ Units)</option>
                                <option>Export (Container Load)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Additional Details</label>
                            <textarea rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-moringa-leaf focus:border-moringa-leaf sm:text-sm"></textarea>
                        </div>
                    </form>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" onclick="submitQuote()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-moringa-leaf text-base font-medium text-white hover:bg-green-800 sm:ml-3 sm:w-auto sm:text-sm">Submit Request</button>
                    <button type="button" onclick="closeInquiryForm()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    {{-- FLOATING GLOBAL WHATSAPP WIDGET --}}
    {{-- Note: For this to appear on ALL pages, copy this block to 'layouts/master.blade.php' --}}
    <div class="fixed bottom-6 right-6 z-[200]">
        <a href="https://wa.me/233244776834?text=Hello%20Castle%20Royal,%20I%20have%20an%20inquiry" target="_blank" class="flex items-center space-x-2 bg-green-500 hover:bg-green-600 text-white px-4 py-3 rounded-full shadow-2xl transition transform hover:scale-110 border-2 border-white animate-bounce">
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
            <span class="font-bold hidden md:block">Chat on WhatsApp</span>
        </a>
    </div>

    {{-- Styles for Marquee --}}
    <style>
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .animate-marquee {
            animation: marquee 20s linear infinite;
        }
        .hover\:pause:hover {
            animation-play-state: paused;
        }
    </style>

    {{-- Scripts --}}
    <script>
        // Header Text Rotator
        document.addEventListener('DOMContentLoaded', () => {
            const headerText = document.getElementById('header-rotator');
            const messages = ["From Soil to Shelf - 100% Organic", "Purest Moringa Quality", "Empowering Local Farmers", "Nature's Superfood for You"];
            let msgIndex = 0;

            setInterval(() => {
                headerText.style.opacity = '0';
                setTimeout(() => {
                    msgIndex = (msgIndex + 1) % messages.length;
                    headerText.textContent = messages[msgIndex];
                    headerText.style.opacity = '1';
                }, 500);
            }, 4000);
        });

        // Modal Functions
        function openModal(id) {
            document.getElementById(`modal-${id}`).classList.remove('hidden');
            document.body.style.overflow = 'hidden'; 
        }

        function closeModal(id) {
            document.getElementById(`modal-${id}`).classList.add('hidden');
            document.body.style.overflow = ''; 
        }

        // NEW: Commercial Inquiry Logic
        function openInquiryForm(productName, id) {
            // Close the product detail modal first
            closeModal(id);
            
            // Open the Form Modal
            const formModal = document.getElementById('inquiryModal');
            document.getElementById('inquiry-title').innerText = 'Request Quote: ' + productName;
            formModal.classList.remove('hidden');
        }

        function closeInquiryForm() {
            document.getElementById('inquiryModal').classList.add('hidden');
        }

        function submitQuote() {
            // Simulate Success
            alert("Thank you! Your quote request has been sent to our sales team. We will contact you shortly.");
            closeInquiryForm();
        }

        function scrollToGrid() {
            document.getElementById('product-grid').scrollIntoView({ behavior: 'smooth' });
        }
    </script>
@endsection
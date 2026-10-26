<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title', 'Castle Royal Agro - Ghana Green Gold')</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'moringa-leaf': '#2E7D32',
                        'moringa-light': '#81C784',
                        'ghana-gold': '#FFD700',
                        'soil-brown': '#5D4037',
                        'cloud-white': '#F9FAFB',
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        /* Mobile Stability Fixes */
        html, body {
            overflow-x: hidden;
            width: 100%;
            position: relative;
        }
        
        /* Floating Animation for WhatsApp */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>

<body class="bg-cloud-white font-sans text-gray-800 flex flex-col min-h-screen">

    {{-- NAVIGATION (Hidden on Dashboard) --}}
    @unless(Request::is('dashboard'))
    <nav class="bg-white fixed w-full top-0 z-[100] border-b-4 border-moringa-leaf shadow-md transition-all duration-300 h-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full">
            <div class="flex justify-between items-center h-full">
                
                {{-- LOGO --}}
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center space-x-3 cursor-pointer z-[101]">
                        <img src="{{ asset('logo.jpg') }}" alt="Castle Royal Logo" class="h-10 w-auto rounded-md object-contain">
                        <div class="flex flex-col">
                            <span class="text-2xl font-black text-moringa-leaf tracking-tighter leading-none mb-1">CastleROYAL</span>
                            <span class="text-xs font-bold text-ghana-gold tracking-widest uppercase leading-none">Agro Ghana Ltd</span>
                        </div>
                    </a>
                </div>
                
                {{-- DESKTOP MENU --}}
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ url('/') }}" class="text-gray-700 hover:text-moringa-leaf font-bold transition">Home</a>
                    <a href="{{ url('/initiative') }}" class="text-gray-700 hover:text-moringa-leaf font-semibold transition">The 3GR Initiative</a>
                    <a href="{{ url('/products') }}" class="text-gray-700 hover:text-moringa-leaf font-semibold transition">Green Gold Products</a>
                    
                    {{-- NEW: Contact Trigger --}}
                    <button onclick="openGlobalContact()" class="text-gray-700 hover:text-moringa-leaf font-semibold transition">Contact Us</button>

                    <a href="{{ route('login') }}" class="bg-moringa-leaf text-white px-6 py-2 rounded-full font-bold hover:bg-green-800 transition shadow-lg hover:scale-105">
                       Holder Login
                    </a>
                </div>

                {{-- MOBILE HAMBURGER BUTTON --}}
                <div class="md:hidden flex items-center relative z-[101]">
                    <button onclick="toggleMobileMenu()" class="text-gray-700 hover:text-moringa-leaf focus:outline-none p-2 border border-gray-200 rounded-md bg-white">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- MOBILE MENU DROPDOWN --}}
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100 shadow-xl absolute w-full left-0 top-20 z-50 max-h-[calc(100vh-80px)] overflow-y-auto">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 flex flex-col items-center py-6">
                <a href="{{ url('/') }}" class="block px-3 py-4 text-lg font-bold text-gray-700 hover:text-moringa-leaf hover:bg-green-50 w-full text-center rounded-md">Home</a>
                <a href="{{ url('/initiative') }}" class="block px-3 py-4 text-lg font-medium text-gray-700 hover:text-moringa-leaf hover:bg-green-50 w-full text-center rounded-md">The 3GR Initiative</a>
                <a href="{{ url('/products') }}" class="block px-3 py-4 text-lg font-medium text-gray-700 hover:text-moringa-leaf hover:bg-green-50 w-full text-center rounded-md">Green Gold Products</a>
                
                {{-- NEW: Mobile Contact Trigger --}}
                <button onclick="openGlobalContact(); toggleMobileMenu();" class="block px-3 py-4 text-lg font-medium text-gray-700 hover:text-moringa-leaf hover:bg-green-50 w-full text-center rounded-md">Contact Us</button>
                
                <a href="{{ route('login') }}" class="mt-4 w-3/4 text-center bg-moringa-leaf text-white px-6 py-3 rounded-full font-bold shadow-md">Holder Login</a>
            </div>
        </div>
    </nav>
    @endunless

    {{-- MAIN CONTENT --}}
    <main class="flex-grow w-full overflow-x-hidden {{ Request::is('dashboard') ? '' : 'pt-20' }}">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-soil-brown text-white pt-12 pb-8 mt-auto relative z-10 w-full">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left">
            <div>
                <h3 class="text-ghana-gold font-bold text-lg mb-4">Castle Royal Agro</h3>
                <p class="text-gray-300 text-sm leading-relaxed px-4 md:px-0">
                    Leading the Ghana Green Gold Revolution (3GR). Industrializing Moringa to create jobs.
                </p>
            </div>
            <div class="mt-6 md:mt-0">
                <h3 class="text-ghana-gold font-bold text-lg mb-4">Contact Us</h3>
                <p class="text-gray-300 text-sm">📍 #2 Faanofa Street, Kokomlemle</p>
                <p class="text-gray-300 text-sm mt-3">📞 0244776834</p>
                {{-- NEW: Footer Contact Trigger --}}
                <button onclick="openGlobalContact()" class="text-ghana-gold text-sm mt-2 hover:underline">Send us a message</button>
            </div>
            <div class="mt-6 md:mt-0">
                <h3 class="text-ghana-gold font-bold text-lg mb-4">Quick Links</h3>
                <ul class="text-gray-300 text-sm space-y-2">
                    <li><a href="{{ route('login') }}" class="hover:text-ghana-gold transition">Prospectus</a></li>
                    <li><a href="{{ url('/products') }}" class="hover:text-ghana-gold transition">Products</a></li>
                </ul>
            </div>
        </div>
        <div class="text-center text-gray-500 text-xs mt-10 border-t border-gray-700 pt-4">
            &copy; 2026 Castle Royal Agro Ghana Ltd. All rights reserved.
        </div>
    </footer>

    {{-- 4. GLOBAL FLOATING WHATSAPP (Visible on ALL Pages) --}}
    <div class="fixed bottom-6 right-6 z-[200] animate-float">
        <a href="https://wa.me/233240804388?text=Hello%20Castle%20Royal,%20I%20have%20an%20inquiry" target="_blank" class="flex items-center space-x-2 bg-green-500 hover:bg-green-600 text-white px-4 py-3 rounded-full shadow-2xl transition transform hover:scale-110 border-2 border-white">
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
            <span class="font-bold hidden md:block">Chat on WhatsApp</span>
        </a>
    </div>

    {{-- 5. GLOBAL GENERAL CONTACT MODAL (Hidden by default) --}}
    <div id="globalContactModal" class="fixed inset-0 z-[200] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-80 transition-opacity backdrop-blur-sm" onclick="closeGlobalContact()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border-t-8 border-ghana-gold">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-moringa-leaf sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-xl leading-6 font-bold text-gray-900">
                                Contact Castle Royal Agro
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 mb-4">
                                    Have a question? Fill out the form below and our team will get back to you within 24 hours.
                                </p>
                                
                                <form action="https://formspree.io/f/mykpdezq" method="POST" class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Your Name</label>
                                        <input type="text" name="name" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-moringa-leaf focus:border-moringa-leaf sm:text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Email Address</label>
                                        <input type="email" name="email" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-moringa-leaf focus:border-moringa-leaf sm:text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Subject</label>
                                        <select name="subject" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-moringa-leaf focus:border-moringa-leaf sm:text-sm">
                                            <option>General Inquiry</option>
                                            <option>Partnership Proposal</option>
                                            <option>Farm Visit Request</option>
                                            <option>Media / Press</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Message</label>
                                        <textarea name="message" rows="3" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-moringa-leaf focus:border-moringa-leaf sm:text-sm"></textarea>
                                    </div>

                                    <div class="bg-gray-50 pt-4 sm:flex sm:flex-row-reverse">
                                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-moringa-leaf text-base font-medium text-white hover:bg-green-800 sm:ml-3 sm:w-auto sm:text-sm">
                                            Send Message
                                        </button>
                                        <button type="button" onclick="closeGlobalContact()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                document.body.style.overflow = 'hidden'; // Lock scrolling
            } else {
                menu.classList.add('hidden');
                document.body.style.overflow = 'auto'; // Unlock scrolling
            }
        }

        // Global Contact Modal Logic
        function openGlobalContact() {
            document.getElementById('globalContactModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeGlobalContact() {
            document.getElementById('globalContactModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    </script>

</body>
</html>
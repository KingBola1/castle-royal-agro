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
                <div class="flex-shrink-0 flex items-center h-full py-2">
                    <a href="{{ url('/') }}" class="h-full flex items-center">
                        <img class="h-full w-auto max-h-16 object-contain" src="{{ asset('logo.jpg') }}" alt="Castle Royal Agro">
                    </a>
                </div>

                {{-- DESKTOP MENU --}}
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ url('/') }}" class="text-gray-700 hover:text-moringa-leaf font-semibold transition">Home</a>
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
                    <button onclick="toggleMobileMenu()" class="text-gray-700 hover:text-moringa-leaf focus:outline-none p-2 rounded-md transition-colors bg-gray-50 border border-gray-200">
                        <svg class="h-8 w-8" id="menu-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- MOBILE MENU OVERLAY --}}
        <div id="mobile-menu" class="fixed inset-0 bg-white/95 backdrop-blur-sm z-[90] hidden flex-col transition-all duration-300 transform translate-y-full md:hidden">
            <div class="flex flex-col items-center justify-center h-full space-y-6 pt-20 pb-10 overflow-y-auto w-full px-6">
                <a href="{{ url('/') }}" class="block px-3 py-4 text-lg font-medium text-gray-700 hover:text-moringa-leaf hover:bg-green-50 w-full text-center rounded-md">Home</a>
                <a href="{{ url('/initiative') }}" class="block px-3 py-4 text-lg font-medium text-gray-700 hover:text-moringa-leaf hover:bg-green-50 w-full text-center rounded-md">The 3GR Initiative</a>
                <a href="{{ url('/products') }}" class="block px-3 py-4 text-lg font-medium text-gray-700 hover:text-moringa-leaf hover:bg-green-50 w-full text-center rounded-md">Green Gold Products</a>
                
                {{-- NEW: Mobile Contact Trigger --}}
                <button onclick="openGlobalContact(); toggleMobileMenu();" class="block px-3 py-4 text-lg font-medium text-gray-700 hover:text-moringa-leaf hover:bg-green-50 w-full text-center rounded-md">Contact Us</button>
                
                <a href="{{ route('login') }}" class="mt-4 w-3/4 text-center bg-moringa-leaf text-white px-6 py-3 rounded-full font-bold shadow-md">Holder Login</a>
            </div>
        </div>
    </nav>
    @endunless

    {{-- MAIN CONTENT INJECTION --}}
    <main class="flex-grow @unless(Request::is('dashboard')) pt-20 @endunless relative w-full overflow-x-hidden">
        @yield('content')
    </main>

    {{-- FOOTER (Hidden on Dashboard) --}}
    @unless(Request::is('dashboard'))
    <footer class="bg-soil-brown text-white py-12 relative w-full overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-bold text-ghana-gold mb-4">Castle Royal Agro</h3>
                    <p class="text-gray-300">Pioneering the Ghana Green Gold Revolution through sustainable Moringa processing and wealth creation.</p>
                </div>
                <div>
                    <h4 class="font-bold mb-4 border-b border-gray-600 pb-2">Quick Links</h4>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="{{ url('/initiative') }}" class="hover:text-ghana-gold transition">The Initiative</a></li>
                        <li><a href="{{ url('/products') }}" class="hover:text-ghana-gold transition">Our Products</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-ghana-gold transition">Holder Portal</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4 border-b border-gray-600 pb-2">Connect With Us</h4>
                    <p class="text-gray-300 mb-2">Accra, Ghana</p>
                    <p class="text-gray-300 mb-4">info@castleroyalagro.com</p>
                    {{-- NEW: Footer Contact Button --}}
                    <button onclick="openGlobalContact()" class="inline-flex items-center px-4 py-2 border border-ghana-gold text-ghana-gold hover:bg-ghana-gold hover:text-soil-brown rounded transition font-bold">
                        Send us a Message
                    </button>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400 text-sm">
                &copy; {{ date('Y') }} Castle Royal Agro Ghana Ltd. All Rights Reserved.
            </div>
        </div>
    </footer>
    @endunless

    {{-- GLOBAL FLOATING WHATSAPP BUTTON --}}
    @unless(Request::is('dashboard'))
    <div class="fixed bottom-6 right-6 z-[100] animate-float">
        <a href="https://wa.me/233244000000" target="_blank" class="flex items-center bg-green-500 text-white px-4 py-3 rounded-full shadow-2xl hover:bg-green-600 transition transform hover:scale-110">
            <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12.031 0C5.385 0 0 5.385 0 12.031c0 2.124.553 4.195 1.604 6.02L.073 23.908l5.992-1.571c1.764.957 3.738 1.464 5.766 1.464 6.646 0 12.031-5.385 12.031-12.031C24.062 5.385 18.677 0 12.031 0zm0 21.84c-1.802 0-3.568-.484-5.116-1.402l-.367-.217-3.8.996.996-3.8-.238-.378c-1.008-1.603-1.54-3.45-1.54-5.346 0-5.556 4.52-10.076 10.076-10.076 5.556 0 10.076 4.52 10.076 10.076 0 5.556-4.52 10.076-10.076 10.076zm5.526-7.55c-.302-.151-1.792-.885-2.07-.987-.277-.102-.479-.151-.681.151-.202.302-.781.987-.958 1.188-.177.202-.354.227-.656.076-1.528-.767-2.618-1.391-3.619-2.909-.264-.401-.019-.597.126-.757.301-.334.618-.838.618-1.206 0-.251-.126-.477-.252-.728-.277-.553-1.159-2.812-1.587-3.841-.417-.996-.838-.859-1.16-.874-.277-.013-.579-.013-.881-.013-.302 0-.781.113-1.183.553-.403.44-1.536 1.501-1.536 3.66 0 2.158 1.575 4.242 1.793 4.533.218.291 3.09 4.717 7.483 6.611 2.378 1.026 3.237 1.113 4.312.983.896-.109 2.768-1.131 3.158-2.223.389-1.093.389-2.03.277-2.223-.112-.193-.415-.306-.717-.457z"/>
            </svg>
            <span class="font-bold text-sm hidden sm:block">Chat on WhatsApp</span>
        </a>
    </div>
    @endunless

    {{-- GLOBAL CONTACT MODAL --}}
    <div id="global-contact-modal" class="fixed inset-0 z-[200] hidden">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeGlobalContact()"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-lg bg-white rounded-xl shadow-2xl overflow-hidden animate-[pulse_0.2s_ease-out]">
            <div class="bg-moringa-leaf p-4 flex justify-between items-center text-white">
                <h3 class="font-bold text-xl">Contact Castle Royal Agro</h3>
                <button onclick="closeGlobalContact()" class="text-white hover:text-ghana-gold focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="p-6">
                <form id="global-contact-form" action="{{ route('contact.submit') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-moringa-leaf focus:border-moringa-leaf outline-none transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input type="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-moringa-leaf focus:border-moringa-leaf outline-none transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                            <select name="subject" class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-moringa-leaf focus:border-moringa-leaf outline-none transition">
                                <option>Investment Inquiry</option>
                                <option>Product Ordering</option>
                                <option>General Information</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                            <textarea name="message" rows="3" required class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-moringa-leaf focus:border-moringa-leaf outline-none transition"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-moringa-leaf text-white font-bold py-3 rounded hover:bg-green-800 transition shadow-md">
                            Send Message
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const icon = document.getElementById('menu-icon');
            
            if (menu.classList.contains('hidden')) {
                // Open Menu
                menu.classList.remove('hidden');
                setTimeout(() => {
                    menu.classList.remove('translate-y-full');
                    menu.classList.add('translate-y-0');
                }, 10);
                // Change icon to X
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>';
            } else {
                // Close Menu
                menu.classList.remove('translate-y-0');
                menu.classList.add('translate-y-full');
                setTimeout(() => {
                    menu.classList.add('hidden');
                }, 300);
                // Revert icon to Hamburger
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>';
            }
        }

        // Global Contact Modal Logic
        function openGlobalContact() {
            document.getElementById('global-contact-modal').classList.remove('hidden');
        }
        function closeGlobalContact() {
            document.getElementById('global-contact-modal').classList.add('hidden');
        }
    </script>
</body>
</html>
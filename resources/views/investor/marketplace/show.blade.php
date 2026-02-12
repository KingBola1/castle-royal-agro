<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $package->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Package Details (Left) -->
                <div class="md:col-span-2 space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        @if($package->image)
                            <img src="{{ asset($package->image) }}" alt="{{ $package->name }}" class="w-full h-80 object-cover">
                        @endif
                        <div class="p-6">
                            <h3 class="text-2xl font-bold mb-4">Investment Details</h3>
                            <div class="prose max-w-none text-gray-700">
                                {!! nl2br(e($package->description)) !!}
                            </div>
                            
                            <div class="mt-8 grid grid-cols-2 md:grid-cols-3 gap-6 border-t pt-6">
                                <div>
                                    <label class="block text-sm text-gray-500">Price Per Unit</label>
                                    <div class="text-xl font-bold">GHS {{ number_format($package->price, 2) }}</div>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-500">Expected ROI</label>
                                    <div class="text-xl font-bold text-green-600">{{ $package->roi_percentage }}%</div>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-500">Duration</label>
                                    <div class="text-xl font-bold">{{ $package->duration_months }} Months</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Investment Form (Right) -->
                <div class="md:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 sticky top-6">
                        <h3 class="text-lg font-bold mb-4">Invest Now</h3>

                        <form method="POST" action="{{ route('marketplace.buy', $package) }}">
                            @csrf
                            
                            <!-- Units Input -->
                            <div class="mb-4">
                                <x-input-label for="units" :value="__('Number of Units')" />
                                <x-text-input id="units" class="block mt-1 w-full" type="number" name="units" :value="old('units', 1)" min="1" required 
                                    oninput="calculateTotal()" />
                                <x-input-error :messages="$errors->get('units')" class="mt-2" />
                            </div>

                             <!-- Price Per Unit (ReadOnly) -->
                             <div class="mb-4">
                                <x-input-label :value="__('Price Per Unit (GHS)')" />
                                <div class="p-2 bg-gray-100 rounded border text-gray-700">
                                    {{ number_format($package->price, 2) }}
                                </div>
                            </div>

                             <!-- Total (Client-side calc) -->
                             <div class="mb-4">
                                <x-input-label :value="__('Total Amount (GHS)')" />
                                <div id="total-display" class="p-2 bg-gray-100 rounded border text-gray-900 font-bold text-lg">
                                    {{ number_format($package->price, 2) }}
                                </div>
                            </div>

                            <!-- Payment Reference -->
                            <div class="mb-6">
                                <x-input-label for="payment_reference" :value="__('Payment Reference')" />
                                <div class="text-xs text-gray-500 mb-1">Enter Bank Transaction ID or Payment Note</div>
                                <x-text-input id="payment_reference" class="block mt-1 w-full" type="text" name="payment_reference" :value="old('payment_reference')" placeholder="e.g. TXN-12345678" required />
                                <x-input-error :messages="$errors->get('payment_reference')" class="mt-2" />
                            </div>

                            <x-primary-button class="w-full justify-center text-lg py-3">
                                {{ __('Confirm Purchase') }}
                            </x-primary-button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function calculateTotal() {
            const units = document.getElementById('units').value;
            const price = {{ $package->price }};
            const total = units * price;
            // Format number to 2 decimal places with commas
            const formatted = new Intl.NumberFormat('en-GH', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(total);
            document.getElementById('total-display').innerText = formatted;
        }
    </script>
</x-app-layout>

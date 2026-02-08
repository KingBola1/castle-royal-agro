<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Request Payout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <div class="mb-4 bg-blue-50 border-l-4 border-blue-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    Available Balance: <span class="font-bold">GH₵ {{ number_format(Auth::user()->projected_roi, 2) }}</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('withdrawals.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="amount" class="block font-medium text-sm text-gray-700">Withdrawal Amount (GHS)</label>
                            <input id="amount" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                   type="number" 
                                   name="amount" 
                                   value="{{ old('amount') }}" 
                                   required 
                                   autofocus />
                            @error('amount')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="fill_payment" class="block font-medium text-sm text-gray-700">Quick Auto-Fill</label>
                            <select id="fill_payment" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Select a Saved Method...</option>
                                @if(Auth::user()->momo_details)
                                    <option value="{{ Auth::user()->momo_details }}">Use Saved MoMo: {{ Str::limit(Auth::user()->momo_details, 30) }}</option>
                                @endif
                                @if(Auth::user()->bank_details)
                                    <option value="{{ Auth::user()->bank_details }}">Use Saved Bank: {{ Str::limit(Auth::user()->bank_details, 30) }}</option>
                                @endif
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="payment_details" class="block font-medium text-sm text-gray-700">Payment Details (MoMo Name & Number)</label>
                            <textarea id="payment_details" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                      name="payment_details" 
                                      rows="3" 
                                      required 
                                      placeholder="e.g. MTN Momo - John Mayer - 0244123456"></textarea>
                            @error('payment_details')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Submit Request
                            </button>
                        </div>
                    </form>

                    <script>
                        document.getElementById('fill_payment').addEventListener('change', function() {
                            if(this.value) {
                                document.getElementById('payment_details').value = this.value;
                            }
                        });
                    </script>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

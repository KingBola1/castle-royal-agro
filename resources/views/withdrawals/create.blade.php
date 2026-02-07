<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Request Withdrawal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <div class="mb-4 bg-yellow-50 border-l-4 border-yellow-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    Available Balance: <span class="font-bold">GH₵ {{ number_format(Auth::user()->projected_roi, 2) }}</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('withdrawals.store') }}">
                        @csrf

                        <!-- Amount -->
                        <div>
                            <x-label for="amount" :value="__('Withdrawal Amount (GHS)')" />
                            <x-input id="amount" class="block mt-1 w-full" type="number" name="amount" :value="old('amount')" required step="0.01" min="1" max="{{ Auth::user()->projected_roi }}" autofocus />
                            @error('amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Payment Details -->
                        <div class="mt-4">
                            <x-label for="payment_details" :value="__('Payment Details (E.g. Momo Number & Name)')" />
                            <textarea id="payment_details" name="payment_details" rows="4" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>{{ old('payment_details') }}</textarea>
                             @error('payment_details') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Submit Request') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Set up Two-Factor Authentication') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 text-center">
                    
                    <h3 class="text-lg font-bold mb-4">Protect Your Account</h3>
                    <p class="mb-6 text-gray-600">Scan this QR code with your authenticator app (e.g., Google Authenticator, Authy).</p>

                    <div class="flex justify-center mb-6">
                        {!! $qrCodeSvg !!}
                    </div>

                    <p class="mb-6 text-sm text-gray-500">Manual Key: <strong>{{ $secret }}</strong></p>

                    <form method="POST" action="{{ route('admin.2fa.verify.store') }}" class="max-w-xs mx-auto">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="code" class="sr-only">Authentication Code</label>
                            <input type="text" name="code" id="code" placeholder="Enter 6-digit code" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline text-center tracking-widest text-xl" required autofocus autocomplete="one-time-code" inputmode="numeric" pattern="[0-9]*">
                            @error('code')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full transition duration-150 ease-in-out">
                            Verify & Enable
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

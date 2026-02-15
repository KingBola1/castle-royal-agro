<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Two-Factor Authentication Verification') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 max-w-md mx-auto">
                    
                    <div class="text-center mb-6">
                        <svg class="mx-auto h-12 w-12 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-900">Authentication Required</h3>
                        <p class="mt-1 text-sm text-gray-500">Please enter the 6-digit code from your authenticator app.</p>
                    </div>

                    <form method="POST" action="{{ route('admin.2fa.verify.store') }}">
                        @csrf
                        
                        <div class="mb-6">
                            <label for="code" class="block text-sm font-medium text-gray-700 mb-2">Authentication Code</label>
                            <input type="text" name="code" id="code" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md text-center tracking-widest text-2xl py-3" placeholder="000 000" required autofocus autocomplete="one-time-code" inputmode="numeric" pattern="[0-9]*">
                            @error('code')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Verify Login
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

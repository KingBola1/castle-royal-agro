<x-guest-layout>
    {{-- Header with Logo/Icon --}}
    <div class="text-center mb-6">
        <svg class="w-16 h-16 mx-auto text-green-700 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
        </svg>
        <h2 class="mt-4 text-2xl font-bold text-gray-900">{{ __('Verify Your Email') }}</h2>
    </div>

    <div class="mb-4 text-sm text-gray-600 leading-relaxed text-center">
        {{ __('You are currently logged in as ') }} 
        <span class="font-bold text-amber-900">{{ Auth::user()->email }}</span>.
        <br/><br/>
        {{ __('Thanks for partnering with Castle Royal Agro! Before accessing your dashboard, please verify your email address by clicking the link we just emailed to you.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 p-4 rounded-md bg-green-50 border border-green-200">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">
                        {{ __('A new verification link has been sent to your email.') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    <div class="mt-8 space-y-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <div>
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-full shadow-sm text-sm font-bold text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150">
                    {{ __('Resend Verification Email') }}
                </button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-full shadow-sm text-sm font-bold text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                {{ __('Not You? Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>

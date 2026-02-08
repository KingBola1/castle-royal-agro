<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Saved Payment Details') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Save your Mobile Money or Bank details here. These will auto-fill your Withdrawal Requests.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.payment-details') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <label for="payment_details" class="block font-medium text-sm text-gray-700">{{ __('Payment Information') }}</label>
            <textarea id="payment_details" name="payment_details" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="e.g. MTN MoMo - John Doe - 0244123456" required>{{ old('payment_details', $user->payment_details) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('payment_details')" />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Save Details') }}
            </button>

            @if (session('status') === 'Payment details updated.')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

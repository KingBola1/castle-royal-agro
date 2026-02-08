<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg border-l-4 border-indigo-500">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">Saved Payment Details</h2>
                            <p class="mt-1 text-sm text-gray-600">These will auto-fill your Withdrawal Requests.</p>
                        </header>
                        <form method="post" action="{{ route('profile.payment-details') }}" class="mt-6 space-y-6">
                            @csrf @method('patch')
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Mobile Money Details</label>
                                <textarea name="momo_details" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('momo_details', Auth::user()->momo_details) }}</textarea>
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Bank Details</label>
                                <textarea name="bank_details" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('bank_details', Auth::user()->bank_details) }}</textarea>
                            </div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 text-white">Save Details</button>
                        </form>
                    </section>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg" x-data="{ show: false }">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">{{ __('Update Password') }}</h2>
                            <p class="mt-1 text-sm text-gray-600">{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
                        </header>

                        <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                            @csrf @method('put')

                            <div class="flex items-center mb-4">
                                <input type="checkbox" @click="show = !show" id="show_passwords" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <label for="show_passwords" class="ml-2 text-sm text-gray-600 cursor-pointer select-none">Show Passwords</label>
                            </div>

                            <div>
                                <label for="current_password" class="block font-medium text-sm text-gray-700">{{ __('Current Password') }}</label>
                                <input id="current_password" name="current_password" :type="show ? 'text' : 'password'" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" autocomplete="current-password" />
                                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                            </div>

                            <div>
                                <label for="password" class="block font-medium text-sm text-gray-700">{{ __('New Password') }}</label>
                                <input id="password" name="password" :type="show ? 'text' : 'password'" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" autocomplete="new-password" />
                                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                            </div>

                            <div>
                                <label for="password_confirmation" class="block font-medium text-sm text-gray-700">{{ __('Confirm Password') }}</label>
                                <input id="password_confirmation" name="password_confirmation" :type="show ? 'text' : 'password'" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" autocomplete="new-password" />
                                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                            </div>

                            <div class="flex items-center gap-4">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 text-white">{{ __('Save') }}</button>
                                @if (session('status') === 'password-updated')
                                    <p class="text-sm text-green-600">{{ __('Saved.') }}</p>
                                @endif
                            </div>
                        </form>
                    </section>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

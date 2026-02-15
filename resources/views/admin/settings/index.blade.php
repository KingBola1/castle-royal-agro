<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('System Settings & Security') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-red-200">
                <div class="p-6 bg-red-50 border-b border-red-200">
                    <h3 class="text-lg font-bold text-red-700 mb-2">Danger Zone: Transfer System Ownership</h3>
                    <p class="text-sm text-red-600 mb-4">
                        Transferring ownership will instantly strip your "God Mode" privileges and hand them to the target email address. You will be downgraded to a standard Super Admin and logged out immediately. <strong>This action cannot be undone by you.</strong>
                    </p>

                    <form method="POST" action="{{ route('admin.settings.transfer') }}" onsubmit="return confirm('CRITICAL WARNING: Are you absolutely sure you want to transfer System Ownership? You will lose ultimate control of the platform.');">
                        @csrf
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-red-700">New Owner's Registered Email Address</label>
                            <input type="email" name="email" id="email" class="mt-1 block w-full rounded-md border-red-300 shadow-sm focus:border-red-500 focus:ring-red-500" required placeholder="Enter exact email address...">
                            @error('email') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded shadow">
                                Transfer Ownership Now
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

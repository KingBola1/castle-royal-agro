<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Package') }}: {{ $package->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('admin.packages.update', $package) }}">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Package Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $package->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" rows="4">{{ old('description', $package->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Price -->
                            <div class="mb-4">
                                <x-input-label for="price" :value="__('Price per Unit (GHS)')" />
                                <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price', $package->price)" step="0.01" required />
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>

                            <!-- ROI -->
                            <div class="mb-4">
                                <x-input-label for="roi_percentage" :value="__('ROI Percentage (%)')" />
                                <x-text-input id="roi_percentage" class="block mt-1 w-full" type="number" name="roi_percentage" :value="old('roi_percentage', $package->roi_percentage)" step="0.01" required />
                                <x-input-error :messages="$errors->get('roi_percentage')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Duration -->
                            <div class="mb-4">
                                <x-input-label for="duration_months" :value="__('Duration (Months)')" />
                                <x-text-input id="duration_months" class="block mt-1 w-full" type="number" name="duration_months" :value="old('duration_months', $package->duration_months)" required />
                                <x-input-error :messages="$errors->get('duration_months')" class="mt-2" />
                            </div>

                            <!-- Status -->
                            <div class="mb-4">
                                <x-input-label for="status" :value="__('Status')" />
                                <select id="status" name="status" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="draft" {{ old('status', $package->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="open" {{ old('status', $package->status) == 'open' ? 'selected' : '' }}>Open</option>
                                    <option value="closed" {{ old('status', $package->status) == 'closed' ? 'selected' : '' }}>Closed</option>
                                    <option value="sold_out" {{ old('status', $package->status) == 'sold_out' ? 'selected' : '' }}>Sold Out</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Image URL -->
                        <div class="mb-4">
                            <x-input-label for="image" :value="__('Image Path / URL')" />
                            <x-text-input id="image" class="block mt-1 w-full" type="text" name="image" :value="old('image', $package->image)" />
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.packages.index') }}" class="text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-4">Cancel</a>
                            <x-primary-button>
                                {{ __('Update Package') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

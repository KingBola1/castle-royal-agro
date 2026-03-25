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
                    
                    <form method="POST" action="{{ route('admin.packages.update', $package) }}" enctype="multipart/form-data">
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

                        <!-- Current Image Display -->
                        @if($package->image)
                        <div class="mb-4">
                            <x-input-label :value="__('Current Image')" />
                            <img src="{{ filter_var($package->image, FILTER_VALIDATE_URL) ? $package->image : asset('storage/' . $package->image) }}" alt="{{ $package->name }}" class="h-20 w-20 object-cover rounded mt-2">
                        </div>
                        @endif

                        <!-- Image Upload (File) -->
                        <div class="mb-4">
                            <x-input-label for="image" :value="__('Upload New Image (From Computer)')" />
                            <input id="image" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" type="file" name="image">
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            <p class="text-sm text-gray-500 mt-1">Leave empty to keep your current image.</p>
                        </div>

                        <!-- Image URL (Fallback) -->
                        <div class="mb-4">
                            <x-input-label for="image_url" :value="__('Or Paste New Image URL')" />
                            <x-text-input id="image_url" class="block mt-1 w-full" type="text" name="image_url" placeholder="https://example.com/image.jpg" />
                            <x-input-error :messages="$errors->get('image_url')" class="mt-2" />
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

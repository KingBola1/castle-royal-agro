<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Investment Package') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('admin.packages.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Name -->
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Package Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" rows="4">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Price -->
                            <div class="mb-4">
                                <x-input-label for="price" :value="__('Price per Unit (GHS)')" />
                                <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price')" step="0.01" required />
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>

                            <!-- ROI -->
                            <div class="mb-4">
                                <x-input-label for="roi_percentage" :value="__('ROI Percentage (%)')" />
                                <x-text-input id="roi_percentage" class="block mt-1 w-full" type="number" name="roi_percentage" :value="old('roi_percentage')" step="0.01" required />
                                <x-input-error :messages="$errors->get('roi_percentage')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Duration -->
                            <div class="mb-4">
                                <x-input-label for="duration_months" :value="__('Duration (Months)')" />
                                <x-text-input id="duration_months" class="block mt-1 w-full" type="number" name="duration_months" :value="old('duration_months')" required />
                                <x-input-error :messages="$errors->get('duration_months')" class="mt-2" />
                            </div>

                            <!-- Status -->
                            <div class="mb-4">
                                <x-input-label for="status" :value="__('Status')" />
                                <select id="status" name="status" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="open" {{ old('status') == 'open' ? 'selected' : '' }}>Open</option>
                                    <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                                    <option value="sold_out" {{ old('status') == 'sold_out' ? 'selected' : '' }}>Sold Out</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Image URL (For now, simple text input as per request implies 'path' might be text or file, but usually requires file upload logic. User said 'image (string, nullable) - Path'. I'll stick to text input for URL or filename for simplicity unless asked for upload) -->
                        <!-- Image Upload (File) -->
                        <div class="mb-4">
                            <x-input-label for="image" :value="__('Upload Image (From Computer)')" />
                            <input id="image" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" type="file" name="image">
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        <!-- Image URL (Fallback) -->
                        <div class="mb-4">
                            <x-input-label for="image_url" :value="__('Or Paste Image URL')" />
                            <x-text-input id="image_url" class="block mt-1 w-full" type="text" name="image_url" :value="old('image_url')" placeholder="https://example.com/image.jpg" />
                            <x-input-error :messages="$errors->get('image_url')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                             <a href="{{ route('admin.packages.index') }}" class="text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-4">Cancel</a>
                            <x-primary-button>
                                {{ __('Create Package') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Investment Marketplace') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('status') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($packages as $package)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col h-full">
                        <!-- Image Handling -->
                        @if($package->image)
                            <img src="{{ asset($package->image) }}" alt="{{ $package->name }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                                No Image
                            </div>
                        @endif

                        <div class="p-6 flex-grow">
                            <h3 class="text-xl font-bold mb-2">{{ $package->name }}</h3>
                            <div class="text-gray-600 mb-4 text-sm">{{ Str::limit($package->description, 100) }}</div>
                            
                            <div class="grid grid-cols-2 gap-4 text-sm mb-4">
                                <div>
                                    <span class="block text-gray-500">Price per Unit</span>
                                    <span class="font-semibold">GHS {{ number_format($package->price, 2) }}</span>
                                </div>
                                <div>
                                    <span class="block text-gray-500">Exp. ROI</span>
                                    <span class="font-semibold text-green-600">{{ $package->roi_percentage }}%</span>
                                </div>
                                <div>
                                    <span class="block text-gray-500">Duration</span>
                                    <span class="font-semibold">{{ $package->duration_months }} Months</span>
                                </div>
                            </div>
                        </div>

                        <div class="p-6 pt-0 mt-auto">
                            <a href="{{ route('marketplace.show', $package) }}" class="block w-full text-center bg-gray-800 text-white font-bold py-2 px-4 rounded hover:bg-gray-700 transition">
                                View Investment
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-10 text-gray-500">
                        No active investment packages found at the moment. Please check back later.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>

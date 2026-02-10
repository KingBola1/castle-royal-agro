<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User Roles & Permissions') }}: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('users.update', $user->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Roles Config -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Roles</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                @foreach($roles as $role)
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="roles[]" value="{{ $role->name }}" 
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                               {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                                        <span class="ml-2 text-gray-700 capitalize">{{ $role->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <hr class="my-6">

                        <!-- Permissions Config -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Direct Permissions (Optional)</h3>
                            <p class="text-sm text-gray-500 mb-4">Usually handled by roles, but can be assigned directly here.</p>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                @foreach($permissions as $permission)
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" 
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                               {{ $user->hasDirectPermission($permission->name) ? 'checked' : '' }}>
                                        <span class="ml-2 text-gray-700 capitalize">{{ $permission->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                             <a href="{{ route('users.index') }}" class="mr-4 text-gray-600 hover:text-gray-900">Cancel</a>
                            <x-primary-button class="ml-3">
                                {{ __('Update Assignments') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

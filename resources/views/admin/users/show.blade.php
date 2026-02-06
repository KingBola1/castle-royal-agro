<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage User') }}: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">User Personal Information</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <span class="block text-sm font-bold text-gray-500">Full Name</span>
                            <span class="block text-gray-900">{{ $user->name }}</span>
                        </div>
                        <div>
                            <span class="block text-sm font-bold text-gray-500">Email</span>
                            <span class="block text-gray-900">{{ $user->email }}</span>
                        </div>
                        <div>
                            <span class="block text-sm font-bold text-gray-500">Phone</span>
                            <span class="block text-gray-900">{{ $user->phone ?? 'Not Provided' }}</span>
                        </div>
                        <div>
                            <span class="block text-sm font-bold text-gray-500">Ghana Card ID</span>
                            <span class="block text-gray-900">{{ $user->ghana_card_id ?? 'Not Provided' }}</span>
                        </div>
                         <div>
                            <span class="block text-sm font-bold text-gray-500">Next of Kin</span>
                            <span class="block text-gray-900">{{ $user->next_of_kin_name ?? 'Not Provided' }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Account Actions</h3>
                    
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                            <select name="role" id="role" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="investor" {{ $user->role == 'investor' ? 'selected' : '' }}>Investor</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="super_admin" {{ $user->role == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Current Role: <strong>{{ $user->role }}</strong></p>
                        </div>

                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="frozen" {{ $user->status == 'frozen' ? 'selected' : '' }}>Frozen</option>
                                <option value="blocked" {{ $user->status == 'blocked' ? 'selected' : '' }}>Blocked</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none">
                            Save Changes
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

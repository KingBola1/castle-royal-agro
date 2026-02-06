<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Platform Administration') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">User Management</h3>
                        {{-- Placeholder for future filters or export buttons --}}
                    </div>

                    <div class="overflow-x-auto relative">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3 px-6">Name & Email</th>
                                    <th scope="col" class="py-3 px-6">Role</th>
                                    <th scope="col" class="py-3 px-6">Status</th>
                                    <th scope="col" class="py-3 px-6">Joined Date</th>
                                    <th scope="col" class="py-3 px-6 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                            <div class="flex flex-col">
                                                <span class="font-bold">{{ $user->name }}</span>
                                                <span class="text-xs text-gray-400">{{ $user->email }}</span>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6">
                                            @if($user->role === 'super_admin')
                                                <span class="bg-red-100 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">Super Admin</span>
                                            @elseif($user->role === 'admin')
                                                <span class="bg-red-100 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">Admin</span>
                                            @else
                                                <span class="bg-gray-100 text-gray-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">Investor</span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6">
                                            {{-- Assuming a 'status' column exists or using logic. Defaulting to Active for now as requested. --}}
                                            {{-- If you have a specific status column, replace 'true' with $user->is_active or similar --}}
                                             @if($user->status === 'active' || !$user->status) 
                                                <span class="bg-green-100 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">Active</span>
                                            @else
                                                 <span class="bg-red-100 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">Frozen</span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6">
                                            {{ $user->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="py-4 px-6 text-right">
                                            <a href="#" class="font-medium text-blue-600 hover:text-blue-500 hover:underline">Manage</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

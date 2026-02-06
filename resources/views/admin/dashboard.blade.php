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
                                    <th scope="col" class="py-3 px-6 w-16">ID</th>
                                    <th scope="col" class="py-3 px-6">NAME</th>
                                    <th scope="col" class="py-3 px-6">EMAIL</th>
                                    <th scope="col" class="py-3 px-6">ROLE</th>
                                    <th scope="col" class="py-3 px-6">STATUS</th>
                                    <th scope="col" class="py-3 px-6">DATE JOINED</th>
                                    <th scope="col" class="py-3 px-6 text-right">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        {{-- ID Column --}}
                                        <td class="py-4 px-6">
                                            {{ $user->id }}
                                        </td>
                                        
                                        {{-- Name Column --}}
                                        <td class="py-4 px-6 font-medium text-gray-900">
                                            {{ $user->name }}
                                        </td>

                                        {{-- Email Column --}}
                                        <td class="py-4 px-6 text-gray-500">
                                            {{ $user->email }}
                                        </td>

                                        {{-- Role Column --}}
                                        <td class="py-4 px-6">
                                            @if($user->role === 'super_admin')
                                                <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">Super Admin</span>
                                            @elseif($user->role === 'admin')
                                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">Admin</span>
                                            @else
                                                <span class="bg-gray-100 text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded">Investor</span>
                                            @endif
                                        </td>

                                        {{-- Status Column --}}
                                        <td class="py-4 px-6">
                                            @if($user->status === 'active' || !$user->status) 
                                                <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">Active</span>
                                            @else
                                                 <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded">Frozen</span>
                                            @endif
                                        </td>

                                        {{-- Date Joined Column --}}
                                        <td class="py-4 px-6">
                                            {{ $user->created_at->format('M d, Y') }}
                                        </td>

                                        {{-- Actions Column --}}
                                        <td class="py-4 px-6 text-right">
                                            <a href="{{ route('admin.users.show', $user->id) }}" class="font-medium text-indigo-600 hover:text-indigo-900 hover:underline">Manage</a>
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

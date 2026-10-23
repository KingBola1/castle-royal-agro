<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Global Audit Trail') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    {{-- NEW BUTTON HEADER STARTS HERE --}}
                    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 border-b pb-4">
                        <h3 class="text-xl font-bold text-gray-900">System Activity Feed</h3>
                        
                        <div class="flex space-x-3 mt-4 sm:mt-0">
                            <!-- Excel/CSV Button -->
                            <a href="{{ route('admin.reports.audit-logs', ['format' => 'csv']) }}" class="inline-flex items-center px-4 py-2 bg-green-50 border border-green-600 rounded-md font-semibold text-xs text-green-700 uppercase tracking-widest hover:bg-green-600 hover:text-white transition shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Download Excel
                            </a>
                            <!-- PDF Button -->
                            <a href="{{ route('admin.reports.audit-logs', ['format' => 'pdf']) }}" class="inline-flex items-center px-4 py-2 bg-red-50 border border-red-600 rounded-md font-semibold text-xs text-red-700 uppercase tracking-widest hover:bg-red-600 hover:text-white transition shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                Download PDF
                            </a>
                        </div>
                    </div>
                    {{-- NEW BUTTON HEADER ENDS HERE --}}

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Date & Time</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Admin / Staff</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Action Taken</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Affected User</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Details</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($logs as $log)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $log->created_at->format('M d, Y - h:i A') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-indigo-600">
                                            @if($log->admin_id === $log->user_id && $log->action === 'Withdrawal Requested')
                                                <span class="text-gray-500 italic">Self-Service</span>
                                            @else
                                                {{ $log->admin->name ?? 'System' }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                {{ $log->action }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $log->user->name ?? 'N/A' }} <br>
                                            <span class="text-xs text-gray-400">{{ $log->user->email ?? '' }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 w-1/3">
                                            {{ $log->details }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No system activity recorded yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $logs->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
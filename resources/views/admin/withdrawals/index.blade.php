<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Withdrawal Requests') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    {{-- REPORT BUTTONS HEADER --}}
                    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 border-b pb-4">
                        <h3 class="text-xl font-bold text-gray-900">Withdrawal Records</h3>
                        <div class="flex space-x-3 mt-4 sm:mt-0">
                            <a href="{{ route('admin.reports.withdrawals', ['format' => 'csv']) }}" class="inline-flex items-center px-4 py-2 bg-green-50 border border-green-600 rounded-md font-semibold text-xs text-green-700 uppercase tracking-widest hover:bg-green-600 hover:text-white transition shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg> Download Excel
                            </a>
                            <a href="{{ route('admin.reports.withdrawals', ['format' => 'pdf']) }}" class="inline-flex items-center px-4 py-2 bg-red-50 border border-red-600 rounded-md font-semibold text-xs text-red-700 uppercase tracking-widest hover:bg-red-600 hover:text-white transition shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg> Download PDF
                            </a>
                        </div>
                    </div>

                    @if (session('status'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Success!</strong>
                            <span class="block sm:inline">{{ session('status') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Error!</strong>
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Holder</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Details</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($withdrawals as $withdrawal)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $withdrawal->created_at->format('M d, Y H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $withdrawal->user->name }}<br>
                                            <span class="text-xs text-gray-400">{{ $withdrawal->user->email }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">GH₵ {{ number_format($withdrawal->amount, 2) }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">{{ $withdrawal->payment_details }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($withdrawal->status === 'pending')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                            @elseif($withdrawal->status === 'approved')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            @if($withdrawal->status === 'pending')
                                                <div class="flex space-x-2">
                                                    @if(auth()->user()->hasAnyRole(['System Owner', 'Super Admin', 'super_admin']) || auth()->user()->hasDirectPermission('manage_withdrawals'))
                                                        <form action="{{ route('admin.withdrawals.approve', $withdrawal->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to approve this withdrawal? This will notify the holder.');">
                                                            @csrf
                                                            <button type="submit" class="text-green-600 hover:text-green-900 font-bold">Approve</button>
                                                        </form>
                                                        <span class="text-gray-300">|</span>
                                                        <form action="{{ route('admin.withdrawals.reject', $withdrawal->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to REJECT this withdrawal?');">
                                                            @csrf
                                                            <button type="submit" class="text-red-600 hover:text-red-900 font-bold">Reject</button>
                                                        </form>
                                                    @else
                                                        <span class="text-gray-400 text-sm italic">Restricted</span>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-gray-400 italic">No actions</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $withdrawals->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
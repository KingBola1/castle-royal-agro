<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-amber-900 leading-tight">
            @if(auth()->user()->hasAnyRole(['System Owner', 'Super Admin', 'super_admin', 'Admin', 'admin']))
                Staff Dashboard
            @else
                Investor Portfolio
            @endif
        </h2>
    </x-slot>

    {{-- Main Background: Golden Lemon Green Moringa Pattern --}}
    <div class="py-12 min-h-screen relative bg-cover bg-center bg-fixed" 
         style="background-image: url('{{ asset('images/backgrounds/moringa_pattern.png') }}');">
        
        {{-- Success Message --}}
        @if (session('status'))
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4 relative z-10">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">{{ session('status') }}</span>
                </div>
            </div>
        @endif

        {{-- Overlay to ensure text readability --}}
        <div class="absolute inset-0 bg-white/80 z-0"></div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-10">

       {{-- SECURE BACK-OFFICE BUTTON --}}
            @if(Auth::user()->role === 'super_admin' || Auth::user()->role === 'admin' || Auth::user()->role === 'System Owner')
            <div class="mb-6 bg-red-50 border-l-4 border-red-600 p-4 rounded shadow-sm flex justify-between items-center">
                <div>
                    <h3 class="text-red-800 font-bold text-lg">System Management</h3>
                    <p class="text-sm text-red-600">Access the secure back-office to manage users and investments.</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="bg-red-700 hover:bg-red-800 text-white font-bold py-3 px-6 rounded-lg shadow-md uppercase tracking-wider transition transform hover:scale-105">
                    Enter Back-Office
                </a>
            </div>
            @endif
            
            {{-- Section 1: Welcome & Status --}}
            {{-- Border Top is YELLOW (Gold) --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-8 border-t-8 border-yellow-500">
                <div class="p-8 bg-white border-b border-gray-200">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <div>
                            {{-- Text is GREEN (Moringa) --}}
                            <h3 class="text-3xl font-bold text-green-700">
                                Welcome, {{ $user->name }}!
                                @if(Auth::user()->role === 'super_admin' || Auth::user()->role === 'admin')
                                    <span class="ml-2 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-full uppercase tracking-wide">
                                        {{ str_replace('_', ' ', Auth::user()->role) }}
                                    </span>
                                @endif
                            </h3>
                            <p class="text-gray-500 mt-2 text-lg">
                                Investor ID: <span class="font-mono text-amber-800 font-bold">CRA-{{ $user->id }}-{{ $user->created_at->format('Y') }}</span>
                            </p>
                        </div>
                        <div class="mt-4 md:mt-0 text-center md:text-right">
                            <span class="inline-flex items-center px-5 py-2 rounded-full text-sm font-bold bg-green-100 text-green-800 border border-green-200 shadow-sm">
                                <span class="w-3 h-3 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                                Account Active
                            </span>
                            <p class="text-xs text-gray-400 mt-2">Member since {{ $user->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section 2: Financial Stats Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                
                {{-- Card 1: Total Investment --}}
                <div class="bg-white overflow-hidden shadow-lg rounded-xl p-8 border border-gray-100 hover:shadow-2xl transition duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-sm font-bold text-gray-400 uppercase tracking-widest">Total Invested</h4>
                        <div class="p-3 bg-yellow-50 rounded-full">
                            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    <p class="text-4xl font-extrabold text-amber-900">GH₵ {{ number_format($totalInvested, 2) }}</p>
                    <p class="text-sm text-gray-400 mt-2">Acres Secured: {{ $activeAcres }}</p>
                </div>

                {{-- Card 2: Total Withdrawn --}}
                <div class="bg-white overflow-hidden shadow-lg rounded-xl p-8 border border-gray-100 hover:shadow-2xl transition duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-sm font-bold text-gray-400 uppercase tracking-widest">Total Withdrawn</h4>
                        <div class="p-3 bg-red-50 rounded-full">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                    </div>
                    <p class="text-4xl font-extrabold text-amber-900">GH₵ {{ number_format($totalWithdrawn ?? 0, 2) }}</p>
                    <p class="text-sm text-gray-400 mt-2">Successful Payouts</p>
                </div>

                {{-- Card 3: Total Amount Left --}}
                <div class="bg-white overflow-hidden shadow-lg rounded-xl p-8 border border-gray-100 hover:shadow-2xl transition duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-sm font-bold text-gray-400 uppercase tracking-widest">Total Amount Left</h4>
                        <div class="p-3 bg-blue-50 rounded-full">
                            {{-- Icon: Suitcase/Wallet --}}
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        </div>
                    </div>
                    <p class="text-4xl font-extrabold text-amber-900">GH₵ {{ number_format($totalAmountLeft ?? 0, 2) }}</p>
                    <p class="text-sm text-gray-400 mt-2">Available Balance</p>
                </div>

                {{-- Card 2: Active Acres --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-gray-500 text-sm font-medium uppercase tracking-wide">Land Portfolio</div>
                    <div class="mt-2 flex items-baseline">
                        <span class="text-3xl font-extrabold text-gray-900">
                            {{ number_format(Auth::user()->active_acres, 1) }}
                        </span>
                        <span class="ml-2 text-sm font-medium text-gray-500">Acres</span>
                    </div>
                </div>

                {{-- Card 3: Projected ROI --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-indigo-500 relative">
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="text-gray-500 text-sm font-medium uppercase tracking-wide">Projected Cash Return</div>
                            <div class="mt-2 flex items-baseline">
                                <span class="text-3xl font-extrabold text-gray-900">
                                    GH₵ {{ number_format($projectedRoi, 2) }}
                                </span>
                                <span class="ml-2 text-sm font-medium text-gray-500">Available</span>
                            </div>
                        </div>
                        <a href="{{ route('withdrawals.create') }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none transition">
                            Request Payout
                        </a>
                    </div>
                </div>

                {{-- Card 3: Action Required --}}
                <div class="bg-amber-900 overflow-hidden shadow-lg rounded-xl p-8 text-white relative group cursor-pointer">
                    <div class="relative z-10">
                        <p class="text-xs font-bold text-yellow-400 uppercase tracking-widest mb-1">Action Required</p>
                        <h4 class="text-2xl font-bold mb-4">Complete Profile</h4>
                        <p class="text-sm text-gray-200 mb-6">Add your Phone, Next of Kin, and Ghana Card to unlock investments.</p>
                        <a href="{{ route('profile.edit') }}" class="inline-block w-full bg-yellow-500 text-amber-900 text-center font-bold py-3 px-4 rounded shadow hover:bg-white hover:text-green-700 transition duration-300">
                            Go to Settings
                        </a>
                    </div>
                </div>
            </div>

            {{-- Section 3: Wallet Settings --}}
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        💼 Wallet Settings
                    </h3>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <form method="post" action="{{ route('profile.payment-details') }}">
                            @csrf
                            @method('patch')

                            {{-- MoMo Details --}}
                            <div class="mb-4">
                                <label for="momo_details" class="block font-medium text-sm text-gray-700">
                                    Mobile Money Details
                                </label>
                                <textarea id="momo_details" name="momo_details" rows="2" 
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" 
                                    placeholder="e.g. MTN MoMo - 0244 000 000 - John Doe">{{ Auth::user()->momo_details }}</textarea>
                            </div>

                            {{-- Bank Details --}}
                            <div class="mb-4">
                                <label for="bank_details" class="block font-medium text-sm text-gray-700">
                                    Bank Account Details
                                </label>
                                <textarea id="bank_details" name="bank_details" rows="2" 
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" 
                                    placeholder="e.g. GCB Bank - Accra Branch - Account Number - Name">{{ Auth::user()->bank_details }}</textarea>
                            </div>

                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none transition">
                                Save Wallet Settings
                            </button>
                            
                            <p class="mt-2 text-xs text-gray-500">
                                Saved details will auto-fill your Withdrawal Requests.
                            </p>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Section 4: Investment History --}}
            <div class="flex justify-between items-center mt-8 mb-4">
                <h3 class="text-xl font-bold text-amber-900 pl-2 border-l-4 border-green-700"> Your Investment History</h3>
                <a href="{{ route('marketplace.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none">
                    Browse Marketplace
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                @if($investments->isEmpty())
                    <div class="p-12 text-center">
                        <div class="mx-auto h-24 w-24 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                            <svg class="h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">No Investments Yet</h3>
                        <p class="mt-2 text-gray-500 max-w-sm mx-auto">You haven't purchased any packages yet.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Package</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Units</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount Invested</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Exp. ROI</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($investments as $investment)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $investment->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $investment->package->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $investment->units }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                            GH₵ {{ number_format($investment->amount_invested, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">
                                            GH₵ {{ number_format($investment->expected_roi, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($investment->status === 'active') bg-green-100 text-green-800 
                                                @elseif($investment->status === 'pending') bg-yellow-100 text-yellow-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ ucfirst($investment->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            {{-- Section 4: Withdrawal History --}}
            <h3 class="text-xl font-bold text-amber-900 mb-4 pl-2 border-l-4 border-yellow-500 mt-8"> Withdrawal History</h3>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 mb-8">
                @if(Auth::user()->withdrawals->isEmpty())
                    <div class="p-6 text-center text-gray-500">
                        No withdrawal history found.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach(Auth::user()->withdrawals as $withdrawal)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $withdrawal->created_at->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">GH₵ {{ number_format($withdrawal->amount, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($withdrawal->status === 'pending')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                            @elseif($withdrawal->status === 'approved')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
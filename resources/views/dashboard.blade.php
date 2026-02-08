<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-amber-900 leading-tight">
            {{ __('Investor Portfolio') }}
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
                                    GH₵ {{ number_format(Auth::user()->projected_roi, 2) }}
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

                            <label for="payment_details" class="block font-medium text-sm text-gray-700">
                                Default Payment Details (Auto-Fill for Withdrawals)
                            </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <textarea id="payment_details" name="payment_details" rows="2" 
                                    class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-l-md sm:text-sm border-gray-300" 
                                    placeholder="e.g. MTN MoMo - 0244 000 000 - John Doe">{{ Auth::user()->payment_details }}</textarea>
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-r-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none">
                                    Save
                                </button>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">
                                Enter your MoMo Name & Number here. Next time you request a payout, this will be typed for you automatically!
                            </p>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Section 4: Investment History --}}
            <h3 class="text-xl font-bold text-amber-900 mb-4 pl-2 border-l-4 border-green-700 mt-8"> Your Investment History</h3>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                @if($investments->isEmpty())
                    <div class="p-12 text-center">
                        <div class="mx-auto h-24 w-24 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                            <svg class="h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">No Investments Yet</h3>
                        <p class="mt-2 text-gray-500 max-w-sm mx-auto">You haven't purchased any Moringa acres yet.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Package</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount (GH₵)</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ROI Rate</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Exp. Profit</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acres</th>
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
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $investment->package_name ?? 'Custom Investment' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                            {{ number_format($investment->amount, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $investment->roi_percentage ?? 'N/A' }}%
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-700">
                                            GH₵ {{ number_format($investment->projected_profit, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $investment->acres }} Acres
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 uppercase">
                                                {{ $investment->status }}
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
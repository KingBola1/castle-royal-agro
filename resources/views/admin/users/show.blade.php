<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage User') }}: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- LEFT COLUMN: Read-Only Info -->
                    <div class="space-y-6">
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
                    </div>

                    <!-- RIGHT COLUMN: Editable Actions -->
                    <div class="space-y-6">

                        <!-- ACCESS TOOLS (Magic Link) - Independent Form -->
                        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">🔑 Access Tools</h3>

                            <div class="mb-6">
                                <p class="text-sm text-gray-600 mb-2">Generate a temporary link to log this user in automatically (valid for 30 mins).</p>
                                <form action="{{ route('admin.users.magic-link', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 active:bg-indigo-600 transition">
                                        Generate Magic Link
                                    </button>
                                </form>
                            </div>

                            @if(session('success') && str_contains(session('success'), 'http'))
                                <div class="bg-green-50 p-4 rounded-md border border-green-200 mb-4 break-all">
                                    <p class="text-xs font-bold text-green-800 uppercase mb-1">Copy and Send this Link:</p>
                                    <code class="text-sm text-indigo-700 select-all">{{ session('success') }}</code>
                                </div>
                            @endif
                        </div>
                        
                        <!-- HIDDEN FORM FOR PASSWORD RESET (to avoid nesting) -->
                        <form id="password-reset-form" action="{{ route('admin.users.reset-password', $user->id) }}" method="POST" class="hidden">@csrf</form>

                        <!-- MAIN UPDATE FORM -->
                        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <!-- Account Actions Card (Role/Status) -->
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Account Actions</h3>
                                
                                    </select>
                                    <p class="text-xs text-gray-500 mt-1">
                                        Current Role: 
                                        <span class="font-semibold text-gray-900">
                                            @forelse($user->roles as $role)
                                                {{ ucfirst($role->name) }}{{ !$loop->last ? ', ' : '' }}
                                            @empty
                                                <span class="text-gray-400">No Role</span>
                                            @endforelse
                                        </span>
                                    </p>
                                </div>

                                <div class="mb-4">
                                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                    <select name="status" id="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                        <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="frozen" {{ $user->status == 'frozen' ? 'selected' : '' }}>Frozen</option>
                                        <option value="blocked" {{ $user->status == 'blocked' ? 'selected' : '' }}>Blocked</option>
                                    </select>
                                </div>
                                    </select>
                                </div>
                                
                                <div class="mt-6 border-t border-gray-200 pt-4">
                                    <label for="new_password" class="block text-sm font-medium text-red-700">Manual Password Reset</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <input type="text" name="new_password" form="password-reset-form" id="new_password" required minlength="6" class="focus:ring-red-500 focus:border-red-500 flex-1 block w-full rounded-l-md sm:text-sm border-gray-300" placeholder="New Password">
                                        <button type="submit" form="password-reset-form" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-r-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            Reset
                                        </button>
                                    </div>
                                    <p class="mt-1 text-xs text-red-500">Warning: Immediate override.</p>
                                </div>
                            </div>

                            <!-- Investment Portfolio -->
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Investment Portfolio</h3>

                                <div class="mb-4">
                                    <label for="total_invested" class="block text-sm font-medium text-gray-700">Total Invested (GHS)</label>
                                    <input type="number" name="total_invested" id="total_invested" step="0.01" value="{{ $user->total_invested }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                                </div>

                                <div class="mb-4">
                                    <label for="active_acres" class="block text-sm font-medium text-gray-700">Active Acres</label>
                                    <input type="number" name="active_acres" id="active_acres" step="0.1" value="{{ $user->active_acres }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                                </div>

                                <div class="mb-4">
                                    <label for="projected_roi" class="block text-sm font-medium text-gray-700">Projected ROI (GHS)</label>
                                    <input type="number" name="projected_roi" id="projected_roi" step="0.01" value="{{ $user->projected_roi }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                            </div>

                            <!-- Global Save Button -->
                            <button type="submit" class="w-full inline-flex justify-center py-3 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Save Changes
                            </button>
                        </form>

                    </div>
                </div>
            
            {{-- Add New Transaction --}}
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-green-500">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Add New Transaction (Receipt)</h3>
                @if(session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif
                
                <form action="{{ route('admin.users.invest', $user->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end bg-gray-50 p-4 rounded-lg">
                    @csrf
                    
                    {{-- Package Selector --}}
                    <div class="col-span-1 md:col-span-4">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Select Package (Optional)</label>
                        <select id="packageSelect" onchange="applyPackage()" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">-- Choose a Preset --</option>
                            @foreach($packages as $pkg)
                                <option value="{{ $pkg->id }}" 
                                    data-name="{{ $pkg->name }}"
                                    data-amount="{{ $pkg->amount }}" 
                                    data-roi="{{ $pkg->roi_percentage }}" 
                                    data-acres="{{ $pkg->acres }}">
                                    {{ $pkg->name }} - {{ number_format($pkg->amount) }} GHS ({{ $pkg->acres ?? 'N/A' }} Acres)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-1 md:col-span-4">
                        <label for="package_name" class="block text-xs font-bold text-gray-700 uppercase">Package/Transaction Name</label>
                        <input type="text" name="package_name" id="package_name" placeholder="e.g. Gold Package or Manual Top-up" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <div>
                        <label for="amount" class="block text-xs font-bold text-gray-700 uppercase">Amount (GHS)</label>
                        <input type="number" name="amount" id="amount" required step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="acres" class="block text-xs font-bold text-gray-700 uppercase">Acres</label>
                        <input type="number" name="acres" id="acres" required step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="roi_percentage" class="block text-xs font-bold text-gray-700 uppercase">ROI %</label>
                        <input type="number" name="roi_percentage" id="roi_percentage" required step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none">
                            Add Investment
                        </button>
                    </div>
                </form>
            </div>

            <hr class="my-8 border-gray-200">

            {{-- Investment History & Actions --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-8">
                <h4 class="text-md font-medium text-gray-900 mb-4">Investment History</h4>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Acres</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">ROI %</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Profit</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($investments as $inv)
                            <tr>
                                <td class="px-4 py-2 text-sm text-gray-500">{{ $inv->created_at->format('M d, Y') }}</td>
                                <td class="px-4 py-2 text-sm text-gray-900">GH₵ {{ number_format($inv->amount, 2) }}</td>
                                <td class="px-4 py-2 text-sm text-gray-500">{{ $inv->acres }}</td>
                                <td class="px-4 py-2 text-sm text-gray-500">{{ $inv->roi_percentage }}%</td>
                                <td class="px-4 py-2 text-sm text-green-600 font-medium">+{{ number_format($inv->projected_profit, 2) }}</td>
                                <td class="px-4 py-2 text-sm font-medium flex space-x-2">
                                    <button type="button" onclick="openEditModal({{ $inv->id }}, {{ $inv->amount }}, {{ $inv->acres }}, {{ $inv->roi_percentage }})" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                    
                                    <form action="{{ route('admin.investments.destroy', $inv->id) }}" method="POST" onsubmit="return confirm('Are you sure? This will adjust user totals.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <hr class="my-8 border-gray-200">

            {{-- Audit Log --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h4 class="text-md font-medium text-gray-900 mb-4">Audit Log (Last 5 Actions)</h4>
                <div class="bg-gray-50 rounded-lg p-4">
                    <ul class="space-y-3">
                        @forelse($auditLogs as $log)
                        <li class="text-sm">
                            <span class="font-bold text-gray-700">[{{ $log->created_at->format('M d H:i') }}]</span>
                            <span class="font-semibold text-indigo-700">{{ $log->action }}:</span>
                            <span class="text-gray-600">{{ $log->details }}</span>
                            <span class="text-xs text-gray-400 block ml-4">By Admin ID: {{ $log->admin_id }}</span>
                        </li>
                        @empty
                        <li class="text-sm text-gray-500">No actions recorded yet.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            {{-- Edit Modal --}}
            <div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeEditModal()"></div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <form id="editForm" method="POST" action="">
                            @csrf
                            @method('PUT')
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Edit Investment</h3>
                                        <div class="mt-4 grid grid-cols-1 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Amount</label>
                                                <input type="number" name="amount" id="edit_amount" step="0.01" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Acres</label>
                                                <input type="number" name="acres" id="edit_acres" step="0.01" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">ROI %</label>
                                                <input type="number" name="roi_percentage" id="edit_roi" step="0.01" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                    Save Changes
                                </button>
                                <button type="button" onclick="closeEditModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                    


                </div>
            </div>

            <script>
                function applyPackage() {
                    const select = document.getElementById('packageSelect');
                    const option = select.options[select.selectedIndex];
                    
                    if (option.value) {
                        document.getElementById('amount').value = option.getAttribute('data-amount');
                        document.getElementById('roi_percentage').value = option.getAttribute('data-roi');
                        document.getElementById('acres').value = option.getAttribute('data-acres');
                        document.getElementById('package_name').value = option.getAttribute('data-name');
                    }
                }

                function openEditModal(id, amount, acres, roi) {
                    const form = document.getElementById('editForm');
                    form.action = '/admin/investments/' + id; // Assuming this route exists
                    
                    document.getElementById('edit_amount').value = amount;
                    document.getElementById('edit_acres').value = acres;
                    document.getElementById('edit_roi').value = roi;
                    
                    document.getElementById('editModal').classList.remove('hidden');
                }

                function closeEditModal() {
                    document.getElementById('editModal').classList.add('hidden');
                }
            </script>

        </div>
    </div>
</x-app-layout>

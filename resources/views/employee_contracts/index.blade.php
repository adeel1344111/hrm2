@extends('layouts.master')

@section('content')
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">Employee Contracts</h5>
            </div>
            <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                    <a href="{{ route('home') }}" class="text-slate-400 dark:text-zink-200">Dashboard</a>
                </li>
                <li class="text-slate-700 dark:text-zink-100">
                    Employee Contracts
                </li>
            </ul>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="flex flex-col gap-3 mb-4 md:flex-row md:items-center md:justify-between print:hidden">
                    <select id="designationFilter" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 md:w-56">
                        <option value="all">All Designations</option>
                        <option value="CSR">CSR</option>
                        <option value="Verification Officer">Verification Officer</option>
                    </select>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap" id="contractsTable">
                        <thead class="ltr:text-left rtl:text-right bg-slate-100 dark:bg-zink-600">
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-zink-200">S.NO</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-zink-200">Employee Name</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-zink-200">Employee ID</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-zink-200">Appointment Date</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-zink-200">Contract End Date</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-zink-200">Status</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-zink-200">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200 dark:bg-zink-700 dark:divide-zink-500">
                            @forelse($employees as $index => $employee)
                            <tr id="row-{{ $employee->id }}" data-designation="{{ $employee->designation ?? '' }}">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-zink-100">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-zink-100">{{ $employee->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-zink-100">{{ $employee->employee_id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-zink-100 appointment-date-cell">
                                    {{ $employee->appointment_date ? \Carbon\Carbon::parse($employee->appointment_date)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-zink-100 left-date-cell">
                                    {{ $employee->left_date ? \Carbon\Carbon::parse($employee->left_date)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap status-cell">
                                    @if($employee->status === 'active')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-400">
                                            Active
                                        </span>
                                    @elseif($employee->status === 'inactive')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-400">
                                            Inactive
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-500/20 dark:text-yellow-400">
                                            {{ ucfirst($employee->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <button type="button" 
                                                class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 edit-contract-btn"
                                                data-id="{{ $employee->id }}"
                                                data-name="{{ $employee->name }}"
                                                data-appointment="{{ $employee->appointment_date ? \Carbon\Carbon::parse($employee->appointment_date)->format('Y-m-d') : '' }}"
                                                data-left="{{ $employee->left_date ? \Carbon\Carbon::parse($employee->left_date)->format('Y-m-d') : '' }}"
                                                data-status="{{ $employee->status }}"
                                                data-modal-target="editContractModal"
                                                title="Edit">
                                            <i data-lucide="edit" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-sm text-slate-500 dark:text-zink-400">No employees found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Contract Modal -->
<div id="editContractModal" modal-center class="fixed flex flex-col hidden transition-all duration-300 ease-in-out left-2/4 z-drawer -translate-x-2/4 -translate-y-2/4 show">
    <div class="w-screen md:w-[30rem] bg-white shadow rounded-md dark:bg-zink-600">
        <div class="flex items-center justify-between p-4 border-b border-slate-200 dark:border-zink-500">
            <h5 class="text-16" id="editModalTitle">Edit Employee Contract</h5>
            <button data-modal-close="editContractModal" class="transition-all duration-200 ease-linear text-slate-400 hover:text-red-500">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <div class="max-h-[calc(theme('height.screen')_-_180px)] p-4 overflow-y-auto">
            <form id="editContractForm">
                @csrf
                <input type="hidden" id="edit_employee_id" name="employee_id">
                
                <div class="mb-3">
                    <label for="edit_employee_name" class="inline-block mb-1 text-base font-medium">Employee Name</label>
                    <input type="text" id="edit_employee_name" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:text-slate-500 dark:disabled:text-zink-200 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" disabled readonly>
                </div>

                <div class="mb-3">
                    <label for="edit_appointment_date" class="inline-block mb-1 text-base font-medium">Appointment Date</label>
                    <input type="date" id="edit_appointment_date" name="appointment_date" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                </div>

                <div class="mb-3">
                    <label for="edit_left_date" class="inline-block mb-1 text-base font-medium">Contract End Date</label>
                    <input type="date" id="edit_left_date" name="left_date" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                </div>

                <div class="mb-3">
                    <label for="edit_status" class="inline-block mb-1 text-base font-medium">Status</label>
                    <select id="edit_status" name="status" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:focus:border-custom-800" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="suspended">Suspended</option>
                    </select>
                </div>
                
                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" data-modal-close="editContractModal" class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:ring-red-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Cancel</button>
                    <button type="submit" class="text-white bg-custom-500 hover:bg-custom-600 focus:ring-4 focus:ring-custom-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-custom-600 dark:hover:bg-custom-700 dark:focus:ring-custom-800">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('designationFilter')?.addEventListener('change', function() {
            const designation = this.value;
            document.querySelectorAll('#contractsTable tbody tr[data-designation]').forEach((row) => {
                const rowDes = row.getAttribute('data-designation') || '';
                row.classList.toggle('hidden', designation !== 'all' && rowDes !== designation);
            });
        });

        const modal = document.getElementById('editContractModal');
        const form = document.getElementById('editContractForm');
        
        // Edit Button Click
        document.querySelectorAll('.edit-contract-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const appointment = this.getAttribute('data-appointment');
                const left = this.getAttribute('data-left');
                const status = this.getAttribute('data-status');

                document.getElementById('edit_employee_id').value = id;
                document.getElementById('edit_employee_name').value = name;
                document.getElementById('edit_appointment_date').value = appointment || '';
                document.getElementById('edit_left_date').value = left || '';
                document.getElementById('edit_status').value = status;
                
                modal.classList.remove('hidden');
            });
        });

        // Close Modal
        document.querySelectorAll('[data-modal-close="editContractModal"]').forEach(btn => {
            btn.addEventListener('click', function() {
                modal.classList.add('hidden');
            });
        });

        // Form Submit
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const id = document.getElementById('edit_employee_id').value;
            const appointment = document.getElementById('edit_appointment_date').value;
            const left = document.getElementById('edit_left_date').value;
            const status = document.getElementById('edit_status').value;
            const token = document.querySelector('input[name="_token"]').value;

            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerText;
            submitBtn.innerText = 'Saving...';
            submitBtn.disabled = true;

            fetch(`/employee-contracts/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    appointment_date: appointment,
                    left_date: left,
                    status: status
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const row = document.getElementById(`row-${id}`);
                    if (row) {
                        row.querySelector('.appointment-date-cell').innerText = data.data.appointment_date;
                        row.querySelector('.left-date-cell').innerText = data.data.left_date;
                        
                        // Update status badge
                        const statusCell = row.querySelector('.status-cell');
                        let badgeClass = '';
                        let badgeText = '';
                        
                        if (data.data.status === 'active') {
                            badgeClass = 'bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-400';
                            badgeText = 'Active';
                        } else if (data.data.status === 'inactive') {
                            badgeClass = 'bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-400';
                            badgeText = 'Inactive';
                        } else {
                            badgeClass = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-500/20 dark:text-yellow-400';
                            badgeText = data.data.status.charAt(0).toUpperCase() + data.data.status.slice(1);
                        }
                        
                        statusCell.innerHTML = `<span class="px-2 py-1 text-xs font-semibold rounded-full ${badgeClass}">${badgeText}</span>`;
                        
                        // Update button data
                        const btn = row.querySelector('.edit-contract-btn');
                        btn.setAttribute('data-appointment', appointment);
                        btn.setAttribute('data-left', left);
                        btn.setAttribute('data-status', status);
                    }
                    
                    modal.classList.add('hidden');
                    alert('Contract updated successfully!');
                } else {
                    alert(data.message || 'Error updating contract');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred');
            })
            .finally(() => {
                submitBtn.innerText = originalText;
                submitBtn.disabled = false;
            });
        });
    });
</script>
@endsection

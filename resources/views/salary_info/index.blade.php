@extends('layouts.master')

@section('content')
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">Salaries</h5>
            </div>
            <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                    <a href="{{ route('home') }}" class="text-slate-400 dark:text-zink-200">Dashboard</a>
                </li>
                <li class="text-slate-700 dark:text-zink-100">
                    Salaries
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
                    <button type="button" data-modal-target="bulkTempSalaryModal" class="text-white bg-custom-500 hover:bg-custom-600 focus:ring-4 focus:ring-custom-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-custom-600 dark:hover:bg-custom-700 dark:focus:ring-custom-800">
                        Bulk Temp Salary
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap" id="salariesTable">
                        <thead class="ltr:text-left rtl:text-right bg-slate-100 dark:bg-zink-600">
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-zink-200">Employee Name</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-zink-200">Employee ID</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-zink-200">Status</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-zink-200">Punctuality</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-zink-200">Basic Salary</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-zink-200">Temp Salary</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-zink-200">Last Salary</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-zink-200">Last Updated</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-zink-200">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200 dark:bg-zink-700 dark:divide-zink-500">
                            @forelse($users as $user)
                            <tr id="row-{{ $user->id }}" data-designation="{{ $user->designation ?? '' }}">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-zink-100">{{ $user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-zink-100">{{ $user->employee_id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($user->status == 'active')
                                        <span class="px-2.5 py-0.5 inline-flex text-xs font-medium rounded-full bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-400">Active</span>
                                    @else
                                        <span class="px-2.5 py-0.5 inline-flex text-xs font-medium rounded-full bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-400">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-zink-100 punctuality-cell">{{ number_format($user->current_salary->punctuality ?? 0) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-zink-100 basic-salary-cell">{{ number_format($user->current_salary->basic_salary ?? 0) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-zink-100 temp-salary-cell">{{ isset($user->current_salary->temp_salary) ? number_format($user->current_salary->temp_salary) : '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-zink-100 last-salary-cell">
                                    {{ $user->last_total_salary ? number_format($user->last_total_salary) : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 dark:text-zink-400 updated-at-cell">
                                    {{ $user->current_salary && $user->current_salary->updated_at ? $user->current_salary->updated_at->diffForHumans() : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <button type="button" 
                                                class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 edit-salary-btn"
                                                data-id="{{ $user->id }}"
                                                data-name="{{ $user->name }}"
                                                data-basic="{{ $user->current_salary->basic_salary ?? 0 }}"
                                                data-punctuality="{{ $user->current_salary->punctuality ?? 0 }}"
                                                data-modal-target="editSalaryModal"
                                                title="Edit">
                                            <i data-lucide="edit" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="px-6 py-4 text-center text-sm text-slate-500 dark:text-zink-400">No employees found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Salary Modal -->
<div id="editSalaryModal" modal-center class="fixed flex flex-col hidden transition-all duration-300 ease-in-out left-2/4 z-drawer -translate-x-2/4 -translate-y-2/4 show">
    <div class="w-screen md:w-[30rem] bg-white shadow rounded-md dark:bg-zink-600">
        <div class="flex items-center justify-between p-4 border-b border-slate-200 dark:border-zink-500">
            <h5 class="text-16" id="editModalTitle">Edit Salary</h5>
            <button data-modal-close="editSalaryModal" class="transition-all duration-200 ease-linear text-slate-400 hover:text-red-500">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <div class="max-h-[calc(theme('height.screen')_-_180px)] p-4 overflow-y-auto">
            <form id="editSalaryForm">
                @csrf
                <input type="hidden" id="edit_employee_id" name="employee_id">
                
                <div class="mb-3">
                    <label for="edit_employee_name" class="inline-block mb-1 text-base font-medium">Employee Name</label>
                    <input type="text" id="edit_employee_name" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:text-slate-500 dark:disabled:text-zink-200 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" disabled readonly>
                </div>

                <div class="mb-3">
                    <label for="edit_basic_salary" class="inline-block mb-1 text-base font-medium">Basic Salary</label>
                    <input type="number" id="edit_basic_salary" name="basic_salary" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" required>
                </div>

                <div class="mb-3">
                    <label for="edit_punctuality" class="inline-block mb-1 text-base font-medium">Punctuality</label>
                    <input type="number" id="edit_punctuality" name="punctuality" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" required>
                </div>
                
                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" data-modal-close="editSalaryModal" class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:ring-red-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Cancel</button>
                    <button type="submit" class="text-white bg-custom-500 hover:bg-custom-600 focus:ring-4 focus:ring-custom-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-custom-600 dark:hover:bg-custom-700 dark:focus:ring-custom-800">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bulk Temp Salary Modal -->
<div id="bulkTempSalaryModal" modal-center class="fixed flex flex-col hidden transition-all duration-300 ease-in-out left-2/4 z-drawer -translate-x-2/4 -translate-y-2/4 show">
    <div class="w-screen md:w-[30rem] bg-white shadow rounded-md dark:bg-zink-600">
        <div class="flex items-center justify-between p-4 border-b border-slate-200 dark:border-zink-500">
            <h5 class="text-16" id="bulkTempSalaryTitle">Bulk Temporary Salary</h5>
            <button data-modal-close="bulkTempSalaryModal" class="transition-all duration-200 ease-linear text-slate-400 hover:text-red-500">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <div class="max-h-[calc(theme('height.screen')_-_180px)] p-4 overflow-y-auto">
            <form id="bulkTempSalaryForm">
                @csrf
                
                <div class="mb-3">
                    <label for="bulk_employee_ids" class="inline-block mb-1 text-base font-medium">Employee IDs (one per line)</label>
                    <textarea id="bulk_employee_ids" name="employee_ids" rows="5" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" placeholder="MK039&#10;MK047&#10;MK134" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="bulk_temp_salary" class="inline-block mb-1 text-base font-medium">Temporary Salary Amount</label>
                    <input type="number" id="bulk_temp_salary" name="temp_salary" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" placeholder="Leave empty to clear/delete temp salary">
                    <span class="text-xs text-slate-500 mt-1 block">Leaving this blank will remove any temporary salary for the given IDs.</span>
                </div>
                
                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" data-modal-close="bulkTempSalaryModal" class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:ring-red-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Cancel</button>
                    <button type="submit" class="text-white bg-custom-500 hover:bg-custom-600 focus:ring-4 focus:ring-custom-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-custom-600 dark:hover:bg-custom-700 dark:focus:ring-custom-800">Apply Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('designationFilter')?.addEventListener('change', function() {
            const designation = this.value;
            document.querySelectorAll('#salariesTable tbody tr[data-designation]').forEach((row) => {
                const rowDes = row.getAttribute('data-designation') || '';
                row.classList.toggle('hidden', designation !== 'all' && rowDes !== designation);
            });
        });

        const modal = document.getElementById('editSalaryModal');
        const form = document.getElementById('editSalaryForm');
        
        // Edit Button Click
        document.querySelectorAll('.edit-salary-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const basic = this.getAttribute('data-basic');
                const punctuality = this.getAttribute('data-punctuality');

                document.getElementById('edit_employee_id').value = id;
                document.getElementById('edit_employee_name').value = name;
                document.getElementById('edit_basic_salary').value = basic;
                document.getElementById('edit_punctuality').value = punctuality;
                
                modal.classList.remove('hidden');
            });
        });

        // Close Modal Logic (Assuming global modal JS handles basic toggling, but adding specific close here just in case)
        document.querySelectorAll('[data-modal-close="editSalaryModal"]').forEach(btn => {
            btn.addEventListener('click', function() {
                modal.classList.add('hidden');
            });
        });

        // Form Submit
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const id = document.getElementById('edit_employee_id').value;
            const basic = document.getElementById('edit_basic_salary').value;
            const punctuality = document.getElementById('edit_punctuality').value;
            const token = document.querySelector('input[name="_token"]').value;

            // Show loading state if desired
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerText;
            submitBtn.innerText = 'Saving...';
            submitBtn.disabled = true;

            fetch(`/salary-info/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    basic_salary: basic,
                    punctuality: punctuality
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update table row without refresh
                    const row = document.getElementById(`row-${id}`);
                    if (row) {
                        row.querySelector('.basic-salary-cell').innerText = data.data.basic_salary;
                        row.querySelector('.punctuality-cell').innerText = data.data.punctuality;
                        row.querySelector('.last-salary-cell').innerText = data.data.last_salary;
                        row.querySelector('.updated-at-cell').innerText = data.data.last_updated;
                        
                        // Update button data attributes
                        const btn = row.querySelector('.edit-salary-btn');
                        btn.setAttribute('data-basic', basic); // store raw value
                        btn.setAttribute('data-punctuality', punctuality);
                    }
                    
                    // Close modal
                    modal.classList.add('hidden');
                    
                    // Show success toast (optional, if you have a toast library)
                    alert('Salary updated successfully!');
                } else {
                    alert(data.message || 'Error updating salary');
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

        // Bulk Temp Salary Logic
        const bulkModal = document.getElementById('bulkTempSalaryModal');
        const bulkForm = document.getElementById('bulkTempSalaryForm');

        document.querySelectorAll('[data-modal-target="bulkTempSalaryModal"]').forEach(btn => {
            btn.addEventListener('click', function() {
                bulkForm.reset();
                bulkModal.classList.remove('hidden');
            });
        });

        document.querySelectorAll('[data-modal-close="bulkTempSalaryModal"]').forEach(btn => {
            btn.addEventListener('click', function() {
                bulkModal.classList.add('hidden');
            });
        });

        bulkForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const employeeIds = document.getElementById('bulk_employee_ids').value;
            const tempSalary = document.getElementById('bulk_temp_salary').value;
            const token = document.querySelector('input[name="_token"]').value;

            const submitBtn = bulkForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerText;
            submitBtn.innerText = 'Applying...';
            submitBtn.disabled = true;

            fetch(`/salary-info/bulk-temp-salary`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    employee_ids: employeeIds,
                    temp_salary: tempSalary
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Temporary salaries updated successfully! Refreshing page...');
                    bulkModal.classList.add('hidden');
                    window.location.reload();
                } else {
                    alert(data.message || 'Error updating temporary salaries');
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

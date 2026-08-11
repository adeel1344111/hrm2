<?php $__env->startSection('content'); ?>
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">Active Agents Info</h5>
                <p class="text-sm text-slate-500 dark:text-zink-200 mt-1">Active CSR &amp; Verification Officers — edit details inline without refreshing.</p>
            </div>
            <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1 before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                    <a href="<?php echo e(route('home')); ?>" class="text-slate-400 dark:text-zink-200">Dashboard</a>
                </li>
                <li class="text-slate-700 dark:text-zink-100">Active Agents Info</li>
            </ul>
        </div>

        <div class="card">
            <div class="card-body">
                <style>
                    #agentsInfoTable .sticky-emp {
                        position: sticky;
                        left: 0;
                        z-index: 2;
                        min-width: 6rem;
                        box-shadow: none;
                    }
                    #agentsInfoTable .sticky-name {
                        position: sticky;
                        left: 6rem;
                        z-index: 2;
                        min-width: 11rem;
                        box-shadow: 6px 0 8px -6px rgba(0,0,0,.18);
                    }
                    #agentsInfoTable thead .sticky-emp,
                    #agentsInfoTable thead .sticky-name {
                        z-index: 3;
                    }
                </style>
                <div class="flex flex-col gap-3 mb-4 md:flex-row md:items-center md:justify-between print:hidden">
                    <div class="text-sm text-slate-500 dark:text-zink-200">
                        <span id="agentCount"><?php echo e($agents->count()); ?></span> active agent(s)
                    </div>
                    <div class="flex flex-col gap-2 w-full md:w-auto md:flex-row md:items-center">
                        <select id="designationFilter"
                            class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 md:w-56">
                            <option value="all">All Designations</option>
                            <option value="CSR">CSR</option>
                            <option value="Verification Officer">Verification Officer</option>
                        </select>
                        <input type="text" id="agentSearch" placeholder="Search by name or employee ID..."
                            class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 w-full md:w-80">
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full" id="agentsInfoTable">
                        <thead class="ltr:text-left rtl:text-right bg-slate-100 dark:bg-zink-600">
                            <tr>
                                <th class="px-3 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-zink-200 sticky-emp bg-slate-100 dark:bg-zink-600">Employee ID</th>
                                <th class="px-3 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-zink-200 sticky-name bg-slate-100 dark:bg-zink-600">Full Name</th>
                                <th class="px-3 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-zink-200">Contact</th>
                                <th class="px-3 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-zink-200">Emergency</th>
                                <th class="px-3 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-zink-200">CNIC</th>
                                <th class="px-3 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-zink-200">Designation</th>
                                <th class="px-3 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-zink-200">Appointment</th>
                                <th class="px-3 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-zink-200">Status *</th>
                                <th class="px-3 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-zink-200">Floor Manager</th>
                                <th class="px-3 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-zink-200">Team Lead</th>
                                <th class="px-3 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-zink-200 sticky right-0 bg-slate-100 dark:bg-zink-600 z-10">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200 dark:bg-zink-700 dark:divide-zink-500">
                            <?php $__empty_1 = true; $__currentLoopData = $agents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr id="row-<?php echo e($agent->id); ?>"
                                class="agent-row"
                                data-id="<?php echo e($agent->id); ?>"
                                data-designation="<?php echo e($agent->designation ?? ''); ?>"
                                data-search="<?php echo e(strtolower(($agent->name ?? '') . ' ' . ($agent->employee_id ?? ''))); ?>">
                                <td class="px-3 py-2 sticky-emp bg-white dark:bg-zink-700 text-sm font-semibold text-slate-900 dark:text-zink-100 whitespace-nowrap">
                                    <?php echo e($agent->employee_id ?: '—'); ?>

                                </td>
                                <td class="px-3 py-2 sticky-name bg-white dark:bg-zink-700 text-sm text-slate-900 dark:text-zink-100 whitespace-nowrap">
                                    <?php echo e($agent->name ?: '—'); ?>

                                </td>
                                <td class="px-2 py-2">
                                    <input type="text" name="contact_number" value="<?php echo e($agent->contact_number); ?>"
                                        class="form-input text-xs min-w-[8rem] border-slate-200 dark:border-zink-500 dark:bg-zink-600 dark:text-zink-100">
                                </td>
                                <td class="px-2 py-2">
                                    <input type="text" name="emergency_contact" value="<?php echo e($agent->emergency_contact); ?>"
                                        class="form-input text-xs min-w-[8rem] border-slate-200 dark:border-zink-500 dark:bg-zink-600 dark:text-zink-100">
                                </td>
                                <td class="px-2 py-2">
                                    <input type="text" name="cnic" value="<?php echo e($agent->cnic); ?>"
                                        class="form-input text-xs min-w-[9rem] border-slate-200 dark:border-zink-500 dark:bg-zink-600 dark:text-zink-100">
                                </td>
                                <td class="px-2 py-2">
                                    <select name="designation" class="form-input text-xs min-w-[8rem] border-slate-200 dark:border-zink-500 dark:bg-zink-600 dark:text-zink-100">
                                        <option value="">—</option>
                                        <?php $__currentLoopData = $designations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $designation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($designation->name); ?>" <?php echo e($agent->designation === $designation->name ? 'selected' : ''); ?>>
                                                <?php echo e($designation->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($agent->designation && !$designations->contains('name', $agent->designation)): ?>
                                            <option value="<?php echo e($agent->designation); ?>" selected><?php echo e($agent->designation); ?></option>
                                        <?php endif; ?>
                                    </select>
                                </td>
                                <td class="px-2 py-2">
                                    <input type="date" name="appointment_date" value="<?php echo e($agent->appointment_date ? \Carbon\Carbon::parse($agent->appointment_date)->format('Y-m-d') : ''); ?>"
                                        class="form-input text-xs min-w-[9rem] border-slate-200 dark:border-zink-500 dark:bg-zink-600 dark:text-zink-100">
                                </td>
                                <td class="px-2 py-2">
                                    <select name="status" class="form-input text-xs min-w-[6.5rem] border-slate-200 dark:border-zink-500 dark:bg-zink-600 dark:text-zink-100" required>
                                        <option value="active" <?php echo e($agent->status === 'active' ? 'selected' : ''); ?>>Active</option>
                                        <option value="inactive" <?php echo e($agent->status === 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                                    </select>
                                </td>
                                <td class="px-2 py-2">
                                    <select name="floor_manager_id" class="form-input text-xs min-w-[9rem] border-slate-200 dark:border-zink-500 dark:bg-zink-600 dark:text-zink-100">
                                        <option value="">—</option>
                                        <?php $__currentLoopData = $floorManagers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($fm->id); ?>" <?php echo e((int)$agent->floor_manager_id === (int)$fm->id ? 'selected' : ''); ?>>
                                                <?php echo e($fm->name); ?><?php echo e($fm->employee_id ? ' ('.$fm->employee_id.')' : ''); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </td>
                                <td class="px-2 py-2">
                                    <select name="team_lead_id" class="form-input text-xs min-w-[9rem] border-slate-200 dark:border-zink-500 dark:bg-zink-600 dark:text-zink-100">
                                        <option value="">—</option>
                                        <?php $__currentLoopData = $teamLeads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($tl->id); ?>" <?php echo e((int)$agent->team_lead_id === (int)$tl->id ? 'selected' : ''); ?>>
                                                <?php echo e($tl->name); ?><?php echo e($tl->employee_id ? ' ('.$tl->employee_id.')' : ''); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </td>
                                <td class="px-2 py-2 sticky right-0 bg-white dark:bg-zink-700 z-[1]">
                                    <button type="button"
                                        class="save-agent-btn text-white bg-custom-500 hover:bg-custom-600 font-medium rounded-md text-xs px-3 py-1.5 whitespace-nowrap"
                                        data-id="<?php echo e($agent->id); ?>">
                                        Save
                                    </button>
                                    <span class="row-status text-xs ml-1 hidden"></span>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr id="emptyAgentsRow">
                                <td colspan="11" class="px-6 py-8 text-center text-sm text-slate-500 dark:text-zink-400">No active agents found.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="agentToast" class="fixed bottom-4 right-4 z-[100] hidden px-4 py-3 rounded-md shadow-lg text-sm font-medium text-white"></div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        || '<?php echo e(csrf_token()); ?>';
    const toast = document.getElementById('agentToast');
    const searchInput = document.getElementById('agentSearch');
    const designationFilter = document.getElementById('designationFilter');
    const countEl = document.getElementById('agentCount');

    function showToast(message, ok) {
        toast.textContent = message;
        toast.classList.remove('hidden', 'bg-green-600', 'bg-red-600');
        toast.classList.add(ok ? 'bg-green-600' : 'bg-red-600');
        clearTimeout(showToast._t);
        showToast._t = setTimeout(() => toast.classList.add('hidden'), 2500);
    }

    function updateCount() {
        const visible = document.querySelectorAll('.agent-row:not(.hidden):not([data-removed])').length;
        if (countEl) countEl.textContent = String(visible);
    }

    function applyFilters() {
        const q = (searchInput?.value || '').trim().toLowerCase();
        const designation = designationFilter?.value || 'all';

        document.querySelectorAll('.agent-row').forEach((row) => {
            if (row.dataset.removed) return;
            const hay = row.getAttribute('data-search') || '';
            const rowDesignation = row.getAttribute('data-designation') || '';
            const matchesSearch = !q || hay.includes(q);
            const matchesDesignation = designation === 'all' || rowDesignation === designation;
            row.classList.toggle('hidden', !(matchesSearch && matchesDesignation));
        });
        updateCount();
    }

    searchInput?.addEventListener('input', applyFilters);
    designationFilter?.addEventListener('change', applyFilters);

    function getRowPayload(row) {
        const val = (name) => {
            const el = row.querySelector(`[name="${name}"]`);
            return el ? el.value : '';
        };
        return {
            contact_number: val('contact_number'),
            emergency_contact: val('emergency_contact'),
            cnic: val('cnic'),
            designation: val('designation') || null,
            appointment_date: val('appointment_date') || null,
            status: val('status'),
            floor_manager_id: val('floor_manager_id') || null,
            team_lead_id: val('team_lead_id') || null,
        };
    }

    document.querySelectorAll('.save-agent-btn').forEach((btn) => {
        btn.addEventListener('click', async function () {
            const id = this.getAttribute('data-id');
            const row = document.getElementById('row-' + id);
            if (!row) return;

            const statusEl = row.querySelector('.row-status');
            this.disabled = true;
            this.textContent = 'Saving...';
            if (statusEl) statusEl.classList.add('hidden');

            try {
                const res = await fetch(`/agent-info/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify(getRowPayload(row)),
                });

                const data = await res.json();
                if (!res.ok || !data.success) {
                    const msg = data.message
                        || (data.errors ? Object.values(data.errors).flat().join(' ') : 'Update failed');
                    throw new Error(msg);
                }

                if (data.remove_row) {
                    row.dataset.removed = '1';
                    row.remove();
                    updateCount();
                    showToast(data.message + ' (removed from active list)', true);
                } else {
                    const designationVal = row.querySelector('[name="designation"]')?.value || '';
                    row.setAttribute('data-designation', designationVal);
                    applyFilters();
                    if (statusEl) {
                        statusEl.textContent = 'Saved';
                        statusEl.classList.remove('hidden', 'text-red-500');
                        statusEl.classList.add('text-green-600');
                        setTimeout(() => statusEl.classList.add('hidden'), 1800);
                    }
                    showToast(data.message || 'Saved', true);
                }
            } catch (err) {
                showToast(err.message || 'Update failed', false);
                if (statusEl) {
                    statusEl.textContent = 'Error';
                    statusEl.classList.remove('hidden', 'text-green-600');
                    statusEl.classList.add('text-red-500');
                }
            } finally {
                this.disabled = false;
                this.textContent = 'Save';
            }
        });
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/hrm2/resources/views/agent_info/index.blade.php ENDPATH**/ ?>
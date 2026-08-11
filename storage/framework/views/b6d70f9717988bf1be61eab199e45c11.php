
<div>
    <div class="p-4 mb-4 group-data-[sidebar-size=sm]:hidden">
        <div class="block rounded-lg p-3">
            <div class="flex flex-col items-center text-center">
                <div class="mb-3">
                    <div class="flex items-center justify-center font-medium rounded-full size-20 shrink-0 bg-slate-200 text-slate-800 dark:text-zink-50 dark:bg-zink-600 text-2xl">
                        <?php echo e(strtoupper(substr(session('outsource_company_name', 'O'), 0, 1))); ?>

                    </div>
                </div>
                <h3 class="text-slate-900 dark:text-zink-100 font-bold text-sm mb-1">Outsource</h3>
                <p class="text-slate-600 dark:text-zink-300 text-xs font-medium mb-1"><?php echo e(session('outsource_company_name')); ?></p>
                <div>
                    <span class="text-slate-500 dark:text-zink-400 text-xs font-medium"><?php echo e(session('outsource_admin_name')); ?></span>
                </div>
            </div>
        </div>
    </div>

    <ul class="group-data-[layout=horizontal]:flex group-data-[layout=horizontal]:flex-col group-data-[layout=horizontal]:md:flex-row" id="navbar-nav">
        <li class="px-4 py-1 text-vertical-menu-item group-data-[sidebar=dark]:text-vertical-menu-item-dark uppercase font-medium text-[11px] cursor-default tracking-wider group-data-[sidebar-size=sm]:hidden inline-block">
            <span>Outsource Menu</span>
        </li>

        <li class="relative group/sm">
            <a href="<?php echo e(route('outsource.dashboard')); ?>" class="<?php echo e(request()->routeIs('outsource.dashboard') ? 'active' : ''); ?> flex items-center ltr:pl-3 rtl:pr-3 ltr:pr-5 rtl:pl-5 mx-3 my-1 group/menu-link text-vertical-menu-item-font-size font-normal transition-all duration-75 ease-linear rounded-md py-2.5 text-vertical-menu-item hover:text-vertical-menu-item-hover hover:bg-vertical-menu-item-bg-hover [&.active]:text-vertical-menu-item-active [&.active]:bg-vertical-menu-item-bg-active group-data-[sidebar=dark]:text-vertical-menu-item-dark group-data-[sidebar=dark]:hover:text-vertical-menu-item-hover-dark group-data-[sidebar=dark]:hover:bg-vertical-menu-item-bg-hover-dark group-data-[sidebar=dark]:[&.active]:text-vertical-menu-item-active-dark group-data-[sidebar=dark]:[&.active]:bg-vertical-menu-item-bg-active-dark group-data-[sidebar=dark]:dark:text-zink-200 group-data-[sidebar=dark]:[&.active]:dark:bg-zink-600">
                <span class="min-w-[1.75rem] inline-block text-start text-[16px]">
                    <i data-lucide="layout-dashboard" class="h-4 w-4"></i>
                </span>
                <span class="align-middle">Dashboard</span>
            </a>
        </li>

        <li class="relative group/sm">
            <a href="<?php echo e(route('outsource.submissions')); ?>" class="<?php echo e(request()->routeIs('outsource.submissions') ? 'active' : ''); ?> flex items-center ltr:pl-3 rtl:pr-3 ltr:pr-5 rtl:pl-5 mx-3 my-1 group/menu-link text-vertical-menu-item-font-size font-normal transition-all duration-75 ease-linear rounded-md py-2.5 text-vertical-menu-item hover:text-vertical-menu-item-hover hover:bg-vertical-menu-item-bg-hover [&.active]:text-vertical-menu-item-active [&.active]:bg-vertical-menu-item-bg-active group-data-[sidebar=dark]:text-vertical-menu-item-dark group-data-[sidebar=dark]:hover:text-vertical-menu-item-hover-dark group-data-[sidebar=dark]:hover:bg-vertical-menu-item-bg-hover-dark group-data-[sidebar=dark]:[&.active]:text-vertical-menu-item-active-dark group-data-[sidebar=dark]:[&.active]:bg-vertical-menu-item-bg-active-dark group-data-[sidebar=dark]:dark:text-zink-200 group-data-[sidebar=dark]:[&.active]:dark:bg-zink-600">
                <span class="min-w-[1.75rem] inline-block text-start text-[16px]">
                    <i data-lucide="list-checks" class="h-4 w-4"></i>
                </span>
                <span class="align-middle">Today Submissions</span>
            </a>
        </li>

        <li class="relative group/sm">
            <a href="<?php echo e(route('outsource.report')); ?>" class="<?php echo e(request()->routeIs('outsource.report') ? 'active' : ''); ?> flex items-center ltr:pl-3 rtl:pr-3 ltr:pr-5 rtl:pl-5 mx-3 my-1 group/menu-link text-vertical-menu-item-font-size font-normal transition-all duration-75 ease-linear rounded-md py-2.5 text-vertical-menu-item hover:text-vertical-menu-item-hover hover:bg-vertical-menu-item-bg-hover [&.active]:text-vertical-menu-item-active [&.active]:bg-vertical-menu-item-bg-active group-data-[sidebar=dark]:text-vertical-menu-item-dark group-data-[sidebar=dark]:hover:text-vertical-menu-item-hover-dark group-data-[sidebar=dark]:hover:bg-vertical-menu-item-bg-hover-dark group-data-[sidebar=dark]:[&.active]:text-vertical-menu-item-active-dark group-data-[sidebar=dark]:[&.active]:bg-vertical-menu-item-bg-active-dark group-data-[sidebar=dark]:dark:text-zink-200 group-data-[sidebar=dark]:[&.active]:dark:bg-zink-600">
                <span class="min-w-[1.75rem] inline-block text-start text-[16px]">
                    <i data-lucide="bar-chart-3" class="h-4 w-4"></i>
                </span>
                <span class="align-middle">Submissions Report</span>
            </a>
        </li>

        <li class="relative group/sm mt-2">
            <a href="<?php echo e(route('outsource.logout')); ?>"
               onclick="event.preventDefault(); document.getElementById('outsource-logout-form').submit();"
               class="flex items-center ltr:pl-3 rtl:pr-3 ltr:pr-5 rtl:pl-5 mx-3 my-1 group/menu-link text-vertical-menu-item-font-size font-normal transition-all duration-75 ease-linear rounded-md py-2.5 text-vertical-menu-item hover:text-red-400 hover:bg-vertical-menu-item-bg-hover group-data-[sidebar=dark]:text-vertical-menu-item-dark group-data-[sidebar=dark]:dark:text-zink-200">
                <span class="min-w-[1.75rem] inline-block text-start text-[16px]">
                    <i data-lucide="log-out" class="h-4 w-4"></i>
                </span>
                <span class="align-middle">Sign Out</span>
            </a>
            <form id="outsource-logout-form" action="<?php echo e(route('outsource.logout')); ?>" method="POST" class="hidden"><?php echo csrf_field(); ?></form>
        </li>
    </ul>
</div>
<?php /**PATH /var/www/hrm2/resources/views/sidebar/outsource-sidebar.blade.php ENDPATH**/ ?>
<!DOCTYPE html>
<html lang="en" class="dark scroll-smooth group" data-layout="vertical" data-sidebar="dark" data-sidebar-size="lg" data-mode="dark" data-topbar="dark" data-skin="default" data-navbar="sticky" data-content="fluid" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>HR Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta content="Human Resource Management System" name="description">
    <meta content="HRM System" name="author">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo e(URL::to('assets/images/favicon_new.png')); ?>">
    <!-- Layout config Js -->
    <script src="<?php echo e(URL::to('assets/js/layout.js')); ?>"></script>
    <!-- HR System CSS -->
    <link rel="stylesheet" href="<?php echo e(URL::to('assets/css/hrm-system.css')); ?>">
    
    <style>
        .invalid-feedback {
            color: red;
        }
        .is-invalid {
            border-color: red;
        }
        .choices {
            position: relative;
            overflow: hidden;
            margin-bottom: 0px !important;
            font-size: 16px;
        }
        
        /* Pagination Dark Mode Styles */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            margin-top: 1.5rem;
        }
        
        .pagination .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 0.75rem;
            margin: 0 0.125rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            text-decoration: none;
            color: #475569;
            background-color: #ffffff;
            transition: all 0.2s ease-in-out;
        }
        
        .pagination .page-link:hover {
            background-color: #f1f5f9;
            border-color: #cbd5e1;
            color: #334155;
        }
        
        .pagination .page-item.active .page-link {
            background-color: #3b82f6;
            border-color: #3b82f6;
            color: #ffffff;
        }
        
        .pagination .page-item.disabled .page-link {
            color: #94a3b8;
            background-color: #f8fafc;
            border-color: #e2e8f0;
            cursor: not-allowed;
        }
        
        /* Dark Mode Pagination - Multiple selectors for compatibility */
        [data-mode="dark"] .pagination .page-link,
        html[data-mode="dark"] .pagination .page-link,
        .group[data-mode="dark"] .pagination .page-link {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #cbd5e1 !important;
        }
        
        [data-mode="dark"] .pagination .page-link:hover,
        html[data-mode="dark"] .pagination .page-link:hover,
        .group[data-mode="dark"] .pagination .page-link:hover {
            background-color: #334155 !important;
            border-color: #475569 !important;
            color: #e2e8f0 !important;
        }
        
        [data-mode="dark"] .pagination .page-item.active .page-link,
        html[data-mode="dark"] .pagination .page-item.active .page-link,
        .group[data-mode="dark"] .pagination .page-item.active .page-link {
            background-color: #3b82f6 !important;
            border-color: #3b82f6 !important;
            color: #ffffff !important;
        }
        
        [data-mode="dark"] .pagination .page-item.disabled .page-link,
        html[data-mode="dark"] .pagination .page-item.disabled .page-link,
        .group[data-mode="dark"] .pagination .page-item.disabled .page-link {
            color: #64748b !important;
            background-color: #0f172a !important;
            border-color: #1e293b !important;
        }
        
        /* Form Inputs Dark Mode - Multiple selectors */
        [data-mode="dark"] .form-input,
        html[data-mode="dark"] .form-input,
        .group[data-mode="dark"] .form-input {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #cbd5e1 !important;
        }
        
        [data-mode="dark"] .form-input:focus,
        html[data-mode="dark"] .form-input:focus,
        .group[data-mode="dark"] .form-input:focus {
            border-color: #3b82f6 !important;
            background-color: #1e293b !important;
        }
        
        [data-mode="dark"] .form-input::placeholder,
        html[data-mode="dark"] .form-input::placeholder,
        .group[data-mode="dark"] .form-input::placeholder {
            color: #94a3b8 !important;
        }
        
        [data-mode="dark"] .form-select,
        html[data-mode="dark"] .form-select,
        .group[data-mode="dark"] .form-select {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #cbd5e1 !important;
        }
        
        [data-mode="dark"] .form-select:focus,
        html[data-mode="dark"] .form-select:focus,
        .group[data-mode="dark"] .form-select:focus {
            border-color: #3b82f6 !important;
            background-color: #1e293b !important;
        }
        
        /* Pagination Info Text */
        .pagination-info {
            color: #64748b;
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }
        
        [data-mode="dark"] .pagination-info,
        html[data-mode="dark"] .pagination-info,
        .group[data-mode="dark"] .pagination-info {
            color: #94a3b8 !important;
        }
        
        /* Additional form elements that might need dark mode */
        [data-mode="dark"] input[type="text"],
        [data-mode="dark"] input[type="search"],
        [data-mode="dark"] input[type="email"],
        [data-mode="dark"] input[type="password"],
        [data-mode="dark"] select,
        html[data-mode="dark"] input[type="text"],
        html[data-mode="dark"] input[type="search"],
        html[data-mode="dark"] input[type="email"],
        html[data-mode="dark"] input[type="password"],
        html[data-mode="dark"] select {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #cbd5e1 !important;
        }
        
        [data-mode="dark"] input[type="text"]::placeholder,
        [data-mode="dark"] input[type="search"]::placeholder,
        [data-mode="dark"] input[type="email"]::placeholder,
        [data-mode="dark"] input[type="password"]::placeholder,
        html[data-mode="dark"] input[type="text"]::placeholder,
        html[data-mode="dark"] input[type="search"]::placeholder,
        html[data-mode="dark"] input[type="email"]::placeholder,
        html[data-mode="dark"] input[type="password"]::placeholder {
            color: #94a3b8 !important;
        }
        /* Light mode — force readable inputs only (do NOT restyle buttons / cards) */
        html[data-mode="light"] .form-input:not(.btn),
        html[data-mode="light"] .form-select:not(.btn),
        html[data-mode="light"] input[type="text"]:not(.btn),
        html[data-mode="light"] input[type="search"]:not(.btn),
        html[data-mode="light"] input[type="email"]:not(.btn),
        html[data-mode="light"] input[type="password"]:not(.btn),
        html[data-mode="light"] input[type="date"]:not(.btn),
        html[data-mode="light"] input[type="month"]:not(.btn),
        html[data-mode="light"] input[type="time"]:not(.btn),
        html[data-mode="light"] input[type="number"]:not(.btn),
        html[data-mode="light"] select:not(.btn),
        html[data-mode="light"] textarea:not(.btn) {
            background-color: #ffffff !important;
            border-color: #e2e8f0 !important;
            color: #0f172a !important;
        }
        html[data-mode="light"] .form-input::placeholder,
        html[data-mode="light"] input::placeholder,
        html[data-mode="light"] textarea::placeholder {
            color: #94a3b8 !important;
        }
        html[data-mode="light"] table thead th {
            color: #475569 !important;
        }
        /* Attendance Confirm Mark — base bg-green-600 is NOT in compiled CSS */
        #confirm-mark-selected-btn,
        #mark-selected-btn:not(:disabled) {
            background-color: #16a34a !important;
            border-color: #16a34a !important;
            color: #ffffff !important;
        }
        #confirm-mark-selected-btn:hover,
        #mark-selected-btn:not(:disabled):hover {
            background-color: #15803d !important;
            border-color: #15803d !important;
            color: #ffffff !important;
        }
        #mark-selected-btn:disabled {
            background-color: #16a34a !important;
            border-color: #16a34a !important;
            color: #ffffff !important;
            opacity: 0.45;
        }
        html[data-mode="dark"] #selected-mark-bar {
            background-color: rgba(22, 163, 74, 0.12) !important;
            border-color: rgba(74, 222, 128, 0.35) !important;
        }

        /* Keep primary action buttons visible in light mode */
        html[data-mode="light"] .btn.bg-green-500,
        html[data-mode="light"] .btn.bg-green-600,
        html[data-mode="light"] #confirm-mark-selected-btn,
        html[data-mode="light"] #mark-selected-btn {
            background-color: #16a34a !important;
            border-color: #16a34a !important;
            color: #ffffff !important;
        }
        html[data-mode="light"] .btn.bg-green-500:hover,
        html[data-mode="light"] .btn.bg-green-600:hover,
        html[data-mode="light"] #confirm-mark-selected-btn:hover,
        html[data-mode="light"] #mark-selected-btn:hover {
            background-color: #15803d !important;
            border-color: #15803d !important;
            color: #ffffff !important;
        }
        html[data-mode="light"] .btn.bg-custom-500,
        html[data-mode="light"] #bulk-mark-btn {
            color: #ffffff !important;
        }
        html[data-mode="light"] .btn.bg-red-500,
        html[data-mode="light"] #cleanup-btn {
            color: #ffffff !important;
        }
        html[data-mode="light"] #selected-mark-bar {
            background-color: #f0fdf4 !important;
            border-color: #bbf7d0 !important;
        }
    </style>
</head>
<body class="text-base bg-body-bg text-body font-public dark:text-zink-100 dark:bg-zink-800 group-data-[skin=bordered]:bg-body-bordered group-data-[skin=bordered]:dark:bg-zink-700">
    <div class="group-data-[sidebar-size=sm]:min-h-sm group-data-[sidebar-size=sm]:relative">
        <div class="app-menu w-vertical-menu bg-vertical-menu ltr:border-r rtl:border-l border-vertical-menu-border fixed bottom-0 top-0 z-[1003] transition-all duration-75 ease-linear group-data-[sidebar-size=md]:w-vertical-menu-md group-data-[sidebar-size=sm]:w-vertical-menu-sm group-data-[sidebar-size=sm]:pt-header group-data-[sidebar=dark]:bg-vertical-menu-dark group-data-[sidebar=dark]:border-vertical-menu-dark group-data-[sidebar=brand]:bg-vertical-menu-brand group-data-[sidebar=brand]:border-vertical-menu-brand group-data-[sidebar=modern]:bg-gradient-to-tr group-data-[sidebar=modern]:to-vertical-menu-to-modern group-data-[sidebar=modern]:from-vertical-menu-form-modern group-data-[layout=horizontal]:w-full group-data-[layout=horizontal]:bottom-auto group-data-[layout=horizontal]:top-header hidden md:block print:hidden group-data-[sidebar-size=sm]:absolute group-data-[sidebar=modern]:border-vertical-menu-border-modern group-data-[layout=horizontal]:dark:bg-zink-700 group-data-[layout=horizontal]:border-t group-data-[layout=horizontal]:dark:border-zink-500 group-data-[layout=horizontal]:border-r-0 group-data-[sidebar=dark]:dark:bg-zink-700 group-data-[sidebar=dark]:dark:border-zink-600 group-data-[layout=horizontal]:group-data-[navbar=scroll]:absolute group-data-[layout=horizontal]:group-data-[navbar=bordered]:top-[calc(theme('spacing.header')_+_theme('spacing.4'))] group-data-[layout=horizontal]:group-data-[navbar=bordered]:inset-x-4 group-data-[layout=horizontal]:group-data-[navbar=hidden]:top-0 group-data-[layout=horizontal]:group-data-[navbar=hidden]:h-16 group-data-[layout=horizontal]:group-data-[navbar=bordered]:w-[calc(100%_-_2rem)] group-data-[layout=horizontal]:group-data-[navbar=bordered]:[&.sticky]:top-header group-data-[layout=horizontal]:group-data-[navbar=bordered]:rounded-b-md group-data-[layout=horizontal]:shadow-md group-data-[layout=horizontal]:shadow-slate-500/10 group-data-[layout=horizontal]:dark:shadow-zink-500/10 group-data-[layout=horizontal]:opacity-0">
            <div class="flex items-center justify-center px-5 text-center h-header group-data-[layout=horizontal]:hidden group-data-[sidebar-size=sm]:fixed group-data-[sidebar-size=sm]:top-0 group-data-[sidebar-size=sm]:bg-vertical-menu group-data-[sidebar-size=sm]:group-data-[sidebar=dark]:bg-vertical-menu-dark group-data-[sidebar-size=sm]:group-data-[sidebar=brand]:bg-vertical-menu-brand group-data-[sidebar-size=sm]:group-data-[sidebar=modern]:bg-gradient-to-br group-data-[sidebar-size=sm]:group-data-[sidebar=modern]:to-vertical-menu-to-modern group-data-[sidebar-size=sm]:group-data-[sidebar=modern]:from-vertical-menu-form-modern group-data-[sidebar-size=sm]:group-data-[sidebar=modern]:bg-vertical-menu-modern group-data-[sidebar-size=sm]:z-10 group-data-[sidebar-size=sm]:w-[calc(theme('spacing.vertical-menu-sm')_-_1px)] group-data-[sidebar-size=sm]:group-data-[sidebar=dark]:dark:bg-zink-700">
                <button type="button" class="hidden p-0 float-end" id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>
            <!-- Left Sidebar -->
            <div id="scrollbar" class="group-data-[sidebar-size=md]:max-h-[calc(100vh_-_theme('spacing.header')_*_1.2)] group-data-[sidebar-size=lg]:max-h-[calc(100vh_-_theme('spacing.header')_*_1.2)] group-data-[layout=horizontal]:h-56 group-data-[layout=horizontal]:md:h-auto group-data-[layout=horizontal]:overflow-auto group-data-[layout=horizontal]:md:overflow-visible group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:mx-auto">
                <?php echo $__env->make('sidebar.outsource-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <!-- Left Sidebar End -->
            </div>
        </div>

        <!-- Left Sidebar End -->
        <div id="sidebar-overlay" class="absolute inset-0 z-[1002] bg-slate-500/30 hidden"></div>
        <header id="page-topbar" class="ltr:md:left-vertical-menu rtl:md:right-vertical-menu group-data-[sidebar-size=md]:ltr:md:left-vertical-menu-md group-data-[sidebar-size=md]:rtl:md:right-vertical-menu-md group-data-[sidebar-size=sm]:ltr:md:left-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:md:right-vertical-menu-sm group-data-[layout=horizontal]:ltr:left-0 group-data-[layout=horizontal]:rtl:right-0 fixed right-0 z-[1000] left-0 print:hidden group-data-[navbar=bordered]:m-4 group-data-[navbar=bordered]:[&.is-sticky]:mt-0 transition-all ease-linear duration-300 group-data-[navbar=hidden]:hidden group-data-[navbar=scroll]:absolute group/topbar group-data-[layout=horizontal]:z-[1004]">
            <div class="layout-width">
                <div class="flex items-center px-4 mx-auto bg-topbar border-b-2 border-topbar group-data-[topbar=dark]:bg-topbar-dark group-data-[topbar=dark]:border-topbar-dark group-data-[topbar=brand]:bg-topbar-brand group-data-[topbar=brand]:border-topbar-brand shadow-md h-header shadow-slate-200/50 group-data-[navbar=bordered]:rounded-md group-data-[navbar=bordered]:group-[.is-sticky]/topbar:rounded-t-none group-data-[topbar=dark]:dark:bg-zink-700 group-data-[topbar=dark]:dark:border-zink-700 dark:shadow-none group-data-[topbar=dark]:group-[.is-sticky]/topbar:dark:shadow-zink-500 group-data-[topbar=dark]:group-[.is-sticky]/topbar:dark:shadow-md group-data-[navbar=bordered]:shadow-none group-data-[layout=horizontal]:group-data-[navbar=bordered]:rounded-b-none group-data-[layout=horizontal]:shadow-none group-data-[layout=horizontal]:dark:group-[.is-sticky]/topbar:shadow-none">
                    <div class="flex items-center w-full group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl navbar-header group-data-[layout=horizontal]:ltr:xl:pr-3 group-data-[layout=horizontal]:rtl:xl:pl-3">
                        <!-- LOGO -->
                        <div class="items-center justify-center hidden px-5 text-center h-header group-data-[layout=horizontal]:md:flex group-data-[layout=horizontal]:ltr::pl-0 group-data-[layout=horizontal]:rtl:pr-0">
                            <a href="<?php echo e(route('outsource.dashboard')); ?>">
                                <span class="hidden">
                                    <img src="<?php echo e(URL::to('assets/images/logo.png')); ?>" alt="" class="h-6 mx-auto">
                                </span>
                                <span class="group-data-[topbar=dark]:hidden group-data-[topbar=brand]:hidden">
                                    <img src="<?php echo e(URL::to('assets/images/logo-dark.png')); ?>" alt="" class="h-6 mx-auto">
                                </span>
                            </a>
                            <a href="<?php echo e(route('outsource.dashboard')); ?>" class="hidden group-data-[topbar=dark]:block group-data-[topbar=brand]:block">
                                <span class="group-data-[topbar=dark]:hidden group-data-[topbar=brand]:hidden">
                                    <img src="<?php echo e(URL::to('assets/images/logo.png')); ?>" alt="" class="h-6 mx-auto">
                                </span>
                                <span class="group-data-[topbar=dark]:block group-data-[topbar=brand]:block">
                                    <img src="<?php echo e(URL::to('assets/images/logo-light.png')); ?>" alt="" class="h-6 mx-auto">
                                </span>
                            </a>
                        </div>
        
                        <button type="button" class="inline-flex relative justify-center items-center p-0 text-topbar-item transition-all w-[37.5px] h-[37.5px] duration-75 ease-linear bg-topbar rounded-md btn hover:bg-slate-100 group-data-[topbar=dark]:bg-topbar-dark group-data-[topbar=dark]:border-topbar-dark group-data-[topbar=dark]:text-topbar-item-dark group-data-[topbar=dark]:hover:bg-topbar-item-bg-hover-dark group-data-[topbar=dark]:hover:text-topbar-item-hover-dark group-data-[topbar=brand]:bg-topbar-brand group-data-[topbar=brand]:border-topbar-brand group-data-[topbar=brand]:text-topbar-item-brand group-data-[topbar=brand]:hover:bg-topbar-item-bg-hover-brand group-data-[topbar=brand]:hover:text-topbar-item-hover-brand group-data-[topbar=dark]:dark:bg-zink-700 group-data-[topbar=dark]:dark:text-zink-200 group-data-[topbar=dark]:dark:border-zink-700 group-data-[topbar=dark]:dark:hover:bg-zink-600 group-data-[topbar=dark]:dark:hover:text-zink-50 group-data-[layout=horizontal]:flex group-data-[layout=horizontal]:md:hidden hamburger-icon" id="topnav-hamburger-icon">
                            <i data-lucide="chevrons-left" class="w-5 h-5 group-data-[sidebar-size=sm]:hidden"></i>
                            <i data-lucide="chevrons-right" class="hidden w-5 h-5 group-data-[sidebar-size=sm]:block"></i>
                        </button>
        
                        <div class="relative hidden ltr:ml-3 rtl:mr-3 lg:block group-data-[layout=horizontal]:hidden group-data-[layout=horizontal]:lg:block">
                            <input type="text" class="py-2 pr-4 text-sm text-topbar-item bg-topbar border border-topbar-border rounded pl-8 placeholder:text-slate-400 form-control focus-visible:outline-0 min-w-[300px] focus:border-blue-400 group-data-[topbar=dark]:bg-topbar-dark group-data-[topbar=dark]:border-topbar-border-dark group-data-[topbar=dark]:placeholder:text-slate-500 group-data-[topbar=dark]:text-topbar-item-dark group-data-[topbar=brand]:bg-topbar-brand group-data-[topbar=brand]:border-topbar-border-brand group-data-[topbar=brand]:placeholder:text-blue-300 group-data-[topbar=brand]:text-topbar-item-brand group-data-[topbar=dark]:dark:bg-zink-700 group-data-[topbar=dark]:dark:border-zink-500 group-data-[topbar=dark]:dark:text-zink-100" placeholder="Search for ..." autocomplete="off">
                            <i data-lucide="search" class="inline-block size-4 absolute left-2.5 top-2.5 text-topbar-item fill-slate-100 group-data-[topbar=dark]:fill-topbar-item-bg-hover-dark group-data-[topbar=dark]:text-topbar-item-dark group-data-[topbar=brand]:fill-topbar-item-bg-hover-brand group-data-[topbar=brand]:text-topbar-item-brand group-data-[topbar=dark]:dark:text-zink-200 group-data-[topbar=dark]:dark:fill-zink-600"></i>
                        </div>
        
                        <div class="flex gap-3 ms-auto">
        
                            <div class="relative flex items-center h-header">
                                <button type="button" class="inline-flex relative justify-center items-center p-0 text-topbar-item transition-all w-[37.5px] h-[37.5px] duration-200 ease-linear bg-topbar rounded-md btn hover:bg-topbar-item-bg-hover hover:text-topbar-item-hover group-data-[topbar=dark]:bg-topbar-dark group-data-[topbar=dark]:hover:bg-topbar-item-bg-hover-dark group-data-[topbar=dark]:hover:text-topbar-item-hover-dark group-data-[topbar=brand]:bg-topbar-brand group-data-[topbar=brand]:hover:bg-topbar-item-bg-hover-brand group-data-[topbar=brand]:hover:text-topbar-item-hover-brand group-data-[topbar=dark]:dark:bg-zink-700 group-data-[topbar=dark]:dark:hover:bg-zink-600 group-data-[topbar=brand]:text-topbar-item-brand group-data-[topbar=dark]:dark:hover:text-zink-50 group-data-[topbar=dark]:dark:text-zink-200 group-data-[topbar=dark]:text-topbar-item-dark" id="light-dark-mode">
                                    <i data-lucide="sun" class="inline-block w-5 h-5 stroke-1 fill-slate-100 group-data-[topbar=dark]:fill-topbar-item-bg-hover-dark group-data-[topbar=brand]:fill-topbar-item-bg-hover-brand"></i>
                                </button>
                            </div>
        
                            <div class="relative flex items-center dropdown h-header">
                                <?php
                                    $osCompany = session('outsource_company_name', 'Outsource');
                                    $osAdmin = session('outsource_admin_name', 'Partner');
                                    $osInitial = strtoupper(substr($osCompany, 0, 1));
                                ?>
                                <button type="button" class="inline-block p-0 transition-all duration-200 ease-linear bg-topbar rounded-full text-topbar-item dropdown-toggle btn hover:bg-topbar-item-bg-hover hover:text-topbar-item-hover group-data-[topbar=dark]:text-topbar-item-dark group-data-[topbar=dark]:bg-topbar-dark group-data-[topbar=dark]:hover:bg-topbar-item-bg-hover-dark group-data-[topbar=dark]:hover:text-topbar-item-hover-dark group-data-[topbar=brand]:bg-topbar-brand group-data-[topbar=brand]:hover:bg-topbar-item-bg-hover-brand group-data-[topbar=brand]:hover:text-topbar-item-hover-brand group-data-[topbar=dark]:dark:bg-zink-700 group-data-[topbar=dark]:dark:hover:bg-zink-600 group-data-[topbar=brand]:text-topbar-item-brand group-data-[topbar=dark]:dark:hover:text-zink-50 group-data-[topbar=dark]:dark:text-zink-200" id="dropdownMenuButton" data-bs-toggle="dropdown">
                                    <div class="bg-pink-100 rounded-full">
                                        <div class="flex items-center justify-center font-medium rounded-full size-10 shrink-0 bg-slate-200 text-slate-800 dark:text-zink-50 dark:bg-zink-600">
                                            <?php echo e($osInitial); ?>

                                        </div>
                                    </div>
                                </button>
                                <div class="absolute z-50 hidden p-4 ltr:text-left rtl:text-right bg-white rounded-md shadow-md !top-4 dropdown-menu min-w-[14rem] dark:bg-zink-600" aria-labelledby="dropdownMenuButton">
                                    <h6 class="mb-2 text-sm font-normal text-slate-500 dark:text-zink-300">Outsource Portal</h6>
                                    <div class="flex gap-3 mb-3">
                                        <div class="relative inline-block shrink-0">
                                            <div class="rounded bg-slate-100 dark:bg-zink-500">
                                                <div class="flex items-center justify-center font-medium rounded-full size-10 shrink-0 bg-slate-200 text-slate-800 dark:text-zink-50 dark:bg-zink-600">
                                                    <?php echo e($osInitial); ?>

                                                </div>
                                            </div>
                                            <span class="-top-1 ltr:-right-1 rtl:-left-1 absolute w-2.5 h-2.5 bg-green-400 border-2 border-white rounded-full dark:border-zink-600"></span>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 text-15"><?php echo e($osCompany); ?></h6>
                                            <p class="text-slate-500 dark:text-zink-300"><?php echo e($osAdmin); ?></p>
                                        </div>
                                    </div>
                                    <ul>
                                        <li class="pt-2 mt-2 border-t border-slate-200 dark:border-zink-500">
                                            <a class="block ltr:pr-4 rtl:pl-4 py-1.5 text-base font-medium transition-all duration-200 ease-linear text-slate-600 dropdown-item hover:text-custom-500 focus:text-custom-500 dark:text-zink-200 dark:hover:text-custom-500 dark:focus:text-custom-500" href="<?php echo e(route('outsource.logout')); ?>" onclick="event.preventDefault(); document.getElementById('outsource-header-logout-form').submit();">
                                                <i data-lucide="log-out" class="inline-block size-4 ltr:mr-2 rtl:ml-2"></i> Sign Out
                                            </a>
                                            <form id="outsource-header-logout-form" action="<?php echo e(route('outsource.logout')); ?>" method="POST" style="display: none;">
                                                <?php echo csrf_field(); ?>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    
   
        <div class="relative min-h-screen group-data-[sidebar-size=sm]:min-h-sm">
            <!-- message -->
            <?php echo Toastr::message(); ?>

            <!-- Page-content -->
            <?php echo $__env->yieldContent('content'); ?>
            <!-- End Page-content -->

            <!-- Page-footer -->
            <footer class="relative px-4 h-14 border-t py-3 flex items-center dark:border-zink-600">
                <div class="w-full">
                    <div class="flex items-center justify-between text-slate-400 dark:text-zink-200">
                        <div>
                            <script>document.write(new Date().getFullYear())</script> HRM System
                        </div>
                        <div class="hidden lg:block">
                            <div>
                                Human Resource Management System
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- End Page-footer -->
        </div>
    </div>
    <!-- end main content -->
    <div class="fixed items-center hidden bottom-6 right-12 h-header group-data-[navbar=hidden]:flex">
        <button data-drawer-target="customizerButton" type="button" class="inline-flex items-center justify-center w-12 h-12 p-0 transition-all duration-200 ease-linear rounded-md shadow-lg text-sky-50 bg-sky-500">
            <i data-lucide="settings" class="inline-block w-5 h-5"></i>
        </button>
    </div>

    <div id="customizerButton" drawer-end="" class="fixed inset-y-0 flex flex-col w-full transition-transform duration-300 ease-in-out transform bg-white shadow ltr:right-0 rtl:left-0 md:w-96 z-drawer show dark:bg-zink-600">
        <div class="flex justify-between p-4 border-b border-slate-200 dark:border-zink-500">
            <div class="grow">
                <h5 class="mb-1 text-16">HR System Theme Customizer</h5>
                <p class="font-normal text-slate-500 dark:text-zink-200">Choose your themes & layouts etc.</p>
            </div>
            <div class="shrink-0">
                <button data-drawer-close="customizerButton" class="transition-all duration-150 ease-linear text-slate-500 hover:text-slate-800 dark:text-zink-200 dark:hover:text-zink-50"><i data-lucide="x" class="w-4 h-4"></i></button>
            </div>
        </div>
        <div class="h-full p-6 overflow-y-auto">
            <div>
                <h5 class="mb-3 underline capitalize text-15">Choose Layouts</h5>
                <div class="grid grid-cols-1 mb-5 gap-7 sm:grid-cols-2">
                    <div class="relative">
                        <input id="layout-one" name="dataLayout" class="absolute w-4 h-4 border rounded-full appearance-none cursor-pointer ltr:right-2 rtl:left-2 top-2 vertical-menu-btn bg-slate-100 border-slate-300 checked:bg-custom-500 checked:border-custom-500 dark:bg-zink-400 dark:border-zink-500" type="radio" value="vertical" checked="">
                        <label class="block w-full h-24 p-0 overflow-hidden border rounded-lg cursor-pointer border-slate-200 dark:border-zink-500" for="layout-one">
                            <span class="flex h-full gap-0">
                                <span class="shrink-0">
                                    <span class="flex flex-col h-full gap-1 p-1 ltr:border-r rtl:border-l border-slate-200 dark:border-zink-500">
                                        <span class="block p-1 px-2 mb-2 rounded bg-slate-100 dark:bg-zink-400"></span>
                                        <span class="block p-1 px-2 pb-0 bg-slate-100 dark:bg-zink-500"></span>
                                        <span class="block p-1 px-2 pb-0 bg-slate-100 dark:bg-zink-500"></span>
                                        <span class="block p-1 px-2 pb-0 bg-slate-100 dark:bg-zink-500"></span>
                                    </span>
                                </span>
                                <span class="grow">
                                    <span class="flex flex-col h-full">
                                        <span class="block h-3 bg-slate-100 dark:bg-zink-500"></span>
                                        <span class="block h-3 mt-auto bg-slate-100 dark:bg-zink-500"></span>
                                    </span>
                                </span>
                            </span>
                        </label>
                        <h5 class="mt-2 text-center text-15">Vertical</h5>
                    </div>

                    <div class="relative">
                        <input id="layout-two" name="dataLayout" class="absolute w-4 h-4 border rounded-full appearance-none cursor-pointer ltr:right-2 rtl:left-2 top-2 vertical-menu-btn bg-slate-100 border-slate-300 checked:bg-custom-500 checked:border-custom-500 dark:bg-zink-400 dark:border-zink-500" type="radio" value="horizontal">
                        <label class="block w-full h-24 p-0 overflow-hidden border rounded-lg cursor-pointer border-slate-200 dark:border-zink-500" for="layout-two">
                            <span class="flex flex-col h-full gap-1">
                                <span class="flex items-center gap-1 p-1 bg-slate-100 dark:bg-zink-500">
                                    <span class="block p-1 ml-1 bg-white rounded dark:bg-zink-500"></span>
                                    <span class="block p-1 px-2 pb-0 bg-white dark:bg-zink-500 ms-auto"></span>
                                    <span class="block p-1 px-2 pb-0 bg-white dark:bg-zink-500"></span>
                                </span>
                                <span class="block p-1 bg-slate-100 dark:bg-zink-500"></span>
                                <span class="block p-1 mt-auto bg-slate-100 dark:bg-zink-500"></span>
                            </span>
                        </label>
                        <h5 class="mt-2 text-center text-15">Horizontal</h5>
                    </div>
                </div>

                <div id="semi-dark">
                    <div class="flex items-center">
                        <div class="relative inline-block w-10 mr-2 align-middle transition duration-200 ease-in">
                            <input type="checkbox" name="customDefaultSwitch" value="dark" id="customDefaultSwitch" class="absolute block w-5 h-5 transition duration-300 ease-linear border-2 rounded-full appearance-none cursor-pointer border-slate-200 bg-white/80 peer/published checked:bg-white checked:right-0 checked:border-custom-500 arrow-none dark:border-zink-500 dark:bg-zink-500 dark:checked:bg-zink-400 checked:bg-none">
                            <label for="customDefaultSwitch" class="block h-5 overflow-hidden transition duration-300 ease-linear border rounded-full cursor-pointer border-slate-200 bg-slate-200 peer-checked/published:bg-custom-500 peer-checked/published:border-custom-500 dark:border-zink-500 dark:bg-zink-600"></label>
                        </div>
                        <label for="customDefaultSwitch" class="inline-block text-base font-medium">Semi Dark (Sidebar & Header)</label>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <!-- data-skin="" -->
                <h5 class="mb-3 underline capitalize text-15">Skin Layouts</h5>
                <div class="grid grid-cols-1 mb-5 gap-7 sm:grid-cols-2">
                    <div class="relative">
                        <input id="layoutSkitOne" name="dataLayoutSkin" class="absolute w-4 h-4 border rounded-full appearance-none cursor-pointer ltr:right-2 rtl:left-2 top-2 vertical-menu-btn bg-slate-100 border-slate-300 checked:bg-custom-500 checked:border-custom-500 dark:bg-zink-400 dark:border-zink-500" type="radio" value="default">
                        <label class="block w-full h-24 p-0 overflow-hidden border rounded-lg cursor-pointer border-slate-200 dark:border-zink-500 bg-slate-50 dark:bg-zink-600" for="layoutSkitOne">
                            <span class="flex h-full gap-0">
                                <span class="shrink-0">
                                    <span class="flex flex-col h-full gap-1 p-1 ltr:border-r rtl:border-l border-slate-200 dark:border-zink-500">
                                        <span class="block p-1 px-2 mb-2 rounded bg-slate-100 dark:bg-zink-400"></span>
                                        <span class="block p-1 px-2 pb-0 bg-slate-100 dark:bg-zink-500"></span>
                                        <span class="block p-1 px-2 pb-0 bg-slate-100 dark:bg-zink-500"></span>
                                        <span class="block p-1 px-2 pb-0 bg-slate-100 dark:bg-zink-500"></span>
                                    </span>
                                </span>
                                <span class="grow">
                                    <span class="flex flex-col h-full">
                                        <span class="block h-3 bg-slate-100 dark:bg-zink-500"></span>
                                        <span class="block h-3 mt-auto bg-slate-100 dark:bg-zink-500"></span>
                                    </span>
                                </span>
                            </span>
                        </label>
                        <h5 class="mt-2 text-center text-15">Default</h5>
                    </div>
            
                    <div class="relative">
                        <input id="layoutSkitTwo" name="dataLayoutSkin" class="absolute w-4 h-4 border rounded-full appearance-none cursor-pointer ltr:right-2 rtl:left-2 top-2 vertical-menu-btn bg-slate-100 border-slate-300 checked:bg-custom-500 checked:border-custom-500 dark:bg-zink-400 dark:border-zink-500" type="radio" value="bordered" checked="">
                        <label class="block w-full h-24 p-0 overflow-hidden border rounded-lg cursor-pointer border-slate-200 dark:border-zink-500" for="layoutSkitTwo">
                            <span class="flex h-full gap-0">
                                <span class="shrink-0">
                                    <span class="flex flex-col h-full gap-1 p-1 ltr:border-r rtl:border-l border-slate-200 dark:border-zink-500">
                                        <span class="block p-1 px-2 mb-2 rounded bg-slate-100 dark:bg-zink-400"></span>
                                        <span class="block p-1 px-2 pb-0 bg-slate-100 dark:bg-zink-500"></span>
                                        <span class="block p-1 px-2 pb-0 bg-slate-100 dark:bg-zink-500"></span>
                                        <span class="block p-1 px-2 pb-0 bg-slate-100 dark:bg-zink-500"></span>
                                    </span>
                                </span>
                                <span class="grow">
                                    <span class="flex flex-col h-full">
                                        <span class="block h-3 border-b border-slate-200 dark:border-zink-500"></span>
                                        <span class="block h-3 mt-auto border-t border-slate-200 dark:border-zink-500"></span>
                                    </span>
                                </span>
                            </span>
                        </label>
                        <h5 class="mt-2 text-center text-15">Bordered</h5>
                    </div>
                </div>
            </div>
            
            <div class="mt-6">
                <!-- data-mode="" -->
                <h5 class="mb-3 underline capitalize text-15">Light & Dark</h5>
                <div class="flex gap-3">
                    <button type="button" id="dataModeOne" name="dataMode" value="light" class="transition-all duration-200 ease-linear bg-white border-dashed text-slate-500 btn border-slate-200 hover:text-slate-500 hover:bg-slate-50 hover:border-slate-200 [&.active]:text-custom-500 [&.active]:bg-custom-50 [&.active]:border-custom-200 dark:bg-zink-600 dark:text-zink-200 dark:border-zink-400 dark:hover:bg-zink-600 dark:hover:text-zink-100 dark:hover:border-zink-400 dark:[&.active]:bg-custom-500/10 dark:[&.active]:border-custom-500/30 dark:[&.active]:text-custom-500 active">Light Mode</button>
                    <button type="button" id="dataModeTwo" name="dataMode" value="dark" class="transition-all duration-200 ease-linear bg-white border-dashed text-slate-500 btn border-slate-200 hover:text-slate-500 hover:bg-slate-50 hover:border-slate-200 [&.active]:text-custom-500 [&.active]:bg-custom-50 [&.active]:border-custom-200 dark:bg-zink-600 dark:text-zink-200 dark:border-zink-400 dark:hover:bg-zink-600 dark:hover:text-zink-100 dark:hover:border-zink-400 dark:[&.active]:bg-custom-500/10 dark:[&.active]:border-custom-500/30 dark:[&.active]:text-custom-500">Dark Mode</button>
                </div>
            </div>

            <div class="mt-6">
                <!-- dir="ltr" -->
                <h5 class="mb-3 underline capitalize text-15">LTR & RTL</h5>
                <div class="flex flex-wrap gap-3">
                    <button type="button" id="diractionOne" name="dir" value="ltr" class="transition-all duration-200 ease-linear bg-white border-dashed text-slate-500 btn border-slate-200 hover:text-slate-500 hover:bg-slate-50 hover:border-slate-200 [&.active]:text-custom-500 [&.active]:bg-custom-50 [&.active]:border-custom-200 dark:bg-zink-600 dark:text-zink-200 dark:border-zink-400 dark:hover:bg-zink-600 dark:hover:text-zink-100 dark:hover:border-zink-400 dark:[&.active]:bg-custom-500/10 dark:[&.active]:border-custom-500/30 dark:[&.active]:text-custom-500 active">LTR Mode</button>
                    <button type="button" id="diractionTwo" name="dir" value="rtl" class="transition-all duration-200 ease-linear bg-white border-dashed text-slate-500 btn border-slate-200 hover:text-slate-500 hover:bg-slate-50 hover:border-slate-200 [&.active]:text-custom-500 [&.active]:bg-custom-50 [&.active]:border-custom-200 dark:bg-zink-600 dark:text-zink-200 dark:border-zink-400 dark:hover:bg-zink-600 dark:hover:text-zink-100 dark:hover:border-zink-400 dark:[&.active]:bg-custom-500/10 dark:[&.active]:border-custom-500/30 dark:[&.active]:text-custom-500">RTL Mode</button>
                </div>
            </div>

            <div class="mt-6">
                <!-- data-content -->
                <h5 class="mb-3 underline capitalize text-15">Content Width</h5>
                <div class="flex gap-3">
                    <button type="button" id="datawidthOne" name="datawidth" value="fluid" class="transition-all duration-200 ease-linear bg-white border-dashed text-slate-500 btn border-slate-200 hover:text-slate-500 hover:bg-slate-50 hover:border-slate-200 [&.active]:text-custom-500 [&.active]:bg-custom-50 [&.active]:border-custom-200 dark:bg-zink-600 dark:text-zink-200 dark:border-zink-400 dark:hover:bg-zink-600 dark:hover:text-zink-100 dark:hover:border-zink-400 dark:[&.active]:bg-custom-500/10 dark:[&.active]:border-custom-500/30 dark:[&.active]:text-custom-500 active">Fluid</button>
                    <button type="button" id="datawidthTwo" name="datawidth" value="boxed" class="transition-all duration-200 ease-linear bg-white border-dashed text-slate-500 btn border-slate-200 hover:text-slate-500 hover:bg-slate-50 hover:border-slate-200 [&.active]:text-custom-500 [&.active]:bg-custom-50 [&.active]:border-custom-200 dark:bg-zink-600 dark:text-zink-200 dark:border-zink-400 dark:hover:bg-zink-600 dark:hover:text-zink-100 dark:hover:border-zink-400 dark:[&.active]:bg-custom-500/10 dark:[&.active]:border-custom-500/30 dark:[&.active]:text-custom-500">Boxed</button>
                </div>
            </div>

            <div class="mt-6" id="sidebar-size">
                <!-- data-sidebar-size="" -->
                <h5 class="mb-3 underline capitalize text-15">Sidebar Size</h5>
                <div class="flex flex-wrap gap-3">
                    <button type="button" id="sidebarSizeOne" name="sidebarSize" value="lg" class="transition-all duration-200 ease-linear bg-white border-dashed text-slate-500 btn border-slate-200 hover:text-slate-500 hover:bg-slate-50 hover:border-slate-200 [&.active]:text-custom-500 [&.active]:bg-custom-50 [&.active]:border-custom-200 dark:bg-zink-600 dark:text-zink-200 dark:border-zink-400 dark:hover:bg-zink-600 dark:hover:text-zink-100 dark:hover:border-zink-400 dark:[&.active]:bg-custom-500/10 dark:[&.active]:border-custom-500/30 dark:[&.active]:text-custom-500 active">Default</button>
                    <button type="button" id="sidebarSizeTwo" name="sidebarSize" value="md" class="transition-all duration-200 ease-linear bg-white border-dashed text-slate-500 btn border-slate-200 hover:text-slate-500 hover:bg-slate-50 hover:border-slate-200 [&.active]:text-custom-500 [&.active]:bg-custom-50 [&.active]:border-custom-200 dark:bg-zink-600 dark:text-zink-200 dark:border-zink-400 dark:hover:bg-zink-600 dark:hover:text-zink-100 dark:hover:border-zink-400 dark:[&.active]:bg-custom-500/10 dark:[&.active]:border-custom-500/30 dark:[&.active]:text-custom-500">Compact</button>
                    <button type="button" id="sidebarSizeThree" name="sidebarSize" value="sm" class="transition-all duration-200 ease-linear bg-white border-dashed text-slate-500 btn border-slate-200 hover:text-slate-500 hover:bg-slate-50 hover:border-slate-200 [&.active]:text-custom-500 [&.active]:bg-custom-50 [&.active]:border-custom-200 dark:bg-zink-600 dark:text-zink-200 dark:border-zink-400 dark:hover:bg-zink-600 dark:hover:text-zink-100 dark:hover:border-zink-400 dark:[&.active]:bg-custom-500/10 dark:[&.active]:border-custom-500/30 dark:[&.active]:text-custom-500">Small (Icon)</button>
                </div>
            </div>

            <div class="mt-6" id="navigation-type">
                <!-- data-navbar="" -->
                <h5 class="mb-3 underline capitalize text-15">Navigation Type</h5>
                <div class="flex flex-wrap gap-3">
                    <button type="button" id="navbarTwo" name="navbar" value="sticky" class="transition-all duration-200 ease-linear bg-white border-dashed text-slate-500 btn border-slate-200 hover:text-slate-500 hover:bg-slate-50 hover:border-slate-200 [&.active]:text-custom-500 [&.active]:bg-custom-50 [&.active]:border-custom-200 dark:bg-zink-600 dark:text-zink-200 dark:border-zink-400 dark:hover:bg-zink-600 dark:hover:text-zink-100 dark:hover:border-zink-400 dark:[&.active]:bg-custom-500/10 dark:[&.active]:border-custom-500/30 dark:[&.active]:text-custom-500 active">Sticky</button>
                    <button type="button" id="navbarOne" name="navbar" value="scroll" class="transition-all duration-200 ease-linear bg-white border-dashed text-slate-500 btn border-slate-200 hover:text-slate-500 hover:bg-slate-50 hover:border-slate-200 [&.active]:text-custom-500 [&.active]:bg-custom-50 [&.active]:border-custom-200 dark:bg-zink-600 dark:text-zink-200 dark:border-zink-400 dark:hover:bg-zink-600 dark:hover:text-zink-100 dark:hover:border-zink-400 dark:[&.active]:bg-custom-500/10 dark:[&.active]:border-custom-500/30 dark:[&.active]:text-custom-500">Scroll</button>
                    <button type="button" id="navbarThree" name="navbar" value="bordered" class="transition-all duration-200 ease-linear bg-white border-dashed text-slate-500 btn border-slate-200 hover:text-slate-500 hover:bg-slate-50 hover:border-slate-200 [&.active]:text-custom-500 [&.active]:bg-custom-50 [&.active]:border-custom-200 dark:bg-zink-600 dark:text-zink-200 dark:border-zink-400 dark:hover:bg-zink-600 dark:hover:text-zink-100 dark:hover:border-zink-400 dark:[&.active]:bg-custom-500/10 dark:[&.active]:border-custom-500/30 dark:[&.active]:text-custom-500">Bordered</button>
                    <button type="button" id="navbarFour" name="navbar" value="hidden" class="transition-all duration-200 ease-linear bg-white border-dashed text-slate-500 btn border-slate-200 hover:text-slate-500 hover:bg-slate-50 hover:border-slate-200 [&.active]:text-custom-500 [&.active]:bg-custom-50 [&.active]:border-custom-200 dark:bg-zink-600 dark:text-zink-200 dark:border-zink-400 dark:hover:bg-zink-600 dark:hover:text-zink-100 dark:hover:border-zink-400 dark:[&.active]:bg-custom-500/10 dark:[&.active]:border-custom-500/30 dark:[&.active]:text-custom-500">Hidden</button>
                </div>
            </div>

            <div class="mt-6" id="sidebar-color">
                <!-- data-sidebar="" light, dark, brand, modern-->
                <h5 class="mb-3 underline capitalize text-15">Sizebar Colors</h5>
                <div class="flex flex-wrap gap-3">
                    <button type="button" id="sidebarColorOne" name="sidebarColor" value="light" class="flex items-center justify-center w-10 h-10 bg-white border rounded-md border-slate-200 group active"><i data-lucide="check" class="w-5 h-5 hidden group-[.active]:inline-block text-slate-600"></i></button>
                    <button type="button" id="sidebarColorTwo" name="sidebarColor" value="dark" class="flex items-center justify-center w-10 h-10 border rounded-md border-zink-900 bg-zink-900 group"><i data-lucide="check" class="w-5 h-5 hidden group-[.active]:inline-block text-white"></i></button>
                    <button type="button" id="sidebarColorThree" name="sidebarColor" value="brand" class="flex items-center justify-center w-10 h-10 border rounded-md border-custom-800 bg-custom-800 group"><i data-lucide="check" class="w-5 h-5 hidden group-[.active]:inline-block text-white"></i></button>
                    <button type="button" id="sidebarColorFour" name="sidebarColor" value="modern" class="flex items-center justify-center w-10 h-10 border rounded-md border-purple-950 bg-gradient-to-t from-red-400 to-purple-500 group"><i data-lucide="check" class="w-5 h-5 hidden group-[.active]:inline-block text-white"></i></button>
                </div>
            </div>
            
            <div class="mt-6">
                <!-- data-topbar="" light, dark, brand, modern-->
                <h5 class="mb-3 underline capitalize text-15">Topbar Colors</h5>
                <div class="flex flex-wrap gap-3">
                    <button type="button" id="topbarColorOne" name="topbarColor" value="light" class="flex items-center justify-center w-10 h-10 bg-white border rounded-md border-slate-200 group active"><i data-lucide="check" class="w-5 h-5 hidden group-[.active]:inline-block text-slate-600"></i></button>
                    <button type="button" id="topbarColorTwo" name="topbarColor" value="dark" class="flex items-center justify-center w-10 h-10 border rounded-md border-zink-900 bg-zink-900 group"><i data-lucide="check" class="w-5 h-5 hidden group-[.active]:inline-block text-white"></i></button>
                    <button type="button" id="topbarColorThree" name="topbarColor" value="brand" class="flex items-center justify-center w-10 h-10 border rounded-md border-custom-800 bg-custom-800 group"><i data-lucide="check" class="w-5 h-5 hidden group-[.active]:inline-block text-white"></i></button>
                </div>
            </div>
            
        </div>
        <div class="flex items-center justify-center gap-3 p-4 border-t border-slate-200 dark:border-zink-500">
            <button type="button" id="reset-layout" class="w-full transition-all duration-200 ease-linear text-slate-500 btn bg-slate-200 border-slate-200 hover:text-slate-600 hover:bg-slate-300 hover:border-slate-300 focus:text-slate-600 focus:bg-slate-300 focus:border-slate-300 focus:ring focus:ring-slate-100">Reset</button>
        </div>
    </div>

    <script src="<?php echo e(URL::to('assets/libs/choices.js/public/assets/scripts/choices.min.js')); ?>"></script>
    <script src="<?php echo e(URL::to('assets/libs/%40popperjs/core/umd/popper.min.js')); ?>"></script>
    <script src="<?php echo e(URL::to('assets/libs/tippy.js/tippy-bundle.umd.min.js')); ?>"></script>
    <script src="<?php echo e(URL::to('assets/libs/simplebar/simplebar.min.js')); ?>"></script>
    <script src="<?php echo e(URL::to('assets/libs/prismjs/prism.js')); ?>"></script>
    <script src="<?php echo e(URL::to('assets/libs/lucide/umd/lucide.js')); ?>"></script>
    <script src="<?php echo e(URL::to('assets/js/hrm-system.bundle.js')); ?>"></script>
    <script src="<?php echo e(URL::to('assets/libs/flatpickr/flatpickr.min.js')); ?>"></script>
    <!--apexchart js-->
    <script src="<?php echo e(URL::to('assets/libs/apexcharts/apexcharts.min.js')); ?>"></script>
    
    <script src="<?php echo e(URL::to('assets/js/datatables/jquery-3.7.0.js')); ?>"></script>
    <script src="<?php echo e(URL::to('assets/js/datatables/data-tables.min.js')); ?>"></script>
    <script src="<?php echo e(URL::to('assets/js/datatables/data-tables.tailwindcss.min.js')); ?>"></script>
    <!--buttons dataTables-->
    <script src="<?php echo e(URL::to('assets/js/datatables/datatables.buttons.min.js')); ?>"></script>
    <script src="<?php echo e(URL::to('assets/js/datatables/jszip.min.js')); ?>"></script>
    <script src="<?php echo e(URL::to('assets/js/datatables/pdfmake.min.js')); ?>"></script>
    <script src="<?php echo e(URL::to('assets/js/datatables/buttons.html5.min.js')); ?>"></script>
    <script src="<?php echo e(URL::to('assets/js/datatables/buttons.print.min.js')); ?>"></script>
    <script src="<?php echo e(URL::to('assets/js/datatables/datatables.init.js')); ?>"></script>

    <!-- App js -->
    <script src="<?php echo e(URL::to('assets/js/app.js')); ?>"></script>
    
    <?php echo $__env->yieldContent('script'); ?>
</body>
</html><?php /**PATH /var/www/hrm2/resources/views/layouts/outsource-master.blade.php ENDPATH**/ ?>
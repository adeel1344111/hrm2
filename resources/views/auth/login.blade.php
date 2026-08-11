@extends('layouts.app')

@section('content')
<style>
    .hrm-login-card { width: 100%; max-width: 28rem; margin-left: auto; margin-right: auto; }
    .hrm-login-accent { height: 0.375rem; width: 100%; background: linear-gradient(90deg, #3b82f6, #60a5fa, #93c5fd); }
    .hrm-login-logo {
        display: inline-flex; align-items: center; justify-content: center;
        width: 3rem; height: 3rem; margin-bottom: 1rem;
        color: #fff; border-radius: 0.75rem;
        background: linear-gradient(135deg, #3b82f6, #1e40af);
        box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.35);
    }
    .hrm-login-logo svg { width: 1.5rem; height: 1.5rem; stroke: #fff; }
    .hrm-login-field { position: relative; }
    .hrm-login-field .hrm-login-icon-left {
        position: absolute; left: 0.85rem; top: 50%; transform: translateY(-50%);
        width: 1rem; height: 1rem; color: #94a3b8; pointer-events: none; z-index: 2;
    }
    .hrm-login-field .hrm-login-icon-left svg { width: 1rem; height: 1rem; }
    .hrm-login-field .hrm-login-icon-right {
        position: absolute; right: 0.65rem; top: 50%; transform: translateY(-50%);
        padding: 0.25rem; border: 0; background: transparent; color: #94a3b8;
        cursor: pointer; z-index: 2; line-height: 0;
    }
    .hrm-login-field .hrm-login-icon-right svg { width: 1rem; height: 1rem; }
    .hrm-login-field .form-input {
        padding-left: 2.5rem !important;
        padding-right: 1rem !important;
    }
    .hrm-login-field.has-toggle .form-input {
        padding-right: 2.5rem !important;
    }
    .hrm-login-btn {
        display: inline-flex !important; align-items: center; justify-content: center;
        gap: 0.5rem; width: 100%;
    }
    .hrm-login-btn svg { width: 1rem; height: 1rem; flex-shrink: 0; }
</style>

    <div class="hrm-login-card mb-0 card shadow-xl border border-slate-200 dark:border-zink-500 relative overflow-hidden">
        <div class="hrm-login-accent"></div>
        <div class="px-8 py-10 card-body">
            <div class="text-center">
                <div class="hrm-login-logo">
                    <i data-lucide="users"></i>
                </div>
                <h4 class="mt-2 mb-1 text-lg font-semibold text-custom-500">Welcome Back</h4>
                <p class="text-sm text-slate-500 dark:text-zink-200">Sign in with your Employee ID to continue</p>
            </div>

            @if ($errors->any())
                <div class="px-4 py-3 mt-5 text-sm text-red-600 border border-red-200 rounded-lg bg-red-50 dark:bg-zink-600 dark:border-zink-500 dark:text-red-400">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" class="mt-8" method="POST" autocomplete="on">
                @csrf

                <div class="mb-4">
                    <label for="employee_id" class="inline-block mb-2 text-sm font-medium text-slate-700 dark:text-zink-100">Employee ID</label>
                    <div class="hrm-login-field">
                        <i data-lucide="user" class="hrm-login-icon-left"></i>
                        <input type="text" id="employee_id" name="employee_id" value="{{ old('employee_id') }}"
                               class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-300 bg-white text-slate-900"
                               placeholder="e.g. MK001" required autofocus>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="password" class="inline-block mb-2 text-sm font-medium text-slate-700 dark:text-zink-100">Password</label>
                    <div class="hrm-login-field has-toggle">
                        <i data-lucide="lock" class="hrm-login-icon-left"></i>
                        <input type="password" id="password" name="password"
                               class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-300 bg-white text-slate-900"
                               placeholder="Enter your password" required>
                        <button type="button" id="togglePassword" class="hrm-login-icon-right" aria-label="Show password">
                            <i data-lucide="eye" id="togglePasswordIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-6">
                    <div class="flex items-center gap-2">
                        <input id="remember" name="remember" type="checkbox" value="1"
                               class="border rounded-sm appearance-none size-4 bg-white border-slate-300 dark:bg-zink-600 dark:border-zink-500 checked:bg-custom-500 checked:border-custom-500 dark:checked:bg-custom-500 dark:checked:border-custom-500">
                        <label for="remember" class="inline-block text-sm font-medium text-slate-600 dark:text-zink-200 align-middle cursor-pointer">Remember me</label>
                    </div>
                </div>

                <div class="mb-2">
                    <button type="submit" class="hrm-login-btn text-white btn bg-custom-500 border-custom-500 hover:bg-custom-600 hover:border-custom-600 focus:ring focus:ring-custom-100 shadow-md">
                        <i data-lucide="log-in"></i>
                        <span>Sign In</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.lucide) lucide.createIcons();
        const form = document.querySelector('form');
        const employeeIdInput = document.getElementById('employee_id');
        const passwordInput = document.getElementById('password');
        const toggleBtn = document.getElementById('togglePassword');
        const toggleIcon = document.getElementById('togglePasswordIcon');

        form?.addEventListener('submit', function (e) {
            if (!employeeIdInput.value || !passwordInput.value) {
                e.preventDefault();
                alert('Please fill in all required fields.');
            }
        });

        toggleBtn?.addEventListener('click', function () {
            const show = passwordInput.type === 'password';
            passwordInput.type = show ? 'text' : 'password';
            if (toggleIcon) {
                toggleIcon.setAttribute('data-lucide', show ? 'eye-off' : 'eye');
                if (window.lucide) lucide.createIcons();
            }
        });
    });
</script>
@endsection

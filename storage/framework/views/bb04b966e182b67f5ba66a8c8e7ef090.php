<?php $__env->startSection('content'); ?>
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
    .hrm-login-field .form-input {
        padding-left: 2.5rem !important;
        padding-right: 1rem !important;
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
                    <i data-lucide="building-2"></i>
                </div>
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Outsource Login</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-zink-200">Mighty Knights · Partner Portal</p>
            </div>

            <div class="mt-8 text-center">
                <h4 class="mb-1 text-lg font-semibold text-custom-500">Welcome Back</h4>
                <p class="text-sm text-slate-500 dark:text-zink-200">Sign in with your company email to continue</p>
            </div>

            <?php if(session('error')): ?>
                <div class="px-4 py-3 mt-5 text-sm text-red-600 border border-red-200 rounded-lg bg-red-50 dark:bg-zink-600 dark:border-zink-500 dark:text-red-400">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>
            <?php if(session('feedback') === 'logged_out'): ?>
                <div class="px-4 py-3 mt-5 text-sm text-green-600 border border-green-200 rounded-lg bg-green-50 dark:bg-zink-600 dark:border-zink-500">
                    You have been logged out.
                </div>
            <?php endif; ?>
            <?php if(session('outsource_login_access')): ?>
                <div class="px-4 py-3 mt-5 text-sm text-custom-500 border border-custom-200 rounded-lg bg-custom-50 dark:bg-zink-600 dark:border-zink-500">
                    Already logged in as <?php echo e(session('outsource_company_name')); ?>.
                    <a href="<?php echo e(route('outsource.dashboard')); ?>" class="font-semibold underline">Open Dashboard</a>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('outsource.login.submit')); ?>" class="mt-8" method="POST" autocomplete="on">
                <?php echo csrf_field(); ?>

                <div class="mb-4">
                    <label for="email" class="inline-block mb-2 text-sm font-medium text-slate-700 dark:text-zink-100">Company Email</label>
                    <div class="hrm-login-field">
                        <i data-lucide="mail" class="hrm-login-icon-left"></i>
                        <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>"
                               class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-300 bg-white text-slate-900"
                               placeholder="company@email.com" required autofocus>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="password" class="inline-block mb-2 text-sm font-medium text-slate-700 dark:text-zink-100">Admin Password</label>
                    <div class="hrm-login-field">
                        <i data-lucide="lock" class="hrm-login-icon-left"></i>
                        <input type="password" id="password" name="password"
                               class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-300 bg-white text-slate-900"
                               placeholder="Enter your password" required>
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.lucide) lucide.createIcons();
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/hrm2/resources/views/outsource/login.blade.php ENDPATH**/ ?>
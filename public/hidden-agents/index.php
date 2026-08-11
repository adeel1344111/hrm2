<?php

// Force No-Cache
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

/**
 * Hidden Agents Manager
 * Part of HRM Custom Tools
 */

ini_set('display_errors', 0);
error_reporting(0);

// --- Load DB from .env ---
function getDbConnection() {
    $envPath = __DIR__ . '/../../.env';
    if (!file_exists($envPath)) die(json_encode(['error' => 'Env missing']));
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $config = [];
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        $parts = explode('=', $line, 2);
        if (count($parts) === 2) {
            $config[trim($parts[0])] = trim($parts[1], "\"' \r\n");
        }
    }
    try {
        $pdo = new PDO(
            "mysql:host={$config['DB_HOST']};dbname={$config['DB_DATABASE']};charset=utf8mb4",
            $config['DB_USERNAME'],
            $config['DB_PASSWORD']
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die(json_encode(['error' => 'DB connection failed']));
    }
}

// --- AJAX toggle handler ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    $pdo    = getDbConnection();
    $empId  = trim($_POST['employee_id'] ?? '');
    $action = $_POST['action'];

    if (empty($empId)) {
        echo json_encode(['success' => false, 'message' => 'Invalid employee ID']);
        exit;
    }

    try {
        if ($action === 'hide') {
            $stmt = $pdo->prepare("INSERT IGNORE INTO hidden_agents (employee_id) VALUES (?)");
            $stmt->execute([$empId]);
            echo json_encode(['success' => true, 'hidden' => true]);
        } elseif ($action === 'unhide') {
            $stmt = $pdo->prepare("DELETE FROM hidden_agents WHERE employee_id = ?");
            $stmt->execute([$empId]);
            echo json_encode(['success' => true, 'hidden' => false]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Unknown action']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'DB error']);
    }
    exit;
}

// --- Load users with hidden status ---
$pdo   = getDbConnection();
$search = trim($_GET['search'] ?? '');
$filter = $_GET['filter'] ?? 'all'; // all | hidden | visible

$query = "
    SELECT u.employee_id, u.name, u.user_type, u.department, u.designation, u.status,
           IF(h.employee_id IS NOT NULL, 1, 0) AS is_hidden
    FROM users u
    LEFT JOIN hidden_agents h ON h.employee_id = u.employee_id
    WHERE u.designation = 'Verification Officer'
      AND u.status = 'active'
";

$params = [];
$conditions = [];

if (!empty($search)) {
    $conditions[] = "(u.name LIKE ? OR u.employee_id LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if ($filter === 'hidden') {
    $conditions[] = "h.employee_id IS NOT NULL";
} elseif ($filter === 'visible') {
    $conditions[] = "h.employee_id IS NULL";
}

if ($conditions) {
    $query .= " AND " . implode(' AND ', $conditions);
}

$query .= " ORDER BY u.name ASC";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalUsers   = count($users);
$hiddenCount  = count(array_filter($users, fn($u) => $u['is_hidden']));
$visibleCount = $totalUsers - $hiddenCount;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hidden Agents Manager | HRM Tools</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: #0f172a;
            color: #f8fafc;
            margin: 0;
            padding: 0;
        }
        .glass {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .bg-gradient-premium {
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 50%, #d946ef 100%);
        }
        .row-enter {
            animation: fadeIn 0.3s ease forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(6px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .badge-agent       { background: rgba(59,130,246,0.15); color: #93c5fd; border: 1px solid rgba(59,130,246,0.25); }
        .badge-team_lead   { background: rgba(139,92,246,0.15); color: #c4b5fd; border: 1px solid rgba(139,92,246,0.25); }
        .badge-floor_manager{ background: rgba(16,185,129,0.15); color: #6ee7b7; border: 1px solid rgba(16,185,129,0.25); }
        .badge-admin       { background: rgba(245,158,11,0.15); color: #fcd34d; border: 1px solid rgba(245,158,11,0.25); }

        .btn-hide {
            background: rgba(239,68,68,0.15);
            border: 1px solid rgba(239,68,68,0.35);
            color: #fca5a5;
            transition: all 0.2s;
        }
        .btn-hide:hover {
            background: rgba(239,68,68,0.3);
            border-color: rgba(239,68,68,0.6);
            box-shadow: 0 0 12px rgba(239,68,68,0.25);
        }
        .btn-unhide {
            background: rgba(34,197,94,0.15);
            border: 1px solid rgba(34,197,94,0.35);
            color: #86efac;
            transition: all 0.2s;
        }
        .btn-unhide:hover {
            background: rgba(34,197,94,0.3);
            border-color: rgba(34,197,94,0.6);
            box-shadow: 0 0 12px rgba(34,197,94,0.25);
        }
        .row-hidden-bg {
            background: rgba(239,68,68,0.04);
        }
        .search-input {
            background: rgba(15,23,42,0.8);
            border: 1px solid rgba(255,255,255,0.08);
            color: #f1f5f9;
            transition: border-color 0.2s;
        }
        .search-input:focus {
            outline: none;
            border-color: rgba(139,92,246,0.5);
            box-shadow: 0 0 0 3px rgba(139,92,246,0.1);
        }
        .filter-btn {
            transition: all 0.2s;
            border: 1px solid rgba(255,255,255,0.08);
            background: rgba(30,41,59,0.5);
        }
        .filter-btn.active {
            border-color: rgba(139,92,246,0.5);
            background: rgba(139,92,246,0.2);
            color: #c4b5fd;
        }
        .toast {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 999;
            padding: 12px 20px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.3s ease;
            pointer-events: none;
        }
        .toast.show {
            opacity: 1;
            transform: translateY(0);
        }
        .toast-success { background: rgba(22,163,74,0.9); backdrop-filter: blur(8px); border: 1px solid rgba(34,197,94,0.3); }
        .toast-error   { background: rgba(220,38,38,0.9); backdrop-filter: blur(8px); border: 1px solid rgba(239,68,68,0.3); }

        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: rgba(15,23,42,0.5); }
        ::-webkit-scrollbar-thumb { background: rgba(139,92,246,0.4); border-radius: 3px; }
    </style>
</head>
<body class="min-h-screen">

    <!-- Ambient BG -->
    <div class="fixed inset-0 pointer-events-none -z-10">
        <div class="absolute top-[-10%] left-[-5%] w-[35%] h-[40%] bg-blue-600/8 blur-[120px] rounded-full"></div>
        <div class="absolute bottom-[-5%] right-[-5%] w-[30%] h-[35%] bg-purple-600/8 blur-[120px] rounded-full"></div>
        <div class="absolute top-[40%] left-[50%] w-[20%] h-[20%] bg-pink-600/5 blur-[100px] rounded-full"></div>
    </div>

    <!-- Toast -->
    <div id="toast" class="toast">
        <i id="toast-icon" data-lucide="check-circle" class="w-4 h-4 shrink-0"></i>
        <span id="toast-msg"></span>
    </div>

    <div class="relative z-10 w-full max-w-5xl mx-auto px-4 py-8">

        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-4">
                <div class="p-2.5 bg-gradient-premium rounded-xl shadow-lg">
                    <i data-lucide="eye-off" class="w-6 h-6 text-white"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">Hidden Agents <span class="text-purple-400">Manager</span></h1>
                    <p class="text-[10px] text-slate-500 uppercase font-bold tracking-widest leading-none mt-1">Verification Officers &bull; Active Only</p>
                </div>
            </div>
            <div class="text-right hidden sm:block">
                <div class="text-xs text-slate-500">Database</div>
                <div class="text-sm font-semibold text-slate-300 font-mono">u450550210_hrm</div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="glass rounded-2xl p-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-slate-700/50 flex items-center justify-center shrink-0">
                    <i data-lucide="users" class="w-5 h-5 text-slate-300"></i>
                </div>
                <div>
                    <div class="text-[10px] text-slate-500 uppercase font-bold tracking-widest">Total Users</div>
                    <div class="text-2xl font-bold text-white"><?= $totalUsers ?></div>
                </div>
            </div>
            <div class="glass rounded-2xl p-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-green-500/10 flex items-center justify-center shrink-0">
                    <i data-lucide="eye" class="w-5 h-5 text-green-400"></i>
                </div>
                <div>
                    <div class="text-[10px] text-slate-500 uppercase font-bold tracking-widest">Visible</div>
                    <div class="text-2xl font-bold text-green-400"><?= $visibleCount ?></div>
                </div>
            </div>
            <div class="glass rounded-2xl p-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-red-500/10 flex items-center justify-center shrink-0">
                    <i data-lucide="eye-off" class="w-5 h-5 text-red-400"></i>
                </div>
                <div>
                    <div class="text-[10px] text-slate-500 uppercase font-bold tracking-widest">Hidden</div>
                    <div class="text-2xl font-bold text-red-400"><?= $hiddenCount ?></div>
                </div>
            </div>
        </div>

        <!-- Search & Filter -->
        <div class="glass rounded-2xl p-4 mb-4 flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500 pointer-events-none"></i>
                <input
                    type="text"
                    id="search-input"
                    placeholder="Search by name or employee ID..."
                    value="<?= htmlspecialchars($search) ?>"
                    class="search-input w-full pl-10 pr-4 py-2.5 rounded-xl text-sm"
                >
            </div>
            <div class="flex gap-2">
                <a href="?filter=all<?= $search ? '&search='.urlencode($search) : '' ?>"
                   class="filter-btn <?= $filter === 'all' ? 'active' : '' ?> px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider text-slate-400">
                    All
                </a>
                <a href="?filter=visible<?= $search ? '&search='.urlencode($search) : '' ?>"
                   class="filter-btn <?= $filter === 'visible' ? 'active' : '' ?> px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider text-slate-400">
                    Visible
                </a>
                <a href="?filter=hidden<?= $search ? '&search='.urlencode($search) : '' ?>"
                   class="filter-btn <?= $filter === 'hidden' ? 'active' : '' ?> px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider text-slate-400">
                    Hidden
                </a>
            </div>
        </div>

        <!-- Table -->
        <div class="glass rounded-2xl overflow-hidden">
            <?php if (empty($users)): ?>
                <div class="flex flex-col items-center justify-center py-20 text-slate-500">
                    <i data-lucide="user-x" class="w-12 h-12 mb-3 opacity-30"></i>
                    <p class="text-sm font-semibold">No users found</p>
                    <p class="text-xs mt-1 opacity-60">Try adjusting your search or filter</p>
                </div>
            <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-white/5">
                            <th class="px-5 py-3.5 text-left text-[10px] font-bold uppercase tracking-widest text-slate-500">#</th>
                            <th class="px-5 py-3.5 text-left text-[10px] font-bold uppercase tracking-widest text-slate-500">Employee ID</th>
                            <th class="px-5 py-3.5 text-left text-[10px] font-bold uppercase tracking-widest text-slate-500">Name</th>
                            <th class="px-5 py-3.5 text-left text-[10px] font-bold uppercase tracking-widest text-slate-500">Role</th>
                            <th class="px-5 py-3.5 text-left text-[10px] font-bold uppercase tracking-widest text-slate-500">Status</th>
                            <th class="px-5 py-3.5 text-right text-[10px] font-bold uppercase tracking-widest text-slate-500">Action</th>
                        </tr>
                    </thead>
                    <tbody id="users-tbody">
                    <?php foreach ($users as $i => $user): ?>
                        <tr class="row-enter border-b border-white/5 transition-colors duration-200 hover:bg-white/[0.02] <?= $user['is_hidden'] ? 'row-hidden-bg' : '' ?>"
                            id="row-<?= htmlspecialchars($user['employee_id']) ?>"
                            style="animation-delay: <?= min($i * 20, 300) ?>ms">
                            <td class="px-5 py-3.5 text-slate-600 font-mono text-xs"><?= $i + 1 ?></td>
                            <td class="px-5 py-3.5">
                                <span class="font-mono text-xs bg-slate-800/70 px-2 py-1 rounded-lg text-slate-300 border border-slate-700/50">
                                    <?= htmlspecialchars($user['employee_id']) ?>
                                </span>
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-500/30 to-blue-500/30 flex items-center justify-center border border-white/10 shrink-0">
                                        <span class="text-xs font-bold text-slate-300"><?= mb_strtoupper(mb_substr($user['name'], 0, 1)) ?></span>
                                    </div>
                                    <span class="font-medium text-slate-200"><?= htmlspecialchars($user['name']) ?></span>
                                </div>
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider badge-<?= $user['user_type'] ?>">
                                    <?= str_replace('_', ' ', $user['user_type']) ?>
                                </span>
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-1.5 status-cell" data-hidden="<?= $user['is_hidden'] ? '1' : '0' ?>">
                                    <?php if ($user['is_hidden']): ?>
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-400 animate-pulse"></span>
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-red-400">Hidden</span>
                                    <?php else: ?>
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-400"></span>
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-green-400">Visible</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <button
                                    class="action-btn <?= $user['is_hidden'] ? 'btn-unhide' : 'btn-hide' ?> px-4 py-1.5 rounded-lg text-xs font-bold flex items-center gap-1.5 ml-auto transition-all active:scale-95"
                                    data-employee-id="<?= htmlspecialchars($user['employee_id']) ?>"
                                    data-hidden="<?= $user['is_hidden'] ? '1' : '0' ?>">
                                    <i data-lucide="<?= $user['is_hidden'] ? 'eye' : 'eye-off' ?>" class="w-3.5 h-3.5"></i>
                                    <span><?= $user['is_hidden'] ? 'Unhide' : 'Hide' ?></span>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- Footer count -->
            <div class="px-5 py-3 border-t border-white/5 flex items-center justify-between">
                <span class="text-xs text-slate-600">Showing <span class="text-slate-400 font-semibold"><?= $totalUsers ?></span> users</span>
                <div class="flex items-center gap-1 text-[10px] text-slate-600">
                    <i data-lucide="zap" class="w-3 h-3 text-purple-500"></i>
                    HRM Tools v1.0
                </div>
            </div>
            <?php endif; ?>
        </div>

    </div><!-- /container -->

    <script>
        lucide.createIcons();

        // ---- Live search (client-side filter on typed input) ----
        const searchInput = document.getElementById('search-input');
        searchInput.addEventListener('input', function() {
            const q = this.value.toLowerCase();
            const rows = document.querySelectorAll('#users-tbody tr');
            rows.forEach(row => {
                const empId = row.querySelector('td:nth-child(2)')?.textContent.toLowerCase() || '';
                const name  = row.querySelector('td:nth-child(3)')?.textContent.toLowerCase() || '';
                row.style.display = (empId.includes(q) || name.includes(q)) ? '' : 'none';
            });
        });

        // ---- Server search on Enter ----
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                const url = new URL(window.location.href);
                url.searchParams.set('search', this.value);
                window.location.href = url.toString();
            }
        });

        // ---- Toast helper ----
        function showToast(msg, type = 'success') {
            const toast   = document.getElementById('toast');
            const toastMsg  = document.getElementById('toast-msg');
            const toastIcon = document.getElementById('toast-icon');

            toastMsg.textContent = msg;
            toast.className = `toast toast-${type} show`;
            toastIcon.setAttribute('data-lucide', type === 'success' ? 'check-circle' : 'x-circle');
            lucide.createIcons();

            clearTimeout(toast._timer);
            toast._timer = setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }

        // ---- Toggle hide / unhide ----
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.action-btn');
            if (!btn) return;

            const employeeId = btn.dataset.employeeId;
            const isHidden   = btn.dataset.hidden === '1';
            const action     = isHidden ? 'unhide' : 'hide';

            // Disable while processing
            btn.disabled = true;
            btn.style.opacity = '0.5';

            const formData = new FormData();
            formData.append('action', action);
            formData.append('employee_id', employeeId);

            fetch('index.php', { method: 'POST', body: formData })
                .then(r => r.json())
                .then(data => {
                    if (!data.success) {
                        showToast(data.message || 'Something went wrong', 'error');
                        btn.disabled = false;
                        btn.style.opacity = '1';
                        return;
                    }

                    const nowHidden = data.hidden;
                    const row       = document.getElementById('row-' + employeeId);

                    // Update button
                    btn.dataset.hidden = nowHidden ? '1' : '0';
                    btn.className      = 'action-btn ' + (nowHidden ? 'btn-unhide' : 'btn-hide') + ' px-4 py-1.5 rounded-lg text-xs font-bold flex items-center gap-1.5 ml-auto transition-all active:scale-95';
                    btn.innerHTML      = `<i data-lucide="${nowHidden ? 'eye' : 'eye-off'}" class="w-3.5 h-3.5"></i><span>${nowHidden ? 'Unhide' : 'Hide'}</span>`;
                    lucide.createIcons();

                    // Update status cell
                    const statusCell = row.querySelector('.status-cell');
                    statusCell.dataset.hidden = nowHidden ? '1' : '0';
                    statusCell.innerHTML = nowHidden
                        ? `<span class="w-1.5 h-1.5 rounded-full bg-red-400 animate-pulse"></span><span class="text-[10px] font-bold uppercase tracking-wider text-red-400">Hidden</span>`
                        : `<span class="w-1.5 h-1.5 rounded-full bg-green-400"></span><span class="text-[10px] font-bold uppercase tracking-wider text-green-400">Visible</span>`;

                    // Row bg
                    if (nowHidden) row.classList.add('row-hidden-bg');
                    else           row.classList.remove('row-hidden-bg');

                    // Update stat counters live
                    updateStatCards();

                    showToast(
                        nowHidden
                            ? `${employeeId} is now hidden`
                            : `${employeeId} is now visible`,
                        'success'
                    );

                    btn.disabled = false;
                    btn.style.opacity = '1';
                })
                .catch(() => {
                    showToast('Network error. Please try again.', 'error');
                    btn.disabled = false;
                    btn.style.opacity = '1';
                });
        });

        function updateStatCards() {
            const rows        = document.querySelectorAll('#users-tbody tr');
            let hidden = 0, visible = 0;
            rows.forEach(row => {
                const cell = row.querySelector('.status-cell');
                if (!cell) return;
                if (cell.dataset.hidden === '1') hidden++;
                else visible++;
            });
            const cards = document.querySelectorAll('.text-2xl.font-bold');
            if (cards[0]) cards[0].textContent = hidden + visible;
            if (cards[1]) cards[1].textContent = visible;
            if (cards[2]) cards[2].textContent = hidden;
        }
    </script>
</body>
</html>

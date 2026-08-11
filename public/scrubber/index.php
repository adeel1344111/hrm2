<?php

// Force No-Cache
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

/**
 * Premium Lead Scrubber Pro v2.5
 * Part of HRM Custom Tools
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
set_time_limit(600);
ini_set('memory_limit', '1024M');
ini_set('post_max_size', '64M');
ini_set('upload_max_filesize', '64M');

$debugFile = '/tmp/scrubber_debug.log';

// Load HRM Autoloader for PhpSpreadsheet
$autoload = __DIR__ . '/../../vendor/autoload.php';
if (!file_exists($autoload)) {
    die("System error: Dependencies missing.");
}
require_once $autoload;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

// --- Helper Functions ---

/**
 * Load Database Connection
 */
function getDbConnection() {
    $envPath = __DIR__ . '/../../.env';
    if (!file_exists($envPath)) die("System error: Env missing.");
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $config = [];
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($name, $value) = explode('=', $line, 2) + [NULL, NULL];
        if ($name !== NULL) $config[$name] = trim($value, '"\' ');
    }
    try {
        $pdo = new PDO("mysql:host={$config['DB_HOST']};dbname={$config['DB_DATABASE']};charset=utf8mb4", $config['DB_USERNAME'], $config['DB_PASSWORD']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) { die("DB Error."); }
}

/**
 * Normalize phone number
 */
function normalizePhone($phone) {
    return preg_replace('/[^0-9]/', '', (string)$phone);
}

// --- Fetch Unique Campaigns ---
$pdo = getDbConnection();
try {
    $campaignStmt = $pdo->query("SELECT DISTINCT campaign FROM verification_submissions UNION SELECT DISTINCT campaign FROM csr_submissions ORDER BY campaign ASC");
    $campaigns = $campaignStmt->fetchAll(PDO::FETCH_COLUMN);
} catch (Exception $e) {
    $campaigns = [];
}

// --- Processing Logic ---

$results = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedCampaign = $_POST['campaign'] ?? '';
    
    if (isset($_FILES['lead_file'])) {
        try {
            $file = $_FILES['lead_file'];
            if ($file['error'] !== UPLOAD_ERR_OK) throw new Exception("Upload error.");

            $inputPath = $file['tmp_name'];
            $spreadsheet = IOFactory::load($inputPath);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            if (empty($rows)) throw new Exception("File is empty.");

            $allNumbers = [];
            $leads = [];
            $header = array_shift($rows); 

            foreach ($rows as $index => $row) {
                $rawPhone = $row[0] ?? '';
                if (empty($rawPhone)) continue;
                $normalized = normalizePhone($rawPhone);
                if (empty($normalized)) continue;
                $allNumbers[$normalized] = true;
                $row['__normalized__'] = $normalized;
                $leads[] = $row;
            }

            if (empty($allNumbers)) throw new Exception("No valid numbers in Col A.");

            $foundNumbers = [];
            $uniqueNormalized = array_keys($allNumbers);
            $chunks = array_chunk($uniqueNormalized, 1000);

            $campFilter = !empty($selectedCampaign) ? " AND campaign = ?" : "";
            $queryParams = !empty($selectedCampaign) ? [$selectedCampaign] : [];

            foreach ($chunks as $chunk) {
                $placeholders = str_repeat('?,', count($chunk) - 1) . '?';
                
                // Verification Table
                $stmt = $pdo->prepare("SELECT phone FROM verification_submissions WHERE phone IN ($placeholders) $campFilter");
                $executeParams = array_merge($chunk, $queryParams);
                $stmt->execute($executeParams);
                while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) $foundNumbers[normalizePhone($r['phone'])] = true;

                // CSR Table
                $stmt = $pdo->prepare("SELECT phone FROM csr_submissions WHERE phone IN ($placeholders) $campFilter");
                $stmt->execute($executeParams);
                while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) $foundNumbers[normalizePhone($r['phone'])] = true;
            }

            $cleanedRows = [$header];
            $totalFound = 0;
            foreach ($leads as $lead) {
                $norm = $lead['__normalized__'];
                if (isset($foundNumbers[$norm])) {
                    $totalFound++;
                    continue;
                }
                unset($lead['__normalized__']);
                $cleanedRows[] = $lead;
            }

            $filename = 'cleaned_leads_' . date('His') . '.csv';
            $outputPath = __DIR__ . '/../storage/scrubbed/' . $filename;
            if (!is_dir(dirname($outputPath))) mkdir(dirname($outputPath), 0777, true);
            $handle = fopen($outputPath, 'w');
            foreach ($cleanedRows as $row) fputcsv($handle, $row);
            fclose($handle);

            $results = [
                'total_processed' => count($leads),
                'found' => $totalFound,
                'unique_found' => count($foundNumbers),
                'remaining' => count($cleanedRows) - 1,
                'download_url' => '/storage/scrubbed/' . $filename,
                'campaign' => !empty($selectedCampaign) ? $selectedCampaign : 'All Campaigns',
                'sample_phones' => array_slice(array_keys($allNumbers), 0, 5)
            ];

        } catch (Exception $e) { $error = $e->getMessage(); }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lead Scrubber Pro | Campaign Specific Scrubbing</title>
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
            overflow-y: auto;
        }
        .glass { background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.1); }
        .bg-gradient-premium { background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 50%, #d946ef 100%); }
    </style>
</head>
<body class="selection:bg-blue-500/30">
    
    <!-- Fixed Background Shadows -->
    <div class="fixed inset-0 pointer-events-none -z-10">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-blue-600/10 blur-[120px] rounded-full"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[30%] h-[30%] bg-purple-600/10 blur-[120px] rounded-full"></div>
    </div>

    <!-- Scrollable Container -->
    <div class="relative z-10 w-full max-w-2xl mx-auto px-4 py-6">
        
        <!-- Compact Header -->
        <div class="flex items-center gap-4 mb-6">
            <div class="p-2 bg-gradient-premium rounded-xl shadow-lg">
                <i data-lucide="shield-check" class="w-6 h-6 text-white"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Lead Scrubber <span class="text-blue-400">Pro</span></h1>
                <p class="text-[10px] text-slate-500 uppercase font-bold tracking-widest leading-none mt-1">Campaign Processing Suite</p>
            </div>
        </div>

        <div class="w-full">
            <?php if ($error): ?>
                <div class="glass border-red-500/50 p-3 rounded-xl mb-4 flex items-start gap-4">
                    <i data-lucide="alert-circle" class="w-4 h-4 text-red-500 shrink-0 mt-0.5"></i>
                    <div class="text-red-200 text-xs"><?php echo htmlspecialchars($error); ?></div>
                </div>
            <?php endif; ?>

            <?php if ($results): ?>
                <div class="glass p-6 rounded-3xl mb-10 shadow-2xl space-y-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold">Results for: <span class="text-blue-400"><?php echo htmlspecialchars($results['campaign']); ?></span></h2>
                        <span class="px-2 py-0.5 bg-green-500/20 text-green-400 text-[10px] font-bold rounded-full border border-green-500/30 uppercase">SUCCESS</span>
                    </div>

                    <div class="grid grid-cols-3 gap-3">
                        <div class="bg-slate-800/50 p-3 rounded-xl text-center border border-slate-700/50">
                            <div class="text-slate-500 text-[8px] font-bold uppercase mb-1">Total</div>
                            <div class="text-lg font-bold text-white"><?php echo number_format($results['total_processed']); ?></div>
                        </div>
                        <div class="bg-indigo-900/30 p-3 rounded-xl text-center border border-indigo-500/20">
                            <div class="text-indigo-400 text-[8px] font-bold uppercase mb-1">Matches</div>
                            <div class="text-lg font-bold text-white"><?php echo number_format($results['found']); ?></div>
                        </div>
                        <div class="bg-purple-900/30 p-3 rounded-xl text-center border border-purple-500/20">
                            <div class="text-purple-400 text-[8px] font-bold uppercase mb-1">Clean</div>
                            <div class="text-lg font-bold text-white"><?php echo number_format($results['remaining']); ?></div>
                        </div>
                    </div>

                    <!-- Audit Samples -->
                    <div class="bg-slate-900/50 p-3 rounded-xl border border-slate-700/50">
                        <p class="text-[9px] text-slate-500 uppercase font-bold tracking-widest mb-1.5 flex items-center gap-1">
                            <i data-lucide="eye" class="w-3 h-3 text-blue-400"></i> Sample Numbers Detected:
                        </p>
                        <div class="flex flex-wrap gap-1.5">
                            <?php foreach($results['sample_phones'] as $sample): ?>
                                <span class="px-1.5 py-0.5 bg-slate-800 rounded text-[9px] text-slate-300 font-mono"><?php echo htmlspecialchars($sample); ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="pt-2 flex gap-3">
                        <a href="<?php echo htmlspecialchars($results['download_url']); ?>" download 
                           class="flex-1 h-12 bg-gradient-premium hover:shadow-[0_0_15px_rgba(139,92,246,0.4)] transition-all rounded-xl flex items-center justify-center gap-2 text-sm font-bold">
                            <i data-lucide="download" class="w-4 h-4"></i>
                            Download Cleaned CSV
                        </a>
                        <a href="index.php" class="px-6 h-12 bg-slate-800 hover:bg-slate-700 rounded-xl flex items-center justify-center text-xs font-semibold transition-all">
                             Reset
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <form action="" method="POST" enctype="multipart/form-data" id="scrub-form" class="space-y-4">
                    
                    <div class="glass p-6 rounded-[2rem] shadow-2xl border-white/5">
                        <!-- Campaign Section -->
                        <div class="mb-6">
                            <div class="flex items-center gap-2 mb-2 px-1">
                                <i data-lucide="crosshair" class="w-3 h-3 text-blue-400"></i>
                                <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Target Campaign</label>
                            </div>
                            <select name="campaign" class="w-full bg-slate-800/80 border border-slate-700 text-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 transition-all appearance-none cursor-pointer">
                                <option value="">Scrub Against All Campaigns (Comprehensive)</option>
                                <?php foreach ($campaigns as $camp): ?>
                                    <option value="<?php echo htmlspecialchars($camp); ?>">Clean Only: <?php echo htmlspecialchars($camp); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Upload Zone -->
                        <div id="drop-zone" class="border-2 border-dashed border-slate-700 rounded-2xl p-6 transition-all duration-300 flex flex-col items-center cursor-pointer hover:border-blue-500/40 hover:bg-blue-500/5 group">
                            <input type="file" name="lead_file" id="lead_file" class="hidden" accept=".csv,.xlsx">
                            
                            <div class="w-12 h-12 bg-slate-800 rounded-xl flex items-center justify-center mb-3 shadow-inner group-hover:scale-110 transition-transform duration-500">
                                <i data-lucide="cloud-upload" class="w-6 h-6 text-blue-400 group-hover:text-blue-200"></i>
                            </div>
                            
                            <p id="file-label" class="text-sm font-semibold mb-1 group-hover:text-blue-300 transition-colors text-center">Click or drop file</p>
                            <p class="text-slate-500 text-[10px] mb-3 uppercase tracking-tighter">Col A (Phone Numbers)</p>
                            
                            <span class="px-4 py-1.5 bg-slate-800 text-slate-400 text-[10px] font-bold rounded-lg border border-slate-700 group-hover:bg-blue-600 group-hover:text-white transition-all">
                                Select CSV/XLSX
                            </span>
                        </div>

                        <div class="mt-6">
                            <button type="submit" id="submit-btn" class="hidden w-full py-4 bg-gradient-premium hover:shadow-[0_0_20px_rgba(59,130,246,0.3)] rounded-xl text-md font-bold transition-all transform active:scale-95 shadow-xl">
                                Start Cleaning Engine
                            </button>
                        </div>
                    </div>
                </form>
            <?php endif; ?>
        </div>

        <!-- Compact Footer -->
        <div class="mt-8 pt-6 w-full flex items-center justify-between border-t border-slate-800/30">
            <div class="flex items-center gap-2 text-slate-500">
                <i data-lucide="zap" class="w-3 h-3 text-blue-400 animate-pulse"></i>
                <span class="text-[9px] font-bold tracking-widest uppercase opacity-60">Lead Management Suite</span>
            </div>
            <div class="text-[8px] text-slate-600 font-medium tracking-widest uppercase">v2.5 PRO • Updated 4:33 PM</div>
        </div>
    </div>

    <script>
        lucide.createIcons();

        const dropZone = document.getElementById('drop-zone');
        const fileInput = document.getElementById('lead_file');
        const submitBtn = document.getElementById('submit-btn');
        const fileLabel = document.getElementById('file-label');

        ['dragover', 'dragleave', 'drop'].forEach(ev => {
            dropZone.addEventListener(ev, e => {
                e.preventDefault();
                e.stopPropagation();
            });
        });

        dropZone.addEventListener('dragover', () => dropZone.classList.add('border-blue-500/50', 'bg-blue-500/5'));
        ['dragleave', 'drop'].forEach(ev => dropZone.addEventListener(ev, () => dropZone.classList.remove('border-blue-500/50', 'bg-blue-500/5')));

        dropZone.addEventListener('drop', e => {
            if (e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;
                handleFile();
            }
        });

        dropZone.addEventListener('click', () => fileInput.click());
        fileInput.addEventListener('change', handleFile);

        function handleFile() {
            if (fileInput.files.length > 0) {
                fileLabel.textContent = fileInput.files[0].name;
                fileLabel.classList.add('text-blue-400');
                submitBtn.classList.remove('hidden');
                
                // Scroll to button
                setTimeout(() => {
                    submitBtn.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }, 100);
            }
        }
    </script>
</body>
</html>

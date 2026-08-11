<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $companyDisplay }} — Frontor Form</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ URL::to('assets/images/favicon_new.png') }}">
    <style>
        body {
            margin: 0;
            padding: 25px;
            background: #0f172a;
            background-image: radial-gradient(circle, #ffffff08 1px, transparent 1px);
            background-size: 10px 10px;
            font-family: system-ui, sans-serif;
            color: #e2e8f0;
        }
        .form-container {
            max-width: 800px;
            margin: 0 auto;
            background: #1e293b;
            padding: 20px;
            border-radius: 12px;
            border: 1px solid #334155;
        }
        .form-header {
            text-align: center;
            margin: -20px -20px 20px;
            padding: 20px;
            background: #0f172a;
            border-radius: 12px 12px 0 0;
            border-bottom: 1px solid #334155;
        }
        .form-header h2 { margin: 0; color: #fff; }
        .form-header p { margin: 8px 0 0; color: #94a3b8; font-size: 0.9rem; }
        .row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        @media (max-width: 640px) { .row { grid-template-columns: 1fr; } }
        label { display: block; margin-bottom: 0.35rem; font-size: 0.875rem; font-weight: 600; color: #cbd5e1; }
        input, select, textarea {
            width: 100%;
            box-sizing: border-box;
            padding: 0.65rem 0.75rem;
            border-radius: 8px;
            border: 1px solid #475569;
            background: #0f172a;
            color: #f1f5f9;
            font: inherit;
        }
        .full { grid-column: 1 / -1; }
        .btn {
            display: inline-block;
            margin-top: 1rem;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            background: #3b82f6;
            color: #fff;
            font-weight: 600;
            cursor: pointer;
            font-size: 1rem;
        }
        .btn:disabled { opacity: 0.6; cursor: not-allowed; }
        #msg { margin-top: 1rem; padding: 0.75rem; border-radius: 8px; display: none; }
        #msg.ok { display: block; background: rgba(34,197,94,.15); color: #4ade80; border: 1px solid rgba(34,197,94,.3); }
        #msg.err { display: block; background: rgba(239,68,68,.15); color: #f87171; border: 1px solid rgba(239,68,68,.3); }
    </style>
</head>
<body>
<div class="form-container">
    <div class="form-header">
        <h2 id="companyTitle">{{ $companyDisplay }}</h2>
        <p>Frontor Submission Form</p>
    </div>
    <form id="outsourceForm">
        <input type="hidden" name="company" id="company" value="{{ strtoupper($company) }}">
        <div class="row">
            <div>
                <label>Dialer ID *</label>
                <input name="dialer_id" id="dialer_id" required maxlength="10" inputmode="numeric" pattern="[0-9]+" placeholder="e.g. 8040">
            </div>
            <div>
                <label>Name *</label>
                <input name="name" id="name" required maxlength="255" placeholder="Agent name">
            </div>
            <div>
                <label>Campaign *</label>
                <select name="campaign" id="campaign" required>
                    <option value="">— Select —</option>
                    <option value="Final Expense">Final Expense</option>
                    <option value="Medicare">Medicare</option>
                </select>
            </div>
            <div>
                <label>Phone *</label>
                <input name="phone" id="phone" required maxlength="15" inputmode="numeric" placeholder="10-digit phone">
            </div>
            <div>
                <label>State *</label>
                <input name="state" id="state" required maxlength="100" placeholder="e.g. TX">
            </div>
            <div>
                <label>ZIP</label>
                <input name="zip" id="zip" maxlength="10" inputmode="numeric" placeholder="5 digits">
            </div>
            <div>
                <label>Age</label>
                <input name="age" id="age" type="number" min="1" max="120" placeholder="Age">
            </div>
            <div class="full">
                <label>Comment</label>
                <textarea name="comment" id="comment" rows="3" placeholder="Optional"></textarea>
            </div>
        </div>
        <button type="submit" class="btn" id="submitBtn">Submit</button>
        <div id="msg"></div>
    </form>
</div>
<script>
(function () {
    const form = document.getElementById('outsourceForm');
    const msg = document.getElementById('msg');
    const btn = document.getElementById('submitBtn');
    const csrf = document.querySelector('meta[name="csrf-token"]').content;
    // Same Google Apps Script web app as legacy HRM outsource form
    const GOOGLE_SHEETS_OUTSOURCE_URL = 'https://script.google.com/macros/s/AKfycbxdHBFYK6Zgn0sbI4h3MVp3aLO-8m_v8f4cMEV_aw79FcColC2vnABByaE3x0fNx6s2hQ/exec';

    function sendToGoogleSheets(fd) {
        try {
            if (navigator.sendBeacon) {
                const params = new URLSearchParams();
                for (const [k, v] of fd.entries()) params.append(k, v);
                const blob = new Blob([params.toString()], { type: 'application/x-www-form-urlencoded' });
                navigator.sendBeacon(GOOGLE_SHEETS_OUTSOURCE_URL, blob);
            } else {
                fetch(GOOGLE_SHEETS_OUTSOURCE_URL, {
                    method: 'POST',
                    body: fd,
                    mode: 'no-cors',
                    keepalive: true,
                }).catch(function () {});
            }
        } catch (e) {
            console.error('Google Sheets error:', e);
        }
    }

    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        msg.className = '';
        msg.style.display = 'none';
        btn.disabled = true;
        btn.textContent = 'Submitting...';

        const fd = new FormData(form);
        try {
            const res = await fetch(@json(route('outsource.submit')), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'text/plain',
                },
                body: fd,
            });
            const text = await res.text();
            const ok = res.ok && /success/i.test(text);
            msg.textContent = text;
            msg.className = ok ? 'ok' : 'err';
            if (ok) {
                sendToGoogleSheets(fd);
                form.reset();
                // keep company hidden after reset
                document.getElementById('company').value = @json(strtoupper($company));
            }
        } catch (err) {
            msg.textContent = 'Network error. Please try again.';
            msg.className = 'err';
        } finally {
            btn.disabled = false;
            btn.textContent = 'Submit';
        }
    });
})();
</script>
</body>
</html>

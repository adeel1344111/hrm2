/**
 * Google Sheets Integration for Submissions
 * Sends submission data to Google Sheets after successful database save
 */

// Google Sheets Web App URLs
const GOOGLE_SHEETS_CSR_URL = 'https://script.google.com/macros/s/AKfycbx-Ok-vwPzt1YUnSPULpO2ever5pl5VODd4q8zywmF2rqATaIIWVlGq_bKkUH_RE0OXKg/exec';
const GOOGLE_SHEETS_VERIFIER_URL = 'https://script.google.com/macros/s/AKfycbzTCFQCjiiDEUAzr8WVOJCx-_4_d92kKDkhua8pdVIZSTUnPfFTj0ZAtGHxBNqbDU0R/exec';

let isSubmitting = false;

document.addEventListener('DOMContentLoaded', function () {
    const submissionForm = document.querySelector('form[action*="submissions"]');

    if (!submissionForm) return;

    // Determine if this is CSR or Verifier form based on fields
    const isCsrForm = submissionForm.querySelector('#state') !== null;
    const isVerifierForm = submissionForm.querySelector('#jornaya_id') !== null;

    const googleSheetsUrl = isCsrForm ? GOOGLE_SHEETS_CSR_URL :
        isVerifierForm ? GOOGLE_SHEETS_VERIFIER_URL : null;

    if (!googleSheetsUrl) return;

    submissionForm.addEventListener('submit', function (e) {
        if (isSubmitting) {
            e.preventDefault();
            return;
        }

        // Don't prevent default - let Laravel handle the submission
        // Just send to Google Sheets in parallel
        isSubmitting = true;

        const submitButton = submissionForm.querySelector('button[type="submit"]');
        if (submitButton) {
            submitButton.disabled = true;
            const originalHtml = submitButton.innerHTML;
            submitButton.innerHTML = '<i data-lucide="loader" class="inline-block w-4 h-4 mr-2 animate-spin"></i> Submitting...';
        }

        // Collect form data
        const formData = new FormData(submissionForm);
        const submissionData = {};

        formData.forEach((value, key) => {
            if (key !== '_token' && key !== '_method') {
                submissionData[key] = value;
            }
        });

        // Send to Google Sheets (fire and forget - don't wait for response)
        const urlEncodedData = new URLSearchParams(submissionData).toString();

        // Use sendBeacon for reliable delivery even if page navigates
        if (navigator.sendBeacon) {
            // sendBeacon doesn't support custom headers, so we use a Blob
            const blob = new Blob([urlEncodedData], { type: 'application/x-www-form-urlencoded' });
            navigator.sendBeacon(googleSheetsUrl, blob);
        } else {
            // Fallback to fetch with no-cors mode
            fetch(googleSheetsUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: urlEncodedData,
                mode: 'no-cors', // Google Apps Script requires this
                keepalive: true // Keep request alive even if page navigates
            }).catch(err => {
                console.error('Google Sheets error:', err);
            });
        }

        // Let the form submit normally to Laravel
        // The disabled button and isSubmitting flag will prevent double submission
    });
});

function showNotification(message, type = 'info') {
    // Use existing notification system if available
    if (typeof Toastify !== 'undefined') {
        Toastify({
            text: message,
            duration: 3000,
            gravity: "top",
            position: "right",
            backgroundColor: type === 'error' ? '#ef4444' : type === 'warning' ? '#f59e0b' : '#10b981',
        }).showToast();
    } else {
        console.log(message);
    }
}

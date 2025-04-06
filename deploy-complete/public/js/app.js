// Custom JavaScript for OFYS
document.addEventListener('DOMContentLoaded', function() {
    console.log('OFYS app loaded successfully');

    // Set CSRF token for all AJAX requests
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (token) {
        // Set for jQuery AJAX if jQuery is present
        if (typeof jQuery !== 'undefined') {
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': token
                }
            });
        }

        // Set for fetch API
        window.csrfToken = token;
    }

    // Handle form submissions
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            // Regular submission will still work if JavaScript is disabled
            // Don't interfere with file uploads
            if (form.getAttribute('enctype') === 'multipart/form-data') {
                return;
            }

            // For auth forms, add special handling
            if (form.classList.contains('auth-form') ||
                form.id === 'login-form' ||
                form.id === 'register-form' ||
                form.action.includes('login') ||
                form.action.includes('register')) {

                // Special handling for auth forms
                console.log('Auth form detected:', form.action);
            }
        });
    });

    // Handle navigation links to prevent page reloads when appropriate
    document.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', function(e) {
            // Leave external links and download links alone
            if (link.getAttribute('target') === '_blank' ||
                link.getAttribute('download') ||
                link.getAttribute('href').startsWith('http') ||
                link.getAttribute('href').startsWith('//')) {
                return;
            }

            // Handle local navigation the default way
            // We're not implementing a SPA here
        });
    });

    // Initialize any custom JavaScript functionality here
});

// Helper functions
function handleErrors(response) {
    if (!response.ok) {
        throw Error(response.statusText);
    }
    return response;
}

// Add any other custom JavaScript your app needs

// Redirect to real JS file
(function() {
    const script = document.createElement('script');
    script.src = '/build/assets/app-BPKtxCGZ.js';
    document.head.appendChild(script);
})();

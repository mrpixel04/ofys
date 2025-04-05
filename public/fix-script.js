/**
 * Fix script for Alpine.js and Livewire duplication issues
 *
 * Add this to your page to prevent "Cannot redefine property: $persist" errors
 */

// Prevent multiple initialization
(function() {
    console.log('🛠️ Applying Alpine/Livewire fix...');

    // Check if the fix has already been applied
    if (window._fixApplied) {
        console.log('⚠️ Fix already applied, skipping');
        return;
    }

    // Track that we've applied the fix
    window._fixApplied = true;

    // Track initialization state
    window._alpineInitialized = false;
    window._livewireInitialized = false;

    // Save original Alpine
    const originalAlpineStart = window.Alpine && window.Alpine.start;
    const originalLivewireStart = window.Livewire && window.Livewire.start;

    // Patch Alpine.start to only run once
    if (window.Alpine && window.Alpine.start) {
        console.log('📌 Patching Alpine.start...');
        window.Alpine.start = function() {
            if (!window._alpineInitialized) {
                console.log('🚀 Starting Alpine safely (first time)');
                window._alpineInitialized = true;
                return originalAlpineStart.apply(this, arguments);
            } else {
                console.log('⚠️ Prevented duplicate Alpine initialization');
                return undefined;
            }
        };
    }

    // Patch Livewire.start to only run once
    if (window.Livewire && window.Livewire.start) {
        console.log('📌 Patching Livewire.start...');
        window.Livewire.start = function() {
            if (!window._livewireInitialized) {
                console.log('🚀 Starting Livewire safely (first time)');
                window._livewireInitialized = true;
                return originalLivewireStart.apply(this, arguments);
            } else {
                console.log('⚠️ Prevented duplicate Livewire initialization');
                return undefined;
            }
        };
    }

    // Monitor for future script injections
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.addedNodes) {
                mutation.addedNodes.forEach(function(node) {
                    if (node.tagName === 'SCRIPT' &&
                        (node.src.includes('alpine') || node.src.includes('livewire'))) {
                        console.log('⚠️ Detected new script load:', node.src);
                    }
                });
            }
        });
    });

    observer.observe(document.documentElement, {
        childList: true,
        subtree: true
    });

    console.log('✅ Alpine/Livewire fix applied successfully');
})();
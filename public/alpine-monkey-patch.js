/**
 * Alpine.js and Livewire Monkey Patch
 *
 * This script modifies Alpine.js and Livewire to prevent multiple initializations
 * and the "Cannot redefine property: $persist" error.
 *
 * Add this script to your page BEFORE any Alpine.js or Livewire scripts.
 */

(function() {
    console.log('🔧 Applying Alpine.js and Livewire monkey patch');

    // Create global flags if they don't exist
    window._alpineInitialized = false;
    window._livewireInitialized = false;
    window._persistRegistered = false;

    // Store the original Object.defineProperty
    const originalDefineProperty = Object.defineProperty;

    // Override Object.defineProperty to prevent $persist redefinition
    Object.defineProperty = function(obj, prop, descriptor) {
        // Catch attempts to define $persist multiple times
        if (prop === '$persist') {
            if (window._persistRegistered) {
                console.log('🛑 Prevented redefinition of $persist');
                return obj;
            }
            window._persistRegistered = true;
            console.log('✅ Registered $persist (first time)');
        }

        // Call the original method
        return originalDefineProperty.call(this, obj, prop, descriptor);
    };

    // Monitor for Alpine availability and patch it
    const checkAndPatchAlpine = function() {
        // Patch Alpine when it becomes available
        if (window.Alpine && !window._alpinePatched) {
            window._alpinePatched = true;

            // Store the original Alpine.start method
            const originalStart = window.Alpine.start;

            // Override Alpine.start to run only once
            window.Alpine.start = function() {
                if (!window._alpineInitialized) {
                    console.log('✅ Starting Alpine.js (first time)');
                    window._alpineInitialized = true;
                    return originalStart.apply(this, arguments);
                } else {
                    console.log('🛑 Prevented duplicate Alpine initialization');
                    return undefined;
                }
            };

            // Store the original plugin method
            const originalPlugin = window.Alpine.plugin;

            // Override plugin method to prevent double registration
            window.Alpine.plugin = function(plugin) {
                if (plugin.name === 'persist' && window._persistRegistered) {
                    console.log('🛑 Prevented duplicate persist plugin registration');
                    return;
                }
                return originalPlugin.apply(this, arguments);
            };

            console.log('✅ Alpine.js patched successfully');
        }
    };

    // Monitor for Livewire availability and patch it
    const checkAndPatchLivewire = function() {
        // Patch Livewire when it becomes available
        if (window.Livewire && !window._livewirePatched) {
            window._livewirePatched = true;

            // Store the original Livewire.start method
            const originalStart = window.Livewire.start;

            // Override Livewire.start to run only once
            window.Livewire.start = function() {
                if (!window._livewireInitialized) {
                    console.log('✅ Starting Livewire (first time)');
                    window._livewireInitialized = true;
                    return originalStart.apply(this, arguments);
                } else {
                    console.log('🛑 Prevented duplicate Livewire initialization');
                    return undefined;
                }
            };

            console.log('✅ Livewire patched successfully');
        }
    };

    // Check for Alpine and Livewire periodically
    const interval = setInterval(function() {
        checkAndPatchAlpine();
        checkAndPatchLivewire();

        // Stop checking once both are patched
        if (window._alpinePatched && window._livewirePatched) {
            clearInterval(interval);
        }
    }, 50);

    // Also check on DOMContentLoaded
    document.addEventListener('DOMContentLoaded', function() {
        checkAndPatchAlpine();
        checkAndPatchLivewire();
    });

    console.log('✅ Monkey patch installed');
})();
<script>
    // AlpineFix Component
    // Add this component to your layout before any other scripts

    // Protect Alpine.js from being initialized more than once
    window._alpineInitialized = false;
    window._livewireInitialized = false;

    // Store original methods
    const originalDefineProperty = Object.defineProperty;
    window._persistDefined = false;

    // Patch Object.defineProperty to prevent $persist property redefinition
    Object.defineProperty = function(obj, prop, descriptor) {
        // Catch and prevent $persist redefinition
        if (prop === '$persist') {
            if (window._persistDefined) {
                console.log('Protected: Prevented $persist redefinition');
                return obj;
            }
            window._persistDefined = true;
        }

        // Call original method for all other properties
        return originalDefineProperty.call(this, obj, prop, descriptor);
    };

    // Function to safely initialize Alpine
    window.initializeAlpineSafely = function() {
        if (window.Alpine && !window._alpineInitialized) {
            window._alpineInitialized = true;
            console.log('AlpineFix: First Alpine initialization');

            // Save original Alpine.start
            const originalStart = window.Alpine.start;

            // Override Alpine.start to run only once
            window.Alpine.start = function() {
                console.log('AlpineFix: Starting Alpine safely');
                return originalStart.apply(this, arguments);
            };
        } else if (window.Alpine && window._alpineInitialized) {
            console.log('AlpineFix: Preventing duplicate Alpine initialization');
            window.Alpine.start = function() {
                console.log('AlpineFix: Alpine start prevented (already initialized)');
                return undefined;
            };
        }
    };

    // Apply safe initialization when the DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        window.initializeAlpineSafely();
    });

    console.log('AlpineFix component loaded');
</script>
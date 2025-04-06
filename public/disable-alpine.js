// Disable Alpine.js globally
(function() {
    console.log('Alpine.js disabler script executing');

    // Define a mock Alpine object that does nothing
    window.Alpine = {
        version: 'disabled',
        start: function() {
            console.log('Alpine initialization prevented (global)');
            return this;
        },
        plugin: function() {
            console.log('Alpine plugin loading prevented (global)');
            return this;
        },
        directive: function() {
            console.log('Alpine directive loading prevented (global)');
            return this;
        },
        data: function() {
            console.log('Alpine data function prevented (global)');
            return function() {};
        },
        store: function() {
            console.log('Alpine store prevented (global)');
            return {};
        },
        magic: function() {
            console.log('Alpine magic prevented (global)');
            return this;
        },
        findClosest: function() {
            console.log('Alpine findClosest prevented (global)');
            return null;
        }
    };

    // Prevent Alpine object from being redefined
    Object.defineProperty(window, 'Alpine', {
        configurable: false,
        writable: false,
        value: window.Alpine
    });

    console.log('Alpine.js has been disabled');
})();

// Bootstrap
import './bootstrap';

// Make sure Alpine is disabled first
window.Alpine = {
    // Empty placeholder to prevent Livewire from initializing Alpine
    version: 'disabled',
    start: function() {
        console.log('Alpine initialization prevented (app.js)');
        return this;
    },
    plugin: function() {
        console.log('Alpine plugin loading prevented (app.js)');
        return this;
    },
    directive: function() {
        console.log('Alpine directive prevented (app.js)');
        return this;
    },
    store: function() {
        console.log('Alpine store prevented (app.js)');
        return this;
    },
    data: function() {
        console.log('Alpine data prevented (app.js)');
        return function() {};
    },
    // Prevent findClosest
    findClosest: function() {
        console.log('Alpine findClosest prevented (app.js)');
        return null;
    }
};

// Initialize Livewire from Laravel with Alpine disabled
import { Livewire } from '../../vendor/livewire/livewire/dist/livewire.esm';

// Make Livewire available globally
window.Livewire = Livewire;

// Disable Alpine integration in Livewire
if (Livewire.hook) {
    Livewire.hook('request', ({ options }) => {
        if (options.updateQueue) {
            options.updateQueue = options.updateQueue.filter(update => {
                // Filter out any Alpine-related updates
                if (update.type && update.type.includes('alpine')) {
                    console.log('Filtered out Alpine update:', update);
                    return false;
                }
                return true;
            });
        }
    });

    // Hook to prevent Alpine initialization
    Livewire.hook('element.initialized', (el) => {
        // Make sure Alpine is disabled
        window.Alpine = window.Alpine || {
            version: 'disabled',
            start: function() { return this; },
            plugin: function() { return this; }
        };
    });
}

// Start Livewire
console.log('Starting Livewire without Alpine');
Livewire.start();

// Ensure jQuery is defined globally
if (typeof jQuery === 'undefined') {
    console.error('jQuery is not loaded! Attempting to use vanilla JS instead.');
    // Define a simple jQuery-like $ function if jQuery is not available
    window.$ = function(selector) {
        const elements = document.querySelectorAll(selector);
        return {
            each: function(callback) {
                elements.forEach(callback);
                return this;
            },
            on: function(event, callback) {
                elements.forEach(el => el.addEventListener(event, callback));
                return this;
            },
            toggleClass: function(className) {
                elements.forEach(el => el.classList.toggle(className));
                return this;
            },
            addClass: function(className) {
                elements.forEach(el => el.classList.add(className));
                return this;
            },
            removeClass: function(className) {
                elements.forEach(el => el.classList.remove(className));
                return this;
            },
            siblings: function(siblingSelector) {
                // Simple implementation
                if (elements.length === 0) return this;
                const parent = elements[0].parentNode;
                const siblings = Array.from(parent.querySelectorAll(siblingSelector));
                return {
                    toggleClass: function(className) {
                        siblings.forEach(el => el.classList.toggle(className));
                        return this;
                    },
                    addClass: function(className) {
                        siblings.forEach(el => el.classList.add(className));
                        return this;
                    },
                    removeClass: function(className) {
                        siblings.forEach(el => el.classList.remove(className));
                        return this;
                    }
                };
            },
            text: function(value) {
                if (value === undefined) {
                    return elements.length > 0 ? elements[0].textContent : '';
                }
                elements.forEach(el => el.textContent = value);
                return this;
            },
            val: function(value) {
                if (value === undefined) {
                    return elements.length > 0 ? elements[0].value : '';
                }
                elements.forEach(el => el.value = value);
                return this;
            },
            data: function(key) {
                return elements.length > 0 ? elements[0].dataset[key] : null;
            },
            closest: function(selector) {
                const matches = [];
                elements.forEach(el => {
                    let current = el;
                    while (current && current !== document) {
                        if (current.matches(selector)) {
                            matches.push(current);
                            break;
                        }
                        current = current.parentElement;
                    }
                });

                return {
                    length: matches.length,
                    toggleClass: function(className) {
                        matches.forEach(el => el.classList.toggle(className));
                        return this;
                    }
                };
            }
        };
    };

    // Add document ready function
    window.$(document).ready = function(fn) {
        if (document.readyState !== 'loading') {
            fn();
        } else {
            document.addEventListener('DOMContentLoaded', fn);
        }
    };
} else {
    console.log('jQuery is available and working!');
}

// jQuery Implementation for common interactions
$(document).ready(function() {
    console.log('Document ready - initializing jQuery functions');

    // Initialize any dropdowns
    $('.dropdown-toggle').on('click', function(e) {
        e.preventDefault();
        $(this).siblings('.dropdown-menu').toggleClass('hidden');
    });

    // Handle any click counters
    $('.counter-button').on('click', function() {
        let counterDisplay = $(this).siblings('.counter-display');
        let count = parseInt(counterDisplay.text()) || 0;
        counterDisplay.text(count + 1);
    });

    // Close dropdowns when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.dropdown').length) {
            $('.dropdown-menu').addClass('hidden');
        }
    });

    // Store values in localStorage (to replace Alpine's $persist)
    $('.persist-input').on('change', function() {
        let key = $(this).data('persist-key');
        let value = $(this).val();
        localStorage.setItem(key, value);
    });

    // Load persisted values
    $('.persist-input').each(function() {
        let key = $(this).data('persist-key');
        let storedValue = localStorage.getItem(key);
        if (storedValue !== null) {
            $(this).val(storedValue);
        }
    });

    // Handle language dropdown
    $('.lang-dropdown-trigger').on('click', function(e) {
        e.stopPropagation();
        $('.lang-dropdown-content').toggleClass('hidden');
    });

    // Handle user dropdown
    $('.user-dropdown-trigger').on('click', function(e) {
        e.stopPropagation();
        $('.user-dropdown-content').toggleClass('hidden');
    });

    // Close dropdowns when clicking outside
    $(document).on('click', function() {
        $('.lang-dropdown-content, .user-dropdown-content').addClass('hidden');
    });

    // Mobile menu toggle
    $('.mobile-menu-button').on('click', function() {
        $('.mobile-menu').toggleClass('hidden');
        $('.mobile-menu-icon-open').toggleClass('hidden');
        $('.mobile-menu-icon-close').toggleClass('hidden');
    });
});

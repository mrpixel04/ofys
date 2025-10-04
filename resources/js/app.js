// Bootstrap
import './bootstrap';

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
            },
            prop: function(property, value) {
                if (value === undefined) {
                    return elements.length > 0 ? elements[0][property] : null;
                }
                elements.forEach(el => el[property] = value);
                return this;
            },
            html: function(value) {
                if (value === undefined) {
                    return elements.length > 0 ? elements[0].innerHTML : '';
                }
                elements.forEach(el => el.innerHTML = value);
                return this;
            },
            find: function(selector) {
                const found = [];
                elements.forEach(el => {
                    const matches = el.querySelectorAll(selector);
                    found.push(...matches);
                });
                return window.$(found);
            },
            submit: function() {
                elements.forEach(el => {
                    if (el.tagName === 'FORM') {
                        el.submit();
                    }
                });
                return this;
            },
            fadeOut: function(duration = 500) {
                elements.forEach(el => {
                    el.style.transition = `opacity ${duration}ms`;
                    el.style.opacity = '0';
                    setTimeout(() => {
                        el.style.display = 'none';
                    }, duration);
                });
                return this;
            },
            fadeIn: function(duration = 500) {
                elements.forEach(el => {
                    el.style.display = '';
                    el.style.opacity = '0';
                    el.style.transition = `opacity ${duration}ms`;
                    setTimeout(() => {
                        el.style.opacity = '1';
                    }, 10);
                });
                return this;
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
    console.log('Document ready - initializing jQuery functions (Livewire/Alpine removed)');

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

    // Form validation and submission helpers
    $('form').on('submit', function(e) {
        const $form = $(this);
        const $submitBtn = $form.find('button[type="submit"]');

        // Show loading state
        if ($submitBtn.length) {
            const originalText = $submitBtn.html();
            $submitBtn.html('<i class="fas fa-spinner fa-spin mr-2"></i>Processing...').prop('disabled', true);

            // Re-enable after 5 seconds (in case of errors)
            setTimeout(() => {
                $submitBtn.html(originalText).prop('disabled', false);
            }, 5000);
        }
    });

    // Flash message auto-hide
    setTimeout(function() {
        $('.alert, .flash-message').fadeOut(500);
    }, 5000);

    // Modal helpers
    $('.modal-trigger').on('click', function() {
        const modalId = $(this).data('modal');
        $('#' + modalId).removeClass('hidden');
    });

    $('.modal-close, .modal-backdrop').on('click', function() {
        $(this).closest('.modal').addClass('hidden');
    });

    // Prevent modal from closing when clicking inside
    $('.modal-content').on('click', function(e) {
        e.stopPropagation();
    });
});

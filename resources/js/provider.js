// Import jQuery
import $ from 'jquery';
window.$ = window.jQuery = $;

// Import axios for API requests
import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

console.log('Provider JS loaded - No Livewire or Alpine');

// jQuery Document Ready
$(document).ready(function() {
    console.log('Provider section initialized with jQuery');

    // Mobile menu toggle
    $('#mobile-menu-button').on('click', function() {
        $('#mobile-menu-panel').toggleClass('hidden');
        $('#menu-open-icon, #menu-close-icon').toggleClass('hidden');
    });

    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.close-alert').closest('.rounded-md').fadeOut();
    }, 5000);

    // Close alerts manually
    $('.close-alert').on('click', function() {
        $(this).closest('.rounded-md').fadeOut();
    });

    // Initialize dropdowns
    $('.dropdown-trigger').on('click', function(e) {
        e.stopPropagation();
        $(this).next('.dropdown-content').toggleClass('hidden');
    });

    // Close dropdowns when clicking outside
    $(document).on('click', function() {
        $('.dropdown-content').addClass('hidden');
    });

    // Toggle password visibility (delegated for dynamically injected forms)
    $(document).on('click', '.toggle-password', function() {
        const targetId = $(this).data('target');
        const input = $(`#${targetId}`);

        if (!input.length) {
            return;
        }

        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            $(this).find('svg').replaceWith(`
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                </svg>
            `);
        } else {
            input.attr('type', 'password');
            $(this).find('svg').replaceWith(`
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            `);
        }
    });
});

// Modal functionality
window.showModal = function(modalId) {
    const modalSelector = '#' + modalId;
    const modalContentSelector = '#' + modalId + '-content';
    const template = document.getElementById(modalId + '-template');

    if (template) {
        const modalContentArea = $(modalContentSelector);
        if (modalContentArea.length) {
            modalContentArea.html(template.innerHTML);
        }
    }

    $(modalSelector).removeClass('hidden');
    $('body').addClass('overflow-hidden');

    $(document).on('keydown.modal', function(event) {
        if (event.key === 'Escape') {
            hideModal(modalId);
        }
    });
}

window.hideModal = function(modalId) {
    const modalSelector = '#' + modalId;
    const modalContentSelector = '#' + modalId + '-content';

    $(modalSelector).addClass('hidden');
    $('body').removeClass('overflow-hidden');
    $(document).off('keydown.modal');

    const modalContentArea = $(modalContentSelector);
    if (modalContentArea.length) {
        modalContentArea.empty();
    }
}

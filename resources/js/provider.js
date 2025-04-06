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
});

// Modal functionality
window.showModal = function(modalId) {
    // Show the modal
    $('#' + modalId).removeClass('hidden');

    // Add overflow:hidden to body to prevent scrolling
    $('body').addClass('overflow-hidden');

    // Add event listener for ESC key
    $(document).on('keydown.modal', function(event) {
        if (event.key === 'Escape') {
            hideModal(modalId);
        }
    });
}

window.hideModal = function(modalId) {
    // Hide the modal
    $('#' + modalId).addClass('hidden');

    // Remove overflow:hidden from body
    $('body').removeClass('overflow-hidden');

    // Remove ESC key event listener
    $(document).off('keydown.modal');
}

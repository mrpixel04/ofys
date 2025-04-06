/**
 * RECOMMENDED VERSION OF app.js
 * Copy this to your resources/js/app.js file
 */

import './bootstrap';

// Import Livewire and Alpine from Livewire package
import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';

// Make Alpine and Livewire globally available
window.Alpine = Alpine;
window.Livewire = Livewire;

// Safety flags to prevent multiple initialization
window._alpineInitialized = window._alpineInitialized || false;
window._livewireInitialized = window._livewireInitialized || false;

// Import Alpine plugins
import persist from '@alpinejs/persist';

// Only register plugins if not already initialized
if (!window._alpineInitialized) {
    // Register plugins before starting
    Alpine.plugin(persist);

    // Listen for Livewire load event
    document.addEventListener('livewire:initialized', () => {
        // Only initialize Alpine once Livewire is ready
        if (!window._alpineInitialized) {
            window._alpineInitialized = true;
            Alpine.start();
            console.log('Alpine started after Livewire initialization');
        }
    });
}

// Only start Livewire once
if (!window._livewireInitialized) {
    window._livewireInitialized = true;
    // Initialize Livewire
    Livewire.start();
    console.log('Livewire initialized');
}

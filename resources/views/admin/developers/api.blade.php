@extends('layouts.simple-admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-indigo-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Enhanced Header with Animation -->
        <div class="mb-8 animate-fade-in">
            <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-indigo-600 mb-2">
                API Documentation
            </h1>
            <p class="text-gray-600 text-lg flex items-center">
                <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Complete API reference for ADMIN, CUSTOMER, and PROVIDER roles
            </p>
        </div>

        <!-- API Tabs -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-purple-100 mb-8">
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-4">
                <ul class="flex flex-wrap text-sm font-semibold" id="apiTabs" role="tablist">
                    <li class="mr-2" role="presentation">
                        <button class="inline-flex items-center px-6 py-3 rounded-xl bg-white bg-opacity-20 text-white hover:bg-opacity-30 transition-all duration-300 active-tab backdrop-blur-sm"
                            id="admin-tab" data-target="admin-content" type="button" role="tab">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            ADMIN API
                        </button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-flex items-center px-6 py-3 rounded-xl text-white hover:bg-white hover:bg-opacity-20 transition-all duration-300"
                            id="customer-tab" data-target="customer-content" type="button" role="tab">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            CUSTOMER API
                        </button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-flex items-center px-6 py-3 rounded-xl text-white hover:bg-white hover:bg-opacity-20 transition-all duration-300"
                            id="provider-tab" data-target="provider-content" type="button" role="tab">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            PROVIDER API
                        </button>
                    </li>
                </ul>
            </div>

            <!-- Tab Contents -->
            <div class="p-6">
                <!-- ADMIN API Content -->
                <div id="admin-content" class="tab-content">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Admin API Endpoints</h2>
                        <p class="text-gray-600 mb-4">Complete API reference for administrative operations</p>
                    </div>

                    <!-- Swagger UI Container for Admin -->
                    <div id="swagger-ui-admin" class="swagger-ui-container"></div>
                </div>

                <!-- CUSTOMER API Content -->
                <div id="customer-content" class="tab-content hidden">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Customer API Endpoints</h2>
                        <p class="text-gray-600 mb-4">API reference for customer-facing operations</p>
                    </div>

                    <!-- Swagger UI Container for Customer -->
                    <div id="swagger-ui-customer" class="swagger-ui-container"></div>
                </div>

                <!-- PROVIDER API Content -->
                <div id="provider-content" class="tab-content hidden">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Vendor API Endpoints</h2>
                        <p class="text-gray-600 mb-4">API reference for provider operations</p>
                    </div>

                    <!-- Swagger UI Container for Vendor -->
                    <div id="swagger-ui-provider" class="swagger-ui-container"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Animations & Styles -->
<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fadeIn 0.6s ease-out;
    }

    .active-tab {
        background-color: rgba(255, 255, 255, 0.3) !important;
    }

    .tab-content {
        display: none;
    }

    .tab-content:not(.hidden) {
        display: block;
    }

    /* Swagger UI Customization */
    .swagger-ui-container {
        min-height: 600px;
    }

    .swagger-ui .topbar {
        display: none;
    }

    .swagger-ui .info {
        margin: 20px 0;
    }
</style>

<!-- Swagger UI CSS -->
<link rel="stylesheet" type="text/css" href="https://unpkg.com/swagger-ui-dist@5.10.5/swagger-ui.css">

@endsection

@section('scripts')
<!-- Swagger UI Bundle -->
<script src="https://unpkg.com/swagger-ui-dist@5.10.5/swagger-ui-bundle.js"></script>
<script src="https://unpkg.com/swagger-ui-dist@5.10.5/swagger-ui-standalone-preset.js"></script>

<script>
    $(document).ready(function() {
        // Tab switching functionality
        $('[id$="-tab"]').on('click', function() {
            const target = $(this).data('target');

            // Remove active class from all tabs
            $('[id$="-tab"]').removeClass('active-tab');
            $('[id$="-tab"]').css('background-color', '');

            // Add active class to clicked tab
            $(this).addClass('active-tab');

            // Hide all content
            $('.tab-content').addClass('hidden');

            // Show target content
            $('#' + target).removeClass('hidden');
        });

        // Initialize Swagger UI for each API
        const adminSpec = {
            openapi: '3.0.0',
            info: {
                title: 'OFYS Admin API',
                version: '1.0.0',
                description: 'API endpoints for administrative operations'
            },
            servers: [{
                url: '{{ url("/api/admin") }}',
                description: 'Admin API Server'
            }],
            paths: {
                '/dashboard': {
                    get: {
                        summary: 'Get Dashboard Statistics',
                        tags: ['Dashboard'],
                        responses: {
                            '200': {
                                description: 'Success',
                                content: {
                                    'application/json': {
                                        schema: {
                                            type: 'object',
                                            properties: {
                                                users_count: { type: 'integer' },
                                                providers_count: { type: 'integer' },
                                                customers_count: { type: 'integer' },
                                                activities_count: { type: 'integer' },
                                                bookings_count: { type: 'integer' }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                },
                '/providers': {
                    get: {
                        summary: 'Get All Vendors',
                        tags: ['Vendors'],
                        parameters: [{
                            name: 'search',
                            in: 'query',
                            schema: { type: 'string' }
                        }],
                        responses: {
                            '200': { description: 'Success' }
                        }
                    }
                },
                '/customers': {
                    get: {
                        summary: 'Get All Customers',
                        tags: ['Customers'],
                        responses: {
                            '200': { description: 'Success' }
                        }
                    }
                },
                '/bookings': {
                    get: {
                        summary: 'Get All Bookings',
                        tags: ['Bookings'],
                        responses: {
                            '200': { description: 'Success' }
                        }
                    }
                }
            }
        };

        const customerSpec = {
            openapi: '3.0.0',
            info: {
                title: 'OFYS Customer API',
                version: '1.0.0',
                description: 'API endpoints for customer operations'
            },
            servers: [{
                url: '{{ url("/api/customer") }}',
                description: 'Customer API Server'
            }],
            paths: {
                '/activities': {
                    get: {
                        summary: 'Browse Activities',
                        tags: ['Activities'],
                        responses: {
                            '200': { description: 'Success' }
                        }
                    }
                },
                '/bookings': {
                    get: {
                        summary: 'Get My Bookings',
                        tags: ['Bookings'],
                        responses: {
                            '200': { description: 'Success' }
                        }
                    },
                    post: {
                        summary: 'Create New Booking',
                        tags: ['Bookings'],
                        responses: {
                            '201': { description: 'Created' }
                        }
                    }
                },
                '/profile': {
                    get: {
                        summary: 'Get Profile',
                        tags: ['Profile'],
                        responses: {
                            '200': { description: 'Success' }
                        }
                    },
                    put: {
                        summary: 'Update Profile',
                        tags: ['Profile'],
                        responses: {
                            '200': { description: 'Updated' }
                        }
                    }
                }
            }
        };

        const providerSpec = {
            openapi: '3.0.0',
            info: {
                title: 'OFYS Vendor API',
                version: '1.0.0',
                description: 'API endpoints for provider operations'
            },
            servers: [{
                url: '{{ url("/api/provider") }}',
                description: 'Vendor API Server'
            }],
            paths: {
                '/activities': {
                    get: {
                        summary: 'Get My Activities',
                        tags: ['Activities'],
                        responses: {
                            '200': { description: 'Success' }
                        }
                    },
                    post: {
                        summary: 'Create Activity',
                        tags: ['Activities'],
                        responses: {
                            '201': { description: 'Created' }
                        }
                    }
                },
                '/bookings': {
                    get: {
                        summary: 'Get Bookings for My Activities',
                        tags: ['Bookings'],
                        responses: {
                            '200': { description: 'Success' }
                        }
                    }
                },
                '/shop-info': {
                    get: {
                        summary: 'Get Shop Information',
                        tags: ['Shop'],
                        responses: {
                            '200': { description: 'Success' }
                        }
                    },
                    put: {
                        summary: 'Update Shop Information',
                        tags: ['Shop'],
                        responses: {
                            '200': { description: 'Updated' }
                        }
                    }
                }
            }
        };

        // Initialize Swagger UI instances
        SwaggerUIBundle({
            spec: adminSpec,
            dom_id: '#swagger-ui-admin',
            deepLinking: true,
            presets: [
                SwaggerUIBundle.presets.apis,
                SwaggerUIStandalonePreset
            ],
            plugins: [
                SwaggerUIBundle.plugins.DownloadUrl
            ],
            layout: "BaseLayout"
        });

        SwaggerUIBundle({
            spec: customerSpec,
            dom_id: '#swagger-ui-customer',
            deepLinking: true,
            presets: [
                SwaggerUIBundle.presets.apis,
                SwaggerUIStandalonePreset
            ],
            plugins: [
                SwaggerUIBundle.plugins.DownloadUrl
            ],
            layout: "BaseLayout"
        });

        SwaggerUIBundle({
            spec: providerSpec,
            dom_id: '#swagger-ui-provider',
            deepLinking: true,
            presets: [
                SwaggerUIBundle.presets.apis,
                SwaggerUIStandalonePreset
            ],
            plugins: [
                SwaggerUIBundle.plugins.DownloadUrl
            ],
            layout: "BaseLayout"
        });
    });
</script>
@endsection

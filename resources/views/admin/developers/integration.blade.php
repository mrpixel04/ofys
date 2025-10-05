@extends('layouts.simple-admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-indigo-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Enhanced Header with Animation -->
        <div class="mb-8 animate-fade-in">
            <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-indigo-600 mb-2">
                Integration Settings
            </h1>
            <p class="text-gray-600 text-lg flex items-center">
                <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                Configure WhatsApp Web.js and N8N integrations
            </p>
        </div>

        <!-- Flash Messages -->
        <div id="flash-message" class="hidden mb-6"></div>

        <!-- Integration Tabs -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-purple-100 mb-8">
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-4">
                <ul class="flex flex-wrap text-sm font-semibold" id="integrationTabs" role="tablist">
                    <li class="mr-2" role="presentation">
                        <button class="inline-flex items-center px-6 py-3 rounded-xl bg-white bg-opacity-20 text-white hover:bg-opacity-30 transition-all duration-300 active-tab backdrop-blur-sm"
                            id="whatsapp-tab" data-target="whatsapp-content" type="button" role="tab">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                            WhatsApp Web.js
                        </button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-flex items-center px-6 py-3 rounded-xl text-white hover:bg-white hover:bg-opacity-20 transition-all duration-300"
                            id="n8n-tab" data-target="n8n-content" type="button" role="tab">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            N8N Automation
                        </button>
                    </li>
                </ul>
            </div>

            <!-- Tab Contents -->
            <div class="p-8">
                <!-- WhatsApp Integration Content -->
                <div id="whatsapp-content" class="tab-content">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">WhatsApp Web.js Integration</h2>
                        <p class="text-gray-600">Connect your self-hosted WhatsApp Web.js service to receive QR codes and manage WhatsApp sessions</p>
                    </div>

                    <!-- Connection Status -->
                    <div class="mb-6 p-4 rounded-xl border-2 {{ $integrations['whatsapp']['session_active'] ? 'border-green-500 bg-green-50' : 'border-amber-500 bg-amber-50' }}">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                @if($integrations['whatsapp']['session_active'])
                                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @else
                                    <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                @endif
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold {{ $integrations['whatsapp']['session_active'] ? 'text-green-900' : 'text-amber-900' }}">
                                    {{ $integrations['whatsapp']['session_active'] ? 'WhatsApp Session Active' : 'WhatsApp Session Inactive' }}
                                </h3>
                                <p class="text-sm {{ $integrations['whatsapp']['session_active'] ? 'text-green-700' : 'text-amber-700' }}">
                                    {{ $integrations['whatsapp']['session_active'] ? 'Your WhatsApp is connected and ready' : 'Configure settings below to activate WhatsApp integration' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- WhatsApp Configuration Form -->
                    <form id="whatsapp-form" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- API URL -->
                            <div>
                                <label for="whatsapp_api_url" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                    </svg>
                                    API URL *
                                </label>
                                <input type="url" id="whatsapp_api_url" name="api_url" value="{{ $integrations['whatsapp']['api_url'] }}"
                                    class="block w-full px-4 py-3 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 rounded-xl shadow-sm transition duration-150"
                                    placeholder="https://your-whatsapp-api.com/api" required>
                                <p class="mt-1 text-sm text-gray-500">Base URL of your WhatsApp Web.js API server</p>
                            </div>

                            <!-- Webhook URL -->
                            <div>
                                <label for="whatsapp_webhook_url" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    Webhook URL
                                </label>
                                <input type="url" id="whatsapp_webhook_url" name="webhook_url" value="{{ $integrations['whatsapp']['webhook_url'] }}"
                                    class="block w-full px-4 py-3 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 rounded-xl shadow-sm transition duration-150"
                                    placeholder="{{ url('/api/webhooks/whatsapp') }}">
                                <p class="mt-1 text-sm text-gray-500">Webhook endpoint for incoming messages</p>
                            </div>

                            <!-- API Key -->
                            <div>
                                <label for="whatsapp_api_key" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                    </svg>
                                    API Key *
                                </label>
                                <input type="text" id="whatsapp_api_key" name="api_key" value="{{ $integrations['whatsapp']['api_key'] }}"
                                    class="block w-full px-4 py-3 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 rounded-xl shadow-sm transition duration-150 font-mono"
                                    placeholder="your-api-key-here" required>
                                <p class="mt-1 text-sm text-gray-500">Authentication key for API requests</p>
                            </div>

                            <!-- Secret Key -->
                            <div>
                                <label for="whatsapp_secret_key" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    Secret Key
                                </label>
                                <input type="password" id="whatsapp_secret_key" name="secret_key" value="{{ $integrations['whatsapp']['secret_key'] }}"
                                    class="block w-full px-4 py-3 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 rounded-xl shadow-sm transition duration-150 font-mono"
                                    placeholder="your-secret-key-here">
                                <p class="mt-1 text-sm text-gray-500">Secret key for webhook verification</p>
                            </div>

                            <!-- QR Code Endpoint -->
                            <div class="md:col-span-2">
                                <label for="whatsapp_qr_endpoint" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                                    </svg>
                                    QR Code Endpoint
                                </label>
                                <input type="url" id="whatsapp_qr_endpoint" name="qr_endpoint" value="{{ $integrations['whatsapp']['qr_endpoint'] }}"
                                    class="block w-full px-4 py-3 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 rounded-xl shadow-sm transition duration-150"
                                    placeholder="https://your-whatsapp-api.com/api/qr">
                                <p class="mt-1 text-sm text-gray-500">Endpoint to fetch QR code image for WhatsApp authentication</p>
                            </div>
                        </div>

                        <!-- QR Code Display Area -->
                        <div id="qr-code-container" class="hidden mt-6 p-6 bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl border-2 border-green-200">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                                Scan QR Code with WhatsApp
                            </h3>
                            <div class="flex justify-center">
                                <img id="qr-code-image" src="" alt="WhatsApp QR Code" class="max-w-xs rounded-lg shadow-lg">
                            </div>
                            <p class="text-center text-sm text-gray-600 mt-4">Open WhatsApp on your phone and scan this QR code to connect</p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4">
                            <button type="button" id="fetch-qr-btn" class="inline-flex items-center justify-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                                </svg>
                                Fetch QR Code
                            </button>
                            <button type="button" id="test-connection-btn" class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Test Connection
                            </button>
                            <button type="submit" class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold rounded-xl transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Save Configuration
                            </button>
                        </div>
                    </form>
                </div>

                <!-- N8N Integration Content -->
                <div id="n8n-content" class="tab-content hidden">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">N8N Automation Integration</h2>
                        <p class="text-gray-600">Connect to your N8N instance for workflow automation and advanced integrations</p>
                    </div>

                    <!-- N8N Configuration Form -->
                    <form id="n8n-form" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- API URL -->
                            <div>
                                <label for="n8n_api_url" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                    </svg>
                                    N8N API URL *
                                </label>
                                <input type="url" id="n8n_api_url" name="api_url" value="{{ $integrations['n8n']['api_url'] }}"
                                    class="block w-full px-4 py-3 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 rounded-xl shadow-sm transition duration-150"
                                    placeholder="https://your-n8n.com/api/v1" required>
                                <p class="mt-1 text-sm text-gray-500">Base URL of your N8N instance API</p>
                            </div>

                            <!-- Webhook URL -->
                            <div>
                                <label for="n8n_webhook_url" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    Webhook URL
                                </label>
                                <input type="url" id="n8n_webhook_url" name="webhook_url" value="{{ $integrations['n8n']['webhook_url'] }}"
                                    class="block w-full px-4 py-3 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 rounded-xl shadow-sm transition duration-150"
                                    placeholder="{{ url('/api/webhooks/n8n') }}">
                                <p class="mt-1 text-sm text-gray-500">Webhook endpoint for N8N workflows</p>
                            </div>

                            <!-- API Key -->
                            <div>
                                <label for="n8n_api_key" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                    </svg>
                                    API Key *
                                </label>
                                <input type="text" id="n8n_api_key" name="api_key" value="{{ $integrations['n8n']['api_key'] }}"
                                    class="block w-full px-4 py-3 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 rounded-xl shadow-sm transition duration-150 font-mono"
                                    placeholder="n8n-api-key-here" required>
                                <p class="mt-1 text-sm text-gray-500">N8N API authentication key</p>
                            </div>

                            <!-- Workflow ID -->
                            <div>
                                <label for="n8n_workflow_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    Workflow ID
                                </label>
                                <input type="text" id="n8n_workflow_id" name="workflow_id" value="{{ $integrations['n8n']['workflow_id'] }}"
                                    class="block w-full px-4 py-3 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 rounded-xl shadow-sm transition duration-150 font-mono"
                                    placeholder="workflow-id-here">
                                <p class="mt-1 text-sm text-gray-500">Default workflow ID for automation</p>
                            </div>
                        </div>

                        <!-- Integration Guide -->
                        <div class="mt-6 p-6 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl border-2 border-blue-200">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Integration Guide
                            </h3>
                            <div class="space-y-3 text-sm text-gray-700">
                                <p><strong>Step 1:</strong> Create a webhook node in your N8N workflow</p>
                                <p><strong>Step 2:</strong> Copy the webhook URL and paste it in the "Webhook URL" field above</p>
                                <p><strong>Step 3:</strong> Generate an API key in your N8N settings</p>
                                <p><strong>Step 4:</strong> Test the connection to ensure everything is working</p>
                                <p><strong>Step 5:</strong> Save the configuration to activate the integration</p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4">
                            <button type="button" id="test-n8n-connection-btn" class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Test Connection
                            </button>
                            <button type="submit" class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold rounded-xl transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Save Configuration
                            </button>
                        </div>
                    </form>
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

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .animate-fade-in {
        animation: fadeIn 0.6s ease-out;
    }

    .animate-slide-in {
        animation: slideIn 0.5s ease-out;
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
</style>

@endsection

@section('scripts')
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

        // Show flash message
        function showFlash(message, type = 'success') {
            const bgColor = type === 'success' ? 'from-green-50 to-emerald-50 border-green-500' : 'from-red-50 to-pink-50 border-red-500';
            const iconColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
            const icon = type === 'success' ?
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>' :
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';

            $('#flash-message').html(`
                <div class="bg-gradient-to-r ${bgColor} border-l-4 p-4 rounded-xl shadow-lg animate-slide-in">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-10 h-10 ${iconColor} rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">${icon}</svg>
                        </div>
                        <p class="ml-3 font-semibold text-gray-700">${message}</p>
                    </div>
                </div>
            `).removeClass('hidden');

            setTimeout(() => {
                $('#flash-message').addClass('hidden');
            }, 5000);
        }

        // WhatsApp Form Submit
        $('#whatsapp-form').on('submit', function(e) {
            e.preventDefault();

            const formData = {
                _token: $('input[name="_token"]').val(),
                api_url: $('#whatsapp_api_url').val(),
                webhook_url: $('#whatsapp_webhook_url').val(),
                api_key: $('#whatsapp_api_key').val(),
                secret_key: $('#whatsapp_secret_key').val(),
                qr_endpoint: $('#whatsapp_qr_endpoint').val()
            };

            $.ajax({
                url: '{{ route("admin.developers.integration.whatsapp") }}',
                method: 'POST',
                data: formData,
                success: function(response) {
                    showFlash(response.message, 'success');
                },
                error: function(xhr) {
                    showFlash(xhr.responseJSON?.message || 'Failed to save WhatsApp configuration', 'error');
                }
            });
        });

        // N8N Form Submit
        $('#n8n-form').on('submit', function(e) {
            e.preventDefault();

            const formData = {
                _token: $('input[name="_token"]').val(),
                api_url: $('#n8n_api_url').val(),
                webhook_url: $('#n8n_webhook_url').val(),
                api_key: $('#n8n_api_key').val(),
                workflow_id: $('#n8n_workflow_id').val()
            };

            $.ajax({
                url: '{{ route("admin.developers.integration.n8n") }}',
                method: 'POST',
                data: formData,
                success: function(response) {
                    showFlash(response.message, 'success');
                },
                error: function(xhr) {
                    showFlash(xhr.responseJSON?.message || 'Failed to save N8N configuration', 'error');
                }
            });
        });

        // Fetch QR Code
        $('#fetch-qr-btn').on('click', function() {
            const qrEndpoint = $('#whatsapp_qr_endpoint').val();
            const apiKey = $('#whatsapp_api_key').val();

            if (!qrEndpoint || !apiKey) {
                showFlash('Please configure API URL and API Key first', 'error');
                return;
            }

            // Show loading state
            $(this).prop('disabled', true).html(`
                <svg class="animate-spin w-5 h-5 mr-2 inline" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Fetching...
            `);

            // Simulate QR code fetch (replace with actual API call)
            setTimeout(() => {
                // In production, make actual API call to fetch QR code
                $('#qr-code-image').attr('src', qrEndpoint);
                $('#qr-code-container').removeClass('hidden');
                $(this).prop('disabled', false).html(`
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                    </svg>
                    Fetch QR Code
                `);
                showFlash('QR Code fetched successfully. Scan with WhatsApp to connect.', 'success');
            }, 1500);
        });

        // Test WhatsApp Connection
        $('#test-connection-btn').on('click', function() {
            const apiUrl = $('#whatsapp_api_url').val();
            const apiKey = $('#whatsapp_api_key').val();

            if (!apiUrl || !apiKey) {
                showFlash('Please configure API URL and API Key first', 'error');
                return;
            }

            showFlash('Testing WhatsApp connection...', 'success');
            // In production, make actual API call to test connection
        });

        // Test N8N Connection
        $('#test-n8n-connection-btn').on('click', function() {
            const apiUrl = $('#n8n_api_url').val();
            const apiKey = $('#n8n_api_key').val();

            if (!apiUrl || !apiKey) {
                showFlash('Please configure API URL and API Key first', 'error');
                return;
            }

            showFlash('Testing N8N connection...', 'success');
            // In production, make actual API call to test connection
        });
    });
</script>
@endsection

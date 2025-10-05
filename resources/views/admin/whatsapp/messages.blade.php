@extends('layouts.simple-admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-indigo-50 pb-8">
    <div class="container mx-auto px-4 py-8">
        <!-- Enhanced Header -->
        <div class="mb-8 animate-fade-in">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-indigo-600 mb-2">
                        WhatsApp Messages
                    </h1>
                    <p class="text-gray-600 text-lg flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                        </svg>
                        Manage customer messages from BuzzBridge
                    </p>
                </div>
                <div class="mt-4 md:mt-0 flex space-x-3">
                    <button id="fetch-messages-btn" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold rounded-xl transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Fetch Messages
                    </button>
                    <button id="train-chatbot-btn" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-semibold rounded-xl transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                        Train Chatbot
                    </button>
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        <div id="flash-message" class="hidden mb-6"></div>

        <!-- Main Chat Interface -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Sidebar - Conversations List -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-purple-100">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-4">
                        <h2 class="text-lg font-bold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                            </svg>
                            Conversations
                        </h2>
                        <p class="text-sm text-purple-100 mt-1">
                            <span id="conversation-count">0</span> active chats
                        </p>
                    </div>

                    <!-- Search -->
                    <div class="p-4 border-b border-gray-200">
                        <div class="relative">
                            <input type="text" id="search-conversations" placeholder="Search conversations..."
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 transition duration-150">
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Conversations List -->
                    <div id="conversations-list" class="overflow-y-auto" style="max-height: 600px;">
                        <!-- Empty State -->
                        <div id="empty-conversations" class="p-8 text-center">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <p class="text-gray-500 font-medium">No conversations yet</p>
                            <p class="text-sm text-gray-400 mt-2">Click "Fetch Messages" to load conversations</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Chat Window -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-purple-100 flex flex-col" style="height: 700px;">
                    <!-- Chat Header -->
                    <div id="chat-header" class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4 hidden">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center text-green-600 font-bold text-lg mr-4">
                                    <span id="chat-avatar">?</span>
                                </div>
                                <div>
                                    <h3 id="chat-name" class="text-lg font-bold text-white">Select a conversation</h3>
                                    <p id="chat-phone" class="text-sm text-green-100"></p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span id="chat-status" class="px-3 py-1 bg-white bg-opacity-20 rounded-full text-xs font-semibold text-white">
                                    Online
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Messages Area -->
                    <div id="messages-area" class="flex-1 overflow-y-auto p-6 bg-gray-50" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%239C92AC\' fill-opacity=\'0.05\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
                        <!-- Empty State -->
                        <div id="empty-chat" class="flex items-center justify-center h-full">
                            <div class="text-center">
                                <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                </svg>
                                <p class="text-gray-500 font-medium text-lg">No conversation selected</p>
                                <p class="text-sm text-gray-400 mt-2">Choose a conversation from the list to start chatting</p>
                            </div>
                        </div>

                        <!-- Messages Container -->
                        <div id="messages-container" class="hidden space-y-4">
                            <!-- Messages will be dynamically inserted here -->
                        </div>
                    </div>

                    <!-- Reply Input Area -->
                    <div id="reply-area" class="border-t border-gray-200 p-4 bg-white hidden">
                        <form id="reply-form" class="flex items-end space-x-3">
                            @csrf
                            <input type="hidden" id="reply-phone" name="phone">
                            <div class="flex-1">
                                <textarea id="reply-message" name="message" rows="2"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 resize-none transition duration-150"
                                    placeholder="Type your message..."></textarea>
                            </div>
                            <button type="submit" class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold rounded-xl transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Train Chatbot Modal -->
<div id="train-modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full animate-scale-in">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 rounded-t-2xl">
            <h3 class="text-xl font-bold text-white flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                </svg>
                Train Chatbot Response
            </h3>
        </div>
        <form id="train-form" class="p-6 space-y-6">
            @csrf
            <div>
                <label for="train-keyword" class="block text-sm font-semibold text-gray-700 mb-2">
                    Keyword / Trigger Phrase
                </label>
                <input type="text" id="train-keyword" name="keyword"
                    class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-150"
                    placeholder="e.g., booking, price, location" required>
                <p class="mt-1 text-sm text-gray-500">When customer mentions this keyword, bot will respond</p>
            </div>

            <div>
                <label for="train-response" class="block text-sm font-semibold text-gray-700 mb-2">
                    Auto Response
                </label>
                <textarea id="train-response" name="response" rows="4"
                    class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none transition duration-150"
                    placeholder="Enter the automatic response message..." required></textarea>
                <p class="mt-1 text-sm text-gray-500">This message will be sent automatically when keyword is detected</p>
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button" id="close-train-modal" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-xl transition-all duration-300">
                    Cancel
                </button>
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl transform hover:scale-105 transition-all duration-300 shadow-lg">
                    Train Chatbot
                </button>
            </div>
        </form>
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

    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    @keyframes spin-slow {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }

    .animate-fade-in {
        animation: fadeIn 0.6s ease-out;
    }

    .animate-slide-in {
        animation: slideIn 0.5s ease-out;
    }

    .animate-scale-in {
        animation: scaleIn 0.3s ease-out;
    }

    .animate-spin-slow {
        animation: spin-slow 3s linear infinite;
    }

    .conversation-item {
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .conversation-item:hover {
        background-color: #f3f4f6;
    }

    .conversation-item.active {
        background-color: #ede9fe;
        border-left: 4px solid #7c3aed;
    }

    .message-bubble {
        max-width: 70%;
        word-wrap: break-word;
    }

    .message-incoming {
        background: white;
        border: 1px solid #e5e7eb;
    }

    .message-outgoing {
        background: linear-gradient(135deg, #7c3aed 0%, #6366f1 100%);
        color: white;
        margin-left: auto;
    }
</style>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        let currentConversation = null;
        let allMessages = [];

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

        // Fetch Messages
        $('#fetch-messages-btn').on('click', function() {
            const btn = $(this);
            btn.prop('disabled', true).html(`
                <svg class="animate-spin w-5 h-5 mr-2 inline" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Fetching...
            `);

            $.ajax({
                url: '{{ route("admin.whatsapp.messages.fetch") }}',
                method: 'POST',
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    if (response.success) {
                        allMessages = response.messages;
                        renderConversations(response.messages);
                        showFlash(`Fetched ${response.messages.length} messages successfully!`, 'success');
                    }
                },
                error: function(xhr) {
                    showFlash(xhr.responseJSON?.message || 'Failed to fetch messages', 'error');
                },
                complete: function() {
                    btn.prop('disabled', false).html(`
                        <svg class="w-5 h-5 mr-2 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Fetch Messages
                    `);
                }
            });
        });

        // Render Conversations List
        function renderConversations(messages) {
            if (messages.length === 0) {
                $('#empty-conversations').show();
                return;
            }

            $('#empty-conversations').hide();
            $('#conversation-count').text(messages.length);

            const html = messages.map(msg => `
                <div class="conversation-item p-4 border-b border-gray-200" data-phone="${msg.from}" data-name="${msg.name}">
                    <div class="flex items-start">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-500 to-indigo-500 flex items-center justify-center text-white font-bold text-lg mr-3 flex-shrink-0">
                            ${msg.name.charAt(0).toUpperCase()}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <h4 class="text-sm font-semibold text-gray-900 truncate">${msg.name}</h4>
                                <span class="text-xs text-gray-500">${formatTime(msg.timestamp)}</span>
                            </div>
                            <p class="text-sm text-gray-600 truncate">${msg.message}</p>
                            <div class="flex items-center mt-2">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full ${msg.status === 'unread' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600'}">
                                    ${msg.status === 'unread' ? '● Unread' : 'Read'}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');

            $('#conversations-list').html(html);
        }

        // Format timestamp
        function formatTime(timestamp) {
            const date = new Date(timestamp);
            const now = new Date();
            const diff = Math.floor((now - date) / 1000 / 60); // minutes

            if (diff < 1) return 'Just now';
            if (diff < 60) return `${diff}m ago`;
            if (diff < 1440) return `${Math.floor(diff / 60)}h ago`;
            return date.toLocaleDateString();
        }

        // Select Conversation
        $(document).on('click', '.conversation-item', function() {
            $('.conversation-item').removeClass('active');
            $(this).addClass('active');

            const phone = $(this).data('phone');
            const name = $(this).data('name');

            currentConversation = { phone, name };

            // Show chat header and reply area
            $('#chat-header').removeClass('hidden');
            $('#reply-area').removeClass('hidden');
            $('#empty-chat').hide();
            $('#messages-container').removeClass('hidden');

            // Update header
            $('#chat-avatar').text(name.charAt(0).toUpperCase());
            $('#chat-name').text(name);
            $('#chat-phone').text(phone);
            $('#reply-phone').val(phone);

            // Load messages for this conversation
            loadConversationMessages(phone);
        });

        // Load Conversation Messages
        function loadConversationMessages(phone) {
            const messages = allMessages.filter(m => m.from === phone);

            const html = messages.map(msg => `
                <div class="flex ${msg.status === 'sent' ? 'justify-end' : 'justify-start'}">
                    <div class="message-bubble ${msg.status === 'sent' ? 'message-outgoing' : 'message-incoming'} px-4 py-3 rounded-2xl shadow-md">
                        <p class="text-sm">${msg.message}</p>
                        <p class="text-xs ${msg.status === 'sent' ? 'text-purple-100' : 'text-gray-500'} mt-1">${formatTime(msg.timestamp)}</p>
                    </div>
                </div>
            `).join('');

            $('#messages-container').html(html);
            $('#messages-area').scrollTop($('#messages-area')[0].scrollHeight);
        }

        // Reply Form Submit
        $('#reply-form').on('submit', function(e) {
            e.preventDefault();

            const phone = $('#reply-phone').val();
            const message = $('#reply-message').val().trim();

            if (!message) return;

            $.ajax({
                url: '{{ route("admin.whatsapp.messages.reply") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    phone: phone,
                    message: message
                },
                success: function(response) {
                    if (response.success) {
                        // Add message to chat
                        const newMessage = `
                            <div class="flex justify-end">
                                <div class="message-bubble message-outgoing px-4 py-3 rounded-2xl shadow-md">
                                    <p class="text-sm">${message}</p>
                                    <p class="text-xs text-purple-100 mt-1">Just now</p>
                                </div>
                            </div>
                        `;
                        $('#messages-container').append(newMessage);
                        $('#messages-area').scrollTop($('#messages-area')[0].scrollHeight);

                        // Clear input
                        $('#reply-message').val('');
                        showFlash('Message sent successfully!', 'success');
                    }
                },
                error: function(xhr) {
                    showFlash(xhr.responseJSON?.message || 'Failed to send message', 'error');
                }
            });
        });

        // Train Chatbot Modal
        $('#train-chatbot-btn').on('click', function() {
            $('#train-modal').removeClass('hidden');
        });

        $('#close-train-modal').on('click', function() {
            $('#train-modal').addClass('hidden');
        });

        // Train Form Submit
        $('#train-form').on('submit', function(e) {
            e.preventDefault();

            const keyword = $('#train-keyword').val();
            const response = $('#train-response').val();

            $.ajax({
                url: '{{ route("admin.whatsapp.messages.train") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    keyword: keyword,
                    response: response
                },
                success: function(response) {
                    if (response.success) {
                        showFlash('Chatbot trained successfully!', 'success');
                        $('#train-modal').addClass('hidden');
                        $('#train-form')[0].reset();
                    }
                },
                error: function(xhr) {
                    showFlash(xhr.responseJSON?.message || 'Failed to train chatbot', 'error');
                }
            });
        });

        // Search Conversations
        $('#search-conversations').on('keyup', function() {
            const search = $(this).val().toLowerCase();
            $('.conversation-item').each(function() {
                const name = $(this).data('name').toLowerCase();
                const phone = $(this).data('phone').toLowerCase();
                if (name.includes(search) || phone.includes(search)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
</script>
@endsection

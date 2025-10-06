<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'billplz' => [
        'api_key' => env('BILLPLZ_API_KEY'),
        'api_url' => env('BILLPLZ_API_URL', 'https://www.billplz-sandbox.com/api'),
        'collection_id' => env('BILLPLZ_COLLECTION_ID'),
        'x_signature_key' => env('BILLPLZ_X_SIGNATURE_KEY'),
    ],

    'whatsapp' => [
        'api_url' => env('WHATSAPP_API_URL'),
        'api_key' => env('WHATSAPP_API_KEY'),
        'webhook_url' => env('WHATSAPP_WEBHOOK_URL'),
        'secret_key' => env('WHATSAPP_SECRET_KEY'),
        'qr_endpoint' => env('WHATSAPP_QR_ENDPOINT'),
    ],

    'n8n' => [
        'api_url' => env('N8N_API_URL'),
        'webhook_url' => env('N8N_WEBHOOK_URL'),
        'api_key' => env('N8N_API_KEY'),
        'workflow_id' => env('N8N_WORKFLOW_ID'),
    ],

];

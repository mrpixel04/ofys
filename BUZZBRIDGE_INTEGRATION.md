# 🔗 BuzzBridge Integration Requirements

> **For**: BuzzBridge WhatsApp Web.js Service (https://buzzbridge.aplikasi-io.com)  
> **Purpose**: Complete API/Webhook specification for OFYS integration  
> **Last Updated**: October 5, 2025

---

## 📋 Overview

This document outlines the **required API endpoints and webhooks** that BuzzBridge must provide for seamless integration with OFYS (Outdoor For Your Soul) platform.

OFYS needs to:
1. ✅ Fetch QR code for WhatsApp authentication
2. ✅ Receive incoming WhatsApp messages from customers
3. ✅ Send outgoing WhatsApp messages to customers
4. ✅ Check WhatsApp session status
5. ✅ Get message history

---

## 🔐 Authentication

All API requests from OFYS to BuzzBridge must use **Bearer Token Authentication**.

```http
Authorization: Bearer {API_KEY}
```

### API Key Management
- BuzzBridge must provide a unique API key for OFYS
- API key should be generated in BuzzBridge admin panel
- API key should be revocable and regeneratable
- Recommended format: `bzb_live_xxxxxxxxxxxxxxxxxxxxxxxx`

---

## 📡 Required API Endpoints

### 1️⃣ **Get QR Code for WhatsApp Authentication**

**Endpoint**: `GET /api/qr`

**Purpose**: Generate and return QR code image for WhatsApp Web authentication

**Request Headers**:
```http
GET /api/qr HTTP/1.1
Host: buzzbridge.aplikasi-io.com
Authorization: Bearer {API_KEY}
Content-Type: application/json
```

**Success Response** (200 OK):
```json
{
  "success": true,
  "data": {
    "qr_code": "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAA...",
    "session_id": "session_abc123",
    "expires_at": "2025-10-05T12:30:00Z",
    "status": "pending"
  },
  "message": "QR code generated successfully"
}
```

**Error Response** (400 Bad Request):
```json
{
  "success": false,
  "error": {
    "code": "SESSION_ALREADY_ACTIVE",
    "message": "WhatsApp session is already active"
  }
}
```

**Notes**:
- QR code should be in Base64 format (data URI)
- QR code should expire after 60 seconds (standard WhatsApp behavior)
- If session is already active, return error
- Session ID should be unique and trackable

---

### 2️⃣ **Get Session Status**

**Endpoint**: `GET /api/session/status`

**Purpose**: Check if WhatsApp session is active/connected

**Request Headers**:
```http
GET /api/session/status HTTP/1.1
Host: buzzbridge.aplikasi-io.com
Authorization: Bearer {API_KEY}
Content-Type: application/json
```

**Success Response** (200 OK):
```json
{
  "success": true,
  "data": {
    "session_id": "session_abc123",
    "status": "active",
    "phone_number": "+60123456789",
    "connected_at": "2025-10-05T12:00:00Z",
    "last_activity": "2025-10-05T14:30:00Z"
  }
}
```

**Possible Status Values**:
- `pending` - QR code generated, waiting for scan
- `active` - WhatsApp connected and ready
- `disconnected` - Session expired or disconnected

---

### 3️⃣ **Fetch Messages**

**Endpoint**: `GET /api/messages`

**Purpose**: Retrieve all WhatsApp messages (incoming and outgoing)

**Request Headers**:
```http
GET /api/messages?limit=50&offset=0&status=unread HTTP/1.1
Host: buzzbridge.aplikasi-io.com
Authorization: Bearer {API_KEY}
Content-Type: application/json
```

**Query Parameters**:
| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `limit` | integer | No | Number of messages to return (default: 50, max: 100) |
| `offset` | integer | No | Pagination offset (default: 0) |
| `status` | string | No | Filter by status: `all`, `unread`, `read` (default: all) |
| `phone` | string | No | Filter by specific phone number |
| `from_date` | string | No | ISO 8601 date (e.g., 2025-10-05T00:00:00Z) |
| `to_date` | string | No | ISO 8601 date |

**Success Response** (200 OK):
```json
{
  "success": true,
  "data": {
    "messages": [
      {
        "id": "msg_123456",
        "from": "+60123456789",
        "from_name": "John Doe",
        "to": "+60198765432",
        "message": "Hi, I want to book a hiking trip",
        "direction": "incoming",
        "status": "unread",
        "timestamp": "2025-10-05T14:25:30Z",
        "message_type": "text",
        "has_media": false,
        "media_url": null
      },
      {
        "id": "msg_123457",
        "from": "+60198765432",
        "from_name": "OFYS Support",
        "to": "+60123456789",
        "message": "Thank you for your inquiry! How can we help?",
        "direction": "outgoing",
        "status": "sent",
        "timestamp": "2025-10-05T14:26:00Z",
        "message_type": "text",
        "has_media": false,
        "media_url": null
      }
    ],
    "pagination": {
      "total": 150,
      "limit": 50,
      "offset": 0,
      "has_more": true
    }
  }
}
```

**Message Object Fields**:
| Field | Type | Description |
|-------|------|-------------|
| `id` | string | Unique message ID |
| `from` | string | Sender phone number (E.164 format) |
| `from_name` | string | Sender name from WhatsApp profile |
| `to` | string | Recipient phone number |
| `message` | string | Message content |
| `direction` | string | `incoming` or `outgoing` |
| `status` | string | `unread`, `read`, `sent`, `delivered`, `failed` |
| `timestamp` | string | ISO 8601 timestamp |
| `message_type` | string | `text`, `image`, `video`, `audio`, `document` |
| `has_media` | boolean | True if message contains media |
| `media_url` | string | URL to download media (if has_media = true) |

---

### 4️⃣ **Send Message**

**Endpoint**: `POST /api/messages/send`

**Purpose**: Send WhatsApp message to a customer

**Request Headers**:
```http
POST /api/messages/send HTTP/1.1
Host: buzzbridge.aplikasi-io.com
Authorization: Bearer {API_KEY}
Content-Type: application/json
```

**Request Body**:
```json
{
  "phone": "+60123456789",
  "message": "Thank you for your inquiry! To book a hiking trip, please visit our website.",
  "reply_to": "msg_123456"
}
```

**Request Body Fields**:
| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `phone` | string | Yes | Recipient phone number (E.164 format) |
| `message` | string | Yes | Message content (max 4096 characters) |
| `reply_to` | string | No | Message ID to reply to (for threading) |

**Success Response** (200 OK):
```json
{
  "success": true,
  "data": {
    "message_id": "msg_789012",
    "phone": "+60123456789",
    "message": "Thank you for your inquiry!...",
    "status": "sent",
    "timestamp": "2025-10-05T14:30:00Z"
  },
  "message": "Message sent successfully"
}
```

**Error Response** (400 Bad Request):
```json
{
  "success": false,
  "error": {
    "code": "INVALID_PHONE_NUMBER",
    "message": "Phone number is not registered on WhatsApp"
  }
}
```

**Possible Error Codes**:
- `INVALID_PHONE_NUMBER` - Phone not registered on WhatsApp
- `SESSION_INACTIVE` - WhatsApp session not connected
- `MESSAGE_TOO_LONG` - Message exceeds 4096 characters
- `RATE_LIMIT_EXCEEDED` - Too many messages sent

---

### 5️⃣ **Mark Message as Read**

**Endpoint**: `POST /api/messages/{message_id}/read`

**Purpose**: Mark a specific message as read

**Request Headers**:
```http
POST /api/messages/msg_123456/read HTTP/1.1
Host: buzzbridge.aplikasi-io.com
Authorization: Bearer {API_KEY}
Content-Type: application/json
```

**Success Response** (200 OK):
```json
{
  "success": true,
  "data": {
    "message_id": "msg_123456",
    "status": "read",
    "read_at": "2025-10-05T14:35:00Z"
  },
  "message": "Message marked as read"
}
```

---

### 6️⃣ **Get Message History (Conversation)**

**Endpoint**: `GET /api/conversations/{phone}`

**Purpose**: Get full conversation history with a specific phone number

**Request Headers**:
```http
GET /api/conversations/+60123456789?limit=100 HTTP/1.1
Host: buzzbridge.aplikasi-io.com
Authorization: Bearer {API_KEY}
Content-Type: application/json
```

**Query Parameters**:
| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `limit` | integer | No | Number of messages (default: 50, max: 200) |
| `before` | string | No | Message ID to paginate before |

**Success Response** (200 OK):
```json
{
  "success": true,
  "data": {
    "phone": "+60123456789",
    "contact_name": "John Doe",
    "messages": [
      {
        "id": "msg_123456",
        "from": "+60123456789",
        "message": "Hi, I want to book a hiking trip",
        "direction": "incoming",
        "timestamp": "2025-10-05T14:25:30Z"
      },
      {
        "id": "msg_123457",
        "from": "+60198765432",
        "message": "Thank you for your inquiry!",
        "direction": "outgoing",
        "timestamp": "2025-10-05T14:26:00Z"
      }
    ],
    "total_messages": 45,
    "has_more": true
  }
}
```

---

### 7️⃣ **Disconnect Session**

**Endpoint**: `POST /api/session/disconnect`

**Purpose**: Logout/disconnect WhatsApp session

**Request Headers**:
```http
POST /api/session/disconnect HTTP/1.1
Host: buzzbridge.aplikasi-io.com
Authorization: Bearer {API_KEY}
Content-Type: application/json
```

**Success Response** (200 OK):
```json
{
  "success": true,
  "data": {
    "session_id": "session_abc123",
    "status": "disconnected",
    "disconnected_at": "2025-10-05T15:00:00Z"
  },
  "message": "Session disconnected successfully"
}
```

---

## 🔔 Required Webhooks (BuzzBridge → OFYS)

### 1️⃣ **Incoming Message Webhook**

**Endpoint**: `POST https://your-ofys.com/api/webhooks/whatsapp`

**Purpose**: BuzzBridge sends this webhook when a new message is received

**Request Headers**:
```http
POST /api/webhooks/whatsapp HTTP/1.1
Host: your-ofys.com
Content-Type: application/json
X-Webhook-Signature: sha256=abc123...
X-BuzzBridge-Event: message.received
```

**Request Body**:
```json
{
  "event": "message.received",
  "timestamp": "2025-10-05T14:25:30Z",
  "data": {
    "message_id": "msg_123456",
    "from": "+60123456789",
    "from_name": "John Doe",
    "to": "+60198765432",
    "message": "Hi, I want to book a hiking trip",
    "message_type": "text",
    "has_media": false,
    "media_url": null,
    "timestamp": "2025-10-05T14:25:30Z"
  }
}
```

**Expected Response** (200 OK):
```json
{
  "success": true,
  "message": "Webhook received"
}
```

**Webhook Signature Verification**:
```php
// OFYS will verify webhook using HMAC SHA256
$signature = hash_hmac('sha256', $requestBody, $webhookSecret);
if ($signature !== $receivedSignature) {
    // Reject webhook
}
```

---

### 2️⃣ **Message Status Update Webhook**

**Endpoint**: `POST https://your-ofys.com/api/webhooks/whatsapp`

**Purpose**: Notify OFYS when message status changes (sent → delivered → read)

**Request Headers**:
```http
POST /api/webhooks/whatsapp HTTP/1.1
Host: your-ofys.com
Content-Type: application/json
X-Webhook-Signature: sha256=abc123...
X-BuzzBridge-Event: message.status
```

**Request Body**:
```json
{
  "event": "message.status",
  "timestamp": "2025-10-05T14:26:00Z",
  "data": {
    "message_id": "msg_789012",
    "status": "read",
    "phone": "+60123456789",
    "updated_at": "2025-10-05T14:26:00Z"
  }
}
```

**Possible Status Values**:
- `sent` - Message sent to WhatsApp servers
- `delivered` - Message delivered to recipient's phone
- `read` - Message read by recipient (blue checkmarks)
- `failed` - Message failed to send

---

### 3️⃣ **Session Status Change Webhook**

**Endpoint**: `POST https://your-ofys.com/api/webhooks/whatsapp`

**Purpose**: Notify OFYS when WhatsApp session status changes

**Request Headers**:
```http
POST /api/webhooks/whatsapp HTTP/1.1
Host: your-ofys.com
Content-Type: application/json
X-Webhook-Signature: sha256=abc123...
X-BuzzBridge-Event: session.status
```

**Request Body**:
```json
{
  "event": "session.status",
  "timestamp": "2025-10-05T14:00:00Z",
  "data": {
    "session_id": "session_abc123",
    "status": "active",
    "phone_number": "+60198765432",
    "connected_at": "2025-10-05T14:00:00Z"
  }
}
```

**Possible Events**:
- `session.connected` - QR code scanned, session active
- `session.disconnected` - Session logged out or expired
- `session.qr_generated` - New QR code generated

---

## 🔒 Security Requirements

### 1. **Webhook Signature Verification**

BuzzBridge must sign all webhook requests using HMAC SHA256:

```javascript
// BuzzBridge Implementation (Node.js example)
const crypto = require('crypto');

function signWebhook(payload, secret) {
  const signature = crypto
    .createHmac('sha256', secret)
    .update(JSON.stringify(payload))
    .digest('hex');
  
  return `sha256=${signature}`;
}

// Include in webhook request header
headers['X-Webhook-Signature'] = signWebhook(payload, webhookSecret);
```

### 2. **HTTPS Only**

- All API endpoints must use HTTPS (TLS 1.2+)
- Reject HTTP requests

### 3. **Rate Limiting**

Recommended rate limits:
- API requests: 100 requests per minute per API key
- Webhook retries: 3 attempts with exponential backoff (1s, 5s, 15s)

### 4. **API Key Rotation**

- Support API key regeneration without downtime
- Allow multiple active API keys for smooth rotation

---

## 📊 Webhook Retry Logic

If OFYS webhook endpoint fails, BuzzBridge should retry:

1. **Retry 1**: After 1 second
2. **Retry 2**: After 5 seconds
3. **Retry 3**: After 15 seconds
4. **Give up**: After 3 failed attempts

**Retry Conditions**:
- HTTP 5xx errors (server errors)
- Network timeouts (> 30 seconds)
- Connection refused

**Don't Retry**:
- HTTP 4xx errors (client errors)
- HTTP 200 OK (success)

---

## 🧪 Testing & Sandbox

### Test API Endpoint
```
https://buzzbridge-sandbox.aplikasi-io.com/api
```

### Test Credentials
- API Key: `bzb_test_xxxxxxxxxxxxxxxxxxxxxxxx`
- Webhook Secret: `test_secret_key_123`

### Test Phone Numbers
BuzzBridge should provide test phone numbers that simulate:
- Incoming messages
- Message status updates
- Session disconnections

Example test numbers:
- `+60100000001` - Always responds with "Test reply"
- `+60100000002` - Simulates message delivery delay
- `+60100000003` - Simulates failed message

---

## 📋 Configuration in OFYS Admin Panel

OFYS admin will configure BuzzBridge integration via:

**Admin Panel → Developers → Integration → WhatsApp Web.js**

Required fields:
1. **API URL**: `https://buzzbridge.aplikasi-io.com/api`
2. **API Key**: `bzb_live_xxxxxxxxxxxxxxxxxxxxxxxx`
3. **Webhook Secret**: `your_webhook_secret_key`
4. **QR Endpoint**: `https://buzzbridge.aplikasi-io.com/api/qr`
5. **Webhook URL**: `https://your-ofys.com/api/webhooks/whatsapp` (auto-generated)

---

## 🔍 Error Handling

### Standard Error Response Format

All error responses should follow this format:

```json
{
  "success": false,
  "error": {
    "code": "ERROR_CODE",
    "message": "Human-readable error message",
    "details": {
      "field": "Additional context if needed"
    }
  }
}
```

### Common Error Codes

| Code | HTTP Status | Description |
|------|-------------|-------------|
| `UNAUTHORIZED` | 401 | Invalid or missing API key |
| `FORBIDDEN` | 403 | API key doesn't have permission |
| `NOT_FOUND` | 404 | Resource not found |
| `VALIDATION_ERROR` | 400 | Invalid request parameters |
| `SESSION_INACTIVE` | 400 | WhatsApp session not connected |
| `RATE_LIMIT_EXCEEDED` | 429 | Too many requests |
| `INTERNAL_ERROR` | 500 | Server error |
| `SERVICE_UNAVAILABLE` | 503 | Service temporarily down |

---

## 📞 Support & Contact

For BuzzBridge integration support:
- **Documentation**: https://buzzbridge.aplikasi-io.com/docs
- **API Status**: https://status.buzzbridge.aplikasi-io.com
- **Support Email**: support@buzzbridge.aplikasi-io.com
- **Developer Portal**: https://buzzbridge.aplikasi-io.com/developers

---

## 📝 Changelog

### Version 1.0 (October 5, 2025)
- Initial integration specification
- Core API endpoints defined
- Webhook events documented
- Security requirements outlined

---

## ✅ Integration Checklist

Before going live, ensure BuzzBridge provides:

- [ ] API Key generation in admin panel
- [ ] QR code generation endpoint (`GET /api/qr`)
- [ ] Session status endpoint (`GET /api/session/status`)
- [ ] Fetch messages endpoint (`GET /api/messages`)
- [ ] Send message endpoint (`POST /api/messages/send`)
- [ ] Mark as read endpoint (`POST /api/messages/{id}/read`)
- [ ] Conversation history endpoint (`GET /api/conversations/{phone}`)
- [ ] Disconnect session endpoint (`POST /api/session/disconnect`)
- [ ] Incoming message webhook (to OFYS)
- [ ] Message status webhook (to OFYS)
- [ ] Session status webhook (to OFYS)
- [ ] HMAC SHA256 webhook signature
- [ ] HTTPS/TLS support
- [ ] Rate limiting implementation
- [ ] Webhook retry logic
- [ ] Test/sandbox environment
- [ ] API documentation
- [ ] Error handling standards

---

**Document Status**: ✅ Complete  
**Last Review**: October 5, 2025  
**Next Review**: When BuzzBridge API updates

---

*This document is maintained by the OFYS development team. For questions or clarifications, please contact the OFYS technical team.*

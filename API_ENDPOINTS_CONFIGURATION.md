# 🌐 OFYS - API Endpoints & Domain Configuration

**Domain**: gooutdoor.asia  
**Date**: October 6, 2025

---

## ✅ GOOD NEWS: MOST APIs AUTO-ADJUST!

**Answer: YES, all internal API endpoints will automatically use `gooutdoor.asia` when you set `APP_URL` in `.env`!**

Laravel uses the `APP_URL` environment variable to generate all URLs dynamically. You don't need to manually update each endpoint! 🎉

---

## 🔧 WHAT YOU NEED TO CONFIGURE

### 1️⃣ **Main Configuration (.env file)**

**ONLY ONE SETTING NEEDED:**

```env
APP_URL=https://gooutdoor.asia
```

**That's it!** All these will automatically use `gooutdoor.asia`:
- ✅ Payment callback URLs
- ✅ API endpoints
- ✅ Asset URLs
- ✅ Email links
- ✅ Internal routes

---

## 📍 API ENDPOINTS BREAKDOWN

### **Internal APIs (Auto-Generated from APP_URL)**

These will **automatically** use `https://gooutdoor.asia`:

#### Admin APIs
```
GET  https://gooutdoor.asia/api/admin/dashboard
GET  https://gooutdoor.asia/api/admin/providers
GET  https://gooutdoor.asia/api/admin/customers
GET  https://gooutdoor.asia/api/admin/bookings
```

#### Customer APIs
```
POST https://gooutdoor.asia/api/customer/bookings
GET  https://gooutdoor.asia/api/customer/bookings/{id}
```

#### Provider APIs
```
GET  https://gooutdoor.asia/api/provider/activities
POST https://gooutdoor.asia/api/provider/activities
```

#### Payment APIs (Billplz)
```
POST https://gooutdoor.asia/payment/callback    ← Billplz sends here
GET  https://gooutdoor.asia/payment/return      ← User redirected here
GET  https://gooutdoor.asia/payment/initiate/{id}
GET  https://gooutdoor.asia/payment/success/{id}
GET  https://gooutdoor.asia/payment/failed/{id}
GET  https://gooutdoor.asia/payment/receipt/{id}
GET  https://gooutdoor.asia/payment/status/{id}
POST https://gooutdoor.asia/payment/retry/{id}
```

#### Webhook APIs
```
POST https://gooutdoor.asia/api/webhooks/whatsapp  ← BuzzBridge sends here
POST https://gooutdoor.asia/api/webhooks/n8n       ← N8N sends here
```

---

### **External APIs (You Configure These)**

These are **external services** - you provide THEIR URLs:

#### 1. Billplz API (Payment Gateway)
```env
# Sandbox (for testing)
BILLPLZ_API_URL=https://www.billplz-sandbox.com/api

# Production (when live)
BILLPLZ_API_URL=https://www.billplz.com/api
```

**What it does:**
- Your site sends payment requests TO Billplz
- Billplz processes payment
- Billplz sends callback TO your site

**Configuration needed:**
1. In `.env`: Set `BILLPLZ_API_URL`
2. In Billplz Dashboard: Set callback URL to `https://gooutdoor.asia/payment/callback`

---

#### 2. WhatsApp API (BuzzBridge)
```env
WHATSAPP_API_URL=https://buzzbridge.aplikasi-io.com/api
WHATSAPP_WEBHOOK_URL=https://gooutdoor.asia/api/webhooks/whatsapp
WHATSAPP_QR_ENDPOINT=/qr
```

**What it does:**
- Your site fetches messages FROM BuzzBridge
- Your site sends messages TO BuzzBridge
- BuzzBridge sends new messages TO your webhook

**Configuration needed:**
1. In `.env`: Set `WHATSAPP_API_URL` (BuzzBridge's URL)
2. In `.env`: Set `WHATSAPP_WEBHOOK_URL` (your webhook URL)
3. In BuzzBridge Dashboard: Set webhook to `https://gooutdoor.asia/api/webhooks/whatsapp`

---

#### 3. N8N API (Automation)
```env
N8N_API_URL=https://your-n8n-instance.com/api
N8N_WEBHOOK_URL=https://your-n8n-instance.com/webhook
N8N_WORKFLOW_ID=your_workflow_id
```

**What it does:**
- Your site triggers N8N workflows
- N8N can send data back to your site

**Configuration needed:**
1. In `.env`: Set `N8N_API_URL` (your N8N instance URL)
2. In `.env`: Set `N8N_WEBHOOK_URL` (N8N webhook URL)

---

## 🎯 PRODUCTION .ENV CONFIGURATION

### Complete Production Configuration

```env
# ============================================
# APPLICATION SETTINGS
# ============================================
APP_NAME=OFYS
APP_ENV=production
APP_KEY=base64:SfLbvGKUNkdG4VC1EIU/j6aa+y/v2GQv8A50/lRLx/w=
APP_DEBUG=false
APP_URL=https://gooutdoor.asia          ← MAIN SETTING!

# ============================================
# DATABASE (Your cPanel MySQL)
# ============================================
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=yourusername_dbofys
DB_USERNAME=yourusername_dbofys_user
DB_PASSWORD=your_strong_password

# ============================================
# SESSION (Use your domain)
# ============================================
SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_DOMAIN=.gooutdoor.asia          ← Allows subdomains

# ============================================
# BILLPLZ PAYMENT GATEWAY
# ============================================
# For Testing (Sandbox)
BILLPLZ_API_KEY=your_sandbox_api_key
BILLPLZ_API_URL=https://www.billplz-sandbox.com/api
BILLPLZ_COLLECTION_ID=your_collection_id
BILLPLZ_X_SIGNATURE_KEY=your_x_signature_key

# For Production (Live Payments)
# BILLPLZ_API_KEY=your_production_api_key
# BILLPLZ_API_URL=https://www.billplz.com/api
# BILLPLZ_COLLECTION_ID=your_production_collection_id
# BILLPLZ_X_SIGNATURE_KEY=your_production_x_signature_key

# ============================================
# WHATSAPP INTEGRATION (BuzzBridge)
# ============================================
WHATSAPP_API_URL=https://buzzbridge.aplikasi-io.com/api
WHATSAPP_API_KEY=your_buzzbridge_api_key
WHATSAPP_WEBHOOK_URL=https://gooutdoor.asia/api/webhooks/whatsapp
WHATSAPP_SECRET_KEY=your_secret_key
WHATSAPP_QR_ENDPOINT=/qr

# ============================================
# N8N AUTOMATION (Optional)
# ============================================
N8N_API_URL=https://your-n8n-instance.com/api
N8N_WEBHOOK_URL=https://your-n8n-instance.com/webhook
N8N_API_KEY=your_n8n_api_key
N8N_WORKFLOW_ID=your_workflow_id

# ============================================
# EMAIL CONFIGURATION
# ============================================
MAIL_MAILER=smtp
MAIL_HOST=mail.gooutdoor.asia
MAIL_PORT=587
MAIL_USERNAME=noreply@gooutdoor.asia
MAIL_PASSWORD=your_email_password
MAIL_FROM_ADDRESS="noreply@gooutdoor.asia"
MAIL_FROM_NAME="${APP_NAME}"
MAIL_ENCRYPTION=tls
```

---

## 🔗 EXTERNAL SERVICE CONFIGURATION

### 1. Billplz Dashboard Configuration

**Login to Billplz Dashboard:**

1. **Go to Collections**
   - Create collection: "OFYS Bookings"
   - Note the Collection ID

2. **Set Callback URL**
   ```
   Callback URL: https://gooutdoor.asia/payment/callback
   ```

3. **Enable X-Signature**
   - Turn ON X-Signature verification
   - Copy the X-Signature Key

4. **Set Redirect URL** (optional)
   ```
   Redirect URL: https://gooutdoor.asia/payment/return
   ```

5. **Test with Sandbox First**
   - Use sandbox credentials initially
   - Test complete payment flow
   - Switch to production when ready

---

### 2. BuzzBridge Dashboard Configuration

**Login to BuzzBridge Dashboard:**

1. **Set Webhook URL**
   ```
   Webhook URL: https://gooutdoor.asia/api/webhooks/whatsapp
   ```

2. **Get API Credentials**
   - Copy API Key
   - Copy Secret Key

3. **Test Connection**
   - Scan QR code
   - Send test message
   - Verify webhook receives it

---

### 3. N8N Configuration (If Using)

**In your N8N instance:**

1. **Create Workflow**
   - Add webhook node
   - Note the webhook URL

2. **Configure OFYS Integration**
   - Add HTTP Request node
   - Point to: `https://gooutdoor.asia/api/...`

---

## ✅ VERIFICATION CHECKLIST

After deployment, verify these URLs work:

### Public URLs (No Login Required)
- [ ] `https://gooutdoor.asia` - Homepage
- [ ] `https://gooutdoor.asia/activities` - Activities list
- [ ] `https://gooutdoor.asia/login` - Login page
- [ ] `https://gooutdoor.asia/register` - Register page

### Payment URLs (After Booking)
- [ ] `https://gooutdoor.asia/payment/initiate/{id}` - Start payment
- [ ] `https://gooutdoor.asia/payment/callback` - Billplz callback (POST)
- [ ] `https://gooutdoor.asia/payment/success/{id}` - Success page
- [ ] `https://gooutdoor.asia/payment/failed/{id}` - Failed page
- [ ] `https://gooutdoor.asia/payment/receipt/{id}` - Receipt page
- [ ] `https://gooutdoor.asia/payment/status/{id}` - Status page

### Webhook URLs (External Services)
- [ ] `https://gooutdoor.asia/api/webhooks/whatsapp` - BuzzBridge webhook
- [ ] `https://gooutdoor.asia/api/webhooks/n8n` - N8N webhook

### Admin APIs (Requires Admin Login)
- [ ] `https://gooutdoor.asia/api/admin/dashboard` - Dashboard stats
- [ ] `https://gooutdoor.asia/api/admin/providers` - Providers list
- [ ] `https://gooutdoor.asia/api/admin/customers` - Customers list

---

## 🧪 TESTING EXTERNAL INTEGRATIONS

### Test Billplz Integration

```bash
# 1. Create a test booking
# 2. Click "Pay Now with Billplz"
# 3. Should redirect to: https://www.billplz-sandbox.com/bills/xxx
# 4. Complete payment with test credentials
# 5. Should redirect back to: https://gooutdoor.asia/payment/success/{id}
# 6. Billplz should POST to: https://gooutdoor.asia/payment/callback
```

**Test Credentials (Sandbox):**
- Bank: TEST0001 (Success)
- Bank: TEST0002 (Failed)

---

### Test WhatsApp Integration

```bash
# 1. Go to Admin → Developers → WhatsApp Messages
# 2. Click "Fetch Messages"
# 3. Should call: https://buzzbridge.aplikasi-io.com/api/messages
# 4. Messages should display in chat interface
# 5. Send a test reply
# 6. Should POST to: https://buzzbridge.aplikasi-io.com/api/messages/send
```

---

### Test Webhook Reception

```bash
# Test if your webhook can receive data
curl -X POST https://gooutdoor.asia/api/webhooks/whatsapp \
  -H "Content-Type: application/json" \
  -d '{
    "event": "message.received",
    "data": {
      "from": "+60123456789",
      "message": "Test message"
    }
  }'

# Check Laravel logs
tail -f /home/yourusername/ofys/storage/logs/laravel.log
```

---

## 🔒 SECURITY CONSIDERATIONS

### 1. Webhook Security

**Verify webhook authenticity:**

```php
// In your webhook handler
public function handleWebhook(Request $request)
{
    // Verify signature
    $signature = $request->header('X-Signature');
    $expectedSignature = hash_hmac('sha256', 
        $request->getContent(), 
        config('services.whatsapp.secret_key')
    );
    
    if (!hash_equals($expectedSignature, $signature)) {
        abort(403, 'Invalid signature');
    }
    
    // Process webhook...
}
```

### 2. API Rate Limiting

Laravel automatically rate-limits APIs:
- 60 requests per minute for authenticated users
- 10 requests per minute for guests

### 3. HTTPS Only

**Force HTTPS in .htaccess:**
```apache
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

---

## 📊 URL GENERATION IN LARAVEL

### How Laravel Generates URLs

```php
// All these automatically use APP_URL from .env

// Named routes
route('payment.callback')
// → https://gooutdoor.asia/payment/callback

// URL helper
url('/api/webhooks/whatsapp')
// → https://gooutdoor.asia/api/webhooks/whatsapp

// Asset URLs
asset('storage/images/photo.jpg')
// → https://gooutdoor.asia/storage/images/photo.jpg

// API resources
route('api.admin.dashboard')
// → https://gooutdoor.asia/api/admin/dashboard
```

**No manual configuration needed!** 🎉

---

## 🎯 SUMMARY

### What Auto-Adjusts (Just set APP_URL)
✅ All internal API endpoints  
✅ All payment URLs  
✅ All webhook URLs  
✅ All asset URLs  
✅ All email links  
✅ All route URLs  

### What You Must Configure
⚠️ Billplz callback URL (in Billplz dashboard)  
⚠️ BuzzBridge webhook URL (in BuzzBridge dashboard)  
⚠️ External API URLs (in .env)  
⚠️ Email server settings (in .env)  

### Configuration Files
1. **`.env`** - Main configuration (APP_URL, external APIs)
2. **Billplz Dashboard** - Set callback URL
3. **BuzzBridge Dashboard** - Set webhook URL
4. **N8N** - Set workflow webhook (if using)

---

## ✅ FINAL ANSWER

**Q: Do all API endpoints need to be updated for gooutdoor.asia?**

**A: NO! Just set `APP_URL=https://gooutdoor.asia` in your `.env` file, and Laravel will automatically generate all URLs with your domain!**

**The ONLY manual configuration needed:**
1. Set `APP_URL` in `.env`
2. Configure callback URL in Billplz dashboard
3. Configure webhook URL in BuzzBridge dashboard

**Everything else is automatic!** 🚀

---

**Your site will work perfectly at gooutdoor.asia with all APIs functioning correctly!** ✨

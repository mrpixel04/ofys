# 💳 Billplz Payment Gateway Integration Guide

> **For**: OFYS Customer Payment System  
> **Purpose**: Complete guide for Billplz payment integration  
> **Last Updated**: October 5, 2025  
> **Status**: ✅ Backend Complete | 🚧 Frontend Views Pending

---

## 📋 Table of Contents

- [Overview](#-overview)
- [What's Been Implemented](#-whats-been-implemented)
- [Configuration](#-configuration)
- [Database Structure](#-database-structure)
- [Payment Flow](#-payment-flow)
- [API Integration](#-api-integration)
- [Security Features](#-security-features)
- [Testing Guide](#-testing-guide)
- [Frontend Views Needed](#-frontend-views-needed)
- [Troubleshooting](#-troubleshooting)

---

## 🌟 Overview

OFYS now integrates with **Billplz**, Malaysia's leading payment gateway, to process customer bookings securely. The integration supports:

- ✅ **FPX** (Online Banking)
- ✅ **Credit/Debit Cards** (Visa, Mastercard, AMEX)
- ✅ **E-Wallets** (Boost, TNG, GrabPay, ShopeePay)
- ✅ **Secure Callbacks** with X-Signature verification
- ✅ **Payment Status Tracking**
- ✅ **Receipt Generation**
- ✅ **Retry Failed Payments**

---

## ✅ What's Been Implemented

### 1️⃣ **Database Migration** ✅
- **File**: `database/migrations/2025_10_05_060914_add_billplz_payment_fields_to_bookings_table.php`
- **Fields Added**:
  - `billplz_bill_id` - Billplz bill identifier
  - `billplz_collection_id` - Collection ID
  - `billplz_url` - Payment page URL
  - `billplz_transaction_id` - Transaction reference
  - `billplz_transaction_status` - Transaction status
  - `billplz_paid_at` - Payment timestamp
  - `billplz_paid_amount` - Amount paid (in cents)
  - `billplz_x_signature` - Security signature
  - `payment_gateway_response` - Full JSON response
  - `payment_attempts` - Number of attempts
  - `last_payment_attempt` - Last attempt timestamp
- **Status**: ✅ Migrated

### 2️⃣ **Booking Model Updates** ✅
- **File**: `app/Models/Booking.php`
- **New Methods**:
  - `isPending()` - Check if payment pending
  - `isPaid()` - Check if payment completed
  - `isFailed()` - Check if payment failed
  - `getTotalPriceInCents()` - Convert MYR to cents
  - `markAsProcessing()` - Mark payment as processing
  - `markAsPaid()` - Mark payment as successful
  - `markAsFailed()` - Mark payment as failed
- **New Scopes**:
  - `scopePendingPayment()` - Get pending payments
  - `scopePaid()` - Get paid bookings
  - `scopeFailedPayment()` - Get failed payments
- **Status**: ✅ Complete

### 3️⃣ **Billplz Service Class** ✅
- **File**: `app/Services/BillplzService.php`
- **Methods**:
  - `createBill()` - Create bill in Billplz
  - `getBill()` - Retrieve bill details
  - `deleteBill()` - Delete a bill
  - `verifyXSignature()` - Verify webhook signature
  - `processCallback()` - Process payment callback
  - `getPaymentMethods()` - Get available payment methods
  - `getFpxBanks()` - Get FPX bank list
- **Features**:
  - HTTP Basic Auth with API key
  - Comprehensive error logging
  - Security signature verification
  - Automatic booking status updates
- **Status**: ✅ Complete

### 4️⃣ **Payment Controller** ✅
- **File**: `app/Http/Controllers/Customer/PaymentController.php`
- **Routes**:
  - `GET /payment/initiate/{bookingId}` - Start payment
  - `POST /payment/callback` - Billplz callback (webhook)
  - `GET /payment/return` - Redirect after payment
  - `GET /payment/success/{bookingId}` - Success page
  - `GET /payment/failed/{bookingId}` - Failed page
  - `GET /payment/receipt/{bookingId}` - Receipt page
  - `GET /payment/status/{bookingId}` - Status tracking
  - `POST /payment/retry/{bookingId}` - Retry payment
- **Security**:
  - Authentication required (except callback/return)
  - User ownership verification
  - X-Signature validation
  - Duplicate payment prevention
- **Status**: ✅ Complete

### 5️⃣ **Configuration** ✅
- **File**: `config/services.php`
- **Environment Variables**:
  ```env
  BILLPLZ_API_KEY=your_sandbox_api_key
  BILLPLZ_API_URL=https://www.billplz-sandbox.com/api
  BILLPLZ_COLLECTION_ID=your_collection_id
  BILLPLZ_X_SIGNATURE_KEY=your_x_signature_key
  ```
- **Status**: ✅ Complete

### 6️⃣ **Routes** ✅
- **File**: `routes/web.php`
- **Public Routes** (no auth):
  - Callback webhook
  - Return redirect
- **Authenticated Routes**:
  - Payment initiation
  - Success/failed pages
  - Receipt generation
  - Status tracking
  - Payment retry
- **Status**: ✅ Complete

---

## 🔧 Configuration

### Step 1: Get Billplz Credentials

1. **Sign up** at [Billplz Sandbox](https://www.billplz-sandbox.com)
2. **Create a Collection**:
   - Go to **Billing → Collections**
   - Click **Create Collection**
   - Name: "OFYS Bookings"
   - Copy the **Collection ID**
3. **Get API Key**:
   - Go to **Settings → API**
   - Copy your **API Secret Key**
4. **Get X Signature Key**:
   - Go to **Settings → X Signature Key**
   - Generate and copy the key

### Step 2: Configure Environment

Add to `.env`:

```env
# Billplz Payment Gateway (Sandbox)
BILLPLZ_API_KEY=73eb57f0-7d4e-42b9-a544-aeac6e4b0f81
BILLPLZ_API_URL=https://www.billplz-sandbox.com/api
BILLPLZ_COLLECTION_ID=inbmmepb
BILLPLZ_X_SIGNATURE_KEY=S-AbCdEfGhIjKlMnOpQr
```

### Step 3: Set Webhook URL

In Billplz Dashboard:
1. Go to **Settings → Webhooks**
2. Set **Callback URL**: `https://your-domain.com/payment/callback`
3. Enable **X Signature**

---

## 🗄️ Database Structure

### Bookings Table (Extended)

| Field | Type | Description |
|-------|------|-------------|
| `billplz_bill_id` | string | Unique bill ID from Billplz |
| `billplz_collection_id` | string | Collection ID |
| `billplz_url` | string | Payment page URL |
| `billplz_transaction_id` | string | Transaction reference |
| `billplz_transaction_status` | string | paid/failed/pending |
| `billplz_paid_at` | timestamp | Payment completion time |
| `billplz_paid_amount` | integer | Amount in cents (MYR) |
| `billplz_x_signature` | text | Security signature |
| `payment_gateway_response` | json | Full Billplz response |
| `payment_attempts` | integer | Number of payment attempts |
| `last_payment_attempt` | timestamp | Last attempt time |

---

## 🔄 Payment Flow

### Normal Flow (Success)

```
1. Customer creates booking
   ↓
2. Customer clicks "Pay Now"
   ↓
3. System creates Billplz bill
   ↓
4. Customer redirected to Billplz payment page
   ↓
5. Customer selects payment method (FPX/Card/E-Wallet)
   ↓
6. Customer completes payment
   ↓
7. Billplz sends callback to /payment/callback (webhook)
   ↓
8. System verifies X-Signature and updates booking
   ↓
9. Customer redirected to /payment/success
   ↓
10. Customer can view receipt
```

### Failed Payment Flow

```
1-6. Same as above
   ↓
7. Payment fails (insufficient funds, cancelled, etc.)
   ↓
8. Billplz sends callback with paid=false
   ↓
9. System marks booking as failed
   ↓
10. Customer redirected to /payment/failed
   ↓
11. Customer can retry payment
```

---

## 🔌 API Integration

### Create Bill

```php
$billplz = new BillplzService();
$result = $billplz->createBill($booking);

// Response
[
    'success' => true,
    'bill_id' => 'w7zrjjz9',
    'url' => 'https://www.billplz-sandbox.com/bills/w7zrjjz9',
    'data' => [...]
]
```

### Process Callback

```php
$result = $billplz->processCallback($callbackData);

// Response
[
    'success' => true,
    'message' => 'Payment successful',
    'booking' => Booking,
    'paid' => true
]
```

### Verify X Signature

```php
$isValid = $billplz->verifyXSignature($data, $signature);
// Returns: true/false
```

---

## 🔒 Security Features

### 1. X-Signature Verification

All callbacks from Billplz are verified using HMAC SHA256:

```php
// Billplz signs data
$signature = hash_hmac('sha256', $dataString, $xSignatureKey);

// We verify
if (!hash_equals($generatedSignature, $receivedSignature)) {
    // Reject callback
}
```

### 2. User Ownership Verification

```php
$booking = Booking::where('id', $bookingId)
    ->where('user_id', Auth::id())
    ->firstOrFail();
```

### 3. Duplicate Payment Prevention

```php
if ($booking->isPaid()) {
    return 'Payment already processed';
}
```

### 4. Amount Tampering Prevention

- Amount is stored in database before bill creation
- Billplz bill amount is verified against booking amount
- Any mismatch is logged and rejected

### 5. HTTPS Only

- All API calls use HTTPS
- Webhook callbacks require HTTPS
- No plain HTTP allowed

---

## 🧪 Testing Guide

### Sandbox Testing

Billplz Sandbox provides test banks and cards:

#### Test FPX Banks

| Bank Code | Name | Result |
|-----------|------|--------|
| TEST0001 | Test 0001 | Success |
| TEST0002 | Test 0002 | Failed |
| TEST0021 | Test 0021 | Success (B2B) |

#### Test Cards

| Card Number | CVV | Expiry | Result |
|-------------|-----|--------|--------|
| 4111 1111 1111 1111 | 123 | 12/25 | Success |
| 4000 0000 0000 0002 | 123 | 12/25 | Declined |

### Testing Steps

1. **Create a booking** as a customer
2. **Click "Pay Now"** button
3. **Select TEST0001** bank in Billplz
4. **Complete payment**
5. **Verify**:
   - Booking status = `confirmed`
   - Payment status = `done`
   - `billplz_paid_at` is set
   - `billplz_transaction_id` exists
   - Receipt is accessible

---

## 🎨 Frontend Views Needed

### Priority 1: Essential Views

#### 1. Payment Success Page
- **File**: `resources/views/customer/payment/success.blade.php`
- **Route**: `/payment/success/{bookingId}`
- **Content**:
  - ✅ Success message
  - 📋 Booking details
  - 💰 Payment amount
  - 📄 Receipt link
  - 🏠 Return to dashboard button

#### 2. Payment Failed Page
- **File**: `resources/views/customer/payment/failed.blade.php`
- **Route**: `/payment/failed/{bookingId}`
- **Content**:
  - ❌ Failure message
  - 📋 Booking details
  - 🔄 Retry payment button
  - 💬 Contact support link
  - 🏠 Return to dashboard button

#### 3. Payment Receipt Page
- **File**: `resources/views/customer/payment/receipt.blade.php`
- **Route**: `/payment/receipt/{bookingId}`
- **Content**:
  - 🧾 Official receipt header
  - 📋 Booking details
  - 💰 Payment breakdown
  - 🏢 Company details
  - 📅 Payment date/time
  - 🔢 Transaction ID
  - 🖨️ Print button
  - 📧 Email receipt button

### Priority 2: Enhanced Features

#### 4. Payment Status Tracking Page
- **File**: `resources/views/customer/payment/status.blade.php`
- **Route**: `/payment/status/{bookingId}`
- **Content**:
  - 📊 Payment timeline
  - 🔍 Transaction details
  - 📝 Payment gateway response
  - 🔄 Refresh status button
  - 📞 Support contact

#### 5. Booking Detail Enhancement
- **File**: `resources/views/customer/bookings/show.blade.php` (update existing)
- **Add**:
  - 💳 "Pay Now" button (if pending)
  - 🧾 "View Receipt" button (if paid)
  - 📊 "Payment Status" link
  - 🔄 "Retry Payment" button (if failed)

---

## 🎨 Design Guidelines

### Color Scheme (Customer Pages)

- **Success**: Green (#10B981, bg-green-500)
- **Failed**: Red (#EF4444, bg-red-500)
- **Pending**: Yellow (#EAB308, bg-yellow-500)
- **Primary**: Blue (#2563EB, bg-blue-600)

### UI Components

- Use **Tailwind CSS** for styling
- Follow existing OFYS design patterns
- Responsive design (mobile-first)
- Clear call-to-action buttons
- Professional receipt layout

---

## 🔍 Troubleshooting

### Common Issues

#### 1. "Unauthorized" Error

**Problem**: API key is invalid or missing

**Solution**:
```bash
# Check .env file
BILLPLZ_API_KEY=your_actual_key

# Clear config cache
php artisan config:clear
```

#### 2. Callback Not Received

**Problem**: Webhook URL not configured or incorrect

**Solution**:
1. Check Billplz dashboard webhook settings
2. Ensure URL is publicly accessible (not localhost)
3. Use ngrok for local testing:
   ```bash
   ngrok http 8000
   # Use ngrok URL in Billplz webhook settings
   ```

#### 3. X-Signature Verification Failed

**Problem**: X-Signature key mismatch

**Solution**:
```bash
# Verify X-Signature key in .env matches Billplz dashboard
BILLPLZ_X_SIGNATURE_KEY=your_actual_key

# Check logs
tail -f storage/logs/laravel.log
```

#### 4. Payment Already Processed

**Problem**: Duplicate callback received

**Solution**: This is normal. System prevents duplicate processing automatically.

---

## 📊 Monitoring & Logs

### Log Files

All payment activities are logged:

```bash
# View logs
tail -f storage/logs/laravel.log

# Search for payment logs
grep "Billplz" storage/logs/laravel.log
```

### Log Entries

- ✅ Bill created successfully
- ❌ Bill creation failed
- 📞 Callback received
- ✅ Payment successful
- ❌ Payment failed
- ⚠️ Invalid X-Signature

---

## 📈 Next Steps

### Immediate (Required for Production)

1. ✅ Create payment success view
2. ✅ Create payment failed view
3. ✅ Create receipt view
4. ✅ Add "Pay Now" button to booking details
5. ✅ Test complete payment flow

### Future Enhancements

- 📧 Email notifications for payment status
- 📱 SMS notifications
- 🔄 Automatic payment reminders
- 📊 Payment analytics dashboard
- 💰 Refund processing
- 🎁 Promo code support

---

## 📞 Support

### Billplz Support
- **Documentation**: https://www.billplz.com/api
- **Support Email**: support@billplz.com
- **Sandbox**: https://www.billplz-sandbox.com

### OFYS Development Team
- **Technical Lead**: [Your Name]
- **Email**: dev@ofys.com

---

## ✅ Integration Checklist

- [x] Database migration created and run
- [x] Booking model updated with payment methods
- [x] BillplzService class implemented
- [x] PaymentController created
- [x] Routes configured
- [x] Environment variables documented
- [x] Security features implemented
- [ ] Payment success view created
- [ ] Payment failed view created
- [ ] Receipt view created
- [ ] Payment status view created
- [ ] Booking detail page updated
- [ ] Testing completed
- [ ] Production credentials configured
- [ ] Webhook URL configured in Billplz
- [ ] Documentation reviewed

---

**Document Status**: ✅ Complete  
**Last Updated**: October 5, 2025  
**Next Review**: After frontend views completion

---

*This document is maintained by the OFYS development team. For questions or updates, please contact the technical lead.*

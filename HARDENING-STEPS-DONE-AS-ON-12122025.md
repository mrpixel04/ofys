# Hardening Steps Done (as of 12-12-2025)

1. Finding: Missing security headers/CSP/HSTS and no nonce support for scripts.  
   Solution: Added global `SecurityHeaders` middleware with HSTS-on-HTTPS, frame blocking, nosniff, referrer + permissions policies, CSP with CDN allowlist, upgrade-insecure-requests, and per-request nonce shared to views (`$cspNonce`).

2. Finding: Session cookies not enforced secure/encrypted in production.  
   Solution: Enabled session encryption by default and made secure cookies default in production; added production guardrails that log critical if `APP_DEBUG` is on or secure cookies are off.

3. Finding: Auth/payment endpoints lacked rate limiting (brute-force/abuse risk).  
   Solution: Added throttling to login/register/reset, Billplz callback/return, payment initiate/retry to slow abuse.

4. Finding: Billplz callbacks/returns were weakly validated (signature/amount/idempotency).  
   Solution: Introduced FormRequest validation for callback/return, require X-Signature, persist signature/tx data, and reject amount mismatches before marking payments.

5. Finding: Production HTTPS enforcement needed consistency.  
   Solution: Kept `URL::forceScheme('https')` in production to align generated URLs with HTTPS and paired with HSTS.

Next to do (suggested): adopt nonce attributes on inline scripts/styles to remove `'unsafe-inline'`, add WAF/CDN rules (rate limiting, bot/burst control), and rotate secrets with `APP_DEBUG=false`/secure cookie checks verified in prod.

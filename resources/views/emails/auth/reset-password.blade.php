<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Reset Your OFYS Password</title>
</head>
<body style="margin:0;background:#f8fafc;font-family:'Segoe UI',Tahoma,sans-serif;color:#0f172a;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc;padding:32px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="560" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:24px;overflow:hidden;box-shadow:0 30px 70px rgba(15,23,42,0.08);">
                    <tr>
                        <td style="background:#0f172a;padding:32px;text-align:center;">
                            <p style="margin:0;font-size:24px;font-weight:700;color:#facc15;letter-spacing:0.08em;">OFYS</p>
                            <p style="margin:12px 0 0;font-size:18px;font-weight:600;color:#f8fafc;">Secure Access Request</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:36px;">
                            <p style="margin:0;font-size:18px;font-weight:600;">Hello {{ $name }},</p>
                            <p style="margin:16px 0 0;font-size:15px;line-height:1.7;color:#475569;">
                                We received a request to reset your OFYS password. Tap the button below within the next 60 minutes to choose a new password.
                            </p>

                            <table role="presentation" width="100%" style="margin:32px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $actionUrl }}" style="display:inline-block;padding:14px 36px;border-radius:999px;background:linear-gradient(135deg,#0ea5e9,#2563eb);color:#ffffff;font-size:15px;font-weight:700;text-decoration:none;box-shadow:0 14px 30px rgba(37,99,235,0.35);">
                                            Reset Password
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:0;font-size:14px;color:#94a3b8;line-height:1.6;">
                                Button not working? Copy and paste this link into your browser:<br>
                                <span style="color:#0f172a;">{{ $actionUrl }}</span>
                            </p>

                            <p style="margin:24px 0 0;font-size:13px;color:#94a3b8;">
                                Didn’t request this? Your account is still secure—simply ignore this email.
                                Please check your spam folder if you can’t find this message in your inbox.
                            </p>
                            <p style="margin:12px 0 0;font-size:13px;color:#94a3b8;">
                                Need help? Reach us at <a href="mailto:{{ $supportEmail }}" style="color:#f59e0b;text-decoration:none;">{{ $supportEmail }}</a>.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background:#f1f5f9;padding:24px;text-align:center;">
                            <p style="margin:0;font-size:12px;color:#64748b;">© {{ date('Y') }} OFYS - Outdoor For Your Soul. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

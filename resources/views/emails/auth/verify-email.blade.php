<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Verify Your OFYS Email</title>
</head>
<body style="margin:0;background:#f8fafc;font-family:'Segoe UI',Tahoma,sans-serif;color:#0f172a;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc;padding:32px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="560" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:24px;overflow:hidden;box-shadow:0 30px 70px rgba(15,23,42,0.08);">
                    <tr>
                        <td style="background:linear-gradient(135deg,#facc15,#eab308);padding:32px;text-align:center;">
                            <p style="margin:0;font-size:24px;font-weight:700;color:#1e1b4b;letter-spacing:0.08em;">OFYS</p>
                            <p style="margin:12px 0 0;font-size:18px;font-weight:600;color:#1e1b4b;">Welcome to Outdoor For Your Soul</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:36px;">
                            <p style="margin:0;font-size:18px;font-weight:600;">Hi {{ $name }},</p>
                            <p style="margin:16px 0 0;font-size:15px;line-height:1.7;color:#475569;">
                                Thanks for joining OFYS! Click the button below to verify your email and unlock curated outdoor adventures crafted for Malaysian explorers.
                            </p>

                            <table role="presentation" width="100%" style="margin:32px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $actionUrl }}" style="display:inline-block;padding:14px 32px;border-radius:999px;background:linear-gradient(135deg,#facc15,#eab308);color:#1e1b4b;font-size:15px;font-weight:700;text-decoration:none;box-shadow:0 14px 30px rgba(250,204,21,0.35);">
                                            Verify My Email
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:0;font-size:14px;color:#94a3b8;line-height:1.6;">
                                If the button doesn’t work, copy and paste this link into your browser:<br>
                                <span style="color:#0f172a;">{{ $actionUrl }}</span>
                            </p>

                            <p style="margin:28px 0 0;font-size:13px;color:#94a3b8;">
                                Didn’t sign up? You can safely ignore this email. Please check your spam folder if you can’t find us in your inbox.
                            </p>
                            <p style="margin:12px 0 0;font-size:13px;color:#94a3b8;">
                                Need help? Reach us at <a href="mailto:{{ $supportEmail }}" style="color:#f59e0b;text-decoration:none;">{{ $supportEmail }}</a>.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background:#0f172a;padding:24px;text-align:center;">
                            <p style="margin:0;font-size:12px;color:#94a3b8;">© {{ date('Y') }} OFYS - Outdoor For Your Soul. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

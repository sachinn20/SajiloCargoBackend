<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Password Reset Token - Sajilo Cargo</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    <table width="100%" cellspacing="0" cellpadding="0" bgcolor="#f4f4f4" style="padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellspacing="0" cellpadding="0" bgcolor="#ffffff" style="border-radius: 8px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.05);">
                    <tr>
                        <td style="background-color: #004aad; padding: 20px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0;">Sajilo Cargo</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 30px;">
                            <p style="font-size: 16px; color: #333333; margin: 0 0 16px;">Hello,</p>
                            <p style="font-size: 16px; color: #333333; margin: 0 0 16px;">
                                You have requested to reset your password. Please use the token below to proceed:
                            </p>
                            <div style="margin: 24px 0; text-align: center;">
                                <span style="display: inline-block; background-color: #004aad; color: #ffffff; font-size: 24px; padding: 12px 24px; border-radius: 6px; letter-spacing: 2px;">
                                    {{ $token }}
                                </span>
                            </div>
                            <p style="font-size: 14px; color: #555555; margin: 0 0 16px;">
                                This token is valid for <strong>15 minutes</strong>. If you did not request this, please ignore this email.
                            </p>
                            <p style="font-size: 16px; color: #333333; margin-top: 32px;">Thank you,<br><strong>Sajilo Cargo Team</strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color: #f1f1f1; text-align: center; padding: 16px; font-size: 12px; color: #888888;">
                            © {{ date('Y') }} Sajilo Cargo. All rights reserved.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

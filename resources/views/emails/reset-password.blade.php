<p>Hello,</p>

<p>You requested to reset your password. Click the link below to set a new one:</p>

<p>
    <a href="{{ url('/reset-password/' . $token) }}">
        Reset Password
    </a>
</p>

<p>This link will expire in 60 minutes.</p>

<p>If you didn’t request a password reset, you can ignore this email.</p>

<p>Thanks,<br>WTG Team</p>

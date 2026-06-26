<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <style>
    body { font-family: Arial, sans-serif; background: #f4f6f9; margin: 0; padding: 0; }
    .container { max-width: 480px; margin: 40px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
    .header { background: linear-gradient(135deg, #0a2540, #173f66); padding: 30px; text-align: center; }
    .header h1 { color: #fff; margin: 0; font-size: 1.4rem; }
    .header span.cyan { color: #38bdf8; }
    .header span.red { color: #f87171; }
    .body { padding: 32px; text-align: center; }
    .otp-box { display: inline-block; background: #f0f9ff; border: 2px dashed #38bdf8; border-radius: 12px; padding: 16px 40px; margin: 20px 0; }
    .otp-code { font-size: 2.5rem; font-weight: bold; color: #0a2540; letter-spacing: 8px; }
    .note { color: #6b7280; font-size: 0.85rem; margin-top: 16px; }
    .footer { background: #f8fafc; padding: 16px; text-align: center; color: #9ca3af; font-size: 0.75rem; }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h1><span class="cyan">SI</span><span class="red">GANA</span> — Reset Password</h1>
    </div>
    <div class="body">
      <p style="color:#374151;">Gunakan kode OTP berikut untuk mereset password Anda:</p>
      <div class="otp-box">
        <div class="otp-code">{{ $otp }}</div>
      </div>
      <p class="note">Kode ini berlaku selama <strong>10 menit</strong> dan hanya bisa digunakan sekali.</p>
      <p class="note">Jika Anda tidak meminta reset password, abaikan email ini.</p>
    </div>
    <div class="footer">
      &copy; {{ date('Y') }} SIGANA — Sistem Informasi Tanggap Bencana dan Donasi
    </div>
  </div>
</body>
</html>
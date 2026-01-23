<!DOCTYPE html>
<html>
<head>
    <title>Reset Password OTP</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
        <h2 style="color: #4CAF50;">Bufet Coffee - Reset Password</h2>
        <p>Halo,</p>
        <p>Kami menerima permintaan untuk mereset password akun Anda.</p>
        <p>Gunakan kode verifikasi berikut untuk melanjutkan proses:</p>
        
        <div style="background-color: #f4f4f4; padding: 15px; text-align: center; border-radius: 5px; font-size: 24px; font-weight: bold; letter-spacing: 5px; margin: 20px 0;">
            {{ $code }}
        </div>

        <p>Kode ini akan kadaluarsa dalam 10 menit.</p>
        <p>Jika Anda tidak merasa melakukan permintaan ini, silakan abaikan email ini.</p>
        <br>
        <p>Terima kasih,<br>Tim Bufet Coffee</p>
    </div>
</body>
</html>

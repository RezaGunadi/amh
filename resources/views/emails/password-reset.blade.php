<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f6f9fc;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #111827 0%, #1f2937 100%);
            color: #ffffff;
            padding: 30px 20px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }
        .email-body {
            padding: 40px 30px;
        }
        .email-body h2 {
            color: #111;
            font-size: 20px;
            margin-bottom: 20px;
        }
        .email-body p {
            color: #555;
            margin-bottom: 15px;
            line-height: 1.7;
        }
        .reset-button {
            display: inline-block;
            background: linear-gradient(135deg, #111827 0%, #1f2937 100%);
            color: #ffffff !important;
            text-decoration: none;
            padding: 14px 30px;
            border-radius: 8px;
            font-weight: 600;
            margin: 25px 0;
            text-align: center;
            transition: all 0.3s ease;
        }
        .reset-button:hover {
            background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
        }
        .reset-link {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
            word-break: break-all;
            font-family: monospace;
            font-size: 12px;
            color: #495057;
        }
        .warning-box {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .warning-box p {
            margin: 0;
            color: #856404;
            font-size: 14px;
        }
        .email-footer {
            background-color: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }
        .email-footer p {
            margin: 5px 0;
            color: #6c757d;
            font-size: 12px;
        }
        .divider {
            height: 1px;
            background-color: #e9ecef;
            margin: 25px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>🔐 Reset Password</h1>
        </div>
        
        <div class="email-body">
            @if($userName)
                <p>Halo <strong>{{ $userName }}</strong>,</p>
            @else
                <p>Halo,</p>
            @endif
            
            <p>Kami menerima permintaan untuk mereset password akun Anda di <strong>amhriset.com</strong>.</p>
            
            <p>Klik tombol di bawah ini untuk mereset password Anda:</p>
            
            <div style="text-align: center;">
                <a href="{{ $resetUrl }}" class="reset-button">Reset Password</a>
            </div>
            
            <p>Atau salin dan buka link berikut di browser Anda:</p>
            
            <div class="reset-link">
                {{ $resetUrl }}
            </div>
            
            <div class="warning-box">
                <p><strong>⚠️ Penting:</strong> Link ini akan kedaluwarsa dalam 1 jam. Jika Anda tidak meminta reset password, abaikan email ini.</p>
            </div>
            
            @if($expiresAt)
                <p style="font-size: 13px; color: #6c757d;">
                    Link berlaku hingga: <strong>{{ \Carbon\Carbon::parse($expiresAt)->format('d M Y, H:i') }} WIB</strong>
                </p>
            @endif
            
            <div class="divider"></div>
            
            <p style="font-size: 13px; color: #6c757d;">
                Jika tombol tidak berfungsi, salin link di atas dan buka di browser Anda. 
                Jika Anda tidak meminta reset password, tidak ada tindakan yang diperlukan.
            </p>
        </div>
        
        <div class="email-footer">
            <p><strong>amhriset.com</strong></p>
            <p>Riset untuk Keluarga & Pendidikan</p>
            <p style="margin-top: 15px;">
                Email ini dikirim secara otomatis, mohon jangan membalas email ini.
            </p>
        </div>
    </div>
</body>
</html>


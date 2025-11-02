<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Hapus Akun - amhriset' }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 1.8rem;
            margin-bottom: 10px;
        }

        .header p {
            opacity: 0.9;
            font-size: 0.95rem;
        }

        .content {
            padding: 30px;
        }

        .warning-box {
            background: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .warning-box h3 {
            color: #856404;
            margin-bottom: 10px;
            font-size: 1.1rem;
        }

        .warning-box ul {
            margin-left: 20px;
            color: #856404;
        }

        .warning-box li {
            margin-bottom: 8px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .checkbox-group {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 25px;
        }

        .checkbox-group input[type="checkbox"] {
            margin-top: 4px;
            width: auto;
        }

        .checkbox-group label {
            font-weight: normal;
            color: #555;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }

        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }

        .btn {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
            margin-top: 10px;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        .user-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .user-info p {
            margin-bottom: 5px;
            color: #666;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #667eea;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .container {
                margin: 20px auto;
            }

            .content {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🗑️ Hapus Akun</h1>
            <p>Hapus akun Anda secara permanen</p>
        </div>

        <div class="content">
            @if(session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="error-message">
                    <strong>Terjadi kesalahan:</strong>
                    <ul style="margin-top: 8px; margin-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(isset($user) && $user)
                <div class="user-info">
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Nama:</strong> {{ $user->name }}</p>
                    @if($user->hp)
                        <p><strong>No. HP:</strong> {{ $user->hp }}</p>
                    @endif
                </div>

                <div class="warning-box">
                    <h3>⚠️ Peringatan Penting</h3>
                    <ul>
                        <li>Penghapusan akun bersifat <strong>permanen dan tidak dapat dibatalkan</strong></li>
                        <li>Semua data akun akan dihapus: email, username, nomor HP</li>
                        <li>Riwayat, favorites, dan data terkait akun akan ikut terhapus</li>
                        <li>Anda tidak dapat menggunakan email atau username yang sama untuk registrasi ulang</li>
                    </ul>
                </div>

                <form method="POST" action="{{ route('delete-account.process') }}">
                    @csrf
                    
                    <input type="hidden" name="token" value="{{ $token ?? request('token') }}">

                    <div class="form-group">
                        <label for="password">Masukkan Password untuk Konfirmasi</label>
                        <input type="password" id="password" name="password" required 
                               placeholder="Password Anda" autocomplete="current-password">
                    </div>

                    <div class="checkbox-group">
                        <input type="checkbox" id="confirmation" name="confirmation" value="1" required>
                        <label for="confirmation">
                            Saya memahami bahwa penghapusan akun bersifat <strong>permanen</strong> dan 
                            tidak dapat dibatalkan. Saya setuju untuk menghapus akun saya.
                        </label>
                    </div>

                    <button type="submit" class="btn btn-danger">
                        🗑️ Hapus Akun Saya Secara Permanen
                    </button>
                </form>
            @else
                <div class="error-message">
                    <strong>Token tidak valid atau akun tidak ditemukan.</strong>
                    <p style="margin-top: 8px;">Silakan gunakan link yang diberikan dari aplikasi atau hubungi support.</p>
                </div>
            @endif

            <div class="back-link">
                <a href="/">← Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</body>
</html>

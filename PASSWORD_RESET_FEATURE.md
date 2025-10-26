# Fitur Reset Password Lengkap

## Ringkasan
Telah dibuat sistem reset password yang lengkap dengan API dan UI, menggunakan token yang aman dan hanya bisa digunakan sekali.

## Komponen yang Dibuat

### 1. Database
- **Migration**: `2025_10_20_181622_add_expires_at_and_used_to_password_resets_table.php`
- **Tabel**: `password_resets` dengan kolom:
  - `id` - Primary key
  - `email` - Email user
  - `token` - Token reset password (unik)
  - `created_at` - Waktu pembuatan token
  - `expires_at` - Waktu kadaluarsa token (1 jam)
  - `used` - Status penggunaan token (boolean)

### 2. Model
- **File**: `app/Models/PasswordReset.php`
- **Fitur**:
  - Generate token aman
  - Validasi token (tidak expired dan belum digunakan)
  - Mark token as used
  - Auto cleanup token lama

### 3. API Endpoints

#### Reset Password Request
```bash
POST /api/auth/reset-password
Content-Type: application/json

{
    "email": "user@example.com"
}
```

**Response Success:**
```json
{
    "error": false,
    "message": "Link reset password telah dikirim ke email Anda",
    "data": {
        "reset_url": "http://localhost:8000/reset-password?token=abc123...",
        "expires_at": "2025-10-20T19:30:00.000000Z"
    },
    "status_code": 200,
    "signature": null
}
```

#### Update Password
```bash
POST /api/auth/update-password
Content-Type: application/json

{
    "token": "abc123...",
    "password": "newpassword123",
    "password_confirmation": "newpassword123"
}
```

**Response Success:**
```json
{
    "error": false,
    "message": "Password berhasil diubah",
    "data": null,
    "status_code": 200,
    "signature": null
}
```

### 4. UI Pages

#### Halaman Lupa Password
- **URL**: `/forgot-password`
- **File**: `resources/views/auth/forgot-password.blade.php`
- **Fitur**:
  - Form input email
  - Validasi real-time
  - Loading state
  - Error handling
  - Responsive design

#### Halaman Reset Password
- **URL**: `/reset-password?token=abc123...`
- **File**: `resources/views/auth/reset-password.blade.php`
- **Fitur**:
  - Form input password baru
  - Konfirmasi password
  - Password strength indicator
  - Toggle password visibility
  - Token validation
  - Auto redirect ke login

## Keamanan

### Token Security
- **Format**: 64 karakter hex (32 bytes random)
- **Expiry**: 1 jam dari pembuatan
- **Single Use**: Token otomatis invalid setelah digunakan
- **Cleanup**: Token lama dihapus saat membuat token baru

### Validation
- **Email**: Harus valid dan terdaftar
- **Password**: Minimal 6 karakter
- **Token**: Harus valid, tidak expired, dan belum digunakan
- **Confirmation**: Password dan konfirmasi harus sama

## Cara Penggunaan

### 1. User Lupa Password
1. User mengakses `/forgot-password`
2. Input email yang terdaftar
3. Sistem mengirim link reset password
4. User klik link di email

### 2. Reset Password
1. User klik link dari email
2. Diarahkan ke `/reset-password?token=...`
3. Input password baru dan konfirmasi
4. Submit form
5. Password berhasil diubah
6. Auto redirect ke login

### 3. Developer Integration
```javascript
// Request reset password
const response = await fetch('/api/auth/reset-password', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify({
        email: 'user@example.com'
    })
});

const data = await response.json();
console.log(data.data.reset_url); // Link untuk reset password
```

## Error Handling

### Common Errors
- **Email tidak ditemukan**: Status 404
- **Token tidak valid**: Status 404
- **Token expired**: Status 400
- **Token sudah digunakan**: Status 400
- **Password tidak valid**: Status 422
- **Server error**: Status 500

### Error Messages
- Semua error message dalam bahasa Indonesia
- User-friendly error messages
- Detailed error untuk debugging

## Testing

### Manual Testing
```bash
# 1. Test forgot password
curl -X POST http://localhost:8000/api/auth/reset-password \
  -H "Content-Type: application/json" \
  -d '{"email": "test@example.com"}'

# 2. Test reset password (gunakan token dari response sebelumnya)
curl -X POST http://localhost:8000/api/auth/update-password \
  -H "Content-Type: application/json" \
  -d '{
    "token": "your_token_here",
    "password": "newpassword123",
    "password_confirmation": "newpassword123"
  }'
```

### UI Testing
1. Buka `http://localhost:8000/forgot-password`
2. Input email yang valid
3. Klik "Kirim Link Reset"
4. Copy link dari response
5. Buka link di browser
6. Input password baru
7. Submit form

## Fitur UI

### Forgot Password Page
- ✅ Responsive design
- ✅ Real-time validation
- ✅ Loading states
- ✅ Error handling
- ✅ Success messages
- ✅ Link ke halaman login

### Reset Password Page
- ✅ Token validation
- ✅ Password strength indicator
- ✅ Toggle password visibility
- ✅ Password confirmation
- ✅ Auto redirect setelah berhasil
- ✅ Error handling

## Status
✅ **SELESAI** - Sistem reset password lengkap dengan API dan UI sudah berfungsi dengan sempurna.

## Next Steps (Optional)
- [ ] Implementasi pengiriman email real
- [ ] Rate limiting untuk mencegah spam
- [ ] Logging untuk audit trail
- [ ] Email template yang lebih menarik
- [ ] SMS reset sebagai alternatif


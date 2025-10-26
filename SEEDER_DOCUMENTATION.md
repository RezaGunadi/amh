# 🗄️ Seeder Documentation - Test Data untuk Child Care App

## 📋 Overview

Seeder ini dibuat untuk menyediakan data test yang lengkap untuk aplikasi Child Care, termasuk akun test Google Console dengan data sensor yang realistis.

## 🚀 Cara Menjalankan Seeder

### Method 1: Menggunakan Artisan Command
```bash
cd api_kelas_privat
php artisan db:seed --class=TestUserSeeder
php artisan db:seed --class=GoogleConsoleSeeder
```

### Method 2: Menggunakan Script Custom
```bash
cd api_kelas_privat
php run_seeders.php
```

### Method 3: Menjalankan Semua Seeder
```bash
cd api_kelas_privat
php artisan db:seed
```

## 👤 Akun Test yang Dibuat

### 1. **Test User Google Console**
- **Email**: `testuser@test.com`
- **Password**: `123456`
- **Role**: `user`
- **Phone**: `081234567890`
- **Devices**: TEST001, TEST002, TEST003

### 2. **Admin Test User**
- **Email**: `admin@test.com`
- **Password**: `admin123`
- **Role**: `admin`
- **Phone**: `081234567891`
- **Devices**: ADMIN01

### 3. **Demo User IoT**
- **Email**: `demo@test.com`
- **Password**: `demo123`
- **Role**: `user`
- **Phone**: `081234567892`
- **Devices**: DEMO01

### 4. **Google Console Test User**
- **Email**: `google.console@test.com`
- **Password**: `google123`
- **Role**: `user`
- **Phone**: `081234567899`
- **Devices**: GOOGLE01, GOOGLE02, GOOGLE03, GOOGLE04, GOOGLE05

## 🔧 Device Tokens dan Deskripsi

### General Test Devices

| Token | Device Name | Description | Data Points |
|-------|-------------|-------------|-------------|
| `TEST001` | Test Device Temperature Monitor | Monitor suhu dengan sensor multi-port | 50 |
| `TEST002` | Test Device Humidity Sensor | Sensor kelembaban dengan monitoring | 50 |
| `TEST003` | Test Device Heart Rate Monitor | Monitor detak jantung | 50 |
| `ADMIN01` | Admin IoT Device | Device admin untuk testing | 50 |
| `DEMO01` | Demo Smart Home Device | Device demo smart home | 50 |

### Google Console Devices

| Token | Device Name | Description | Data Points |
|-------|-------------|-------------|-------------|
| `GOOGLE01` | Google Console Temperature Sensor | Sensor suhu Google Console | 100 |
| `GOOGLE02` | Google Console Humidity Monitor | Monitor kelembaban Google Console | 100 |
| `GOOGLE03` | Google Console Heart Rate Monitor | Monitor detak jantung Google Console | 100 |
| `GOOGLE04` | Google Console Smart Home Hub | Hub smart home Google Console | 100 |
| `GOOGLE05` | Google Console Weather Station | Stasiun cuaca Google Console | 100 |

## 📊 Data Sensor yang Dibuat

### Sensor Types
- **Temperature** (°C): 18-40°C
- **Humidity** (%): 30-100%
- **Light** (lux): 50-1000 lux
- **Voltage** (V): 3.0-5.0V
- **Current** (A): 0.02-0.6A
- **Weight** (g): 20-1000g
- **Distance** (cm): 2-100cm

### Data Characteristics
- **Total Data Points**: 750 (50 per device × 5 general devices + 100 per device × 5 Google devices)
- **Time Range**: 30 hari terakhir
- **Location**: Jakarta area dengan variasi kecil
- **Realistic Values**: Data sensor yang realistis sesuai dengan tipe device

## 🧪 Testing Scenarios

### 1. **Authentication Testing**
```bash
# Test login dengan akun Google Console
POST /api/login
{
  "email": "google.console@test.com",
  "password": "google123"
}
```

### 2. **Device List Testing**
```bash
# Get device list untuk Google Console user
GET /api/arduino/get-dht-pulse/{token}
```

### 3. **Sensor Data Testing**
```bash
# Get sensor data untuk device GOOGLE01
GET /api/arduino/get-dht-pulse/detail/GOOGLE01
```

### 4. **Add Device Testing**
```bash
# Add new device
POST /api/arduino/device/input/{mobile_token}
{
  "address": "NEW_DEVICE_001",
  "name": "New Test Device"
}
```

## 📱 Flutter App Testing

### Login dengan Akun Google Console
1. Buka aplikasi Flutter
2. Masukkan email: `google.console@test.com`
3. Masukkan password: `google123`
4. Login berhasil dan akan melihat 5 devices Google Console

### Test Device Management
1. Login dengan akun Google Console
2. Lihat daftar devices (GOOGLE01-GOOGLE05)
3. Klik device untuk melihat data sensor
4. Data akan menampilkan 100 data points per device

### Test Charts
1. Pilih device GOOGLE01 (Temperature Sensor)
2. Lihat chart temperature, humidity, light, dll
3. Data akan menampilkan grafik yang realistis

## 🔍 Data Verification

### Check Users
```sql
SELECT id, name, email, role, is_active FROM users WHERE email LIKE '%@test.com';
```

### Check Devices
```sql
SELECT id, user_id, token, name, user_name FROM tools_address WHERE name LIKE '%Test%' OR name LIKE '%Google%';
```

### Check Sensor Data
```sql
SELECT token_id, COUNT(*) as data_count FROM api_arduinos WHERE token_id LIKE 'TEST%' OR token_id LIKE 'GOOGLE%' GROUP BY token_id;
```

## 🛠️ Customization

### Menambah Device Baru
Edit file `TestUserSeeder.php` atau `GoogleConsoleSeeder.php`:

```php
// Tambahkan device baru
$newDevice = [
    'user_id' => $userId,
    'token' => 'NEW_TOKEN',
    'name' => 'New Device Name',
    'user_name' => 'User Name',
    'is_deleted' => 0,
    'created_at' => now(),
    'updated_at' => now(),
];
```

### Menambah Data Sensor
Edit method `createSensorData()` atau `createGoogleConsoleSensorData()`:

```php
// Tambahkan data sensor baru
$sensorData = [
    'token_id' => 'NEW_TOKEN',
    'port0' => 25.5,
    'type0' => 'temperatur',
    // ... other fields
];
```

## 🚨 Troubleshooting

### Error: "Class not found"
```bash
# Pastikan autoload sudah di-update
composer dump-autoload
```

### Error: "Database connection failed"
```bash
# Pastikan database sudah dibuat dan .env sudah dikonfigurasi
php artisan migrate
```

### Error: "Seeder already exists"
```bash
# Clear data existing terlebih dahulu
php artisan migrate:fresh --seed
```

## 📈 Performance Notes

- **Total Records**: ~800 records (4 users + 10 devices + 750 sensor data)
- **Execution Time**: ~5-10 detik
- **Memory Usage**: ~50MB
- **Database Size**: ~2-5MB

## 🎯 Next Steps

1. **Run seeder** untuk membuat data test
2. **Test Flutter app** dengan akun Google Console
3. **Verify data** di database
4. **Test semua fitur** aplikasi
5. **Customize data** sesuai kebutuhan

## 📞 Support

Jika ada masalah dengan seeder, periksa:
1. Database connection
2. Migration status
3. File permissions
4. PHP version compatibility

**Seeder siap digunakan untuk testing aplikasi Child Care!** 🚀



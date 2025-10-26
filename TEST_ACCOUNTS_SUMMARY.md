# 🎯 Test Accounts & Data Summary - Child Care App

## ✅ Seeder Berhasil Dijalankan!

Data test telah berhasil dibuat dengan total:
- **4 Users** (akun test)
- **8 Devices** (perangkat IoT)
- **650 Sensor Data Points** (data sensor realistis)

## 👤 Akun Test yang Tersedia

### 1. **Google Console Test User** (Recommended)
- **Email**: `google.console@test.com`
- **Password**: `google123`
- **Role**: `user`
- **Phone**: `081234567899`
- **Devices**: 5 devices (GOOGLE01-GOOGLE05)
- **Data Points**: 500 (100 per device)

### 2. **Test User Google Console**
- **Email**: `testuser@test.com`
- **Password**: `123456`
- **Role**: `user`
- **Phone**: `081234567890`
- **Devices**: 3 devices (TEST001-TEST003)
- **Data Points**: 150 (50 per device)

### 3. **Admin Test User**
- **Email**: `admin@test.com`
- **Password**: `admin123`
- **Role**: `admin`
- **Phone**: `081234567891`
- **Devices**: 1 device (ADMIN01)
- **Data Points**: 50

### 4. **Demo User IoT**
- **Email**: `demo@test.com`
- **Password**: `demo123`
- **Role**: `user`
- **Phone**: `081234567892`
- **Devices**: 1 device (DEMO01)
- **Data Points**: 50

## 🔧 Device Tokens & Descriptions

### Google Console Devices (Recommended for Testing)

| Token | Device Name | Description | Data Points | Sensor Types |
|-------|-------------|-------------|-------------|--------------|
| `GOOGLE01` | Google Console Temperature Sensor | High-precision temperature monitoring | 100 | Temp, Humidity, Light, Voltage, Current, Weight, Distance |
| `GOOGLE02` | Google Console Humidity Monitor | Advanced humidity tracking | 100 | Humidity, Temp, Light, Voltage, Current, Weight, Distance |
| `GOOGLE03` | Google Console Heart Rate Monitor | Medical-grade heart rate monitoring | 100 | Heart Rate, Humidity, Light, Voltage, Current, Weight, Distance |
| `GOOGLE04` | Google Console Smart Home Hub | Central smart home control | 100 | Temp, Humidity, Light, Voltage, Current, Weight, Distance |
| `GOOGLE05` | Google Console Weather Station | Professional weather monitoring | 100 | Temp, Humidity, Light, Voltage, Current, Weight, Distance |

### General Test Devices

| Token | Device Name | Description | Data Points | Sensor Types |
|-------|-------------|-------------|-------------|--------------|
| `TEST001` | Test Device Temperature Monitor | Basic temperature monitoring | 50 | Temp, Humidity, Light, Voltage, Current, Weight, Distance |
| `TEST002` | Test Device Humidity Sensor | Basic humidity monitoring | 50 | Humidity, Temp, Light, Voltage, Current, Weight, Distance |
| `TEST003` | Test Device Heart Rate Monitor | Basic heart rate monitoring | 50 | Heart Rate, Humidity, Light, Voltage, Current, Weight, Distance |
| `ADMIN01` | Admin IoT Device | Admin testing device | 50 | Temp, Humidity, Light, Voltage, Current, Weight, Distance |
| `DEMO01` | Demo Smart Home Device | Demo smart home device | 50 | Temp, Humidity, Light, Voltage, Current, Weight, Distance |

## 📊 Sensor Data Characteristics

### Data Range (Realistic Values)
- **Temperature**: 18-40°C
- **Humidity**: 30-100%
- **Light**: 50-1000 lux
- **Voltage**: 3.0-5.0V
- **Current**: 0.02-0.6A
- **Weight**: 20-1000g
- **Distance**: 2-100cm
- **Heart Rate**: 60-180 BPM

### Data Distribution
- **Time Range**: 30 hari terakhir
- **Location**: Jakarta area dengan variasi kecil
- **Frequency**: Data setiap beberapa menit
- **Quality**: Realistic sensor values

## 🧪 Testing Scenarios

### 1. **Login Testing**
```bash
# Test dengan akun Google Console
Email: google.console@test.com
Password: google123
```

### 2. **Device List Testing**
- Login dengan akun Google Console
- Lihat 5 devices (GOOGLE01-GOOGLE05)
- Setiap device memiliki 100 data points

### 3. **Sensor Data Testing**
- Pilih device GOOGLE01 (Temperature Sensor)
- Lihat data temperature, humidity, light, dll
- Data menampilkan grafik yang realistis

### 4. **Chart Testing**
- Pilih device GOOGLE03 (Heart Rate Monitor)
- Lihat chart heart rate dengan data 60-180 BPM
- Data menampilkan variasi yang realistis

## 📱 Flutter App Testing Steps

### Step 1: Login
1. Buka aplikasi Flutter
2. Masukkan email: `google.console@test.com`
3. Masukkan password: `google123`
4. Klik Login

### Step 2: View Devices
1. Setelah login, akan melihat 5 devices Google Console
2. Setiap device menampilkan nama dan status
3. Klik device untuk melihat detail

### Step 3: View Sensor Data
1. Pilih device GOOGLE01 (Temperature Sensor)
2. Lihat data sensor dengan chart
3. Data menampilkan temperature, humidity, light, dll

### Step 4: Test Charts
1. Pilih device GOOGLE03 (Heart Rate Monitor)
2. Lihat chart heart rate
3. Data menampilkan variasi 60-180 BPM

## 🔍 Data Verification Queries

### Check Users
```sql
SELECT id, name, email, role, is_active FROM users WHERE email LIKE '%@test.com';
```

### Check Devices
```sql
SELECT id, user_id, token, name, user_name FROM tools_address WHERE token LIKE 'GOOGLE%' OR token LIKE 'TEST%';
```

### Check Sensor Data
```sql
SELECT token_id, COUNT(*) as data_count FROM api_arduinos WHERE token_id LIKE 'GOOGLE%' OR token_id LIKE 'TEST%' GROUP BY token_id;
```

### Sample Sensor Data
```sql
SELECT token_id, port0, port1, port2, type0, type1, type2, time FROM api_arduinos WHERE token_id = 'GOOGLE01' ORDER BY time DESC LIMIT 5;
```

## 🚀 Ready for Production Testing

### ✅ **What's Ready:**
- ✅ **4 Test Accounts** dengan password yang mudah diingat
- ✅ **8 IoT Devices** dengan token yang unik
- ✅ **650 Sensor Data Points** dengan nilai yang realistis
- ✅ **Google Console Account** dengan 5 devices dan 500 data points
- ✅ **Realistic Data** untuk testing charts dan visualisasi
- ✅ **Multiple Sensor Types** untuk testing berbagai fitur

### 🎯 **Recommended Testing Account:**
**Use `google.console@test.com` / `google123`** untuk testing yang paling komprehensif karena memiliki:
- 5 devices (GOOGLE01-GOOGLE05)
- 500 data points (100 per device)
- Data yang paling realistis
- Variasi sensor yang lengkap

## 📞 Support

Jika ada masalah dengan data test:
1. **Re-run seeder**: `php run_seeders.php`
2. **Check database**: Pastikan database connection OK
3. **Verify data**: Gunakan query SQL di atas
4. **Clear cache**: `php artisan cache:clear`

**Data test siap untuk testing aplikasi Child Care!** 🎉



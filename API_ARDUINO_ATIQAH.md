# API Arduino Atiqah

## Endpoint
```
POST /api/arduino/atiqah/{token}
```

## Deskripsi
API untuk menyimpan data sensor dari Arduino dengan token tertentu. Data akan disimpan ke dalam tabel `api_arduinos` dengan mapping ke port0-port6.

## Parameter URL
- `token` (string, required): Token unik untuk mengidentifikasi device Arduino

## Request Body (JSON)
```json
{
    "ir": 123.45,
    "suhu": 25.6,
    "kelembapan": 65.2,
    "kecemasan": 0.8,
    "lat": -6.2088,
    "lng": 106.8456
}
```

### Field Description
- `ir` (numeric, required): Nilai sensor IR
- `suhu` (numeric, required): Nilai suhu dalam derajat Celsius
- `kelembapan` (numeric, required): Nilai kelembapan dalam persentase
- `kecemasan` (numeric, required): Nilai tingkat kecemasan (0-1)
- `lat` (numeric, required): Latitude (garis lintang)
- `lng` (numeric, required): Longitude (garis bujur)

## Mapping Data ke Port
Data akan disimpan dengan mapping berikut:
- `port0` = `ir` (IR sensor)
- `port1` = `suhu` (Suhu)
- `port2` = `kelembapan` (Kelembapan)
- `port3` = `kecemasan` (Kecemasan)
- `port4` = `lat` (Latitude)
- `port5` = `lng` (Longitude)
- `port6` = 0 (Port kosong)

## Response

### Success Response (200)
```json
{
    "error": false,
    "message": "Data berhasil disimpan",
    "data": {
        "id": 123,
        "token": "abc123def456",
        "ir": 123.45,
        "suhu": 25.6,
        "kelembapan": 65.2,
        "kecemasan": 0.8,
        "lat": -6.2088,
        "lng": 106.8456,
        "created_at": "2024-01-15T10:30:00.000000Z"
    },
    "status_code": 200
}
```

### Error Response (401) - Token Invalid
```json
{
    "error": true,
    "message": "Token tidak valid atau masa aktif habis",
    "status_code": 401
}
```

### Error Response (422) - Validation Error
```json
{
    "error": true,
    "message": "Data tidak valid",
    "errors": {
        "ir": ["The ir field is required."],
        "suhu": ["The suhu field must be a number."]
    },
    "status_code": 422
}
```

### Error Response (500) - Server Error
```json
{
    "error": true,
    "message": "Terjadi kesalahan: [error message]",
    "status_code": 500
}
```

## Contoh Penggunaan

### cURL
```bash
curl -X POST "http://your-domain.com/api/arduino/atiqah/abc123def456" \
     -H "Content-Type: application/json" \
     -d '{
         "ir": 123.45,
         "suhu": 25.6,
         "kelembapan": 65.2,
         "kecemasan": 0.8,
         "lat": -6.2088,
         "lng": 106.8456
     }'
```

### JavaScript (Fetch)
```javascript
fetch('/api/arduino/atiqah/abc123def456', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify({
        ir: 123.45,
        suhu: 25.6,
        kelembapan: 65.2,
        kecemasan: 0.8,
        lat: -6.2088,
        lng: 106.8456
    })
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error('Error:', error));
```

### Python (requests)
```python
import requests

url = "http://your-domain.com/api/arduino/atiqah/abc123def456"
data = {
    "ir": 123.45,
    "suhu": 25.6,
    "kelembapan": 65.2,
    "kecemasan": 0.8,
    "lat": -6.2088,
    "lng": 106.8456
}

response = requests.post(url, json=data)
print(response.json())
```

## Catatan
- Token harus terdaftar di tabel `tools_addresses` dan tidak dihapus (`is_deleted = 0`)
- Semua field harus berupa angka (numeric)
- Data akan disimpan dengan timestamp otomatis
- Port6 diset ke 0 dan bisa digunakan untuk data tambahan di masa depan 
# Fitur Add or Update Menu Makanan dengan Image Upload

## Ringkasan
Method `addOrUpdateMenuMakanan` sudah memiliki fitur upload image yang lengkap dengan kompresi otomatis hingga 100KB sambil mempertahankan resolusi asli.

## Endpoint
```bash
POST /api/sipintar/food
Content-Type: multipart/form-data
```

## Fitur yang Tersedia

### 1. Add Menu Makanan Baru
- Upload image dengan kompresi otomatis
- Simpan semua data menu makanan
- Generate filename unik untuk image

### 2. Update Menu Makanan Existing
- Update data menu makanan berdasarkan ID
- Upload image baru (optional)
- Replace image lama jika ada

### 3. Image Compression
- **Target Size**: 100KB
- **Resolusi**: Dipertahankan sebisa mungkin
- **Format Support**: JPEG, PNG, GIF, WebP
- **Lokasi**: `public/images/menu_makanan/`

## Cara Penggunaan

### 1. Add Menu Makanan Baru
```bash
POST /api/sipintar/food
Content-Type: multipart/form-data

{
    "nama_makanan": "Nasi Goreng Special",
    "kategori": "Makanan Utama",
    "deskripsi_menu": "Nasi goreng dengan bumbu special dan telur",
    "komposisi": "Nasi, telur, bawang, kecap, minyak",
    "foto": [FILE_UPLOAD], // Image akan dikompres otomatis
    "berat_g": 250,
    "energi_kkal": 350.5,
    "protein_gram": 12.5,
    "lemak_gram": 8.2,
    "karbohidrat_gram": 45.3,
    "gula_gram": 5.1,
    "natrium_mg": 800.0,
    "serat_gram": 2.5,
    "zat_besi_mg": 3.2,
    "kalsium_mg": 150.0,
    "skor_zat_gizi": 85,
    "protein_persen": 15,
    "lemak_persen": 20,
    "gula_persen": 8,
    "garam_persen": 12,
    "serat_persen": 10,
    "zat_besi_persen": 25,
    "kalsium_persen": 15,
    "is_active": true
}
```

### 2. Update Menu Makanan Existing
```bash
POST /api/sipintar/food
Content-Type: multipart/form-data

{
    "id": "menu-uuid-here", // ID menu yang akan diupdate
    "nama_makanan": "Nasi Goreng Special Updated",
    "kategori": "Makanan Utama",
    "foto": [FILE_UPLOAD], // Image baru (optional)
    "berat_g": 300,
    "energi_kkal": 400.0,
    // ... field lainnya
}
```

## Response Format

### Success Response
```json
{
    "error": false,
    "message": "Menu makanan added successfully", // atau "updated successfully"
    "data": {
        "id": "uuid-here",
        "nama_makanan": "Nasi Goreng Special",
        "kategori": "Makanan Utama",
        "deskripsi_menu": "Nasi goreng dengan bumbu special",
        "komposisi": "Nasi, telur, bawang, kecap, minyak",
        "foto": "images/menu_makanan/1699123456_abc123.jpg",
        "berat_g": 250,
        "energi_kkal": "350.50",
        "protein_gram": "12.50",
        // ... field lainnya
        "created_at": "2025-10-20T10:30:00.000000Z",
        "updated_at": "2025-10-20T10:30:00.000000Z"
    },
    "status_code": 200,
    "signature": null
}
```

### Error Response
```json
{
    "error": true,
    "message": "Menu makanan not found", // atau error message lainnya
    "status_code": 404,
    "signature": null
}
```

## Image Compression Algorithm

### Tahap 1: Quality Compression
```php
// Mulai dengan quality 90% dan turunkan hingga target size tercapai
$quality = 90;
do {
    // Save dengan quality saat ini
    imagejpeg($sourceImage, $fullPath, $quality);
    
    // Jika masih terlalu besar, turunkan quality
    if ($fileSize > $targetSizeBytes && $quality > 10) {
        $quality -= 10;
    }
} while ($fileSize > $targetSizeBytes && $quality > 10);
```

### Tahap 2: Dimension Compression (jika diperlukan)
```php
// Jika quality compression tidak cukup, kurangi dimensi
$scale = 0.9; // Mulai dengan 90% dari ukuran asli
do {
    $newWidth = round($originalWidth * $scale);
    $newHeight = round($originalHeight * $scale);
    
    // Resize dan save
    imagecopyresampled($resizedImage, $sourceImage, 0, 0, 0, 0, 
                      $newWidth, $newHeight, $originalWidth, $originalHeight);
    
    // Jika masih terlalu besar, kurangi scale
    if ($fileSize > $targetSizeBytes && $scale > 0.1) {
        $scale -= 0.1;
    }
} while ($fileSize > $targetSizeBytes && $scale > 0.1);
```

## Keuntungan

### Image Upload & Compression
- ✅ **Storage Efficient**: Image dikompres hingga 100KB
- ✅ **Quality Preserved**: Resolusi dipertahankan sebisa mungkin
- ✅ **Format Support**: Mendukung JPEG, PNG, GIF, WebP
- ✅ **Automatic**: Kompresi otomatis saat upload
- ✅ **Fallback**: Jika quality compression tidak cukup, akan resize
- ✅ **Unique Filename**: Mencegah konflik nama file

### Add or Update Logic
- ✅ **Flexible**: Bisa add baru atau update existing
- ✅ **ID-based Update**: Update berdasarkan ID menu
- ✅ **Optional Image**: Image upload bersifat optional
- ✅ **Data Validation**: Validasi data input
- ✅ **Error Handling**: Error handling yang comprehensive

## Testing

### Test Add Menu Makanan
```bash
curl -X POST http://localhost:8000/api/sipintar/food \
  -F "nama_makanan=Test Menu" \
  -F "kategori=Test" \
  -F "foto=@test_image.jpg" \
  -F "berat_g=100" \
  -F "energi_kkal=200.0"
```

### Test Update Menu Makanan
```bash
curl -X POST http://localhost:8000/api/sipintar/food \
  -F "id=existing-menu-uuid" \
  -F "nama_makanan=Updated Menu" \
  -F "foto=@new_image.jpg" \
  -F "berat_g=150"
```

## File Structure
```
public/
└── images/
    └── menu_makanan/
        ├── 1699123456_abc123.jpg
        ├── 1699123457_def456.png
        └── 1699123458_ghi789.webp
```

## Status
✅ **SELESAI** - Method `addOrUpdateMenuMakanan` sudah memiliki fitur upload image dengan kompresi yang lengkap dan siap digunakan.

## Notes
- Image akan disimpan dengan nama file yang unik (timestamp + uniqid)
- Jika upload image baru saat update, image lama akan tetap ada (tidak dihapus otomatis)
- Kompresi image menggunakan native PHP GD library
- Target size 100KB bisa disesuaikan dengan mengubah parameter `$targetSizeKB`


# Soft Delete History dan Image Compression untuk Menu Makanan

## Ringkasan
Telah ditambahkan soft delete untuk tabel history dan fitur kompresi image untuk upload menu makanan dengan target ukuran 100KB sambil mempertahankan resolusi asli.

## 1. Soft Delete untuk History

### Perubahan Database
- **Migration**: `2025_10_19_070947_add_soft_deletes_to_history_table.php`
- **Perubahan**: Menambahkan kolom `deleted_at` ke tabel `history`

### Perubahan Model
- **File**: `app/Models/History.php`
- **Perubahan**: 
  - Menambahkan `use Illuminate\Database\Eloquent\SoftDeletes;`
  - Menambahkan `SoftDeletes` trait
  - Menghapus `HasUuids` trait (sesuai perubahan user)

### Perubahan Controller
- **File**: `app/Http/Controllers/api/ApiSiPintarController.php`
- **Method**: `deleteHistory()`
- **Perubahan**:
  - Menambahkan verifikasi user ownership
  - Menggunakan soft delete
  - Improved error handling

## 2. Image Compression untuk Menu Makanan

### Fitur Kompresi Image
- **Target Size**: 100KB
- **Resolusi**: Dipertahankan sebisa mungkin
- **Format Support**: JPEG, PNG, GIF, WebP
- **Lokasi**: `public/images/menu_makanan/`

### Algoritma Kompresi

#### Tahap 1: Quality Compression
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

#### Tahap 2: Dimension Compression (jika diperlukan)
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

### Method yang Ditambahkan

#### 1. `compressAndSaveImage($image, $targetSizeKB = 100)`
- Main method untuk kompresi image
- Mendukung multiple format
- Menggunakan 2 tahap kompresi

#### 2. `compressPng($sourceImage, $outputPath, $quality)`
- Khusus untuk kompresi PNG
- Mempertahankan transparency
- Menggunakan PNG compression level

#### 3. `compressByResizing($sourceImage, $outputPath, $targetSizeBytes, $mimeType)`
- Kompresi dengan mengurangi dimensi
- Mempertahankan aspect ratio
- Fallback jika quality compression tidak cukup

## Cara Penggunaan

### 1. Upload Menu Makanan dengan Image
```bash
POST /api/sipintar/menu-makanan
Content-Type: multipart/form-data

{
    "nama_makanan": "Nasi Goreng",
    "kategori": "Makanan Utama",
    "deskripsi_menu": "Nasi goreng dengan bumbu special",
    "foto": [FILE_UPLOAD], // Image akan dikompres otomatis
    "berat_g": 250,
    "energi_kkal": 350.5,
    // ... field lainnya
}
```

### 2. Delete History (Soft Delete)
```bash
POST /api/sipintar/delete-history
{
    "mobile_token": "user_token",
    "history_id": "history_uuid"
}
```

## Keuntungan

### Soft Delete History
- ✅ **Data Recovery**: History yang dihapus bisa dikembalikan
- ✅ **Audit Trail**: Bisa melacak history yang pernah dihapus
- ✅ **User Security**: User hanya bisa hapus history miliknya
- ✅ **Better UX**: User bisa "undo" aksi hapus

### Image Compression
- ✅ **Storage Efficient**: Image dikompres hingga 100KB
- ✅ **Quality Preserved**: Resolusi dipertahankan sebisa mungkin
- ✅ **Format Support**: Mendukung JPEG, PNG, GIF, WebP
- ✅ **Automatic**: Kompresi otomatis saat upload
- ✅ **Fallback**: Jika quality compression tidak cukup, akan resize

## Testing

### Test Image Compression
```bash
# Upload image besar (>1MB)
curl -X POST http://localhost:8000/api/sipintar/menu-makanan \
  -F "nama_makanan=Test Menu" \
  -F "foto=@large_image.jpg" \
  -F "kategori=Test"

# Hasil: Image akan dikompres hingga ~100KB
```

### Test History Soft Delete
```bash
# Delete history
curl -X POST http://localhost:8000/api/sipintar/delete-history \
  -H "Content-Type: application/json" \
  -d '{
    "mobile_token": "user_token",
    "history_id": "history_uuid"
  }'

# Hasil: History di-soft-delete, masih ada di database
```

## Status
✅ **SELESAI** - Soft delete untuk history dan image compression untuk menu makanan sudah berfungsi dengan sempurna.


# Format Request addOrUpdateMenuMakanan

## Endpoint
```bash
POST /api/sipintar/food
Content-Type: multipart/form-data
```

## Logic
- **CREATE**: Jika request **TIDAK** mengandung field `id`
- **UPDATE**: Jika request **MENGANDUNG** field `id`

---

## 1. CREATE Menu Makanan Baru

### Request Format
```bash
POST /api/sipintar/food
Content-Type: multipart/form-data
```

### Required Fields
```json
{
    "nama_makanan": "string (required)",
    "kategori": "string (required)",
    "foto": "file (optional - image akan dikompres otomatis)"
}
```

### Complete Request Example
```bash
curl -X POST http://localhost:8000/api/sipintar/food \
  -F "nama_makanan=Nasi Goreng Special" \
  -F "kategori=Makanan Utama" \
  -F "deskripsi_menu=Nasi goreng dengan bumbu special dan telur" \
  -F "komposisi=Nasi, telur, bawang, kecap, minyak" \
  -F "foto=@/path/to/image.jpg" \
  -F "berat_g=250" \
  -F "energi_kkal=350.50" \
  -F "protein_gram=12.50" \
  -F "lemak_gram=8.20" \
  -F "karbohidrat_gram=45.30" \
  -F "gula_gram=5.10" \
  -F "natrium_mg=800.00" \
  -F "serat_gram=2.50" \
  -F "zat_besi_mg=3.20" \
  -F "kalsium_mg=150.00" \
  -F "skor_zat_gizi=85" \
  -F "protein_persen=15" \
  -F "lemak_persen=20" \
  -F "gula_persen=8" \
  -F "garam_persen=12" \
  -F "serat_persen=10" \
  -F "zat_besi_persen=25" \
  -F "kalsium_persen=15" \
  -F "is_active=true"
```

### Field Details (CREATE)
| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `nama_makanan` | string | ✅ | Nama menu makanan |
| `kategori` | string | ✅ | Kategori makanan |
| `deskripsi_menu` | string | ❌ | Deskripsi menu |
| `komposisi` | string | ❌ | Komposisi bahan |
| `foto` | file | ❌ | File image (JPEG/PNG/GIF/WebP) |
| `berat_g` | integer | ❌ | Berat dalam gram |
| `energi_kkal` | decimal | ❌ | Energi dalam kkal |
| `protein_gram` | decimal | ❌ | Protein dalam gram |
| `lemak_gram` | decimal | ❌ | Lemak dalam gram |
| `karbohidrat_gram` | decimal | ❌ | Karbohidrat dalam gram |
| `gula_gram` | decimal | ❌ | Gula dalam gram |
| `natrium_mg` | decimal | ❌ | Natrium dalam mg |
| `serat_gram` | decimal | ❌ | Serat dalam gram |
| `zat_besi_mg` | decimal | ❌ | Zat besi dalam mg |
| `kalsium_mg` | decimal | ❌ | Kalsium dalam mg |
| `skor_zat_gizi` | integer | ❌ | Skor zat gizi |
| `protein_persen` | integer | ❌ | Persentase protein |
| `lemak_persen` | integer | ❌ | Persentase lemak |
| `gula_persen` | integer | ❌ | Persentase gula |
| `garam_persen` | integer | ❌ | Persentase garam |
| `serat_persen` | integer | ❌ | Persentase serat |
| `zat_besi_persen` | integer | ❌ | Persentase zat besi |
| `kalsium_persen` | integer | ❌ | Persentase kalsium |
| `is_active` | boolean | ❌ | Status aktif (default: true) |

### Response (CREATE)
```json
{
    "error": false,
    "message": "Menu makanan added successfully",
    "data": {
        "id": "0199fa06-0182-7343-9ced-35803765cdf8",
        "nama_makanan": "Nasi Goreng Special",
        "kategori": "Makanan Utama",
        "deskripsi_menu": "Nasi goreng dengan bumbu special dan telur",
        "komposisi": "Nasi, telur, bawang, kecap, minyak",
        "foto": "images/menu_makanan/1699123456_abc123.jpg",
        "berat_g": 250,
        "energi_kkal": "350.50",
        "protein_gram": "12.50",
        "lemak_gram": "8.20",
        "karbohidrat_gram": "45.30",
        "gula_gram": "5.10",
        "natrium_mg": "800.00",
        "serat_gram": "2.50",
        "zat_besi_mg": "3.20",
        "kalsium_mg": "150.00",
        "skor_zat_gizi": 85,
        "protein_persen": 15,
        "lemak_persen": 20,
        "gula_persen": 8,
        "garam_persen": 12,
        "serat_persen": 10,
        "zat_besi_persen": 25,
        "kalsium_persen": 15,
        "is_active": true,
        "created_at": "2025-10-21T10:30:00.000000Z",
        "updated_at": "2025-10-21T10:30:00.000000Z"
    },
    "status_code": 200,
    "signature": null
}
```

---

## 2. UPDATE Menu Makanan Existing

### Request Format
```bash
POST /api/sipintar/food
Content-Type: multipart/form-data
```

### Required Fields
```json
{
    "id": "string (required - UUID menu yang akan diupdate)"
}
```

### Complete Request Example
```bash
curl -X POST http://localhost:8000/api/sipintar/food \
  -F "id=0199fa06-0182-7343-9ced-35803765cdf8" \
  -F "nama_makanan=Nasi Goreng Special Updated" \
  -F "kategori=Makanan Utama" \
  -F "deskripsi_menu=Nasi goreng dengan bumbu special yang telah diperbarui" \
  -F "komposisi=Nasi, telur, bawang, kecap, minyak, sayuran" \
  -F "foto=@/path/to/new_image.jpg" \
  -F "berat_g=300" \
  -F "energi_kkal=400.00" \
  -F "protein_gram=15.00" \
  -F "lemak_gram=10.00" \
  -F "karbohidrat_gram=50.00" \
  -F "gula_gram=6.00" \
  -F "natrium_mg=900.00" \
  -F "serat_gram=3.00" \
  -F "zat_besi_mg=4.00" \
  -F "kalsium_mg=180.00" \
  -F "skor_zat_gizi=90" \
  -F "protein_persen=18" \
  -F "lemak_persen=22" \
  -F "gula_persen=10" \
  -F "garam_persen=15" \
  -F "serat_persen=12" \
  -F "zat_besi_persen=30" \
  -F "kalsium_persen=18" \
  -F "is_active=true"
```

### Field Details (UPDATE)
| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `id` | string (UUID) | ✅ | ID menu yang akan diupdate |
| `nama_makanan` | string | ❌ | Nama menu makanan |
| `kategori` | string | ❌ | Kategori makanan |
| `deskripsi_menu` | string | ❌ | Deskripsi menu |
| `komposisi` | string | ❌ | Komposisi bahan |
| `foto` | file | ❌ | File image baru (optional) |
| `berat_g` | integer | ❌ | Berat dalam gram |
| `energi_kkal` | decimal | ❌ | Energi dalam kkal |
| `protein_gram` | decimal | ❌ | Protein dalam gram |
| `lemak_gram` | decimal | ❌ | Lemak dalam gram |
| `karbohidrat_gram` | decimal | ❌ | Karbohidrat dalam gram |
| `gula_gram` | decimal | ❌ | Gula dalam gram |
| `natrium_mg` | decimal | ❌ | Natrium dalam mg |
| `serat_gram` | decimal | ❌ | Serat dalam gram |
| `zat_besi_mg` | decimal | ❌ | Zat besi dalam mg |
| `kalsium_mg` | decimal | ❌ | Kalsium dalam mg |
| `skor_zat_gizi` | integer | ❌ | Skor zat gizi |
| `protein_persen` | integer | ❌ | Persentase protein |
| `lemak_persen` | integer | ❌ | Persentase lemak |
| `gula_persen` | integer | ❌ | Persentase gula |
| `garam_persen` | integer | ❌ | Persentase garam |
| `serat_persen` | integer | ❌ | Persentase serat |
| `zat_besi_persen` | integer | ❌ | Persentase zat besi |
| `kalsium_persen` | integer | ❌ | Persentase kalsium |
| `is_active` | boolean | ❌ | Status aktif |

### Response (UPDATE)
```json
{
    "error": false,
    "message": "Menu makanan updated successfully",
    "data": {
        "id": "0199fa06-0182-7343-9ced-35803765cdf8",
        "nama_makanan": "Nasi Goreng Special Updated",
        "kategori": "Makanan Utama",
        "deskripsi_menu": "Nasi goreng dengan bumbu special yang telah diperbarui",
        "komposisi": "Nasi, telur, bawang, kecap, minyak, sayuran",
        "foto": "images/menu_makanan/1699123457_def456.jpg",
        "berat_g": 300,
        "energi_kkal": "400.00",
        "protein_gram": "15.00",
        "lemak_gram": "10.00",
        "karbohidrat_gram": "50.00",
        "gula_gram": "6.00",
        "natrium_mg": "900.00",
        "serat_gram": "3.00",
        "zat_besi_mg": "4.00",
        "kalsium_mg": "180.00",
        "skor_zat_gizi": 90,
        "protein_persen": 18,
        "lemak_persen": 22,
        "gula_persen": 10,
        "garam_persen": 15,
        "serat_persen": 12,
        "zat_besi_persen": 30,
        "kalsium_persen": 18,
        "is_active": true,
        "created_at": "2025-10-21T10:30:00.000000Z",
        "updated_at": "2025-10-21T11:45:00.000000Z"
    },
    "status_code": 200,
    "signature": null
}
```

---

## 3. Error Responses

### Menu Not Found (UPDATE)
```json
{
    "error": true,
    "message": "Menu makanan not found",
    "status_code": 404,
    "signature": null
}
```

### Server Error
```json
{
    "error": true,
    "message": "Failed to add menu makanan",
    "error": "Error message details",
    "status_code": 500,
    "signature": null
}
```

---

## 4. Image Upload Details

### Supported Formats
- ✅ JPEG (.jpg, .jpeg)
- ✅ PNG (.png)
- ✅ GIF (.gif)
- ✅ WebP (.webp)

### Image Processing
- **Compression**: Otomatis dikompres hingga 100KB
- **Resolution**: Dipertahankan sebisa mungkin
- **Location**: `public/images/menu_makanan/`
- **Filename**: `{timestamp}_{uniqid}.{extension}`

### Example Image Upload
```bash
# Upload image dengan curl
curl -X POST http://localhost:8000/api/sipintar/food \
  -F "nama_makanan=Test Menu" \
  -F "kategori=Test" \
  -F "foto=@/path/to/your/image.jpg"
```

---

## 5. Testing Examples

### Minimal CREATE Request
```bash
curl -X POST http://localhost:8000/api/sipintar/food \
  -F "nama_makanan=Test Menu" \
  -F "kategori=Test Category"
```

### Minimal UPDATE Request
```bash
curl -X POST http://localhost:8000/api/sipintar/food \
  -F "id=0199fa06-0182-7343-9ced-35803765cdf8" \
  -F "nama_makanan=Updated Menu Name"
```

### UPDATE with New Image
```bash
curl -X POST http://localhost:8000/api/sipintar/food \
  -F "id=0199fa06-0182-7343-9ced-35803765cdf8" \
  -F "nama_makanan=Updated Menu" \
  -F "foto=@/path/to/new_image.jpg"
```

---

## 6. Key Points

### CREATE vs UPDATE
- **CREATE**: Tidak ada field `id` dalam request
- **UPDATE**: Harus ada field `id` dengan UUID yang valid

### Image Handling
- **CREATE**: Image optional, akan dikompres otomatis
- **UPDATE**: Image optional, jika ada akan replace image lama
- **Compression**: Semua image dikompres hingga 100KB

### Field Validation
- **Required for CREATE**: `nama_makanan`, `kategori`
- **Required for UPDATE**: `id`
- **All other fields**: Optional

### Data Types
- **Integers**: `berat_g`, `skor_zat_gizi`, semua `*_persen`
- **Decimals**: Semua nilai gizi (2 decimal places)
- **Boolean**: `is_active`
- **String**: `nama_makanan`, `kategori`, `deskripsi_menu`, `komposisi`
- **File**: `foto` (image file)



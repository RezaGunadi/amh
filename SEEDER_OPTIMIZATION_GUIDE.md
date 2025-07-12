# Panduan Optimasi Seeder untuk Mengatasi Out of Memory

## Masalah
Seeder `PaketSoalSeeder` original mengalami masalah "out of memory" karena:
- Memproses terlalu banyak data sekaligus
- Tidak ada garbage collection
- Memory tidak dibersihkan selama proses

## Solusi yang Dibuat

### 1. Seeder Optimized (`PaketSoalSeederOptimized`)
Seeder dengan optimasi memory menggunakan chunking:
- **Chunking**: Memproses data dalam bagian-bagian kecil
- **Garbage Collection**: Membersihkan memory secara berkala
- **Progress Tracking**: Menampilkan progress proses

### 2. Seeder Light (`PaketSoalSeederLight`)
Seeder untuk testing dengan data minimal:
- Data lebih sedikit untuk testing cepat
- Sama-sama menggunakan chunking
- Cocok untuk development dan testing

### 3. Command Artisan
Command khusus untuk menjalankan seeder dengan kontrol memory:

#### Command Optimized
```bash
php artisan seed:optimized --chunk=10 --soal-chunk=10 --memory-limit=512M
```

#### Command Light
```bash
php artisan seed:light --chunk=5 --soal-chunk=5 --memory-limit=256M
```

## Cara Penggunaan

### 1. Testing dengan Seeder Light (Direkomendasikan untuk Testing)
```bash
# Jalankan dengan default settings
php artisan seed:light

# Jalankan dengan custom settings
php artisan seed:light --chunk=3 --soal-chunk=3 --memory-limit=128M
```

**Output yang diharapkan:**
```
Memory limit diset ke: 256M
Memulai seeding LIGHT dengan optimasi...
Chunk size: 5 paket per chunk
Soal chunk size: 5 soal per chunk
Total data yang akan dibuat:
- 2 jenjang (SD, SMP)
- 2 mata pelajaran per jenjang
- 5 paket per mata pelajaran
- 10 soal per paket
Total: 2 x 2 x 5 x 10 = 200 soal
Memulai seeding LIGHT dengan optimasi memory...
Processing jenjang SD (1/2)
  Processing mapel Matematika (1/2)
    Processing chunk 1/1 (paket 1-5)
Processing jenjang SMP (2/2)
  Processing mapel Matematika (1/2)
    Processing chunk 1/1 (paket 1-5)
Seeding LIGHT selesai!
```

### 2. Production dengan Seeder Optimized
```bash
# Jalankan dengan default settings
php artisan seed:optimized

# Jalankan dengan custom settings untuk server dengan memory terbatas
php artisan seed:optimized --chunk=5 --soal-chunk=5 --memory-limit=256M

# Jalankan dengan settings untuk server dengan memory besar
php artisan seed:optimized --chunk=20 --soal-chunk=20 --memory-limit=1G
```

## Parameter Command

### `--chunk`
- **Default**: 10 (optimized), 5 (light)
- **Deskripsi**: Jumlah paket soal yang diproses dalam satu chunk
- **Rekomendasi**: 
  - Memory terbatas: 3-5
  - Memory sedang: 10-15
  - Memory besar: 20-50

### `--soal-chunk`
- **Default**: 10 (optimized), 5 (light)
- **Deskripsi**: Jumlah soal yang diproses dalam satu chunk per paket
- **Rekomendasi**:
  - Memory terbatas: 3-5
  - Memory sedang: 10-15
  - Memory besar: 20-50

### `--memory-limit`
- **Default**: 512M (optimized), 256M (light)
- **Deskripsi**: Memory limit untuk PHP
- **Rekomendasi**:
  - Development: 128M-256M
  - Production: 512M-1G
  - Server terbatas: 64M-128M

## Strategi Optimasi Memory

### 1. Chunking
```php
// Memproses data dalam chunk kecil
for ($chunkIndex = 0; $chunkIndex < $chunks; $chunkIndex++) {
    $startIndex = $chunkIndex * $this->chunkSize;
    $endIndex = min(($chunkIndex + 1) * $this->chunkSize, $jumlahPaket);
    
    // Process chunk ini
    $this->processPaketChunk($jenjang, $mapel, $startIndex, $endIndex);
    
    // Clear memory setelah setiap chunk
    gc_collect_cycles();
}
```

### 2. Garbage Collection
```php
// Membersihkan memory secara manual
unset($paketSoal, $jawaban, $template);
gc_collect_cycles();
```

### 3. Progress Tracking
```php
// Menampilkan progress untuk monitoring
$this->command->info("Processing jenjang {$jenjang} ({$currentJenjang}/{$totalJenjang})");
```

## Troubleshooting

### 1. Masih Out of Memory
```bash
# Kurangi chunk size dan memory limit
php artisan seed:light --chunk=2 --soal-chunk=2 --memory-limit=128M
```

### 2. Proses Terlalu Lambat
```bash
# Tingkatkan chunk size dan memory limit
php artisan seed:optimized --chunk=20 --soal-chunk=20 --memory-limit=1G
```

### 3. Error Database Connection
```bash
# Pastikan database connection tidak timeout
# Tambahkan di .env
DB_TIMEOUT=300
```

### 4. Monitoring Memory Usage
```bash
# Cek memory usage saat proses berjalan
php -i | grep memory_limit
```

## Perbandingan Performance

| Seeder | Data Size | Memory Usage | Time | Recommended Use |
|--------|-----------|--------------|------|-----------------|
| Original | 50 paket x 50 soal x 20 mapel = 50,000 soal | High (Out of Memory) | N/A | Tidak direkomendasikan |
| Light | 5 paket x 10 soal x 4 mapel = 200 soal | Low (~50MB) | ~30 detik | Development/Testing |
| Optimized | 50 paket x 50 soal x 20 mapel = 50,000 soal | Medium (~200MB) | ~10-30 menit | Production |

## Tips Tambahan

### 1. Backup Database Sebelum Seeding
```bash
php artisan db:backup
```

### 2. Monitor Progress
```bash
# Jalankan dengan verbose output
php artisan seed:light -v
```

### 3. Stop dan Resume
Jika proses terhenti, Anda bisa melanjutkan dari chunk tertentu dengan memodifikasi seeder.

### 4. Clean Database Sebelum Seeding
```bash
php artisan migrate:fresh
```

## Kesimpulan

Dengan menggunakan seeder yang dioptimalkan:
- ✅ Mengatasi masalah out of memory
- ✅ Proses lebih stabil dan predictable
- ✅ Progress tracking untuk monitoring
- ✅ Fleksibilitas dalam pengaturan memory dan chunk size
- ✅ Cocok untuk berbagai environment (development, staging, production)

Mulai dengan `seed:light` untuk testing, kemudian gunakan `seed:optimized` untuk production dengan pengaturan yang sesuai dengan resource server Anda. 
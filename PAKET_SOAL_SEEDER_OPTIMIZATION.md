# PaketSoalSeeder Optimization dengan Chunking

## Perubahan yang Dilakukan

### 1. Implementasi Chunking Mechanism
- **Fungsi `run()`** diubah untuk menggunakan sistem chunking
- **Memory management** dengan `gc_collect_cycles()` setelah setiap chunk
- **Progress tracking** yang lebih detail per jenjang dan mata pelajaran

### 2. Fungsi Baru yang Ditambahkan

#### `processMapelInChunks($jenjang, $mapel)`
- Memproses mata pelajaran dalam chunk untuk menghemat memory
- Chunk size: 10 paket per chunk
- Total: 50 paket per mata pelajaran

#### `processPaketChunk($jenjang, $mapel, $startIndex, $endIndex)`
- Memproses paket soal dalam range tertentu
- Memory cleanup setelah setiap paket

#### `generateSoalInChunks($paketId, $mapel, $jenjang)`
- Generate soal dengan distribusi berdasarkan kurikulum
- 50 soal per paket, dibagi berdasarkan topik dan sub-topik

#### `processSoalChunk($paketId, $mapel, $jenjang, $topik, $subTopik, $jumlahSoal, $chunkSize)`
- Memproses soal dalam chunk kecil (10 soal per chunk)
- Memory cleanup setelah setiap chunk soal

### 3. Keuntungan Optimasi

#### Memory Usage
- **Sebelum**: Semua data disimpan di memory sekaligus
- **Sesudah**: Data diproses dalam chunk kecil, memory dibersihkan secara berkala

#### Progress Tracking
- **Sebelum**: Hanya progress umum
- **Sesudah**: Progress detail per jenjang, mata pelajaran, dan chunk

#### Error Handling
- **Sebelum**: Jika error, semua data hilang
- **Sesudah**: Jika error di satu chunk, chunk lain tetap berjalan

### 4. Variasi Soal Tetap Lengkap

Semua fungsi generate soal asli tetap dipertahankan:
- `generateSoalMatematika()` - dengan kurikulum lengkap (SD, SMP, SMA)
- `generateSoalBahasaIndonesia()` - dengan teks bacaan dan kata baku
- `generateSoalIPA()` - dengan topik biologi, fisika, kimia
- `generateSoalIPS()` - dengan sejarah, geografi, ekonomi, sosiologi
- Dan semua fungsi lainnya dengan variasi yang kaya

### 5. Cara Menjalankan

#### Menggunakan Command Baru
```bash
php artisan seeder:paket-soal-optimized
```

#### Menggunakan Seeder Langsung
```bash
php artisan db:seed --class=PaketSoalSeeder
```

### 6. Konfigurasi Memory

Command otomatis mengatur memory limit ke 512M, namun bisa disesuaikan:
```php
ini_set('memory_limit', '1G'); // Untuk data yang lebih besar
```

### 7. Monitoring

Seeder akan menampilkan progress detail:
```
Processing jenjang SD (1/3)
  Processing mapel Matematika (1/6)
    Processing chunk 1/5 (paket 1-10)
    Processing chunk 2/5 (paket 11-20)
    ...
```

### 8. Troubleshooting

Jika masih mengalami memory issues:
1. Kurangi `$chunkSize` di `processMapelInChunks()`
2. Kurangi `$soalChunkSize` di `generateSoalInChunks()`
3. Tingkatkan memory limit di command
4. Jalankan per mata pelajaran terpisah

## Kesimpulan

Optimasi ini berhasil menghemat memory secara signifikan sambil mempertahankan semua variasi soal yang kaya dan lengkap sesuai kurikulum terbaru. 
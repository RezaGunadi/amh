# Panduan Migrasi Database Sipintar dari Supabase ke Laravel

## Ringkasan
Dokumen ini menjelaskan proses migrasi database aplikasi Sipintar dari Supabase ke Laravel API yang sudah ada.

## Tabel yang Dimigrasi

### 1. Tabel `admins`
- **Struktur**: UUID primary key, name, email, username, is_super
- **Data**: 2 admin (Admin Baru dan alfino)
- **Migration**: `2025_10_13_161538_create_admins_table.php`
- **Seeder**: `AdminsSeeder.php`

### 2. Tabel `menu_makanan`
- **Struktur**: UUID primary key, nama_makanan, kategori, deskripsi_menu, komposisi, foto, dan berbagai kolom nutrisi
- **Data**: 105 menu makanan dari CSV
- **Migration**: `2025_10_13_161545_create_menu_makanan_table.php`
- **Seeder**: `MenuMakananSeeder.php`

### 3. Tabel `users` (Modifikasi)
- **Kolom Baru**: school, username, deletion_requested_at
- **Migration**: `2025_10_13_161645_add_sipintar_columns_to_users_table.php`
- **Seeder**: `UsersSeeder.php`
- **Data**: 180 users dari database lama

### 4. Tabel `favorites`
- **Struktur**: ID, user_id (bigint), food_id (UUID), food_name, image_url
- **Migration**: `2025_10_13_161551_create_favorites_table.php`
- **Seeder**: `FavoritesSeeder.php`

### 5. Tabel `history`
- **Struktur**: ID, user_id (bigint), food_id (UUID), food_name, image_url, consumed_at
- **Migration**: `2025_10_13_161557_create_history_table.php`
- **Seeder**: `HistorySeeder.php`

### 6. Tabel `delete_account_requests`
- **Struktur**: ID, user_id (bigint), reason, status, processed_at, processed_by (UUID)
- **Migration**: `2025_10_13_161603_create_delete_account_requests_table.php`
- **Seeder**: `DeleteAccountRequestsSeeder.php`

## Model Laravel

### Model yang Dibuat:
1. `Admin.php` - Model untuk tabel admins
2. `MenuMakanan.php` - Model untuk tabel menu_makanan
3. `Favorite.php` - Model untuk tabel favorites
4. `History.php` - Model untuk tabel history
5. `DeleteAccountRequest.php` - Model untuk tabel delete_account_requests

### Model yang Dimodifikasi:
- `User.php` - Ditambahkan relasi dan kolom baru

## Cara Menjalankan Migrasi

### 1. Jalankan Migration
```bash
php artisan migrate
```

### 2. Jalankan Seeder
```bash
# Seeder individual
php artisan db:seed --class=AdminsSeeder
php artisan db:seed --class=MenuMakananSeeder
php artisan db:seed --class=UsersSeeder

# Atau jalankan semua seeder
php artisan db:seed
```

## Catatan Penting

### 1. Kompatibilitas Data
- Data lama menggunakan UUID untuk user_id, tapi tabel users menggunakan bigint
- Seeder untuk favorites, history, dan delete_account_requests memerlukan mapping user_id
- Untuk production, perlu dibuat mapping table atau konversi data

### 2. Foreign Key Constraints
- Semua tabel menggunakan foreign key constraints untuk integritas data
- Tabel users menggunakan bigint ID, bukan UUID
- Tabel menu_makanan dan admins menggunakan UUID

### 3. Nullable Columns
- Semua kolom baru dibuat nullable dengan default value
- Ini memastikan aplikasi existing tidak error saat koneksi

### 4. File Data Source
- CSV menu makanan: `../sipintar/menu_makanan - Sheet1.csv`
- SQL data users: `../sipintar old database/users_rows.sql`
- SQL data favorites: `../sipintar old database/favorites_rows.sql`
- SQL data history: `../sipintar old database/history_rows.sql`
- SQL data delete requests: `../sipintar old database/delete_account_requests_rows.sql`

## Status Migrasi

✅ **Selesai**:
- Migration files dibuat
- Seeder files dibuat
- Model Laravel dibuat
- Tabel berhasil dibuat
- Data admins, menu_makanan, dan users berhasil di-import

⚠️ **Perlu Perhatian**:
- Seeder favorites, history, dan delete_account_requests memerlukan mapping user_id
- Perlu testing lebih lanjut untuk memastikan aplikasi existing tidak error

## Langkah Selanjutnya

1. **Testing Aplikasi**: Pastikan aplikasi existing masih berfungsi normal
2. **Mapping User ID**: Buat solusi untuk mapping UUID ke bigint
3. **API Endpoints**: Buat endpoint untuk fitur-fitur baru
4. **Documentation**: Update dokumentasi API
5. **Monitoring**: Monitor performa dan error setelah migrasi

## Troubleshooting

### Error Foreign Key Constraint
Jika terjadi error foreign key constraint, pastikan:
1. Tabel parent sudah dibuat
2. Tipe data foreign key sesuai dengan primary key tabel parent
3. Data yang di-import valid

### Error File Not Found
Pastikan path file data source benar:
- CSV dan SQL files berada di direktori yang tepat
- Path dalam seeder sudah disesuaikan

### Error Data Type Mismatch
Periksa tipe data di migration dan seeder:
- UUID vs bigint
- String vs integer
- Nullable vs not null

# Solusi Duplicate Entry Error untuk Favorites dengan Soft Delete

## Masalah
Error: `Integrity constraint violation: 1062 Duplicate entry '199' for key 'PRIMARY'`

## Penyebab
Dengan implementasi soft delete, data yang "dihapus" masih ada di database dengan `deleted_at` yang diisi. Ketika user mencoba menambahkan favorite yang sama lagi, terjadi konflik karena kombinasi `user_id` dan `food_id` sudah ada (meskipun sudah di-soft-delete).

## Solusi yang Diterapkan

### 1. Database Level
- **Migration**: `2025_10_19_011454_fix_favorites_unique_constraint_with_soft_delete.php`
- **Perubahan**: Menambahkan index untuk performa query tanpa unique constraint
- **Alasan**: MySQL tidak mendukung partial unique index dengan WHERE clause seperti PostgreSQL

### 2. Application Level
- **File**: `app/Http/Controllers/api/ApiSiPintarController.php`
- **Method**: `addFavorite()`
- **Logika Baru**:

```php
// 1. Cek apakah ada favorite yang aktif (tidak di-soft-delete)
$checkFavorite = Favorite::where('user_id', $user->id)->where('food_id', $food->id)->first();

if ($checkFavorite) {
    // Jika ada favorite yang aktif, soft delete
    $checkFavorite->delete();
    return "Favorite removed successfully";
} else {
    // 2. Cek apakah ada favorite yang sudah di-soft-delete
    $deletedFavorite = Favorite::withTrashed()
        ->where('user_id', $user->id)
        ->where('food_id', $food->id)
        ->first();
    
    if ($deletedFavorite && $deletedFavorite->trashed()) {
        // Jika ada yang sudah di-soft-delete, restore
        $deletedFavorite->restore();
        return "Favorite restored successfully";
    } else {
        // 3. Jika tidak ada sama sekali, buat baru
        $favorite = Favorite::create([...]);
        return "Favorite added successfully";
    }
}
```

## Keuntungan Solusi Ini

1. **No Duplicate Error**: Tidak ada lagi error duplicate entry
2. **Toggle Functionality**: User bisa menambah/hapus favorite dengan mudah
3. **Data Recovery**: Data yang dihapus bisa dikembalikan
4. **Better UX**: User experience lebih smooth
5. **Audit Trail**: Bisa melacak history favorite user

## Cara Kerja

### Skenario 1: User menambah favorite baru
- Sistem cek apakah ada favorite aktif → Tidak ada
- Sistem cek apakah ada favorite yang di-soft-delete → Tidak ada
- Sistem buat favorite baru

### Skenario 2: User menghapus favorite
- Sistem cek apakah ada favorite aktif → Ada
- Sistem soft delete favorite tersebut

### Skenario 3: User menambah favorite yang pernah dihapus
- Sistem cek apakah ada favorite aktif → Tidak ada
- Sistem cek apakah ada favorite yang di-soft-delete → Ada
- Sistem restore favorite tersebut

## Testing

Untuk test solusi ini:

1. **Test Add Favorite**:
   ```bash
   POST /api/sipintar/favorite
   {
       "mobile_token": "user_token",
       "food_id": "food_uuid"
   }
   ```

2. **Test Remove Favorite** (sama dengan add, akan toggle):
   ```bash
   POST /api/sipintar/favorite
   {
       "mobile_token": "user_token", 
       "food_id": "food_uuid"
   }
   ```

3. **Test Restore Favorite** (sama dengan add, akan restore):
   ```bash
   POST /api/sipintar/favorite
   {
       "mobile_token": "user_token",
       "food_id": "food_uuid"
   }
   ```

## Status
✅ **SELESAI** - Duplicate entry error sudah diperbaiki dan favorites dengan soft delete berfungsi dengan benar.

# Panduan Soft Delete untuk Tabel Favorites

## Ringkasan
Soft delete telah berhasil ditambahkan ke tabel `favorites`. Ini memungkinkan untuk "menghapus" data tanpa benar-benar menghapusnya dari database.

## Perubahan yang Dilakukan

### 1. Migration
- **File**: `database/migrations/2025_10_18_072356_add_soft_deletes_to_favorites_table.php`
- **Perubahan**: Menambahkan kolom `deleted_at` ke tabel `favorites`

### 2. Model Favorite
- **File**: `app/Models/Favorite.php`
- **Perubahan**: 
  - Menambahkan `use Illuminate\Database\Eloquent\SoftDeletes;`
  - Menambahkan `SoftDeletes` ke trait list: `use HasUuids, SoftDeletes;`

## Cara Penggunaan

### Soft Delete (Menghapus sementara)
```php
// Menghapus favorite (soft delete)
$favorite = Favorite::find(1);
$favorite->delete(); // Data tidak benar-benar dihapus, hanya ditandai dengan deleted_at

// Atau langsung dengan ID
Favorite::destroy(1);
```

### Mengambil Data (Otomatis Exclude Soft Deleted)
```php
// Mengambil semua favorites yang belum dihapus
$favorites = Favorite::all();

// Mengambil favorites untuk user tertentu
$userFavorites = Favorite::where('user_id', $userId)->get();
```

### Mengambil Data Termasuk yang Sudah Dihapus
```php
// Mengambil semua favorites termasuk yang sudah dihapus
$allFavorites = Favorite::withTrashed()->get();

// Mengambil hanya yang sudah dihapus
$deletedFavorites = Favorite::onlyTrashed()->get();
```

### Restore (Mengembalikan Data yang Dihapus)
```php
// Mengembalikan favorite yang sudah dihapus
$favorite = Favorite::withTrashed()->find(1);
$favorite->restore();

// Atau langsung dengan ID
Favorite::withTrashed()->find(1)->restore();
```

### Hard Delete (Menghapus Permanen)
```php
// Menghapus permanen (tidak bisa dikembalikan)
$favorite = Favorite::withTrashed()->find(1);
$favorite->forceDelete();

// Atau langsung dengan ID
Favorite::withTrashed()->find(1)->forceDelete();
```

## Keuntungan Soft Delete

1. **Data Recovery**: Data yang "terhapus" masih bisa dikembalikan
2. **Audit Trail**: Bisa melacak data yang pernah dihapus
3. **Referential Integrity**: Tidak merusak relasi dengan tabel lain
4. **User Experience**: User bisa "undo" aksi hapus

## Contoh Implementasi di Controller

```php
// Menghapus favorite dari daftar user
public function removeFavorite(Request $request)
{
    $favorite = Favorite::where('user_id', $request->user_id)
                       ->where('food_id', $request->food_id)
                       ->first();
    
    if ($favorite) {
        $favorite->delete(); // Soft delete
        return response()->json(['message' => 'Favorite removed successfully']);
    }
    
    return response()->json(['message' => 'Favorite not found'], 404);
}

// Mengembalikan favorite yang sudah dihapus
public function restoreFavorite(Request $request)
{
    $favorite = Favorite::withTrashed()
                       ->where('user_id', $request->user_id)
                       ->where('food_id', $request->food_id)
                       ->first();
    
    if ($favorite && $favorite->trashed()) {
        $favorite->restore();
        return response()->json(['message' => 'Favorite restored successfully']);
    }
    
    return response()->json(['message' => 'Favorite not found or not deleted'], 404);
}
```

## Status
✅ **SELESAI** - Soft delete telah berhasil ditambahkan ke tabel favorites dan siap digunakan.

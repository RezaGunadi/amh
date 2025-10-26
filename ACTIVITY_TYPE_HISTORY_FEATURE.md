# Fitur Activity Type untuk History

## Ringkasan
Telah ditambahkan kolom `activity_type` ke tabel history untuk melacak jenis aktivitas yang dilakukan user terhadap makanan.

## Perubahan Database

### Migration
- **File**: `2025_10_20_171429_add_activity_type_to_history_table.php`
- **Perubahan**: Menambahkan kolom `activity_type` dengan default value `'consumed'`
- **Posisi**: Setelah kolom `image_url`

```php
$table->string('activity_type')->default('consumed')->after('image_url');
```

### Model Update
- **File**: `app/Models/History.php`
- **Perubahan**: Menambahkan `'activity_type'` ke `$fillable` array

## Perubahan Controller

### Method `addHistory()`
- **File**: `app/Http/Controllers/api/ApiSiPintarController.php`
- **Perubahan**: Menambahkan `activity_type` ke data yang disimpan

```php
$history = History::create([
    'user_id' => $user->id,
    'food_id' => $food->id,
    'food_name' => $food->nama_makanan,
    'image_url' => $food->foto,
    'activity_type' => $reqData['activity_type'] ?? 'consumed', // Default: 'consumed'
    'consumed_at' => now()
]);
```

## Jenis Activity Type

### Default Values
- **`'consumed'`** - Default, ketika user mengkonsumsi makanan
- **`'planned'`** - Ketika user merencanakan untuk mengkonsumsi
- **`'skipped'`** - Ketika user melewatkan makanan yang direncanakan
- **`'shared'`** - Ketika user berbagi makanan dengan orang lain
- **`'wasted'`** - Ketika makanan terbuang

### Custom Values
Developer bisa menambahkan activity type lain sesuai kebutuhan aplikasi.

## Cara Penggunaan

### 1. Add History dengan Activity Type
```bash
POST /api/sipintar/add-history
Content-Type: application/json

{
    "mobile_token": "user_token",
    "food_id": "food_uuid",
    "activity_type": "consumed"  // Optional, default: "consumed"
}
```

### 2. Add History tanpa Activity Type (akan menggunakan default)
```bash
POST /api/sipintar/add-history
Content-Type: application/json

{
    "mobile_token": "user_token",
    "food_id": "food_uuid"
    // activity_type akan otomatis "consumed"
}
```

### 3. Get History dengan Activity Type
```bash
GET /api/sipintar/history
{
    "mobile_token": "user_token"
}

// Response akan include activity_type
{
    "error": false,
    "message": "History retrieved successfully",
    "data": [
        {
            "id": "history_uuid",
            "user_id": 123,
            "food_id": "food_uuid",
            "food_name": "Nasi Goreng",
            "image_url": "path/to/image.jpg",
            "activity_type": "consumed",
            "consumed_at": "2025-10-20T10:30:00.000000Z",
            "created_at": "2025-10-20T10:30:00.000000Z",
            "updated_at": "2025-10-20T10:30:00.000000Z"
        }
    ]
}
```

## Query Examples

### Filter History berdasarkan Activity Type
```php
// Get hanya consumed history
$consumedHistory = History::where('user_id', $userId)
                         ->where('activity_type', 'consumed')
                         ->get();

// Get planned activities
$plannedHistory = History::where('user_id', $userId)
                        ->where('activity_type', 'planned')
                        ->get();

// Get multiple activity types
$foodActivities = History::where('user_id', $userId)
                        ->whereIn('activity_type', ['consumed', 'planned'])
                        ->get();
```

### Statistics berdasarkan Activity Type
```php
// Count activities by type
$activityStats = History::where('user_id', $userId)
                       ->selectRaw('activity_type, COUNT(*) as count')
                       ->groupBy('activity_type')
                       ->get();

// Result:
// [
//     {"activity_type": "consumed", "count": 45},
//     {"activity_type": "planned", "count": 12},
//     {"activity_type": "skipped", "count": 3}
// ]
```

## Keuntungan

1. **Better Tracking**: Bisa melacak berbagai jenis aktivitas user
2. **Analytics**: Bisa menganalisis pola makan user
3. **Planning**: Bisa membedakan antara yang direncanakan vs yang dikonsumsi
4. **Flexibility**: Mudah menambahkan activity type baru
5. **Backward Compatibility**: Data lama tetap berfungsi dengan default value

## Use Cases

### 1. Meal Planning
- User bisa menandai makanan yang direncanakan (`planned`)
- Kemudian update menjadi `consumed` atau `skipped`

### 2. Food Waste Tracking
- User bisa menandai makanan yang terbuang (`wasted`)
- Untuk analisis pola konsumsi

### 3. Social Features
- User bisa menandai makanan yang dibagikan (`shared`)
- Untuk fitur social sharing

### 4. Health Analytics
- Analisis perbandingan planned vs consumed
- Tracking skipped meals
- Pattern analysis

## Migration Status
✅ **SELESAI** - Kolom `activity_type` telah berhasil ditambahkan ke tabel history dan siap digunakan.

## Testing
```bash
# Test add history dengan activity_type
curl -X POST http://localhost:8000/api/sipintar/add-history \
  -H "Content-Type: application/json" \
  -d '{
    "mobile_token": "test_token",
    "food_id": "food_uuid",
    "activity_type": "planned"
  }'

# Test get history (akan menampilkan activity_type)
curl -X GET "http://localhost:8000/api/sipintar/history?mobile_token=test_token"
```

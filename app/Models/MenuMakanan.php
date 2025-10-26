<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuMakanan extends Model
{
    use SoftDeletes;
    
    protected $table = 'menu_makanan';
    
    protected $fillable = [
        'nama_makanan',
        'kategori',
        'deskripsi_menu',
        'komposisi',
        'foto',
        'berat_g',
        'energi_kkal',
        'protein_gram',
        'lemak_gram',
        'karbohidrat_gram',
        'gula_gram',
        'natrium_mg',
        'serat_gram',
        'zat_besi_mg',
        'kalsium_mg',
        'skor_zat_gizi',
        'protein_persen',
        'lemak_persen',
        'gula_persen',
        'garam_persen',
        'serat_persen',
        'zat_besi_persen',
        'kalsium_persen',
        'is_active',
        'deleted_at',
    ];
    
    protected $casts = [
        'berat_g' => 'integer',
        'energi_kkal' => 'decimal:2',
        'protein_gram' => 'decimal:2',
        'lemak_gram' => 'decimal:2',
        'karbohidrat_gram' => 'decimal:2',
        'gula_gram' => 'decimal:2',
        'natrium_mg' => 'decimal:2',
        'serat_gram' => 'decimal:2',
        'zat_besi_mg' => 'decimal:2',
        'kalsium_mg' => 'decimal:2',
        'skor_zat_gizi' => 'integer',
        'protein_persen' => 'integer',
        'lemak_persen' => 'integer',
        'gula_persen' => 'integer',
        'garam_persen' => 'integer',
        'serat_persen' => 'integer',
        'zat_besi_persen' => 'integer',
        'kalsium_persen' => 'integer',
        'is_active' => 'boolean',
        'deleted_at' => 'datetime',
    ];
    
    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'food_id');
    }
    
    public function history()
    {
        return $this->hasMany(History::class, 'food_id');
    }
}

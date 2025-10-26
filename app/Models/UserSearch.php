<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSearch extends Model
{
    use SoftDeletes;
    protected $table = 'user_search';
    
    protected $fillable = [
        'user_id',
        'search_query',
    ];
}

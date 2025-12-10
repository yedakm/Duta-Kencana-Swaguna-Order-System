<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'slug'
    ];

    public function foods()
    {
        return $this->hasMany(Food::class);
    }

    public static function getTopCategory()
    {
        return self::withCount('foods')
            ->orderByDesc('foods_count')
            ->first();
    }
}

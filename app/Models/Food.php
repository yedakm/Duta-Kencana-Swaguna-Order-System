<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Food extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'foods';

    protected $fillable = [
        'name',
        'category_id',
        'price',
        'description',
        'image',
    ];

    public function getFormattedPriceAttribute()
    {
        $symbol = env('APP_CURRENCY_SYMBOL', 'Rp');
        return $symbol . number_format($this->price, 2, ',', '.');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function order_items()
    {
        return $this->hasMany(OrderItem::class);
    }

    protected static function booted()
    {
        static::creating(function ($food) {
            $food->slug = Str::slug($food->name);
        });

        static::updating(function ($food) {
            $food->slug = Str::slug($food->name);
        });
    }
}

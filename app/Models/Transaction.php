<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $primaryKey = 'invoice_id';
    public $incrementing = false;

    protected $fillable = [
        'invoice_id',
        'order_id',
        'user_id',
        'transaction_date',
        'payment_method',
        'amount',
        'payment_status',
    ];
}

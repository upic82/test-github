<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'shipping_id',
        'province_id',
        'city_id',
        'invoice',
        'weight',
        'address',
        'total',
        'status',
        'snap_token',
    ];

    public function TransactionDetails()
    {
        return $this->hasMany(Transaction::class);
    }

    public function shipping()
    {
        return $this->hasOne(Shipping::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
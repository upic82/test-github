<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'name', 'province_id'
    ];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}
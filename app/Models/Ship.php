<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ship extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'imo_number',
        'flag',
        'type',
        'gross_tonnage'
    ];

    // Transit ilişkisi: bir geminin birden çok transiti olabilir
    public function transits()
    {
        return $this->hasMany(Transit::class);
    }
}

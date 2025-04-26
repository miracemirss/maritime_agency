<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Need extends Model
{
    use HasFactory;
    protected $fillable = [
        'transit_id',
        'type',
        'item',
        'quantity',
        'unit',
        'currency',
        'tracking_no',
        'location',
        'requested_at',
        'delivered_at',
        'delivered',
        'notes'
    ];

    public function transit()
    {
        return $this->belongsTo(Transit::class);
    }

    // Transit ile ilişki (


}

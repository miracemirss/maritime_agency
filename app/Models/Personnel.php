<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
{
    use HasFactory;

    protected $fillable = [
        'transit_id',
        'movement',
        'full_name',
        'nationality',
        'rank',
        'movement_date',
        'visa_required',
        'hotel_needed',
        'meal_needed',
        'pickup_area',
        'flight_no',
    ];

    protected $casts = [
        'movement_date' => 'datetime',
        'visa_required' => 'boolean',
        'hotel_needed' => 'boolean',
        'meal_needed'   => 'boolean',
    ];

    public function transit()
    {
        return $this->belongsTo(Transit::class);
    }
}

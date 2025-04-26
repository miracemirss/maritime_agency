<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transit extends Model
{
    use HasFactory;

    protected $fillable = [
        'ship_id' ,
        'type',
        'direction' ,
        'location' ,
        'eta' ,
        'etd' ,
        'notes' 
    ];

    // Gemi ile ilişki (her transit bir gemiye ait)
    public function ship()
    {
        return $this->belongsTo(Ship::class);
    }

    // app/Models/Transit.php

public function needs()
{
    return $this->hasMany(Need::class);
}

}

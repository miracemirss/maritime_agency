<?php

namespace Database\Seeders;

use App\Models\Ship;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Ship::factory()->create([
             'name' => "Ship 1",
            'imo_number' => "IMO1234567",                       
            'flag' => "Flag 1",
            'gross_tonnage' => 10000
        ]);
    }
}

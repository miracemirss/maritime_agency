<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransitUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ship_id'    => 'sometimes|exists:ships,id',
            'type'       => 'sometimes|in:liman,transit', // liman mı transit mi
            'direction'  => 'nullable|string|max:50',     // NB, SB gibi
            'location'   => 'nullable|string|max:255',    // İstanbul, Çanakkale vs.
            'eta'        => 'nullable|date',              // Estimated Time of Arrival
            'etd'        => 'nullable|date|after_or_equal:eta', // Estimated Time of Departure
            'notes'      => 'nullable|string|max:1000',   // Notlar
        ];
    }

    public function attributes(): array
    {
        return [
            'ship_id'    => 'Gemi',
            'type'       => 'Geçiş türü',
            'direction'  => 'Yön',
            'location'   => 'Lokasyon',
            'eta'        => 'Varış zamanı (ETA)',
            'etd'        => 'Ayrılış zamanı (ETD)',
            'notes'      => 'Notlar',
        ];
    }
}

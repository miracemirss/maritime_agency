<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonnelUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        // İstersen burada auth kontrolü yapabilirsin.
        return true;
    }

    public function rules(): array
    {
        return [
            'transit_id'    => 'sometimes|exists:transits,id',
            'movement'      => 'sometimes|in:gelen,giden',
            'full_name'     => 'sometimes|string|max:255',
            'nationality'   => 'sometimes|string|max:100',
            'rank'          => 'nullable|string|max:100',
            'movement_date' => 'nullable|date',
            'visa_required' => 'nullable|boolean',
            'hotel_needed'  => 'nullable|boolean',
            'meal_needed'   => 'nullable|boolean',
            'pickup_area'   => 'nullable|string|max:255',
            'flight_no'     => 'nullable|string|max:100',
        ];
    }

    public function attributes(): array
    {
        return [
            'transit_id'    => 'Transit',
            'movement'      => 'Hareket yönü',
            'full_name'     => 'Tam ad',
            'nationality'   => 'Uyruk',
            'rank'          => 'Görev',
            'movement_date' => 'Hareket tarihi',
            'visa_required' => 'Vize gerekli mi',
            'hotel_needed'  => 'Otel ihtiyacı',
            'meal_needed'   => 'Yemek ihtiyacı',
            'pickup_area'   => 'Karşılanacak yer',
            'flight_no'     => 'Uçuş numarası',
        ];
    }
}

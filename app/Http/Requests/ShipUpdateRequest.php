<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShipUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'           => 'sometimes|string|max:255',
            'imo_number'     => 'sometimes|nullable|string|max:50',
            'flag'           => 'sometimes|string|max:100',
            'gross_tonnage'  => 'sometimes|nullable|numeric',
            'type'           => 'sometimes|nullable|string|max:100',
        ];
    }

    public function attributes(): array
    {
        return [
            'name'          => 'Gemi adı',
            'imo_number'    => 'IMO numarası',
            'flag'          => 'Bayrak',
            'gross_tonnage' => 'Gross tonaj',
            'type'          => 'Gemi tipi', 
        ];
    }
}

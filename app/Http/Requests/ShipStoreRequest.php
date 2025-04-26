<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShipStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'         => 'required|string|max:255',
            'imo_number'   => 'required|string|unique:ships,imo_number',
            'flag'         => 'nullable|string|max:100',
            'gross_tonnage'=> 'nullable|numeric|min:0',
            'type'         => 'nullable|string|max:100',
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

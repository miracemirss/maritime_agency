<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\SecurityTools;

class TransitStoreRequest extends FormRequest
{
    use SecurityTools;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ship_id'   => 'required|exists:ships,id',
            'type'      => 'required|in:liman,transit',
            'direction' => 'nullable|string|in:NB,SB,EB,WB',
            'location'  => 'nullable|string|max:255',
            'eta'       => 'nullable|date',
            'etd'       => 'nullable|date|after_or_equal:eta',
            'notes'     => 'nullable|string',
        ];
    }

    public function attributes(): array
    {
        return [
            'ship_id'   => 'Gemi',
            'type'      => 'Geçiş türü',
            'direction' => 'Yön',
            'location'  => 'Lokasyon',
            'eta'       => 'Varış zamanı',
            'etd'       => 'Ayrılış zamanı',
            'notes'     => 'Notlar',
        ];
    }

    protected function prepareForValidation(): void
    {
        $data = [];

        if ($this->filled('notes')) {
            $data['notes'] = $this->sanitizeInput($this->input('notes'));
        }

        if ($this->filled('type')) {
            $data['type'] = mb_strtolower($this->input('type'), 'UTF-8');
        }

        if ($this->filled('direction')) {
            $data['direction'] = strtoupper($this->input('direction'));
        }

        $this->merge($data);
    }
}

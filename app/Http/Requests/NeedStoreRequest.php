<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NeedStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'transit_id'   => 'required|exists:transits,id',
            'type'         => 'required|in:liman,transit,ikmal,para,numune,konaklama,lojistik,paket',
            'item'         => 'required|string|max:255',
            'quantity'     => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) {
                    if ($this->type !== 'para' && floor($value) != $value) {
                        $fail('Miktar tam sayı olmalı.');
                    }
                }
            ],
            'unit'         => 'nullable|string|max:50',
            'currency'     => 'nullable|string|max:3',
            'tracking_no'  => 'nullable|string|max:255',
            'location'     => 'nullable|string|max:255',
            'requested_at' => 'nullable|date',
            'delivered_at' => 'nullable|date',
            'delivered'    => 'nullable|boolean',
            'notes'        => 'nullable|string|max:1000',
        ];
    }

    public function attributes(): array
    {
        return [
            'transit_id'   => 'Transit',
            'type'         => 'İhtiyaç türü',
            'item'         => 'Ürün',
            'quantity'     => 'Miktar',
            'unit'         => 'Birim',
            'currency'     => 'Para birimi',
            'tracking_no'  => 'Takip numarası',
            'location'     => 'Lokasyon',
            'requested_at' => 'Talep zamanı',
            'delivered_at' => 'Teslim zamanı',
            'delivered'    => 'Teslim durumu',
            'notes'        => 'Notlar',
        ];
    }
}

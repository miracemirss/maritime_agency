<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NeedUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'transit_id'    => 'sometimes|exists:transits,id',
            'type'          => 'sometimes|in:liman,transit,ikmal,para,numune,konaklama,lojistik,paket',
            'item'          => 'sometimes|string|max:255',
            'quantity'      => 'sometimes|numeric',
            'unit'          => 'nullable|string|max:50',
            'currency'      => 'nullable|string|max:3',
            'tracking_no'   => 'nullable|string|max:255',
            'location'      => 'nullable|string|max:255',
            'requested_at'  => 'nullable|date',
            'delivered_at'  => 'nullable|date|after_or_equal:requested_at',
            'delivered'     => 'nullable|boolean',
            'notes'         => 'nullable|string|max:1000',
        ];
    }

    public function attributes(): array
    {
        return [
            'transit_id'    => 'Transit',
            'type'          => 'İhtiyaç türü',
            'item'          => 'Ürün/Hizmet',
            'quantity'      => 'Miktar',
            'unit'          => 'Birim',
            'currency'      => 'Para birimi',
            'tracking_no'   => 'Takip numarası',
            'location'      => 'Lokasyon',
            'requested_at'  => 'İsteme zamanı',
            'delivered_at'  => 'Teslim zamanı',
            'delivered'     => 'Teslim edildi mi',
            'notes'         => 'Notlar',
        ];
    }
}

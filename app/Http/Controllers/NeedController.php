<?php

namespace App\Http\Controllers;

use App\Models\Need;
use Illuminate\Http\Request;
use App\Http\Requests\NeedStoreRequest;

class NeedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Need::with('transit')->get();    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NeedStoreRequest $request)
    {
        $need = Need::create($request->validated());
    
        return response()->json($need, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Need $need)
    {
        //
        return $need->load('transit');
    // Transit ile ilişkilendirilmiş verileri yükle
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Need $need)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Need $need)
    {
        //
        $request->validate([
            'transit_id' => 'required|exists:transits,id',
            'type' => 'required|in:liman,transit,ikmal,para,numune,konaklama,lojistik,paket',
            'item' => 'required|string|max:255',
            'quantity' => [
    'required',
    'numeric',
    function ($attribute, $value, $fail) use ($request) {
        if ($request->type !== 'para' && floor($value) != $value) {
            $fail('Miktar tam sayı olmalı.');
        }
    }
],
            'unit' => 'nullable|string|max:50',
            'currency' => 'nullable|string|max:3',
            'tracking_no' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'requested_at' => 'nullable|date',
            'delivered_at' => 'nullable|date',
            'delivered' => 'nullable|boolean',
            'notes' => 'nullable|string|max:1000',   
        ]);
        $need->update([
            'transit_id' => $request->transit_id,
            'type' => $request->type,
            'item' => $request->item,
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'currency' => $request->currency,
            'tracking_no' => $request->tracking_no,
            'location' => $request->location,
            'requested_at' => $request->requested_at,
            'delivered_at' => $request->delivered_at,
            'delivered' => $request->delivered,
            'notes' => $request->notes
        ]);
        return response()->json($need, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Need $need)
    {
        //
        $need->delete();    
        return response()->json([
            'message' => 'Need deleted successfully'
        ], 200);    
    }
}

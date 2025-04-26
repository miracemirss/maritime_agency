<?php

namespace App\Http\Controllers;

use App\Models\Ship;
use Illuminate\Http\Request;

use App\Http\Requests\ShipStoreRequest;
use App\Http\Requests\ShipUpdateRequest;
use App\Http\Controllers\SecurityProcess;


class ShipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Ship::all();
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
    public function store(ShipStoreRequest $request)
    {
        $ship = Ship::create($request->validated());
    
        return response()->json([
            'message' => 'Gemi başarıyla oluşturuldu',
            'ship'    => $ship
        ], 201);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Ship $ship)
    {
        //
        return $ship;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ship $ship)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ShipUpdateRequest $request, $id)
{
    $ship = Ship::findOrFail($id); // ID ile gemi kaydı bulunur

    $ship->update($request->validated()); // Sadece doğrulanan verilerle update edilir

    return response()->json([
        'message' => 'Gemi başarıyla güncellendi.',
        'ship'    => $ship
    ]);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ship $ship)
    {
        //
        $ship->delete();
        return response()->json([
            'message' => 'Ship deleted successfully'
        ], 200);

    }
}

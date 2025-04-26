<?php

namespace App\Http\Controllers;

use App\Models\Need;
use Illuminate\Http\Request;
use App\Http\Requests\NeedStoreRequest;
use App\Http\Requests\NeedUpdateRequest;


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
    public function update(NeedUpdateRequest $request, $id)
{
    $need = Need::findOrFail($id); // ID ile ihtiyaç (need) kaydı aranır

    $need->update($request->validated()); // Sadece doğrulanan inputlar güncellenir

    return response()->json([
        'message' => 'İhtiyaç (need) başarıyla güncellendi',
        'need'    => $need
    ]);
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

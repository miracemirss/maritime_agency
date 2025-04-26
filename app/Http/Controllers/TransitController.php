<?php

namespace App\Http\Controllers;

use App\Models\Transit;
use Illuminate\Http\Request;
use App\Http\Requests\TransitStoreRequest;
use App\Http\Requests\TransitUpdateRequest;
class TransitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Transit::with('ship')->get();  
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
   

public function store(TransitStoreRequest $request)
{
  
    $transit = Transit::create($request->validated());

    return response()->json([
       'message' => 'Transit kaydı başarıyla oluşturuldu',
        'transit' => $transit
    ], 201);

   // dd('store methodu çalıştı', $request->all());
}

    /**
     * Display the specified resource.
     */
    public function show(Transit $transit)
    {
        //
        return $transit->load('ship');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transit $transit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TransitUpdateRequest $request, $id)
    {
        $transit = Transit::findOrFail($id); // ID'ye göre transit kaydı aranır
    
        $transit->update($request->validated()); // Sadece doğrulanan alanlar güncellenir
    
        return response()->json([
            'message' => 'Geçiş (transit) başarıyla güncellendi',
            'transit' => $transit
        ]);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transit $transit)
    {
        //
        $transit->delete();
        return response()->json([
            'message' => 'Transit deleted successfully'
        ], 200);
    }
}

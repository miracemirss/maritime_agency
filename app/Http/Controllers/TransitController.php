<?php

namespace App\Http\Controllers;

use App\Models\Transit;
use Illuminate\Http\Request;
use App\Http\Requests\TransitStoreRequest;
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
    public function update(Request $request, Transit $transit)
    {
        //
        $validationRules = [
            'ship_id' => 'required|exists:ships,id',
            'type' => 'required|in:liman,transit',
            'direction' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'eta' => 'nullable|date',
            'etd' => 'nullable|date',
            'notes' => 'nullable|string|max:1000',  
        ];
        $request->validate($validationRules);
        $transit->update([
            'ship_id' => $request->ship_id,
            'type' => $request->type,
            'direction' => $request->direction,
            'location' => $request->location,
            'eta' => $request->eta,
            'etd' => $request->etd,
            'notes' => $request->notes
        ]);
        return response()->json($transit, 200);
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

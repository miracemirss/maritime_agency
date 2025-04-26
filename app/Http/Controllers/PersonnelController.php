<?php

namespace App\Http\Controllers;

use App\Models\Personnel;
use Illuminate\Http\Request;
use App\Http\Requests\PersonnelStoreRequest;
use App\Http\Requests\PersonnelUpdateRequest;


class PersonnelController extends Controller
{
    public function index()
    {
        $personnels = Personnel::all();
        return response()->json($personnels);
    }

    public function store(PersonnelStoreRequest $request)
    {
        $personnel = Personnel::create($request->validated());

        return response()->json([
            'message'   => 'Personel başarıyla kaydedildi',
            'personnel' => $personnel
        ], 201);
    }

    public function show($id)
    {
        $personnel = Personnel::findOrFail($id);
        return response()->json($personnel);
    }

    public function update(PersonnelUpdateRequest $request, $id)
{
    $personnel = Personnel::findOrFail($id); // ID ile kayıt aranır

    $personnel->update($request->validated()); // Sadece doğrulanan alanlar güncellenir

    return response()->json([
        'message'   => 'Personel başarıyla güncellendi',
        'personnel' => $personnel
    ]);
}
    public function destroy($id)
    {
        $personnel = Personnel::findOrFail($id);
        $personnel->delete();

        return response()->json([
            'message' => 'Personel başarıyla silindi'
        ]);
    }
}

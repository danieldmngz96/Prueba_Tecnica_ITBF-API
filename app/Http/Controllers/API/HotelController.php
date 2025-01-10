<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HotelController extends Controller
{
    public function index()
    {
        try {
            $hoteles = Hotel::with('habitaciones')->get();
            return response()->json([
                'success' => true,
                'data' => $hoteles,
                'count' => $hoteles->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener hoteles',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|unique:hotels,nombre',
            'direccion' => 'required',
            'ciudad' => 'required',
            'nit' => 'required|unique:hotels,nit',
            'numero_habitaciones' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $hotel = Hotel::create($request->all());
        return response()->json($hotel, 201);
    }

    public function show($id)
    {
        $hotel = Hotel::with('habitaciones')->findOrFail($id);
        return response()->json($hotel);
    }

    public function update(Request $request, $id)
    {
        $hotel = Hotel::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|unique:hotels,nombre,' . $id,
            'direccion' => 'required',
            'ciudad' => 'required',
            'nit' => 'required|unique:hotels,nit,' . $id,
            'numero_habitaciones' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $hotel->update($request->all());
        return response()->json($hotel);
    }

    public function destroy($id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->delete();
        return response()->json(null, 204);
    }
} 
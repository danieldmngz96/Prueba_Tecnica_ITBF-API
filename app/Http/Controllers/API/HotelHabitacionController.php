<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\HotelHabitacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class HotelHabitacionController extends Controller
{
    private $tiposPermitidos = [
        'ESTANDAR' => ['SENCILLA', 'DOBLE'],
        'JUNIOR' => ['TRIPLE', 'CUADRUPLE'],
        'SUITE' => ['SENCILLA', 'DOBLE', 'TRIPLE']
    ];

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hotel_id' => 'required|exists:hotels,id',
            'tipo_habitacion' => 'required|in:ESTANDAR,JUNIOR,SUITE',
            'acomodacion' => 'required|in:SENCILLA,DOBLE,TRIPLE,CUADRUPLE',
            'cantidad' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Validar acomodación según tipo
        if (!in_array($request->acomodacion, $this->tiposPermitidos[$request->tipo_habitacion])) {
            return response()->json([
                'error' => 'Acomodación no permitida para este tipo de habitación'
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Crear la nueva habitación
            $habitacion = HotelHabitacion::create($request->all());

            // Obtener información actualizada
            $hotel = Hotel::findOrFail($request->hotel_id);
            $habitacionesActuales = $hotel->habitaciones->sum('cantidad');

            DB::commit();

            return response()->json([
                'message' => 'Habitación creada exitosamente',
                'data' => $habitacion,
                'habitaciones_totales' => $habitacionesActuales,
                'info_hotel' => [
                    'nombre' => $hotel->nombre,
                    'capacidad_configurada' => $hotel->numero_habitaciones
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Error al crear la habitación',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $habitacion = HotelHabitacion::findOrFail($id);
            $hotel_id = $habitacion->hotel_id;
            $habitacion->delete();
            
            // Obtener información actualizada después de eliminar
            $hotel = Hotel::findOrFail($hotel_id);
            $habitacionesActuales = $hotel->habitaciones->sum('cantidad');
            
            return response()->json([
                'message' => 'Habitación eliminada exitosamente',
                'habitaciones_totales' => $habitacionesActuales,
                'info_hotel' => [
                    'nombre' => $hotel->nombre,
                    'capacidad_configurada' => $hotel->numero_habitaciones
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al eliminar la habitación',
                'message' => $e->getMessage()
            ], 500);
        }
    }
} 
<?php

use App\Http\Controllers\API\HotelController;
use App\Http\Controllers\API\HotelHabitacionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Ruta de bienvenida
Route::get('/', function () {
    return response()->json([
        'mensaje' => 'hola mundo',
        'api_version' => '1.0',
        'status' => 'active'
    ]);
});

// Rutas para hoteles
Route::group(['prefix' => 'v1'], function () {
    Route::get('/hoteles', [HotelController::class, 'index']);
    Route::post('/hoteles', [HotelController::class, 'store']);
    Route::get('/hoteles/{id}', [HotelController::class, 'show']);
    Route::put('/hoteles/{id}', [HotelController::class, 'update']);
    Route::delete('/hoteles/{id}', [HotelController::class, 'destroy']);
    
    // Rutas de habitaciones
    Route::post('/hotel-habitaciones', [HotelHabitacionController::class, 'store']);
    Route::delete('/hotel-habitaciones/{id}', [HotelHabitacionController::class, 'destroy']);
});

// Ruta para manejar rutas no encontradas
Route::fallback(function () {
    return response()->json([
        'mensaje' => 'Ruta no encontrada',
        'error' => 'Not Found'
    ], 404);
});

// Añade esta ruta para probar la conexión
Route::get('/v1/db-test', function () {
    try {
        \DB::connection()->getPdo();
        return response()->json([
            'success' => true,
            'message' => 'Base de datos conectada correctamente',
            'database' => \DB::connection()->getDatabaseName()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error de conexión a la base de datos',
            'error' => $e->getMessage()
        ], 500);
    }
});

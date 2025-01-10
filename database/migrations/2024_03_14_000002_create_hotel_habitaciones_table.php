<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('hotel_habitaciones');

        Schema::create('hotel_habitaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained('hotels')->onDelete('cascade');
            $table->enum('tipo_habitacion', ['ESTANDAR', 'JUNIOR', 'SUITE']);
            $table->enum('acomodacion', ['SENCILLA', 'DOBLE', 'TRIPLE', 'CUADRUPLE']);
            $table->integer('cantidad');
            $table->timestamps();
        });

        // Insertar datos de prueba
        DB::table('hotel_habitaciones')->insert([
            [
                'hotel_id' => 1,
                'tipo_habitacion' => 'ESTANDAR',
                'acomodacion' => 'SENCILLA',
                'cantidad' => 25,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'hotel_id' => 1,
                'tipo_habitacion' => 'JUNIOR',
                'acomodacion' => 'TRIPLE',
                'cantidad' => 12,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'hotel_id' => 1,
                'tipo_habitacion' => 'ESTANDAR',
                'acomodacion' => 'DOBLE',
                'cantidad' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'hotel_id' => 2,
                'tipo_habitacion' => 'SUITE',
                'acomodacion' => 'DOBLE',
                'cantidad' => 8,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'hotel_id' => 2,
                'tipo_habitacion' => 'JUNIOR',
                'acomodacion' => 'CUADRUPLE',
                'cantidad' => 15,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('hotel_habitaciones');
    }
}; 
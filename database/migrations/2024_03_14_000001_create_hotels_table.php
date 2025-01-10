<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('hotels');
        
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->string('direccion');
            $table->string('ciudad');
            $table->string('nit')->unique();
            $table->integer('numero_habitaciones');
            $table->timestamps();
        });

        // Insertar datos de prueba
        DB::table('hotels')->insert([
            [
                'nombre' => 'DECAMERON CARTAGENA',
                'direccion' => 'CALLE 23 58-25',
                'ciudad' => 'CARTAGENA',
                'nit' => '12345678-9',
                'numero_habitaciones' => 42,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'DECAMERON SAN ANDRÉS',
                'direccion' => 'AV PLAYA 123',
                'ciudad' => 'SAN ANDRÉS',
                'nit' => '98765432-1',
                'numero_habitaciones' => 35,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('hotels');
    }
}; 
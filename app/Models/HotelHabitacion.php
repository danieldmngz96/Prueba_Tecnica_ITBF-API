<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelHabitacion extends Model
{
    use HasFactory;

    protected $table = 'hotel_habitaciones';

    protected $fillable = [
        'hotel_id',
        'tipo_habitacion',
        'acomodacion',
        'cantidad'
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
} 
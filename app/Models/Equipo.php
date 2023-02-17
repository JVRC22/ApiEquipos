<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    protected $table = 'equipos';
    protected $fillable = ['nombre', 'division', 'campeonatos', 'estado', 'propietario'];
    protected $hidden = ['created_at', 'updated_at'];

    public function propietario()
    {
        return $this->belongsTo(Propietario::class);
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }

    public function jugadores()
    {
        return $this->hasMany(Jugador::class);
    }
}

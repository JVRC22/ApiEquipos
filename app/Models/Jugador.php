<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jugador extends Model
{
    use HasFactory;

    protected $table = 'jugadores';
    protected $fillable = ['nombre', 'ap_paterno', 'ap_materno', 'sexo', 'f_nac', 'equipo'];
    protected $hidden = ['created_at', 'updated_at'];

    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propietario extends Model
{
    use HasFactory;

    protected $table = 'propietarios';
    protected $fillable = ['nombre', 'ap_paterno', 'ap_materno', 'sexo', 'f_nac'];
    protected $hidden = ['created_at', 'updated_at'];

    public function equipos()
    {
        return $this->hasMany(Equipo::class);
    }
}

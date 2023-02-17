<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partido extends Model
{
    use HasFactory;

    protected $table = 'partidos';
    protected $fillable = ['local', 'visitante', 'fecha', 'hora'];
    protected $hidden = ['created_at', 'updated_at'];

    public function local()
    {
        return $this->belongsToMany(Equipo::class);
    }

    public function visitante()
    {
        return $this->belongsToMany(Equipo::class);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Partido;

use App\Models\Equipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Query\JoinClause;

class PartidosController extends Controller
{
    public function agregar(Request $request)
    {
        $validacion = Validator::make(
            $request->all(), 
            [
                'local' => 'required|integer|min:1|max:100|exists:equipos,id',
                'visitante' => 'required|integer|min:1|max:100|exists:equipos,id|different:local',
                'fecha' => 'required|date',
                'hora' => 'required|date_format:H:i',
            ],
            [
                'local.required' => 'El equipo local es requerido',
                'local.integer' => 'El equipo local debe ser un número entero',
                'local.min' => 'El equipo local debe ser un número entero mayor a 0',
                'local.max' => 'El equipo local debe ser un número entero menor a 100',
                'local.exists' => 'El equipo local no existe',

                'visitante.required' => 'El equipo visitante es requerido',
                'visitante.integer' => 'El equipo visitante debe ser un número entero',
                'visitante.min' => 'El equipo visitante debe ser un número entero mayor a 0',
                'visitante.max' => 'El equipo visitante debe ser un número entero menor a 100',
                'visitante.exists' => 'El equipo visitante no existe',
                'visitante.different' => 'El equipo visitante debe ser diferente al equipo local',

                'fecha.required' => 'La fecha es requerida',
                'fecha.date' => 'La fecha debe ser una fecha válida',

                'hora.required' => 'La hora es requerida',
                'hora.date_format' => 'La hora debe tener el formato HH:MM',
            ]
        );

        if ($validacion->fails()) 
        {
            return response()->json([
                'message' => $validacion->errors()
            ], 400);
        }

        else
        {
            $partido = Partido::create([
                'local' => $request->local,
                'visitante' => $request->visitante,
                'fecha' => $request->fecha,
                'hora' => $request->hora,
            ]);
    
            if ($partido->save()) 
            {
                return $partido;
            }
    
            else
            {
                return response()->json([
                    'message' => 'No se pudo agregar el partido'
                ], 500);
            }
        }
    }

    public function editar(Request $request, $id)
    {
        $validacion = Validator::make(
            $request->all(), 
            [
                'local' => 'required|integer|min:1|max:100|exists:equipos,id',
                'visitante' => 'required|integer|min:1|max:100|exists:equipos,id|different:local',
                'fecha' => 'required|date',
                'hora' => 'required|date_format:H:i',
            ],
            [
                'local.required' => 'El equipo local es requerido',
                'local.integer' => 'El equipo local debe ser un número entero',
                'local.min' => 'El equipo local debe ser un número entero mayor a 0',
                'local.max' => 'El equipo local debe ser un número entero menor a 100',
                'local.exists' => 'El equipo local no existe',

                'visitante.required' => 'El equipo visitante es requerido',
                'visitante.integer' => 'El equipo visitante debe ser un número entero',
                'visitante.min' => 'El equipo visitante debe ser un número entero mayor a 0',
                'visitante.max' => 'El equipo visitante debe ser un número entero menor a 100',
                'visitante.exists' => 'El equipo visitante no existe',
                'visitante.different' => 'El equipo visitante debe ser diferente al equipo local',

                'fecha.required' => 'La fecha es requerida',
                'fecha.date' => 'La fecha debe ser una fecha válida',

                'hora.required' => 'La hora es requerida',
                'hora.date_format' => 'La hora debe tener el formato HH:MM',
            ]
        );

        if ($validacion->fails())
        {
            return response()->json([
                'message' => $validacion->errors()
            ], 400);
        }

        $partido = Partido::find($id);

        if ($partido)
        {
            $partido->local = $request->local;
            $partido->visitante = $request->visitante;
            $partido->fecha = $request->fecha;
            $partido->hora = $request->hora;

            if ($partido->save())
            {
                return $partido;
            }

            else
            {
                return response()->json([
                    'message' => 'No se pudo editar el partido'
                ], 500);
            }
        }

        else
        {
            return response()->json([
                'message' => 'No se encontró el partido'
            ], 404);
        }
    }

    public function eliminar($id)
    {
        $partido = Partido::find($id);

        if ($partido)
        {
            if ($partido->delete())
            {
                return response()->json([
                    'message' => 'Partido eliminado correctamente'
                ], 200);
            }

            else
            {
                return response()->json([
                    'message' => 'No se pudo eliminar el partido'
                ], 500);
            }
        }

        else
        {
            return response()->json([
                'message' => 'No se encontró el partido'
            ], 404);
        }
    }

    public function mostrar()
    {
            /* SELECT C1.id,C1.local,equipos.nombre as visitante,C1.fecha,C1.hora from

        (SELECT partidos.id,equipos.nombre as local,partidos.visitante,partidos.fecha,partidos.hora from partidos inner join equipos
        on equipos.id=partidos.local) AS C1 inner join equipos
                on equipos.id = C1.visitante*/
        $partidos1 = Partido::Select("partidos.id","equipos.nombre as local","partidos.visitante","partidos.fecha","partidos.hora")
        ->join("equipos","equipos.id" ,"=" ,"partidos.local");

        $partidos=Equipo::Select("C1.id","C1.local","equipos.nombre as visitante","C1.fecha","C1.hora")
        ->joinSub($partidos1,'C1',function (JoinClause $join){
            $join->on('equipos.id','=','C1.visitante');
        })->get();
        
        if ($partidos)
        {
            return $partidos;
        }

        else
        {
            return response()->json([
                'message' => 'No se encontraron partidos'
            ], 404);
        }
    }

    public function mostrarUnico($id)
    {
        $partido = Partido::find($id);

        if ($partido)
        {
            return $partido;
        }

        else
        {
            return response()->json([
                'message' => 'No se encontró el partido'
            ], 404);
        }
    }
}

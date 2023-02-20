<?php

namespace App\Http\Controllers;

use App\Models\Jugador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JugadoresController extends Controller
{
    public function agregar(Request $request)
    {
        $validacion = Validator::make(
            $request->all(), 
            [
                'nombre' => 'required|string|min:3|max:20',
                'ap_paterno' => 'required|string|min:3|max:20',
                'ap_materno' => 'required|string|min:3|max:20',
                'sexo' => 'required|string|in:M,F',
                'f_nac' => 'required|date',
                'equipo' => 'required|integer|min:1|max:100|exists:equipos,id',
            ],
            [
                'nombre.required' => 'El nombre es requerido',
                'nombre.string' => 'El nombre debe ser una cadena de caracteres',
                'nombre.min' => 'El nombre debe tener al menos 3 caracteres',
                'nombre.max' => 'El nombre debe tener como máximo 20 caracteres',

                'ap_paterno.required' => 'El apellido paterno es requerido',
                'ap_paterno.string' => 'El apellido paterno debe ser una cadena de caracteres',
                'ap_paterno.min' => 'El apellido paterno debe tener al menos 3 caracteres',
                'ap_paterno.max' => 'El apellido paterno debe tener como máximo 20 caracteres',

                'ap_materno.required' => 'El apellido materno es requerido',
                'ap_materno.string' => 'El apellido materno debe ser una cadena de caracteres',
                'ap_materno.min' => 'El apellido materno debe tener al menos 3 caracteres',
                'ap_materno.max' => 'El apellido materno debe tener como máximo 20 caracteres',

                'sexo.required' => 'El sexo es requerido',
                'sexo.string' => 'El sexo debe ser una cadena de caracteres',
                'sexo.in' => 'El sexo debe ser M o F',

                'f_nac.required' => 'La fecha de nacimiento es requerida',
                'f_nac.date' => 'La fecha de nacimiento debe ser una fecha válida',

                'equipo.required' => 'El equipo es requerido',
                'equipo.integer' => 'El equipo debe ser un número entero',
                'equipo.min' => 'El equipo debe ser un número entero mayor a 0',
                'equipo.max' => 'El equipo debe ser un número entero menor a 100',
                'equipo.exists' => 'El equipo no existe',
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
            $jugador = Jugador::create([
                "nombre" => $request->nombre,
                "ap_paterno" => $request->ap_paterno,
                "ap_materno" => $request->ap_materno,
                "sexo" => $request->sexo,
                "f_nac" => $request->f_nac,
                "equipo" => $request->equipo
            ]);
    
            if ($jugador->save()) 
            {
                return $jugador;
            } 
            
            else 
            {
                return response()->json([
                    'message' => 'No se pudo agregar el jugador'
                ], 500);
            }
        }
    }

    public function editar(Request $request, $id)
    {
        $validacion = Validator::make(
            $request->all(), 
            [
                'nombre' => 'required|string|min:3|max:20',
                'ap_paterno' => 'required|string|min:3|max:20',
                'ap_materno' => 'required|string|min:3|max:20',
                'sexo' => 'required|string|in:M,F',
                'f_nac' => 'required|date',
                'equipo' => 'required|integer|min:1|max:100|exists:equipos,id',
            ],
            [
                'nombre.required' => 'El nombre es requerido',
                'nombre.string' => 'El nombre debe ser una cadena de caracteres',
                'nombre.min' => 'El nombre debe tener al menos 3 caracteres',
                'nombre.max' => 'El nombre debe tener como máximo 20 caracteres',

                'ap_paterno.required' => 'El apellido paterno es requerido',
                'ap_paterno.string' => 'El apellido paterno debe ser una cadena de caracteres',
                'ap_paterno.min' => 'El apellido paterno debe tener al menos 3 caracteres',
                'ap_paterno.max' => 'El apellido paterno debe tener como máximo 20 caracteres',

                'ap_materno.required' => 'El apellido materno es requerido',
                'ap_materno.string' => 'El apellido materno debe ser una cadena de caracteres',
                'ap_materno.min' => 'El apellido materno debe tener al menos 3 caracteres',
                'ap_materno.max' => 'El apellido materno debe tener como máximo 20 caracteres',

                'sexo.required' => 'El sexo es requerido',
                'sexo.string' => 'El sexo debe ser una cadena de caracteres',
                'sexo.in' => 'El sexo debe ser M o F',

                'f_nac.required' => 'La fecha de nacimiento es requerida',
                'f_nac.date' => 'La fecha de nacimiento debe ser una fecha válida',

                'equipo.required' => 'El equipo es requerido',
                'equipo.integer' => 'El equipo debe ser un número entero',
                'equipo.min' => 'El equipo debe ser un número entero mayor a 0',
                'equipo.max' => 'El equipo debe ser un número entero menor a 100',
                'equipo.exists' => 'El equipo no existe',
            ]
        );

        if ($validacion->fails()) 
        {
            return response()->json([
                'message' => $validacion->errors()
            ], 400);
        }

        $jugador = Jugador::find($id);

        if ($jugador) 
        {
            $jugador->nombre = $request->nombre;
            $jugador->ap_paterno = $request->ap_paterno;
            $jugador->ap_materno = $request->ap_materno;
            $jugador->sexo = $request->sexo;
            $jugador->f_nac = $request->f_nac;
            $jugador->equipo = $request->equipo;

            if ($jugador->save()) 
            {
                return $jugador;
            } 
            
            else 
            {
                return response()->json([
                    'message' => 'No se pudo editar el jugador'
                ], 500);
            }
        } 
        
        else 
        {
            return response()->json([
                'message' => 'No se encontró el jugador'
            ], 404);
        }
    }

    public function eliminar($id)
    {
        $jugador = Jugador::find($id);

        if ($jugador) 
        {
            if ($jugador->delete()) 
            {
                return response()->json([
                    'message' => 'Jugador eliminado'
                ], 200);
            } 
            
            else 
            {
                return response()->json([
                    'message' => 'No se pudo eliminar el jugador'
                ], 500);
            }
        } 
        
        else 
        {
            return response()->json([
                'message' => 'No se encontró el jugador'
            ], 404);
        }
    }

    public function mostrar()
    {
        $jugadores=Jugador::Select("jugadores.id","jugadores.nombre","jugadores.ap_paterno","jugadores.ap_materno","jugadores.sexo","jugadores.f_nac",
        "equipos.nombre as equipo")
        ->join("equipos","jugadores.equipo" ,"=" ,"equipos.id") 
         ->get();

        if ($jugadores) 
        {
            return $jugadores;
        } 
        
        else 
        {
            return response()->json([
                'message' => 'No se encontraron jugadores'
            ], 404);
        }
    }

    public function mostrarUnico($id)
    {
        $jugador = Jugador::find($id);

        if ($jugador) 
        {
            return $jugador;
        } 
        
        else 
        {
            return response()->json([
                'message' => 'No se encontró el jugador'
            ], 404);
        }
    }
}

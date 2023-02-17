<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EquiposController extends Controller
{
    public function agregar(Request $request)
    {
        $validacion = Validator::make(
            $request->all(), 
            [
                'nombre' => 'required|string|min:3|max:20',
                'division' => 'required|integer|min:1|max:3',
                'campeonatos' => 'required|integer|min:0|max:100',
                'estado' => 'required|integer|min:1|max:32,exists:estados,id',
                'propietario' => 'required|integer|min:1|max:100|exists:propietarios,id'
            ],
            [
                'nombre.required' => 'El nombre es requerido',
                'nombre.string' => 'El nombre debe ser una cadena de caracteres',
                'nombre.min' => 'El nombre debe tener al menos 3 caracteres',
                'nombre.max' => 'El nombre debe tener como máximo 20 caracteres',

                'division.required' => 'La división es requerida',
                'division.integer' => 'La división debe ser un número entero',
                'division.min' => 'La división debe ser 1, 2 o 3',
                'division.max' => 'La división debe ser 1, 2 o 3',

                'campeonatos.required' => 'El número de campeonatos es requerido',
                'campeonatos.integer' => 'El número de campeonatos debe ser un número entero',
                'campeonatos.min' => 'El número de campeonatos debe ser un número entero mayor o igual a 0',
                'campeonatos.max' => 'El número de campeonatos debe ser un número entero menor o igual a 100',

                'estado.required' => 'El estado es requerido',
                'estado.integer' => 'El estado debe ser un número entero',
                'estado.min' => 'El estado debe ser un número entero mayor o igual a 1',
                'estado.max' => 'El estado debe ser un número entero menor o igual a 32',
                'estado.exists' => 'El estado no existe',

                'propietario.required' => 'El propietario es requerido',
                'propietario.integer' => 'El propietario debe ser un número entero',
                'propietario.min' => 'El propietario debe ser un número entero mayor o igual a 1',
                'propietario.max' => 'El propietario debe ser un número entero menor o igual a 100',
                'propietario.exists' => 'El propietario no existe'
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
            $equipo = Equipo::create([
                "nombre" => $request->nombre,
                "division" => $request->division,
                "campeonatos" => $request->campeonatos,
                "estado" => $request->estado,
                "propietario" => $request->propietario
            ]);
    
            if ($equipo->save()) 
            {
                return $equipo;
            } 
            
            else 
            {
                return response()->json([
                    'message' => 'No se pudo agregar el equipo'
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
                'division' => 'required|integer|min:1|max:3',
                'campeonatos' => 'required|integer|min:0|max:100',
                'estado' => 'required|integer|min:1|max:32|exists:estados,id',
                'propietario' => 'required|integer|min:1|max:100|exists:propietarios,id'
            ],
            [
                'nombre.required' => 'El nombre es requerido',
                'nombre.string' => 'El nombre debe ser una cadena de caracteres',
                'nombre.min' => 'El nombre debe tener al menos 3 caracteres',
                'nombre.max' => 'El nombre debe tener como máximo 20 caracteres',

                'division.required' => 'La división es requerida',
                'division.integer' => 'La división debe ser un número entero',
                'division.min' => 'La división debe ser 1, 2 o 3',
                'division.max' => 'La división debe ser 1, 2 o 3',

                'campeonatos.required' => 'El número de campeonatos es requerido',
                'campeonatos.integer' => 'El número de campeonatos debe ser un número entero',
                'campeonatos.min' => 'El número de campeonatos debe ser un número entero mayor o igual a 0',
                'campeonatos.max' => 'El número de campeonatos debe ser un número entero menor o igual a 100',

                'estado.required' => 'El estado es requerido',
                'estado.integer' => 'El estado debe ser un número entero',
                'estado.min' => 'El estado debe ser un número entero mayor o igual a 1',
                'estado.max' => 'El estado debe ser un número entero menor o igual a 32',
                'estado.exists' => 'El estado no existe',

                'propietario.required' => 'El propietario es requerido',
                'propietario.integer' => 'El propietario debe ser un número entero',
                'propietario.min' => 'El propietario debe ser un número entero mayor o igual a 1',
                'propietario.max' => 'El propietario debe ser un número entero menor o igual a 100',
                'propietario.exists' => 'El propietario no existe'
            ]
        );

        if ($validacion->fails()) 
        {
            return response()->json([
                'message' => $validacion->errors()
            ], 400);
        }

        $equipo = Equipo::find($id);

        if ($equipo) 
        {
            $equipo->nombre = $request->nombre;
            $equipo->division = $request->division;
            $equipo->campeonatos = $request->campeonatos;
            $equipo->estado = $request->estado;
            $equipo->propietario = $request->propietario;

            if ($equipo->save()) 
            {
                return $equipo;
            } 
            
            else 
            {
                return response()->json([
                    'message' => 'No se pudo editar el equipo'
                ], 500);
            }
        } 
        
        else 
        {
            return response()->json([
                'message' => 'No se encontró el equipo'
            ], 404);
        }
    }

    public function eliminar($id)
    {
        $equipo = Equipo::find($id);

        if ($equipo) 
        {
            if ($equipo->delete()) 
            {
                return response()->json([
                    'message' => 'Equipo eliminado'
                ], 200);
            } 
            
            else 
            {
                return response()->json([
                    'message' => 'No se pudo eliminar el equipo'
                ], 500);
            }
        } 
        
        else 
        {
            return response()->json([
                'message' => 'No se encontró el equipo'
            ], 404);
        }
    }

    public function mostrar()
    {
        $equipos = Equipo::all();

        if ($equipos) 
        {
            return $equipos;
        } 
        
        else 
        {
            return response()->json([
                'message' => 'No se encontraron equipos'
            ], 404);
        }
    }

    public function mostarUnico($id)
    {
        $equipo = Equipo::find($id);

        if ($equipo) 
        {
            return $equipo;
        } 
        
        else 
        {
            return response()->json([
                'message' => 'No se encontró el equipo'
            ], 404);
        }
    }
}

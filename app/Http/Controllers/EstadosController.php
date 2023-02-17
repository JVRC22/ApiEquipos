<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EstadosController extends Controller
{
    public function agregar(Request $request)
    {
        $validacion = Validator::make(
            $request->all(), 
            [
                'nombre' => 'required|string|min:3|max:20|unique:estados,nombre',
            ],
            [
                'nombre.required' => 'El nombre es requerido',
                'nombre.string' => 'El nombre debe ser una cadena de caracteres',
                'nombre.min' => 'El nombre debe tener al menos 3 caracteres',
                'nombre.max' => 'El nombre debe tener como máximo 20 caracteres',
                'nombre.unique' => 'El nombre ya está en uso',
            ]
        );

        if ($validacion->fails()) {
            return response()->json([
                'message' => $validacion->errors()
            ], 400);
        }

        else
        {
            $estado = Estado::create([
                "nombre" => $request->nombre
            ]);
    
            if ($estado->save()) {
                return $estado;
            } 
            
            else {
                return response()->json([
                    'message' => 'No se pudo agregar el estado'
                ], 500);
            }
        }
    }

    public function editar(Request $request, $id)
    {
        $validacion = Validator::make(
            $request->all(), 
            [
                'nombre' => 'required|string|min:3|max:20|unique:estados,nombre',
            ],
            [
                'nombre.required' => 'El nombre es requerido',
                'nombre.string' => 'El nombre debe ser una cadena de caracteres',
                'nombre.min' => 'El nombre debe tener al menos 3 caracteres',
                'nombre.max' => 'El nombre debe tener como máximo 20 caracteres',
                'nombre.unique' => 'El nombre ya está en uso',
            ]
        );

        if ($validacion->fails()) {
            return response()->json([
                'message' => $validacion->errors()
            ], 400);
        }

        $estado = Estado::find($id);

        if ($estado) {
            $estado->nombre = $request->nombre;

            if ($estado->save()) {
                return $estado;
            } 
            
            else {
                return response()->json([
                    'message' => 'No se pudo editar el estado'
                ], 500);
            }
        } 
        
        else {
            return response()->json([
                'message' => 'No se encontró el estado'
            ], 404);
        }
    }

    public function eliminar($id)
    {
        $estado = Estado::find($id);

        if ($estado) 
        {
            if ($estado->delete()) 
            {
                return response()->json([
                    'message' => 'Estado eliminado'
                ], 200);
            } 
            
            else 
            {
                return response()->json([
                    'message' => 'No se pudo eliminar el estado'
                ], 500);
            }
        } 
        
        else {
            return response()->json([
                'message' => 'No se encontró el estado'
            ], 404);
        }
    }

    public function mostrar()
    {
        $estados = Estado::all();

        if ($estados) 
        {
            return $estados;
        } 
        
        else 
        {
            return response()->json([
                'message' => 'No se encontraron estados'
            ], 404);
        }
    }

    public function mostrarUnico($id)
    {
        $estado = Estado::find($id);

        if ($estado) 
        {
            return $estado;
        } 
        
        else 
        {
            return response()->json([
                'message' => 'No se encontró el estado'
            ], 404);
        }
    }
}

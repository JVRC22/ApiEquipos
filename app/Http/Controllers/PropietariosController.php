<?php

namespace App\Http\Controllers;

use App\Models\Propietario;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PropietariosController extends Controller
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
                'f_nac.date' => 'La fecha de nacimiento debe ser una fecha válida'
            ]
        );

        if ($validacion->fails()) {
            return response()->json([
                'message' => $validacion->errors()
            ], 400);
        }

        else
        {
            $propietario = Propietario::create([
                "nombre" => $request->nombre,
                "ap_paterno" => $request->ap_paterno,
                "ap_materno" => $request->ap_materno,
                "sexo" => $request->sexo,
                "f_nac" => $request->f_nac
            ]);
    
            if ($propietario->save()) 
            {
                return $propietario;
            } 
            
            else 
            {
                return response()->json([
                    'message' => 'No se pudo crear el propietario'
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
                'f_nac.date' => 'La fecha de nacimiento debe ser una fecha válida'
            ]
        );

        if ($validacion->fails()) {
            return response()->json([
                'message' => $validacion->errors()
            ], 400);
        }

        $propietario = Propietario::find($id);

        if ($propietario) 
        {
            $propietario->nombre = $request->nombre;
            $propietario->ap_paterno = $request->ap_paterno;
            $propietario->ap_materno = $request->ap_materno;
            $propietario->sexo = $request->sexo;
            $propietario->f_nac = $request->f_nac;

            if ($propietario->save()) 
            {
                return $propietario;
            } 
            
            else 
            {
                return response()->json([
                    'message' => 'No se pudo actualizar el propietario'
                ], 500);
            }
        } 
        
        else 
        {
            return response()->json([
                'message' => 'No se encontró el propietario'
            ], 404);
        }
    }

    public function eliminar($id)
    {
        $propietario = Propietario::find($id);

        if ($propietario) 
        {
            if ($propietario->delete()) 
            {
                return response()->json([
                    'message' => 'Propietario eliminado'
                ], 200);
            } 
            
            else 
            {
                return response()->json([
                    'message' => 'No se pudo eliminar el propietario'
                ], 500);
            }
        } 
        
        else 
        {
            return response()->json([
                'message' => 'No se encontró el propietario'
            ], 404);
        }
    }

    public function mostrar()
    {
        $propietarios = Propietario::all();

        if ($propietarios) 
        {
            return $propietarios;
        } 
        
        else 
        {
            return response()->json([
                'message' => 'No se encontraron propietarios'
            ], 404);
        }
    }

    public function mostrarUnico($id)
    {
        $propietario = Propietario::find($id);

        if ($propietario) 
        {
            return $propietario;
        } 
        
        else 
        {
            return response()->json([
                'message' => 'No se encontró el propietario'
            ], 404);
        }
    }
}

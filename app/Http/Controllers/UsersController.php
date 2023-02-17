<?php

namespace App\Http\Controllers;

use App\Jobs\CorreoVerificacionJob;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isNull;

class UsersController extends Controller
{
    //Gestion de cuentas
    public function register(Request $request)
    {
        $validacion = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'phone' => 'required|integer',
            ],
            [
                'name.required' => 'El nombre es requerido',
                'name.string' => 'El nombre debe ser una cadena de texto',
                'name.max' => 'El nombre debe tener como máximo 255 caracteres',

                'email.required' => 'El correo electrónico es requerido',
                'email.string' => 'El correo electrónico debe ser una cadena de texto',
                'email.email' => 'El correo electrónico debe ser un correo electrónico válido',
                'email.max' => 'El correo electrónico debe tener como máximo 255 caracteres',
                'email.unique' => 'El correo electrónico ya está registrado',

                'password.required' => 'La contraseña es requerida',
                'password.string' => 'La contraseña debe ser una cadena de texto',
                'password.min' => 'La contraseña debe tener como mínimo 8 caracteres',
                'password.confirmed' => 'Las contraseñas no coinciden',

                'phone.required' => 'El teléfono es requerido',
                'phone.integer' => 'El teléfono debe ser un número entero',
            ]
        );

        if ($validacion->fails()) {
            return response()->json([
                'message' => $validacion->errors(),
            ], 400);
        }

        else
        {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
            ]);

            if($user->save())
            {
                $url = URL::temporarySignedRoute("auth.enviarCodigo", now()->addDays(1), ["id" => $user->id]);

                CorreoVerificacionJob::dispatch($user, $url)
                ->delay(now()->addSeconds(10))
                ->onQueue("correo")
                ->onConnection("database");

                return $user;
            }

            else
            {
                return response()->json([
                    'message' => 'Error al crear el usuario',
                ], 500);
            }
        }
    }

    public function login(Request $request)
    {
        $validacion = Validator::make(
            $request->all(),
            [
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:8',
            ],
            [
                'email.required' => 'El correo electrónico es requerido',
                'email.string' => 'El correo electrónico debe ser una cadena de texto',
                'email.email' => 'El correo electrónico debe ser un correo electrónico válido',
                'email.max' => 'El correo electrónico debe tener como máximo 255 caracteres',

                'password.required' => 'La contraseña es requerida',
                'password.string' => 'La contraseña debe ser una cadena de texto',
                'password.min' => 'La contraseña debe tener como mínimo 8 caracteres',
            ]
        );

        if ($validacion->fails()) {
            return response()->json([
                'message' => $validacion->errors(),
            ], 400);
        }

        else
        {
            try
            {
                $user = User::where('email', $request->email)->first();

                if (!$user || !Hash::check($request->password, $user->password)) {
                    return response()->json([
                        'message' => 'Credenciales incorrectas'
                    ], 401);
                }

                $token = $user->createToken('token')->plainTextToken;

                return response()->json([
                    'user' => $user,
                    'token' => $token
                ], 200);
            }

            catch (Exception $e)
            {
                return response()->json([
                    'message' => 'Error al iniciar sesión'
                ], 500);
            }
        }
    }

    public function logout(Request $request)
    {
        try
        {
            $request->user()->Tokens()->delete();

            return response()->json([
                'message' => 'Sesión cerrada'
            ], 200);
        }

        catch(Exception $e)
        {
            return response()->json([
                'message' => 'Error al cerrar sesión'
            ], 500);
        }
    }

    //Funciones de Administrador
    public function cambiarRol()
    {}

    //Funciones de Usuario
    public function cambiarPassword()
    {}
}

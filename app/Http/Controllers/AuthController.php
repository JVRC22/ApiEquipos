<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function enviarCodigo(Request $request)
    {
        $code = rand(1000, 9999);

        $user = User::find($request->id);
        $user->code = $code;
        $user->save();

        Http::post('https://rest.nexmo.com/sms/json',[
            'from'=>"Equipos Api",
            'text'=>"Codigo de verificacion: $code",
            'to'=>"+52$user->phone",
            'api_key'=>"0ff442b0",
            'api_secret'=>"QtZzZW5glUgmiXBv"
        ]);

        return response()->json([
            'message' => 'Código enviado',
        ], 200);
    }

    public function verificarCodigo(Request $request)
    {
        $user = User::find($request->id);
        $code = $user->code;
        $validacion = Validator::make(
            $request->all(),
            [
                'code' => 'required|integer',
            ],
            [
                'code.required' => 'El código es requerido',
                'code.integer' => 'El código debe ser un número entero',
            ]
        );

        if($validacion->fails())
        {
            return response()->json([
                'message' => $validacion->errors(),
            ], 400);
        }

        else
        {
            if($code == $request->code)
            {
                $user->status = 1;
                $user->save();

                return response()->json([
                    'message' => 'Cuenta verificada',
                ], 200);
            }

            else
            {
                return response()->json([
                    'message' => 'Código incorrecto',
                ], 400);
            }
        }
    }
}

<?php

namespace App\Http\Controllers;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;

use function hash_equals;

use App\Mail\ConfirmacionMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
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

        return view('Correos.codigo_enviado');
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

                Mail::to($user->email)->send(new ConfirmacionMail());

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

    public function verificarToken(Request $request)
    {
        $user = $request->user();
        
        if($user)
        {
            return $user->id;
        }
    }
}

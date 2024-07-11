<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;

class AuthController extends Controller
{
    public function register (Request $request) 
    {
        try 
        {
            //validacion de datos
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|min:6',
            ]);

            //si la validacion falla
            if($validator->fails()) {
                throw new ValidationException($validator);
            }

            //insertando datos a la DB
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            //verificar si el usuario se crea en la base de datos
            if(!$user) {
                throw new Exception("Error al crear el usuario en la base de datos", 400);
            }

            return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);;
        } 
        catch (ValidationException $e)
        {
            //manejar errores de validación
            return response()->json(['Error' => $e->errors()], 422);
        }
        catch (\Exception $e) 
        {
            //manejar cualquier otro error
            return response()->json(['Error' => $e->getMessage()], $e->getCode() ?: 500);
        }
        
    }

    public function login (Request $request) 
    {
        try 
        {
            //validacion de datos
            $validator = Validator::make($request->all(), [
                'email'     => 'required|email|string',
                'password'  => 'required|string|min:6'
            ]);
    
            //si la validacion de datos falla
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
    
            //obteniendo credenciales del request
            $credentials = $request->only('email', 'password');
    
            $token = JWTAuth::attempt($credentials);
            
            //si la autenticacion falla
            if(!$token) {
                throw new \InvalidArgumentException('Credenciales inválidas', 401);
            }
    
            //autenticacion exitosa
            return response()->json(['token' => $token], 200);

        } 
        catch (ValidationException $e)
        {
            //manejar errores de validación
            return response()->json(['Error' => $e->errors()], 422);
        }
        catch (\InvalidArgumentException $e) 
        {
            //error de validacion
            return response()->json(['Error' => $e->getMessage()], $e->getCode());
        }
        catch (\Exception $e) 
        {
            //manejar cualquier otro error
            return response()->json(['Error' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }

    public function userProfile () 
    {
        try {
            $user = auth()->user();

            if(!$user) {
                throw new AuthorizationException("Usuaio no Autenticado", 401);
            }

            return response()->json(auth()->user());
        
        } 
        catch (AuthorizationException $e) 
        {
            return response()->json(['Error' => $e->getMessage()], $e->getCode());
        }
        catch (\Exception $e) 
        {
            return response()->json(['Error' => $e->getMessage()], $e->getCode() ?: 500);
        } 
    }
}

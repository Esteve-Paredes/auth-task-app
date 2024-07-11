<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Exception;

class ProjectController extends Controller
{
    public function index()
    {
        try {
            $projects = Project::all();

            //se verifica si el resultado no es un array vacio
            if($projects->isEmpty()) {
                throw new Exception("Error al Obtener Datos de los Proyectos", 404);
            };
    
            return response()->json(['projects' => $projects], 200);  

        } catch (\Exception $e) 
        {
            return response()->json(['Error :' => $e->getMessage()], $e->getCode());
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string',
                'description' => 'required|string'
            ]);  
    
            //verificar si la validacion de datos falla
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
    
            $projects = Project::create([
                'title' => $request->title,
                'description' => $request->description,
                'user_id' => auth()->id()//obtiene el id del usuario autenticado
            ]);
            
            //verificar si la el proyecto se crea en la base de datos
            if(!$projects) {
                throw new Exception("Error al crear el proyecto en la base de datos", 400);
            }
            
            return response()->json(['project' => $projects]);

        } 
        catch (ValidationException $e) 
        {
            return response()->json(['Error' => $e->errors()], 422);
        } 
        catch (\Exception $e) 
        {
            return response()->json(['Error' => $e->getMessage()], $e->getCode());
        }
        
    }

    public function show($id)
    {
        try {
            $projects = Project::find($id);
            
            if(!$projects) {
                throw new Exception('Proyecto no encontrado', 404);
            }
    
            return response()->json(['project' => $projects], 200);
        } 
        catch (\Exception $e) 
        {
            return response()->json(['Error: ' => $e->getMessage()], $e->getCode());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $projects = Project::find($id);
            
            if(!$projects) {
                throw new Exception('Proyecto no encontrado', 404);
            }    
    
            $validator = Validator::make($request->all(), [
                'title' => 'required|string',
                'description' => 'required|string'
            ]);  
    
            //verificar si la validacion de datos falla
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
    
            $projects->title = $request->title;
            $projects->description = $request->description;
    
            $projects->save();
    
            return response()->json(['project' => $projects], 200);   
        }         
        catch (ValidationException $e) 
        {
            return response()->json(['Error' => $e->errors()], 422);
        }
        catch (\Exception $e) 
        {
            return response()->json(['Error: ' => $e->getMessage()], $e->getCode());
        }

    }

    public function destroy($id)
    {
        try {
            $projects = Project::find($id);
            
            if(!$projects) {
                throw new Exception('Proyecto no encontrado', 404);
            }
    
            $projects->delete();
    
            return response()->json(['message' => 'deleted successfully'], 200);   
        } 
        catch (\Exception $e) 
        {
            return response()->json(['Error: ' => $e->getMessage()], $e->getCode());
        }
    }
}


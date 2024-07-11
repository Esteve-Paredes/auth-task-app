<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TaskController extends Controller
{
    public function index($projectId)
    {
        try {
            //traemos todas las taeras que coincidan con el id del proyecto
            $task = Task::where('project_id', $projectId)->get();

            //se verifica si el resultado no es un array vacio
            if($task->isEmpty()) {
                throw new Exception("No se encontraron tareas para el proyecto", 404);
            };
    
            return response()->json(['task' => $task], 200);  

        } catch (\Exception $e) 
        {
            return response()->json(['Error :' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }

    public function store(Request $request, $projectId)
    {
        try {
            //verifica si el proyecto existe
            $project = Project::find($projectId);

            if(!$project) {
                throw new Exception("Proyecto no encontrado", 404);
            }

            $validator = Validator::make($request->all(), [
                'title' => 'required|string',
                'description' => 'required|string',
                'status' => 'required|string|in:pending,in progress,completed'
            ]);  
    
            //verificar si la validacion de datos falla
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
    
            $task = Task::create([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
                'project_id' => $projectId,//obtiene el id del proyecto autenticado
            ]);
            
            //verificar si la el proyecto se crea en la base de datos
            if(!$task) {
                throw new Exception("Error al crear el proyecto en la base de datos", 400);
            }
            
            return response()->json(['project' => $task]);

        }
        catch (ValidationException $e) 
        {
            return response()->json(['Error' => $e->errors()], 422);
        } 
        catch (\Exception $e) 
        {
            return response()->json(['Error' => $e->getMessage()], $e->getCode() ?: 500);
        }
        
    }

    public function show($projectId, $taskId)
    {
        try {
            //verifica si el proyecto existe
            $project = Project::find($projectId);

            if(!$project) {
                throw new Exception("Proyecto no encontrado", 404);
            }

            //verifica si la tarea existe
            $task = Task::find($taskId);
            
            if(!$task) {
                throw new Exception('Tarea no encontrado', 404);
            }
    
            return response()->json(['project' => $task], 200);
        } 
        catch (\Exception $e) 
        {
            return response()->json(['Error: ' => $e->getMessage()], $e->getCode());
        }
    }

    public function update(Request $request, $projectId, $taskId)
    {
        try {
            //verifica si el proyecto existe
            $project = Project::find($projectId);

            if(!$project) {
                throw new Exception("Proyecto no encontrado", 404);
            }

            //verifica si la tarea existe
            $task = Task::find($taskId);
            
            if(!$task) {
                throw new Exception('Tarea no encontrado', 404);
            }    
    
            $validator = Validator::make($request->all(), [
                'title' => 'required|string',
                'description' => 'required|string',
                'status' => 'required|string|in:pending,in progress,completed' 
            ]);  
    
            //verificar si la validacion de datos falla
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
    
            $task->title = $request->title;
            $task->description = $request->description;
            $task->status = $request->status;
    
            $task->save();
    
            return response()->json(['project' => $task], 200);   
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

    public function destroy($projectId, $taskId)
    {
        try {
            //verifica si el proyecto existe
            $project = Project::find($projectId);

            if(!$project) {
                throw new Exception("Proyecto no encontrado", 404);
            }

            //verifica si la tarea existe
            $task = Task::find($taskId);
            
            if(!$task) {
                throw new Exception('Tarea no encontrado', 404);
            }
    
            $task->delete();
    
            return response()->json(['message' => 'Task deleted successfully'], 200);   
        } 
        catch (\Exception $e) 
        {
            return response()->json(['Error: ' => $e->getMessage()], $e->getCode());
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthResource;
use App\Http\Resources\TaskResource;
use App\Models\Permission;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::where(['user_id'=> Auth::id()]);
        if(isset($request->sort)){
            $sortItems =explode(',', $request->sort);
            foreach ($sortItems as $sort){
                $tmp = explode('=', $sort);
                $query->orderby($tmp[0], $tmp[1]);
            }
        }
        if(isset($request->title)){
            $query->where('title', 'like', "%$request->title%");
       }

        if(isset($request->description)){
            $query->where('description', 'like', "%$request->description%");
        }
        if(isset($request->priority)){
            $query->where('priority', $request->priority);
        }

        if(isset($request->status)){
            $query->where('status', $request->status||$request->status=='done'?true:false);
        }

        $tasks = $query->get();
        return TaskResource::collection($tasks);
    }

    public function store(Request $request)
    {
        try {
            $validateTask = Validator::make($request->all(),
                [
                    'title' => 'required|string|max:255',
                    'priority' => 'required|integer|max:5|min:0',
                    'description' => 'nullable',
                    'parent_id'=>'nullable',
                ]);

            if($validateTask->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateTask->errors()
                ], 401);
            }
            $task = Task::factory()->create([
                'title' => $request->title,
                'priority' => $request->priority,
                'description' => $request->description,
                'user_id'=>Auth::id(),
                'status' => false,
                'parent_id'=>$request->parent_id==null?1:$request->parent_id
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Task Created Successfully',
                'task'=>new TaskResource($task)
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $validateTask = Validator::make($request->all(),
                [
                    'title' => 'nullable|max:255',
                    'priority' => 'nullable|max:5|min:0',
                    'description' => 'nullable',
                    'parent_id'=>'nullable|min:1',
                    'status'=>'nullable',
                ]);

            if($validateTask->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateTask->errors()
                ], 401);
            }
            $task = Task::where(['id'=>$request->id, 'user_id'=>Auth::id()])->first();

            if(!$task){
                return response()->json([
                    'status' => false,
                    'message' => 'task is not available or missing',
                ], 403);
            }

            $completedAt = $task->completedAt;
            $status=$task->status;
            if(($request->status || $request->status == 'done')&&!$task->status){
                if(count($task->children)>0){
                    foreach ($task->children as $ch){
                        if(!$ch->status){
                            return response()->json([
                                'status' => false,
                                'message' => 'a task that has outstanding tasks cannot be marked as completed',
                            ], 403);
                        }
                    }
                }
                $completedAt = now();
                $status=true;
            }
            $task->title = $request->title?$request->title:$task->title;
            $task->priority = $request->priority ? $request->priority: $task->priority;
            $task->description = $request->description? $request->description: $task->description;
            $task->status = $status;
            $task->parent_id = $request->parent_id?$request->parent_id: $task->parent_id;
            $task->completedAt = $completedAt;
            $task->save();


            return response()->json([
                'status' => true,
                'message' => 'Task Update',
                'task'=>new TaskResource($task)
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function del(string $id)
    {

        $task = Task::where(['id'=>$id, 'user_id'=>Auth::id()])->first();
        if(!$task){
            return response()->json([
                'status' => false,
                'message' => 'task is not available or missing',
            ], 403);
        }

        if($task->status){
            return response()->json([
                'status' => false,
                'message' => 'the task is not available for deletion',
            ], 403);
        }
        $task->delete();
        return response()->json([
            'status' => true,
            'message' => 'Task del',
        ], 200);
    }
}

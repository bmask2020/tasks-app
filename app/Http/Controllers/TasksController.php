<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\tasks;
use Illuminate\Support\Facades\Cache;

class TasksController extends Controller
{
    
    public function all_tasks() {

        $user = auth('sanctum')->user();
       
        $cacheKey = 'user_tasks_' . $user->id;

        $cacheDuration = 60;

        $tasksData = Cache::remember($cacheKey, $cacheDuration, function () use ($user) {
            return $user->tasks()->paginate(10);
        });


        return response()->json([
            'success'   => true,
            'data'      => [
                'tasks'     => $tasksData
            ],
            'message'   => 'success'
        ], 200);

    } // End Method


    public function tasks_store(Request $request) {

        if($request->isMethod('post')) {

            $validated = $request->validate([
                'title'         => 'required|max:255',
                'description'   => 'required|max:255',
                'status'        => 'required'
            ]);

            $user = auth('sanctum')->user();

            $data = new tasks;
            $data->title        = $request->title;
            $data->description  = $request->description;
            $data->status       = $request->status;
            $data->user_id      = $user->id;
            $data->save();

            $cacheKey = 'user_tasks_' . $user->id;
            Cache::forget($cacheKey);

            return response()->json([
                'success'   => true,
                'data'      => [
                    'task'      => $data
                
                ],
                'message'   => 'success'
            ], 200);

        } else {

            return response()->json([
                'success'   => false,
                'message'   => 'Method Not Allow'
            ], 500);


        }

    } // End Method


    public function tasks_view($id) {

        $user = auth('sanctum')->user();

        $task = $user->tasks()->where([
            ['id', '=', $id],
            ['user_id', '=', $user->id]
        ])->first();

        if($task) {

            return response()->json([
                'success'   => true,
                'data'      => [
                    'task'      => $task
                ],
                'message'   => 'success'
            ], 200);

       

        } else {

            return response()->json([
                'success'   => false,
                'message'   => 'Task Not Found'
            ], 500);

        
        }
       

    } // End Method



    public function tasks_update(Request $request) {

        if($request->isMethod('put')) {

            $validated = $request->validate([
                'title'         => 'required|max:255',
                'description'   => 'required|max:255',
                'status'        => 'required'
            ]);

            $user = auth('sanctum')->user();

            $task = $user->tasks()->where('id', '=', $request->input('id'))->first();

            if($task) {

                $task->title        = $request->title;
                $task->description  = $request->description;
                $task->status       = $request->status;
                $task->save();

                $cacheKey = 'user_tasks_' . $user->id;
                Cache::forget($cacheKey);

                return response()->json([
                    'success'   => true,
                    'data'      => [
                        'task'      => $task
                    ],
                    'message'   => 'task updated successfully'
                ], 200);

            } else {

                return response()->json([
                    'success'   => false,
                    'message'   => 'Task Not Found'
                ], 500);
                
            }
            
        } else {

            return response()->json([
                'success'   => false,
                'message'   => 'Method Not Allow'
            ], 500);
        }

         
    } // End Method



    public function tasks_delete(Request $request) {

        if($request->isMethod('delete')) {

            $user = auth('sanctum')->user();

            $task = $user->tasks()->where('id', '=', $request->input('id'))->first();

            if($task) {

                $task->delete();

                $cacheKey = 'user_tasks_' . $user->id;
                Cache::forget($cacheKey);

                return response()->json([
                    'success'   => true,
                    'data'      => [
                        'task'      => $task
                    ],
                    'message'   => 'task deleted successfully'
                ], 200);

            
            } else {

                return response()->json([
                    'success'   => false,
                    'message'   => 'Task Not Found'
                ], 500);

            }

        } else {

            return response()->json([
                'success'   => false,
                'message'   => 'Method Not Allow'
            ], 500);

        }


    } // End Method



    public function tasks_search(Request $request) {

        $user = auth('sanctum')->user();

        $title = $request->input('title');

        $tasks = $user->tasks()->where('title', 'like', '%' . $title . '%')->paginate(10);

        if($tasks) {

            return response()->json([
                'success'   => true,
                'data'      => [
                    'tasks'     => $tasks
                ],
                'message'   => 'success'
            ], 200);

        } else {

            return response()->json([
                'success'   => false,
                'message'   => 'Task Not Found'
            ], 500);

        }
     

    }  // End Method



    public function tasks_status($status) {

        $user = auth('sanctum')->user();

        if($status == 'done') {

            $tasks = $user->tasks()->where('status', '=', 'done')->paginate(10);
            
            return response()->json([
                'success'   => true,
                'data'      => [
                    'tasks'     => $tasks
                ],
                'message'   => 'success'
            ], 200);

        } else if($status == 'in_progress') {
            
            $tasks = $user->tasks()->where('status', '=', 'in_progress')->paginate(10);

            return response()->json([
                'success'   => true,
                'data'      => [
                    'tasks'     => $tasks
                ],
                'message'   => 'success'
            ], 200);

        } else if($status == 'pending') {

            $tasks = $user->tasks()->where('status', '=', 'pending')->paginate(10);

            return response()->json([
                'success'   => true,
                'data'      => [
                    'tasks'     => $tasks
                ],
                'message'   => 'success'
            ], 200);

         } else {

            return response()->json([
                'success'   => false,
                'message'   => 'Method Not Allow'
            ], 500);


        }

    } // End Method


}

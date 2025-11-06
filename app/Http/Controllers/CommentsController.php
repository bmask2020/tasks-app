<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\comments;
use Carbon\Carbon;
use App\Models\tasks;


class CommentsController extends Controller
{
    
    public function tasks_comment_store(Request $request, $task_id) {

        if($request->isMethod('post')) {

            $validated = $request->validate([
                'commint'   => 'required|max:255'
            ]);
            
           

            if(isset($task_id)) {

                $user = auth('sanctum')->user();

                $commint = new comments;
                $commint->content       = strip_tags($request->commint);
                $commint->user_id       = $user->id;
                $commint->task_id       = (int)$task_id;
                $commint->created_at    = Carbon::now();
                $commint->save();

                return response()->json([
                    'success'   => true,
                    'data'      => [
                        'commint'   => $commint
                    ],
                    'message'   => 'commint created successfully'
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



    public function tasks_comments($task_id) {

        if(isset($task_id)) {

            $commints = tasks::where('id', '=', $task_id)->first()->comments()->paginate(10);

            return response()->json([
                'success'   => true,
                'data'      => [
                    'commints'  => $commints
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

}

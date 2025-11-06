<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\tasks;
use Illuminate\Support\Facades\Auth;

class CheckTaskOwnership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $id = $request->input('id');

        $user = auth('sanctum')->user();
       
        $task = $user->tasks()->where('id', '=', $id)->first();

        if (!$task) {

            return response()->json([
                'message' => 'لا تملك صلاحية لتعديل أو حذف هذه المهمة.',
                'error' => 'Forbidden'
            ], 403);

        }

        return $next($request);
    }
}

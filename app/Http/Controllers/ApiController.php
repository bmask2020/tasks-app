<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    
    
    public function register(Request $request) {

        if($request->isMethod('post')) {

            $validated = $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|unique:users|max:255',
                'password' => 'required'
            ]);


            $name       = strip_tags($request->name);
            $email      = strip_tags($request->email);
            $password   = $request->password;
           
            $data = new User;
            $data->name = $name;
            $data->email = $email;
            $data->password = Hash::make($password);
            $data->created_at = Carbon::now();
            $data->save();
           
            if($data) {

                $tokenResult = $data->createToken($data->email);
                $token = $tokenResult->plainTextToken;


                return response()->json([
                    'success'   => true,
                    'data'      => [
                        'token'     => $token
                    ],
                    'message'   => 'Account Created Successfully'
                ], 200);

            } else {

                return response()->json([
                    'success'   => false,
                    'message'   => 'Validation error',
                ], 500);

            }
           

        } else {

            return response()->json([
                'success' => false,
                'message' => 'Validation error'
            ], 500);

        } 

    } // End Method



    public function login(Request $request) {

        if($request->isMethod('post')) {

            $validated = $request->validate([
                'email' => 'required|max:255',
                'password' => 'required'
            ]);


            $email = $request->email;
            $password = $request->password;

            $user = User::where('email', '=', $email)->first();

            if($user) {

                if(Hash::check($password, $user->password)) {

                    $tokenResult = $user->createToken($user->email);
                    $token = $tokenResult->plainTextToken;

                    return response()->json([
                        'success'   => true,
                        'data'      => [
                            'token'     => $token
                        ],
                        'message'   => 'You Are Login Successfully'
                    ], 200);

                } else {

                    return response()->json([
                        'success'   => false,
                        'message'   => 'Password Not Match',
                    ], 500);

                }

            } else {

                return response()->json([
                    'success'   => false,
                    'message'   => 'Account Not Found',
                ], 500);


            }
           

        } else {

            return response()->json([
                'success' => false,
                'message' => 'Method Not Allow'
            ], 500);

        }

    } // End Method



    

    public function logout() {

        $user = auth('sanctum')->user();

        $user->tokens()->delete();


        return response()->json([
            'success'   => true,
            'message'   => 'You are Logout Successfully'
        ], 200);

    } // End Method



    public function tasks_status($status) {

        return response()->json([
            'status' => 'good'
        ], 200);


    } // End Method

}

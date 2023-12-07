<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    public function getAllUsers(Request $request)
    {
        try {
            $users = User::query()->get();

            if($users->isEmpty()){
                return response()->json(
                    [
                        "success" => true,
                        "message" => "There are not any user", 
                    ],
                    Response::HTTP_OK
                ); 
            }
    
            return response()->json(
                [
                    "success" => true,
                    "message" => "Users obtained succesfully",
                    "data" => $users
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error obtaining the users"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function getAllTeachers(Request $request)
    {
        try {
            $users = User::query()->where('role', 'admin')->get();

            if($users->isEmpty()){
                return response()->json(
                    [
                        "success" => true,
                        "message" => "There are not any Teacher", 
                    ],
                    Response::HTTP_OK
                ); 
            }
    
            return response()->json(
                [
                    "success" => true,
                    "message" => "Teachers obtained succesfully",
                    "data" => $users
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error obtaining the teachers"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function getUserById(Request $request, $id)
    {
        try {

            $user = User::query()->where('id', $id)->first();

            if(!$user){
                return response()->json(
                    [
                        "success" => true,
                        "message" => "There are not any user with this id", 
                    ],
                    Response::HTTP_OK
                ); 
            }

            return response()->json(
                [
                    "success" => true,
                    "message" => "Teachers obtained succesfully",
                    "data" => $user
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error obtaining the teachers"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}

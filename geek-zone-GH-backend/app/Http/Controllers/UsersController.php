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

             

            $mappedUsers = $users->map(function ($user) {
                return [
                    "id" => $user->id,
                    "name" => $user->name,
                    "last_name" => $user->last_name,
                    "email" => $user->email,
                    "city" => $user->city,
                    "phone_number" => $user->phone_number,
                    "photo" => $user->photo,
                    "role" => $user->role,
                    "created_at" => $user->created_at,
                    "updated_at" => $user->updated_at,
                ];
            });
    
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
            $myId = auth()->user();

            $user = User::query()
            ->where('id', $id)
            ->with('followers','followings','feeds','comments','events')
            ->first();

            if(!$user){
                return response()->json(
                    [
                        "success" => true,
                        "message" => "There are not any user with this id", 
                    ],
                    Response::HTTP_OK
                ); 
            }

            $mappedUsers = [
                "id" => $user->id,
                "name" => $user->name,
                "last_name" => $user->last_name,
                "email" => $user->email,
                "city" => $user->city,
                "phone_number" => $user->phone_number,
                "photo" => $user->photo,
                "role" => $user->role,
                "created_at" => $user->created_at,
                "updated_at" => $user->updated_at,
                "followings" => sizeof($user->followers),
                "followers" => sizeof($user->followings),
                "feeds" => $user->feeds,
                "comments" => $user->comments,
                "likes" => $user->likes, 
                "events" => $user->events,
            ];
            
            

            return response()->json(
                [
                    "success" => true,
                    "message" => "Teachers obtained succesfully",
                    "data" => $mappedUsers
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

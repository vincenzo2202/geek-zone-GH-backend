<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    public function getAllUsers()
    {
        try {
            $users = User::query()->get();

            if($users->isEmpty()){
                return response()->json(
                    [
                        "success" => true,
                        "message" => "There are not any game", 
                    ],
                    Response::HTTP_OK
                ); 
            }
    
            return response()->json(
                [
                    "success" => true,
                    "message" => "Games obtained succesfully",
                    "data" => $users
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error obtaining the games"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Feed;
use App\Models\Follower;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class SuperAdminController extends Controller
{
   
    public function changeRole(Request $request)
    {
        try {
            $superAdmin = auth()->user();
            $id = $request->input('id');
            $role = $request->input('role');
            $user = User::query()->find($id);

            if ($superAdmin->role != 'super_admin') {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "You are not authorized to change roles"
                    ],
                    Response::HTTP_FORBIDDEN
                );
            }

            if (!$user) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "User not found"
                    ],
                    Response::HTTP_NOT_FOUND
                );
            } 

            if ($request->has('role')) {
                $user->role = $role;
            } 
 
            $user->save();

            return response()->json(
                [
                    "success" => true,
                    "message" => "Role changed successfully"
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error changing the role"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}

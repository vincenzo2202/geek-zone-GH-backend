<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function updateProfile(Request $request)
    {

        try {
            $token = auth()->user();
            $user = User::query()->find($token->id);

            $name = $request->input('name');
            $last_name = $request->input('last_name');
            $email = $request->input('email');
            $password = $request->input('password');
            $city = $request->input('city');
            $phone_number = $request->input('phone_number');
            $photo = $request->input('photo');

            if (empty($photo)) {
                $photo = 'https://cdn.icon-icons.com/icons2/1378/PNG/512/avatardefault_92824.png';
            };

            if ($request->has('name')) {
                $user->name = $name;
            }

            if ($request->has('last_name')) {
                $user->last_name = $last_name;
            }

            if ($request->has('email')) {
                $user->email = $email;
            }

            if ($request->has('password')) {
                $user->password = bcrypt($password);
            }

            if ($request->has('city')) {
                $user->city = $city;
            }

            if ($request->has('phone_number')) {
                $user->phone_number = $phone_number;
            }

            if ($request->has('photo')) {
                $user->photo = $photo;
            } 
 
            $user->save();

            return response()->json(
                [
                    "success" => true,
                    "message" => "User updated",
                    "data" => $user
                ],
                Response::HTTP_CREATED
            );

        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error updating profile user"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
 
    public function deleteUser(Request $request)
    {
        try {
            $token = auth()->user();
            User::destroy($token->id);

            return response()->json(
                [
                    "success" => true,
                    "message" => "User deleted",
                ],
                Response::HTTP_OK
            );

        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error deleting user"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    

}

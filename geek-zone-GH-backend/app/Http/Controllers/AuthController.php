<?php

namespace App\Http\Controllers;
 
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
       try {
        $validator = $this->validateRegister($request);

        if ($validator->fails()) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error registering user",
                    "error" => $validator->errors()
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        $photo = $request->input('photo');

        if(empty($photo)){
            $photo = 'https://cdn.icon-icons.com/icons2/1378/PNG/512/avatardefault_92824.png';
        };

        $newUser = User::create([
            'name' => $request->input('name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'city' => $request->input('city'),
            'phone_number' => $request->input('phone_number'),  
            'photo' =>  $photo
        ]);

        return response()->json(
            [
                "success" => true,
                "message" => "User registered",
                "data" => $newUser
            ],
            Response::HTTP_CREATED
        );
       } catch (\Throwable $th) {
        Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error registering user"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
       }
        
    }

    private function validateRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:100',
            'last_name' => 'required|min:3|max:100',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:6|max:12|regex:/^[a-zA-Z0-9._-]+$/',
            'city' => 'required|min:3|max:100',
            'phone_number' => 'required|min:3|max:12|regex:/^[0-9]+$/',
            'photo' => 'min:3|max:255',
        ]);

        return $validator;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Chat_user;
use App\Models\Comment;
use App\Models\Feed;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller 
{
    public function getAllMyChats(Request $request)
    {
        try {
            $user = auth()->user();
            $myChats = Chat::query()
                ->where('user_id', $user->id)
                ->with('usersManyToManythroughChat_user')
                ->get();

            if ($myChats->isEmpty()) {
                return response()->json(
                    [
                        "success" => true,
                        "message" => "There are not any chats to show",
                    ],
                    Response::HTTP_OK
                );
            }

            $mappedMyChats = $myChats->map(function ($chat) {
                return [
                    'id' => $chat->id,
                    'name' => $chat->name,
                    'user_id' => $chat->user_id,
                    'created_at' => $chat->created_at,
                    'updated_at' => $chat->updated_at,
                    'users_many_to_manythrough_chat_user' => $chat->usersManyToManythroughChat_user->map(function ($user) {
                        return [
                            'id' => $user->id,
                            'name' => $user->name,
                            'last_name' => $user->last_name,
                            'email' => $user->email,
                            'photo' => $user->photo, 
                        ];
                    }),
                ];
            });

            return response()->json(
                [
                    "success" => true,
                    "message" => "Chats obtained succesfully",
                    "data" => $mappedMyChats,
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error obtaining the chats"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}

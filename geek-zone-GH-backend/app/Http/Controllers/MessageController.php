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

class MessageController extends Controller
{
    public function getAllMessagesByChatId(Request $request, $id)
    {
        try {
            $user = auth()->user(); 
            $messages = Chat::query()
                ->where('id', $id) 
                ->with('messages', 'user','usersManyToManythroughChat_user')
                ->get();

            if ($messages->isEmpty()) {
                return response()->json(
                    [
                        "success" => true,
                        "message" => "Chat not found",
                    ],
                    Response::HTTP_OK
                );
            }

            $mappedMessages = $messages->map(function ($message) {
                return [
                    'id' => $message->id, 
                    'user_id' => $message->user_id,
                    'created_at' => $message->created_at, 
                    'members' => $message->usersManyToManythroughChat_user->map(function ($user) {
                        return  $user->id;
                    }),
                    'messages' => $message->messages->map(function ($message) {
                        return [
                            'id' => $message->id,
                            'name' => $message->user->name,
                            'last_name' => $message->user->last_name,
                            'user_id' => $message->user_id,
                            'message' => $message->message,
                            'created_at' => $message->created_at,
                        ];
                    }),
                    
                ];
            });

            if (!$mappedMessages[0]['members']->contains($user->id)) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "You are not a member of this chat",
                    ],
                    Response::HTTP_OK
                );
            }
            

            return response()->json(
                [
                    "success" => true,
                    "message" => "Messages obtained succesfully",
                    "data" => $mappedMessages,
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error getting messages", 
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}

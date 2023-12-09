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

            //TODO: mirar que tambien el usuario que esta en la intermedia pero no en chat pueda obtener los chats
            $user = auth()->user();
            $myChats = Chat_user::query()
                ->where('user_id', $user->id)
                ->with('chat')
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
                    'id' => $chat->chat->id,
                    'name' => $chat->chat->name,
                    'user_id_owner' => $chat->chat->user_id,
                    'created_at' => $chat->chat->created_at,
                    'updated_at' => $chat->chat->updated_at,
                    'members' => $chat->chat->usersManyToManythroughChat_user->map(function ($user) {
                        return $user->id;
                             
                    }),
                    'members_info' => $chat->chat->usersManyToManythroughChat_user->map(function ($user) {
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
            

            if(!$mappedMyChats[0]['members']->contains($user->id)){
                return response()->json(
                    [
                        "success" => false,
                        "message" => "You are not allowed to see this chat",
                    ],
                    Response::HTTP_UNAUTHORIZED
                );
            }

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

    public function getChatById(Request $request, $id)
    {
        try {
            $user = auth()->user();
            $chat = Chat::query()
                ->where('id', $id)
                ->with(['usersManyToManythroughChat_user', 'messages'])
                ->first();

            if (!$chat) {
                return response()->json(
                    [
                        "success" => true,
                        "message" => "There are not any chats to show",
                    ],
                    Response::HTTP_OK
                );
            }

            if ($chat->user_id !== $user->id) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "You are not allowed to see this chat",
                    ],
                    Response::HTTP_UNAUTHORIZED
                );
            }

            $mappedChat = [
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
                'messages' => $chat->messages->map(function ($message) {
                    return [
                        'id' => $message->id,
                        'user_id' => $message->user_id,
                        'message' => $message->message,
                        'created_at' => $message->created_at,
                    ];
                }),
            ];

            return response()->json(
                [
                    "success" => true,
                    "message" => "Chat obtained succesfully",
                    "data" => $mappedChat,
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error obtaining the chat"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function createChat(Request $request)
    {
        try {
            $user = auth()->user();
            $chatName = $request->input('name');
            $chatWith = $request->input('user_id');

            $chatUser = Chat_user::query()
                ->where('user_id', $chatWith)
                ->with('chat')
                ->first();

            if ($chatUser) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "You already have a chat with this user",
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }
 
            $chat = Chat::create([
                'name' =>  $chatName,
                'user_id' => $user->id,
            ]);

            //hago attach a la tabla intermedia con lo usuarios que participan en el chat
            $chat->usersManyToManythroughChat_user()->attach($user->id, ['chat_id' => $chat->id]);
            $chat->usersManyToManythroughChat_user()->attach($chatWith, ['chat_id' => $chat->id]);

            return response()->json(
                [
                    "success" => true,
                    "message" => "Chat created succesfully",
                    "ChatID" => $chat->id,
                    "data" => $chat,
                ],
                Response::HTTP_CREATED
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error creating the chat"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function deleteChat(Request $request, $id)
    {
        try {
            $user = auth()->user();
            $chat = Chat_user::query()
                ->where('chat_id', $id)
                ->where('user_id', $user->id)
                ->first();

            if (!$chat) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "Chat not found",
                    ],
                    Response::HTTP_NOT_FOUND
                );
            }

            if ($chat->user_id !== $user->id) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "You are not allowed to delete this chat",
                    ],
                    Response::HTTP_UNAUTHORIZED
                );
            }

            Chat_user::destroy($chat->id);
            
            $chatOwner = Chat::query()
                ->where('id', $id)
                ->first();

            if ($chatOwner->user_id === $user->id) {
                Chat::destroy($chatOwner->id);
            }

            return response()->json(
                [
                    "success" => true,
                    "message" => "Chat deleted succesfully",
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error deleting the chat"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}

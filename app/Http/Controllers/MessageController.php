<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Chat_user;
use App\Models\Comment;
use App\Models\Feed;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\FuncCall;

class MessageController extends Controller
{
    public function getAllMessagesByChatId(Request $request, $id)
    {
        try {
            $user = auth()->user();
            $messages = Chat::query()
                ->where('id', $id)
                ->with('messages', 'user', 'usersManyToManythroughChat_user')
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

    public function createMessageByChatId(Request $request)
    {
        try {
            $user = auth()->user();
            $chat = $request->input('chat_id');

            $validator = $this->validateMessage($request);

            if ($validator->fails()) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "Error validating message",
                        "errors" => $validator->errors(),
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            $messages = Chat::query()
                ->where('id', $chat)
                ->with('usersManyToManythroughChat_user')
                ->get();

            if ($messages->isEmpty()) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "Chat not found",
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            $mappedMessages = $messages->map(function ($message) {
                return [
                    'members' => $message->usersManyToManythroughChat_user->map(function ($user) {
                        return  $user->id;
                    })
                ];
            });

            if (!$mappedMessages[0]['members']->contains($user->id)) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "You are not a member of this chat",
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            $message = Message::create([
                'chat_id' => $chat,
                'user_id' => $user->id,
                'message' => $request->input('message'),
            ]);

            if (!$mappedMessages) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "You are not a member of this chat",
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            return response()->json(
                [
                    "success" => true,
                    "message" => "Message created succesfully",
                    "data" => $message,
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error creating message",
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function validateMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:255',
            'chat_id' => 'required|integer',
        ]);

        return $validator;
    }

    public function deleteMessageByChatId(Request $request, $id)
    {
        try {
            $user = auth()->user();
            $message = Message::query()->find($id);

            if (!$message) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "Message not found",
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            if($message->user_id !== $user->id){
                return response()->json(
                    [
                        "success" => false,
                        "message" => "You are not allowed to delete this message",
                    ],
                    Response::HTTP_UNAUTHORIZED
                );
            }

            Message::destroy($message->id);

            return response()->json(
                [
                    "success" => true,
                    "message" => "Message deleted succesfully",
                ],
                Response::HTTP_OK
            );

        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error deleting message",
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}

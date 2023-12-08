<?php

namespace App\Http\Controllers;

use App\Models\Chat;
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
            $myChats = Chat::query()->where('user_id', $user->id)->paginate(10);

            if ($myChats->isEmpty()) {
                return response()->json(
                    [
                        "success" => true,
                        "message" => "There are not any chats to show",
                    ],
                    Response::HTTP_OK
                );
            }

            return response()->json(
                [
                    "success" => true,
                    "message" => "Chats obtained succesfully",
                    "data" => $myChats// information of chats
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

<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Feed;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
class CommentController extends Controller
{
    public function getAllCommentsByFeedId(Request $request, $id)
    {
        try { 
            $comments = Comment::query()->where('feed_id', $id)->get();

            if($comments->isEmpty()){
                return response()->json(
                    [
                        "success" => true,
                        "message" => "There are not any comments to show", 
                    ],
                    Response::HTTP_OK
                ); 
            }

            return response()->json(
                [
                    "success" => true,
                    "message" => "Comments obtained succesfully",
                    "data" => $comments
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error deleting post"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}

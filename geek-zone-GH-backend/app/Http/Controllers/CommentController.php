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
            $comments = Comment::query()->where('feed_id', $id)->paginate(5);
            $commentsArray = Comment::query()->where('feed_id', $id)->get();

            $countComments = sizeof($commentsArray);

            if ($comments->isEmpty()) {
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
                    "dataSize" => $countComments, // cuantity of comments
                    "data" => $comments // information of comments
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error obtaining the comments"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function createCommentByFeedId(Request $request)
    {
        try {

            $validator = $this->validateComment($request);

            $user = auth()->user();
            $feed = Feed::query()->where('id', $request->feed_id)->first();

            if (!$feed) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "Feed not found"
                    ],
                    Response::HTTP_NOT_FOUND
                );
            }

            if ($validator->fails()) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "Error validating the comment",
                        "errors" => $validator->errors()
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            $comment = Comment::query()->create([
                'user_id' => $user->id,
                'feed_id' => $request->input('feed_id'), 
                'comment' => $request->input('comment'),
            ]);

            return response()->json(
                [
                    "success" => true,
                    "message" => "Comment created succesfully",
                    "data" => $comment
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error creating the comment"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    private function validateComment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'required|string|max:6000',
            'feed_id' => 'required|integer',
        ]);

        return $validator;
    }

    public function deleteCommentByFeedId(Request $request, $id)
    {
        try {
            $user = auth()->user();
            $comment = Comment::query()->find($id);

            if (!$comment) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "Comment not found"
                    ],
                    Response::HTTP_NOT_FOUND
                );
            }

            if ($comment->user_id != $user->id) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "You are not allowed to delete this comment"
                    ],
                    Response::HTTP_UNAUTHORIZED
                );
            }

            Comment::destroy($comment->id);

            return response()->json(
                [
                    "success" => true,
                    "message" => "Comment deleted succesfully",
                    "data" => $comment
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error deleting the comment"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

}



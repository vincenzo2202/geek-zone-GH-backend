<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Feed;
use App\Models\Like;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class LikeController extends Controller
{
    public function getLikesByFeedId(Request $request, $id)
    {
        try {
            $likes  = Like::query()->where('feed_id', $id)->get();

            $countLikes = sizeof($likes);

            if ($likes->isEmpty()) {
                return response()->json(
                    [
                        "success" => true,
                        "message" => "There are not any likes to show",
                    ],
                    Response::HTTP_OK
                );
            }

            return response()->json(
                [
                    "success" => true,
                    "message" => "Likes obtained succesfully",
                    "dataSize" => $countLikes, // cuantity of likes
                    "data" => $likes // information of likes

                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error getting the likes"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function createLikeByFeedId(Request $request)
    {
        try {
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

            $like = Like::query()->create([
                'user_id' => $user->id,
                'feed_id' => $request->input('feed_id'),
            ]);

            return response()->json(
                [
                    "success" => true,
                    "message" => "Like created succesfully",
                    "data" => $like
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error creating the like"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function deleteLikeByFeedId(Request $request, $id)
    {
        try {
            $user = auth()->user();
            $feed = Feed::query()->where('id', $id)->first();

            if (!$feed) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "Feed not found"
                    ],
                    Response::HTTP_NOT_FOUND
                );
            }

            $like = Like::query()->where('user_id', $user->id)->where('feed_id', $id)->first();

            if (!$like) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "Like not found"
                    ],
                    Response::HTTP_NOT_FOUND
                );
            }

            Like::destroy($like->id);

            return response()->json(
                [
                    "success" => true,
                    "message" => "Like deleted succesfully",
                    "data" => $like
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error deleting the like"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}

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
}

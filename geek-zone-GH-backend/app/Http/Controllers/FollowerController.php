<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Feed;
use App\Models\Follower;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class FollowerController extends Controller
{
    public function getAllMyFollowings(Request $request)
    {
        try {
            $user = $request->user();
            $followings = Follower::query()
                ->with(['following'])
                ->where('follower_id', $user->id)
                ->get();
            $followingsCount = sizeof($followings);

            if ($followings->isEmpty()) {
                return response()->json(
                    [
                        "success" => true,
                        "message" => "There are not any followings to show",
                    ],
                    Response::HTTP_OK
                );
            }

            $formattedFollowings = $followings->map(function ($following) {
                return [
                    'id' => $following->id,
                    'follower_id' => $following->follower_id,
                    'following_id' => $following->following_id,
                    'created_at' => $following->created_at,
                    'updated_at' => $following->updated_at,
                    'following' => [
                        'name' => $following->following->name,
                        'last_name' => $following->following->last_name,
                        'photo' => $following->following->photo,
                    ],
                ];
            });

            return response()->json(
                [
                    "success" => true,
                    "message" => "Followings obtained succesfully",
                    "dataSize" => $followingsCount, // cuantity of followings
                    "data" => $formattedFollowings // information of followings
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error obtaining the followings"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function getFollowingsByUserId(Request $request, $id)
    {
        try {
            $followings = Follower::query()
                ->with(['following'])
                ->where('follower_id', $id)
                ->get();
            $followingsCount = sizeof($followings);

            if ($followings->isEmpty()) {
                return response()->json(
                    [
                        "success" => true,
                        "message" => "There are not any followings to show",
                    ],
                    Response::HTTP_OK
                );
            }

            $formattedFollowings = $followings->map(function ($following) {
                return [
                    'id' => $following->id,
                    'follower_id' => $following->follower_id,
                    'following_id' => $following->following_id,
                    'created_at' => $following->created_at,
                    'updated_at' => $following->updated_at,
                    'following' => [
                        'name' => $following->following->name,
                        'last_name' => $following->following->last_name,
                        'photo' => $following->following->photo,
                    ],
                ];
            });

            return response()->json(
                [
                    "success" => true,
                    "message" => "Followings obtained succesfully",
                    "dataSize" => $followingsCount, // cuantity of followings
                    "data" => $formattedFollowings // information of followings
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error obtaining the followings"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}

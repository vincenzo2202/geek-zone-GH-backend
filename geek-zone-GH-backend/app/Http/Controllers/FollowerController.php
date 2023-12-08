<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Feed;
use App\Models\Follower;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
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

    public function getAllMyFollowers(Request $request)
    {
        try {
           $user = auth()->user();
            $followers = Follower::query()
                ->with(['follower'])
                ->where('following_id', $user->id)
                ->get();
            $followersCount = sizeof($followers);

            if ($followers->isEmpty()) {
                return response()->json(
                    [
                        "success" => true,
                        "message" => "There are not any followers to show",
                    ],
                    Response::HTTP_OK
                );
            }

            $formattedFollowers = $followers->map(function ($follower) {
                return [
                    'id' => $follower->id,
                    'follower_id' => $follower->follower_id,
                    'following_id' => $follower->following_id,
                    'created_at' => $follower->created_at,
                    'updated_at' => $follower->updated_at,
                    'follower' => [
                        'name' => $follower->follower->name,
                        'last_name' => $follower->follower->last_name,
                        'photo' => $follower->follower->photo,
                    ],
                ];
            });

            return response()->json(
                [
                    "success" => true,
                    "message" => "Followers obtained succesfully",
                    "dataSize" => $followersCount, // cuantity of followers
                    "data" => $formattedFollowers // information of followers
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error obtaining the followers"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function getFollowersByUserId(Request $request,$id)
    {
        try {
            $followers = Follower::query()
                ->with(['follower'])
                ->where('following_id', $id)
                ->get();
            $followersCount = sizeof($followers);

            if ($followers->isEmpty()) {
                return response()->json(
                    [
                        "success" => true,
                        "message" => "There are not any followers to show",
                    ],
                    Response::HTTP_OK
                );
            }

            $formattedFollowers = $followers->map(function ($follower) {
                return [
                    'id' => $follower->id,
                    'follower_id' => $follower->follower_id,
                    'following_id' => $follower->following_id,
                    'created_at' => $follower->created_at,
                    'updated_at' => $follower->updated_at,
                    'follower' => [
                        'name' => $follower->follower->name,
                        'last_name' => $follower->follower->last_name,
                        'photo' => $follower->follower->photo,
                    ],
                ];
            });

            return response()->json(
                [
                    "success" => true,
                    "message" => "Followers obtained succesfully",
                    "dataSize" => $followersCount, // cuantity of followers
                    "data" => $formattedFollowers // information of followers
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error obtaining the followers"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error obtaining the followers"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function createFollower(Request $request)
    {
        try {
            $user = auth()->user();
            $newFollower = $request->input('following_id');
            $followings = Follower::query()
                ->with(['following'])
                ->where('follower_id', $user->id)
                ->where('following_id', $newFollower)
                ->first();

            if ($followings) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "You are already following this user",
                    ],
                    Response::HTTP_OK
                );
            }

            $createFollower = Follower::query()->create([
                'follower_id' => $user->id,
                'following_id' => $newFollower,
            ]);

            return response()->json(
                [
                    "success" => true,
                    "message" => "Follower created succesfully",
                    "data" => $createFollower
                ],
                Response::HTTP_CREATED
            );
 
            
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error creating the follower"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        } catch (\Throwable $th) {
           Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error creating the follower"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function deleteFollower(Request $request, $id)
    {
        try {
            $user = auth()->user();
            $follower = Follower::query()
                ->where('follower_id', $user->id)
                ->where('following_id', $id)
                ->first();

            if (!$follower) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "You are not following this user",
                    ],
                    Response::HTTP_OK
                );
            }

            Follower::destroy($follower->id);

            return response()->json(
                [
                    "success" => true,
                    "message" => "Follower deleted succesfully",
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error deleting the follower"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}

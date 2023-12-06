<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class FeedController extends Controller
{
    public function getAllfeeds(Request $request)
    {
        try {
            $feeds = Feed::query()->get();

            if($feeds->isEmpty()){
                return response()->json(
                    [
                        "success" => true,
                        "message" => "There are not any Post to show", 
                    ],
                    Response::HTTP_OK
                ); 
            }
    
            return response()->json(
                [
                    "success" => true,
                    "message" => "Posts obtained succesfully",
                    "data" => $feeds
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error obtaining the posts"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function getfeedById(Request $request, $id)
    {
        try {
            $feeds = Feed::query()->where('user_id', $id)->get();

            if($feeds->isEmpty()){
                return response()->json(
                    [
                        "success" => true,
                        "message" => "There are not any Post to show", 
                    ],
                    Response::HTTP_OK
                ); 
            }
    
            return response()->json(
                [
                    "success" => true,
                    "message" => "Posts obtained succesfully",
                    "data" => $feeds
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error obtaining the posts"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function createFeed(Request $request)
    {
        try {
            $user = auth()->user();
            $validator = $this->validateFeeds($request);

            if ($validator->fails()) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "Error creating a new post",
                        "error" => $validator->errors()
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            $photo = $request->input('photo'); 

            if (empty($photo)) {
                $photo = '';
            };

            $newFeed = Feed::create([
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'photo' => $photo,
                'user_id' => $user->id
            ]);

            return response()->json(
                [
                    "success" => true,
                    "message" => "User registered",
                    "data" => $newFeed
                ],
                Response::HTTP_CREATED
            );
            
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error creating post"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    private function validateFeeds(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|max:255',
            'content' => 'required|min:1|max:6000',
            'photo' => 'max:255', 
        ]);

        return $validator;
    }
}

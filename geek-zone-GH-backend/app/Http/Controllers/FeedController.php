<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

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
}

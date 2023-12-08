<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Event_user;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class EventUserController extends Controller
{
   public function createEventUser(Request $request)
   {
    try {
        $user = auth()->user();
        $eventAssist = $request->input('event_id');
        $event = Event_user::query()
        ->where('event_id', $eventAssist)
        ->where('user_id', $user->id)
        ->first();

        if($event){
            return response()->json(
                [
                    "success" => true,
                    "message" => "You are already registered for this event"
                ],
                Response::HTTP_OK
            );
        }

        $newEvent = Event_user::create([
            'event_id' => $eventAssist,
            'user_id' => $user->id,
        ]);

        return response()->json(
            [
                "success" => true,
                "message" => "Join event successfully",
                "data" => $newEvent
            ],
            Response::HTTP_CREATED
        );

    } catch (\Throwable $th) {
        Log::error($th->getMessage());

        return response()->json(
            [
                "success" => false,
                "message" => "Error joining event",
            ],
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }
   }

   public function getAllEventUsersByEventId(Request $request,$id)
   {
    try { 
        $eventUsers = Event_user::query()
        ->where('event_id', $id)
        ->with(['user'])
        ->get();

        $count= sizeof($eventUsers);

        if($eventUsers->isEmpty()){
            return response()->json(
                [
                    "success" => true,
                    "message" => "There are not any users to show", 
                ],
                Response::HTTP_OK
            ); 
        }

        $formatEventUsers = $eventUsers->map(function($eventUser){
            return [
                'id' => $eventUser->id, 
                'user_id' => $eventUser->user->id,
                'event_id' => $eventUser->event_id,
                'created_at' => $eventUser->created_at, 
                'user'=>[ 
                    'name' => $eventUser->user->name,
                    'last_name' => $eventUser->user->last_name,
                    'email' => $eventUser->user->email, 
                ]
            ];
        });



        return response()->json(
            [
                "success" => true,
                "message" => "Users obtained succesfully",
                "dataSize" => $count,
                "data" => $formatEventUsers
            ],
            Response::HTTP_OK
        );
  
    } catch (\Throwable $th) {
       Log::error($th->getMessage());

         return response()->json(
              [
                "success" => false,
                "message" => "Error obtaining the users"
              ],
              Response::HTTP_INTERNAL_SERVER_ERROR
         );
    }
   }
}

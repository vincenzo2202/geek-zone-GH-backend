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
}

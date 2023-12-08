<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class EventController extends Controller
{
    public function createEvent(Request $request)
    {
        try {
            $validator = $this->validateEvent($request);
            $user = auth()->user();

            if ($validator->fails()) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "Error creating event",
                        "error" => $validator->errors()
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            $newEvent = Event::create([
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'event_date' => $request->input('event_date'),
                'event_time' => $request->input('event_time'),
                'user_id' => $user->id,

            ]);

            return response()->json(
                [
                    "success" => true,
                    "message" => "Event created",
                    "data" => $newEvent
                ],
                Response::HTTP_CREATED
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error creating event",
                    "error" => $th->getMessage()
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function validateEvent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:100',
            'content' => 'required|string|max:6000',
            'event_date' => 'required|date_format:Y-m-d',
            'event_time' => 'required|date_format:H:i',
        ]);

        return $validator;
    }
}

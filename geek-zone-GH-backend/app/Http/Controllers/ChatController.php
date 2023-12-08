<?php

// namespace App\Http\Controllers;

// use App\Models\Chat;
// use App\Models\Chat_user;
// use App\Models\Comment;
// use App\Models\Feed;
// use App\Models\User;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Log;
// use Symfony\Component\HttpFoundation\Response;
// use Illuminate\Support\Facades\Validator;

// class ChatController extends Controller
// // solo trae mis chats por el id del token y el nombre del chat pero no trae los usuarios con los que tengo chat
// // TODO necesito que traiga tambien a los usiarios con los que tengo chat
// {
//     public function getAllMyChats(Request $request)
//     {
//         try {
//             $user = auth()->user();
//             $myChats = Chat_user::query()
//             ->where('user_id', $user->id)
//             ->with(['chat', 'user'])
//             ->paginate(10);

//             if ($myChats->isEmpty()) {
//                 return response()->json(
//                     [
//                         "success" => true,
//                         "message" => "There are not any chats to show",
//                     ],
//                     Response::HTTP_OK
//                 );
//             }

//             return response()->json(
//                 [
//                     "success" => true,
//                     "message" => "Chats obtained succesfully",
//                     //TODO eliminar bug de la funcion map // esta funcionando
//                     // "data" => $myChats->map(function ($chatUser) {
//                         return [
//                             'id' => $chatUser->id,
//                             'chat_id' => $chatUser->chat_id,
//                             'user_id' => $chatUser->user_id, 
//                             'created_at' => $chatUser->created_at,
//                             'updated_at' => $chatUser->updated_at,
//                             'chat' => [
//                                 'name' => $chatUser->chat->name,
//                             ],
//                             'user' => [
//                                 'name' => $chatUser->user->name,
//                                 'last_name' => $chatUser->user->last_name,
//                             ],
//                         ];
//                     })
//                 ],
//                 Response::HTTP_OK
//             );


//         } catch (\Throwable $th) {
//             Log::error($th->getMessage());
//             return response()->json(
//                 [
//                     "success" => false,
//                     "message" => "Error obtaining the chats"
//                 ],
//                 Response::HTTP_INTERNAL_SERVER_ERROR
//             );
//         }
//     }
// }

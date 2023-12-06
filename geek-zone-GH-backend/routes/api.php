<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

Route::get('/api', function (Request $request) {
   
        return response()->json(
            [
                "success" => true,
                "message" => "Healthcheck ok"
            ],
            Response::HTTP_OK
        );     
});

// USER
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group([
    'middleware' => ['auth:sanctum']
], function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']); 
    Route::put('/profile', [UserController::class, 'updateProfile']);
    Route::delete('/user', [UserController::class, 'deleteUser']);
});
// USERS
Route::group([
    'middleware' => ['auth:sanctum']
], function () {
    Route::get('/allUsers', [UsersController::class, 'getAllUsers']); 
    Route::get('/teachers', [UsersController::class, 'getAllTeachers']);
});

// FEEDS
Route::group([
    'middleware' => ['auth:sanctum']
], function () {
    Route::get('/feeds', [FeedController::class, 'getAllfeeds']);
    Route::get('/feeds/{id}', [FeedController::class, 'getfeedById']);
    Route::post('/createFeed', [FeedController::class, 'createFeed']);
    Route::put('/updateFeed', [FeedController::class, 'updateFeed']);
    //TODO----------------------------->
    Route::delete('/deleteFeed/{id}', [FeedController::class, 'deleteFeed']);
});
//COMMENTS
Route::group([
    'middleware' => ['auth:sanctum']
], function () {
    Route::get('/comments', [CommentController::class, 'getAllComments']); 
    Route::post('/comments', [CommentController::class, 'createComment']); 
    Route::delete('/comments/{id}', [CommentController::class, 'deleteComment']);
});
// LIKES
Route::group([
    'middleware' => ['auth:sanctum']
], function () {
    Route::get('/likes', [LikeController::class, 'getAllLikes']);
    Route::get('/likes/{id}', [LikeController::class, 'getLikeById']);
    Route::post('/likes', [LikeController::class, 'createLike']); 
    Route::delete('/likes/{id}', [LikeController::class, 'deleteLike']);
});

// CHATS
Route::group([
    'middleware' => ['auth:sanctum']
], function () { 
    Route::get('/chats', [ChatController::class, 'getAllChats']);
    Route::get('/chats/{id}', [ChatController::class, 'getChatById']);
    Route::post('/chats', [ChatController::class, 'createChat']);
    Route::delete('/chats/{id}', [ChatController::class, 'deleteChat']);
});

// MESSAGES
Route::group([
    'middleware' => ['auth:sanctum']
], function () {
    Route::get('/messages', [MessageController::class, 'getAllMessages']);
    Route::post('/messages', [MessageController::class, 'createMessage']);
    Route::delete('/messages/{id}', [MessageController::class, 'deleteMessage']);
});
//CHAT_USER
Route::group([
    'middleware' => ['auth:sanctum']
], function () {
    Route::get('/chat_user', [ChatUserController::class, 'getAllChatUsers']);
    Route::post('/chat_user', [ChatUserController::class, 'createChatUser']);
    Route::delete('/chat_user/{id}', [ChatUserController::class, 'deleteChatUser']);
});


//FOLLOWERS     
Route::group([
    'middleware' => ['auth:sanctum']
], function () {
    Route::get('/followers', [FollowerController::class, 'getAllFollowers']);
    Route::get('/followers/{id}', [FollowerController::class, 'getFollowerById']);
    Route::post('/followers', [FollowerController::class, 'createFollower']);
    Route::put('/followers', [FollowerController::class, 'updateFollower']);
    Route::delete('/followers/{id}', [FollowerController::class, 'deleteFollower']);
});
//ADMIN

Route::group([
    'middleware' => ['auth:sanctum']
], function () { 
    Route::post('/event_user', [EventUserController::class, 'createEventUser']);
});

// EVENTS
Route::group([ 
    'middleware' => ['auth:sanctum']
], function () {
    Route::get('/events', [EventController::class, 'getAllEvents']);
    Route::post('/events', [EventController::class, 'createEvent']);
    Route::put('/events', [EventController::class, 'updateEvent']);
    Route::delete('/events/{id}', [EventController::class, 'deleteEvent']);
});

// EVENT_USER
Route::group([
    'middleware' => ['auth:sanctum']
], function () {
    Route::get('/event_user', [EventUserController::class, 'getAllEventUsers']);
    Route::delete('/event_user/{id}', [EventUserController::class, 'deleteEventUser']);
});


// SUPER_ADMIN
Route::group([
    'middleware' => ['auth:sanctum']
], function () {
    Route::get('/users', [UserController::class, 'DeleteUser']);
    Route::post('/event_user', [EventUserController::class, 'createEventUser']);
});
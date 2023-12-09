<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventUserController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\SuperAdminController;
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
    Route::get('user/{id}', [UsersController::class, 'getUserById']);// obtener un usuario por id
});

// FEEDS
Route::group([
    'middleware' => ['auth:sanctum']
], function () {
    Route::get('/feeds', [FeedController::class, 'getAllfeeds']); //obtener todos las publicaciones
    Route::get('/feeds/profile', [FeedController::class, 'getMyFeed']);  //obtener todas las publicaciones de mi perfil
    Route::get('/feeds/{id}', [FeedController::class, 'getfeedsByUserId']); //obtener las publicaciones por id del usuario
    Route::post('/createFeed', [FeedController::class, 'createFeed']);// crear publicacion
    Route::put('/updateFeed', [FeedController::class, 'updateFeed']);// actualizar publicacion
    Route::delete('/deleteFeed/{id}', [FeedController::class, 'deleteFeed']);// eliminar publicacion
});
//COMMENTS
Route::group([
    'middleware' => ['auth:sanctum']
], function () {
    Route::get('/comments/{id}', [CommentController::class, 'getAllCommentsByFeedId']);  
    Route::post('/comments', [CommentController::class, 'createCommentByFeedId']);  
    Route::delete('/comments/{id}', [CommentController::class, 'deleteCommentByFeedId']); 
});
// LIKES
Route::group([
    'middleware' => ['auth:sanctum']
], function () { 
    Route::get('/likes/{id}', [LikeController::class, 'getLikesByFeedId']);
    Route::post('/like', [LikeController::class, 'createLikeByFeedId']); 
    Route::delete('/like/{id}', [LikeController::class, 'deleteLikeByFeedId']);
});

// CHATS
Route::group([
    'middleware' => ['auth:sanctum']
], function () {  
    Route::get('/mychats', [ChatController::class, 'getAllMyChats']);
    //TODO----------------------------->
    Route::get('/chats/{id}', [ChatController::class, 'getChatById']);
    //TODO----------------------------->
    Route::post('/chats', [ChatController::class, 'createChat']);//create chat with someone // hacer atach con el usuario que queremos incluir en el chat
    //TODO----------------------------->
    Route::delete('/chats/{id}', [ChatController::class, 'deleteChat']);
});

// MESSAGES
Route::group([
    'middleware' => ['auth:sanctum']
], function () {
    //TODO----------------------------->
    Route::get('/messages/{id}', [MessageController::class, 'getAllMessagesByChatId']);
    //TODO----------------------------->
    Route::post('/messages', [MessageController::class, 'createMessageByChatId']);
    //TODO----------------------------->
    Route::delete('/messages/{id}', [MessageController::class, 'deleteMessageByChatId']);
}); 

//FOLLOWERS     
Route::group([
    'middleware' => ['auth:sanctum']
], function () {
    Route::get('/followings',[FollowerController::class, 'getAllMyFollowings']);
    Route::get('/followings/{id}', [FollowerController::class, 'getFollowingsByUserId']);
    Route::get('/followers',[FollowerController::class, 'getAllMyFollowers']);
    Route::get('/followers/{id}', [FollowerController::class, 'getFollowersByUserId']); //obtener todos los seguidores de un usuario
    Route::post('/followers', [FollowerController::class, 'createFollower']);// empiza a seguir a alguien 
    Route::delete('/followers/{id}', [FollowerController::class, 'deleteFollower']);
});

// EVENTS
Route::group([ 
    'middleware' => ['auth:sanctum' , 'is_admin' ]
], function () {
    Route::post('/events/create', [EventController::class, 'createEvent']);
    // Route::put('/events', [EventController::class, 'updateEvent']);//future
    Route::delete('/events/{id}', [EventController::class, 'deleteEvent']);
});
Route::group([
    'middleware' => ['auth:sanctum']
], function () { 
    Route::get('/events', [EventController::class, 'getAllEvents']);//obtener todos los eventos
});

// EVENT_USER
Route::group([
    'middleware' => ['auth:sanctum']
], function () {
    Route::post('/event_user', [EventUserController::class, 'createEventUser']);// asistir a un evento
    Route::get('/event_user/{id}', [EventUserController::class, 'getAllEventUsersByEventId']);//ver todos los asistentes a un evento especifico
    Route::delete('/event_user/{id}', [EventUserController::class, 'deleteEventUser']);// dejar de asistir a un evento
});


// SUPER_ADMIN
Route::group([
    'middleware' => ['auth:sanctum']
], function () {
    Route::delete('/deleteOneBySuper/{id}', [SuperAdminController::class, 'deleteOneBySuper']); //borrar un usuario
    Route::put('/changeRole', [SuperAdminController::class, 'changeRole']);// cambiar el rol de un usuario
});
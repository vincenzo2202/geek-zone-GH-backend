<?php

use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/api', function (Request $request) {
    return response()->json(
        [
            "success" => true,
            "message" => "Healthcheck ok"
        ],
        Response::HTTP_OK
    );
});

Route::get('/', function () {
    return view('welcome');
});

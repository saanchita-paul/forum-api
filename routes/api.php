<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ForumController;
use App\Http\Controllers\Api\CommentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
/**
 * sanctum authentication middleware
 */
Route::group(['middleware' => ['auth:sanctum']], function () {
    /**
     * user logout
     */
    Route::post('/auth/logout',[AuthController::class,'logoutUser']);
    /**
     * get user
     */
    Route::get('/auth/user', [AuthController::class,'getUser']);

    Route::put('/comments/{commentId}', [CommentController::class, 'editComment']);
    Route::delete('/comments/{commentId}', [CommentController::class, 'deleteComment']);
});
/**
 * user register
 */
Route::post('/auth/register', [AuthController::class, 'createUser']);
/**
 * user login
 */
Route::post('/auth/login', [AuthController::class, 'loginUser']);




/**
 * forum create api with single image support
 */
Route::post('/forums', [ForumController::class, 'createForum']);
/**
 * forum list with image, pagination, search and count
 */
Route::get('/forums', [ForumController::class, 'forumList']);
/**
 * forum details with comments, upvote count of each forum and voted by
 */
Route::get('/forums/{forumID}', [ForumController::class, 'forumDetails']);
/**
 * comments list with pagination of the forum
 */
Route::get('/forums/{forumID}/comments', [ForumController::class, 'getComments']);
/**
 * add vote to a forum
 */
Route::post('/forums/{forumID}/vote', [ForumController::class, 'addVote']);
/**
 * comment on a forum
 */
Route::post('/forums/{forumID}/comment', [ForumController::class, 'addComment']);
/**
 * vote a comment
 */
Route::post('/comments/{commentID}/vote', [ForumController::class, 'voteComment']);




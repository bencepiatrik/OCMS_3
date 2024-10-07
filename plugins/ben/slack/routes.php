<?php

use Ben\Slack\Http\UserController;
use Ben\Slack\Http\ChatController;
use Ben\Slack\Http\MessageController;
use Ben\Slack\Http\ReactionController;
use Ben\Slack\Middleware\AuthMiddleware;

/* REVIEW - používaš controller cez string, je to o dosť výhodnejšie, keď to spravíš ako si to mal v minulom leveli myslím
čiže cez user Ben\Slack\Http\AuthController; a potom [AuthController, 'funkcia']
Teraz napr. nemôžem využívať text editor funkcie ako redirect na controller cez Ctrl + LMB, tažšie sa to číta a pod */

Route::group(['prefix' => 'api/v1', 'middleware' => ['web']], function() {
    // Auth routes
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);
});


Route::group(['prefix' => 'api/v1', 'middleware' => [AuthMiddleware::class]], function() {
    // Chat routes
    Route::post('/chats', [ChatController::class, 'createChat']);
    Route::get('/chats', [ChatController::class, 'listChats']);

    // Message routes
 //   Route::post('/messages', [MessageController::class, 'sendMessage']);
 //   Route::get('/chats/{chatId}/messages', [MessageController::class, 'getMessages']);


    // Send
    Route::post('messages', [MessageController::class, 'store']);
    // View
    Route::get('messages/{id}', [MessageController::class, 'show']);
    // Update
    Route::put('messages/{id}', [MessageController::class, 'update']);
    // Delete
    Route::delete('messages/{id}', [MessageController::class, 'delete']);




    // User list
    Route::get('/users', [UserController::class, 'getAllUsers']);

    // Message reactions
    Route::get('/emojis', [ReactionController::class, 'getAllowedEmojis']);
    Route::post('/reactions', [ReactionController::class, 'addReaction']);
    Route::get('/messages/{message_id}/reactions', [ReactionController::class, 'getReactionsForMessage']);
});




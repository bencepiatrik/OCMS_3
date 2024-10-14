<?php

use Ben\Slack\Http\UserController;
use Ben\Slack\Http\ChatController;
use Ben\Slack\Http\MessageController;
use Ben\Slack\Http\ReactionController;
use Ben\Slack\Middleware\AuthMiddleware;

// FIX - Dve skupiny v sebe sú lepšie, ani som nevedel, že sa to dá zapísať aj takto. Hlavné komentáre na skupiny endpointov by som nechal, opisovať každý osobitne je naozaj zbytočné.

Route::group(['prefix' => 'api/v1', 'middleware' => ['web']], function() {
    // Auth routes
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);

    // Authenticated routes
    Route::group(['middleware' => [AuthMiddleware::class]], function() {
        // Chat routes
        Route::post('/chats', [ChatController::class, 'createChat']);
        Route::get('/chats', [ChatController::class, 'listChats']);

        // Message routes
        Route::post('messages', [MessageController::class, 'store']);
        Route::get('messages/{id}', [MessageController::class, 'show']);
        Route::put('messages/{id}', [MessageController::class, 'update']);
        Route::delete('messages/{id}', [MessageController::class, 'delete']);

        // User list
        Route::get('/users', [UserController::class, 'getAllUsers']);

        // Message reactions
        Route::get('/emojis', [ReactionController::class, 'getAllowedEmojis']);
        Route::post('/reactions', [ReactionController::class, 'addReaction']);
        Route::get('/messages/{message_id}/reactions', [ReactionController::class, 'getReactionsForMessage']);
    });
});



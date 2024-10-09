<?php

use Ben\Slack\Http\UserController;
use Ben\Slack\Http\ChatController;
use Ben\Slack\Http\MessageController;
use Ben\Slack\Http\ReactionController;
use Ben\Slack\Middleware\AuthMiddleware;

// REVIEW - tu by si mohol skôr mať 2 groupy v sebe, prvá bez AuthMiddleware a v nej group s AuthMiddleware, tým pádom by ti ten 'web' platil aj pri ostatných routes

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


    /* REVIEW - Tu by som len upozornil na takú menšiu vec, a to kedy písať komenty a kedy nie
    Všeobecne sa často hovorí že je lepšie písať komenty ako nie, ale niekedy je to counter-productive a len to zaberá miesto, hlavne v takýchto prípadoch
    kde ten koment nepridáva moc hodnotu, keďže význam koment vyplýva z toho kódu ktorý opisuje, napr. netreba dávať koment 'delete' na endpoint ktorý spúšťa funkciu delete
    levo je jasné o čo ide. Komenty treba písať hlavne tam kde by niekto kto nepozná tvoj kód mohol byť zmätený, a táto osoba môžeš byť samozrejme aj ty keď si svoj kód už dlho nevidel :D */
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




<?php

Route::group(['prefix' => 'api/v1', 'middleware' => ['web']], function() {
    // Auth routes
    Route::post('/register', 'Ben\Slack\Http\AuthController@register');
    Route::post('/login', 'Ben\Slack\Http\AuthController@login');

    // Chat routes
    Route::post('/chats', 'Ben\Slack\Controllers\ChatController@createChat');
    Route::get('/chats', 'Ben\Slack\Controllers\ChatController@listChats');

    // Message routes
    Route::post('/messages', 'Ben\Slack\Controllers\MessageController@sendMessage');
    Route::get('/chats/{chatId}/messages', 'Ben\Slack\Controllers\MessageController@getMessages');

    // User list
    Route::get('/users', 'Ben\Slack\Controllers\UserController@getAllUsers');

    // Message reactions
    Route::get('/emojis', 'Ben\Slack\Controllers\ReactionController@getAllowedEmojis');
    Route::post('/reactions', 'Ben\Slack\Controllers\ReactionController@addReaction');
    Route::get('/messages/{message_id}/reactions', 'Ben\Slack\Controllers\ReactionController@getReactionsForMessage');

});




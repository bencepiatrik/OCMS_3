<?php namespace Ben\Slack\Http;

use Ben\Slack\Models\Chat;
use Ben\Slack\Models\Message;
use Illuminate\Http\Request;

/**
 * Message Controller Backend Controller
 *
 * @link https://docs.octobercms.com/3.x/extend/system/controllers.html
 */
class MessageController
{
    public function sendMessage(Request $request)
    {
        $user = $request->input('authenticated_user');

        $chatId = $request->input('chat_id');
        $chat = Chat::find($chatId);

        if (!$chat || !in_array($user->id, [$chat->user1_id, $chat->user2_id])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $message = Message::create([
            'chat_id' => $chatId,
            'user_id' => $user->id,
            'content' => $request->input('content'),
            'reply_to_message_id' => $request->input('reply_to_message_id'),
            'file_path' => $request->hasFile('file') ? $request->file('file')->store('/uploads') : null
        ]);

        return response()->json($message);
    }

    public function getMessages($chatId, Request $request)
    {
        $user = $request->input('authenticated_user');

        $chat = Chat::find($chatId);
        if (!$chat || !in_array($user->id, [$chat->user1_id, $chat->user2_id])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $messages = $chat->messages()->get()->map(function ($message) {
            $message->file_url = $message->file_path ? url('storage/app/' . $message->file_path) : null;
            return $message;
        });

        return response()->json($messages);
    }
}

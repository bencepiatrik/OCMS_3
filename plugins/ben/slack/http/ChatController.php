<?php namespace Ben\Slack\Http;

use Ben\Slack\Models\Chat;
use Illuminate\Http\Request;

class ChatController
{
    public function createChat(Request $request)
    {
        $user = $request->input('authenticated_user');

        // REVIEW - Tu mi celkom chýba validácia pre toto ID, nemusí existovať (toto sa taktiež dá dokázať v $rules v modeli)
        $user2Id = $request->input('user2_id');

        $chat = Chat::create([
            'user1_id' => $user->id,
            'user2_id' => $user2Id,
            'name' => $request->input('name')
        ]);

        return response()->json($chat);
    }

    public function listChats(Request $request)
    {
        $user = $request->input('authenticated_user');


        $chats = Chat::where('user1_id', $user->id)
            ->orWhere('user2_id', $user->id)
            ->get();

        return response()->json($chats);
    }
}

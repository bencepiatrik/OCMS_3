<?php namespace Ben\Slack\Http;

use Ben\Slack\Models\Chat;
use Ben\Slack\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChatController
{
    /**
     * @throws \Exception
     */
    public function createChat(Request $request)
    {
        $user = AuthService::getAuthenticatedUserFromRequest($request);

        // REVIEW - Tu mi celkom chýba validácia pre toto ID, nemusí existovať (toto sa taktiež dá dokázať v $rules v modeli)
        $user2Id = $request->input('user2_id');

        $data = [
            'user1_id' => $user->id,
            'user2_id' => $user2Id,
            'name' => $request->input('name')
        ];

        $validator = Validator::make($data, (new Chat)->rules);
        if ($validator->fails()) {
            throw new \Exception($validator->errors());
        }
        $chat = Chat::create($data);

        return response()->json($chat);
    }

    public function listChats(Request $request)
    {
        $user = AuthService::getAuthenticatedUserFromRequest($request);

        $chats = Chat::where('user1_id', $user->id)
            ->orWhere('user2_id', $user->id)
            ->get();

        return response()->json($chats);
    }
}

<?php namespace Ben\Slack\Http;


use Ben\Slack\Models\Reaction;
use Illuminate\Http\Request;
use Ben\Slack\Models\Emoji;


/**
 * Reaction Controller Backend Controller
 *
 * @link https://docs.octobercms.com/3.x/extend/system/controllers.html
 */
class ReactionController
{
    public function addReaction(Request $request)
    {
        $user = $request->input('authenticated_user');

        $emoji = $request->input('emoji');

        $allowedEmojis = Emoji::pluck('emoji')->toArray(); // REVIEW - táto istá logika sa ti opakuje o pár riadkov nižšie

        if (!in_array($emoji, $allowedEmojis)) {
            // REVIEW - všade kde takto nastáva chyba by si mal použiť throw new Exception() namiesto json response
            return response()->json(['error' => 'Emoji not allowed'], 400);
        }

        $reaction = Reaction::create([
            'message_id' => $request->input('message_id'),
            'user_id' => $user->id,
            'emoji' => $emoji,
        ]);

        return response()->json($reaction);
    }

    public function getAllowedEmojis()
    {
        return Emoji::pluck('emoji')->toArray();

    }

    public function getReactionsForMessage($messageId, Request $request)
    {
        // REVIEW - nepoužívaš usera
        $user = $request->input('authenticated_user');

        $reactions = Reaction::where('message_id', $messageId)->get();

        if ($reactions->isEmpty()) {
            // REVIEW - Toto by podľa mňa nemala byť úplne chyba, správa nie je chybná ak nemá reakciu/e
            return response()->json(['message' => 'No reactions found for this message'], 404);
        }

        return response()->json($reactions);
    }

}

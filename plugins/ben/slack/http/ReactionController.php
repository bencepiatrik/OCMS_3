<?php namespace Ben\Slack\Http;


use Ben\Slack\Models\Reaction;
use Ben\Slack\Services\AuthService;
use Illuminate\Http\Request;
use Ben\Slack\Models\Emoji;


/**
 * Reaction Controller Backend Controller
 *
 * @link https://docs.octobercms.com/3.x/extend/system/controllers.html
 */
class ReactionController
{
    /**
     * @throws \Exception
     */
    public function addReaction(Request $request)
    {
        $user = AuthService::getAuthenticatedUserFromRequest($request);

        $emoji = $request->input('emoji');

        $allowedEmojis = $this->getAllowedEmojis(); // REVIEW - táto istá logika sa ti opakuje o pár riadkov nižšie // FIX - áno, už to vidím

        if (!in_array($emoji, $allowedEmojis)) {
            // REVIEW - všade kde takto nastáva chyba by si mal použiť throw new Exception() namiesto json response
            throw new \Exception('Emoji not allowed');
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
        // FIX - I see.
        $reactions = Reaction::where('message_id', $messageId)->get();

        // REVIEW - Toto by podľa mňa nemala byť úplne chyba, správa nie je chybná ak nemá reakciu/e
        // FIX - Áno, súhlasím

        return response()->json($reactions);
    }

}

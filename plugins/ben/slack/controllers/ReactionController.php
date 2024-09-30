<?php namespace Ben\Slack\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Ben\Slack\Models\Reaction;
use Ben\Slack\Models\User;
use Illuminate\Http\Request;
use Ben\Slack\Models\Emoji;


/**
 * Reaction Controller Backend Controller
 *
 * @link https://docs.octobercms.com/3.x/extend/system/controllers.html
 */
class ReactionController extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
    ];

    /**
     * @var string formConfig file
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string listConfig file
     */
    public $listConfig = 'config_list.yaml';

    /**
     * @var array required permissions
     */
    public $requiredPermissions = ['ben.slack.access_emojis'];

    /**
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Ben.Slack', 'slack', 'reactioncontroller');
    }


    public function addReaction(Request $request)
    {
        $user = $this->authenticateWithToken($request);

        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user;
        }

        $emoji = $request->input('emoji');

        $allowedEmojis = Emoji::pluck('emoji')->toArray();

        if (!in_array($emoji, $allowedEmojis)) {
            return response()->json(['error' => 'Emoji not allowed'], 400);
        }

        $reaction = Reaction::create([
            'message_id' => $request->input('message_id'),
            'user_id' => $user->id,
            'emoji' => $emoji,
        ]);

        return response()->json($reaction);
    }


    public function authenticateWithToken(Request $request)
    {
        $token = $request->header('Authorization');

        if (strpos($token, 'Bearer ') === 0) {
            $token = substr($token, 7);
        }

        $user = User::where('api_token', $token)->first();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $user;
    }

    public function getAllowedEmojis()
    {
        return Emoji::pluck('emoji')->toArray();

    }

    public function getReactionsForMessage($messageId, Request $request)
    {
        $user = $this->authenticateWithToken($request);
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user;
        }

        $reactions = Reaction::where('message_id', $messageId)->get();

        if ($reactions->isEmpty()) {
            return response()->json(['message' => 'No reactions found for this message'], 404);
        }

        return response()->json($reactions);
    }

}

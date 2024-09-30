<?php namespace Ben\Slack\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Ben\Slack\Models\Chat;
use Ben\Slack\Models\Message;
use Ben\Slack\Models\User;
use Illuminate\Http\Request;

/**
 * Message Controller Backend Controller
 *
 * @link https://docs.octobercms.com/3.x/extend/system/controllers.html
 */
class MessageController extends Controller
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
    public $requiredPermissions = ['ben.slack.messagecontroller'];

    /**
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Ben.Slack', 'slack', 'messagecontroller');
    }

    public function sendMessage(Request $request)
    {
        $user = $this->authenticateWithToken($request);
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user;
        }

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
        $user = $this->authenticateWithToken($request);
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user;
        }

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

}

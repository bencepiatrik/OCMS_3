<?php namespace Ben\Slack\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Ben\Slack\Models\Chat;
use Illuminate\Http\Request;
use Ben\Slack\Models\User;

/**
 * Chat Controller Backend Controller
 *
 * @link https://docs.octobercms.com/3.x/extend/system/controllers.html
 */
class ChatController extends Controller
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
    public $requiredPermissions = ['ben.slack.chatcontroller'];

    /**
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Ben.Slack', 'slack', 'chatcontroller');
    }

    public function createChat(Request $request)
    {
        $user = $this->authenticateWithToken($request);
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user;
        }

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
        $user = $this->authenticateWithToken($request);
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user;
        }

        $chats = Chat::where('user1_id', $user->id)
            ->orWhere('user2_id', $user->id)
            ->get();

        return response()->json($chats);
    }

    public function authenticateWithToken(Request $request) // REVIEW - toto sa ti veľa opakuje + je to niečo čo by si mal riešiť cez middleware v routes.php ako si to robil v leveli 2
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

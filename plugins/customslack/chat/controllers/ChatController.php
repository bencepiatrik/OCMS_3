<?php namespace CustomSlack\Chat\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use CustomSlack\Chat\Models\Chat;
use CustomSlack\Chat\Models\User;
use Illuminate\Support\Facades\Auth;

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
    public $requiredPermissions = ['customslack.chat.chatcontroller'];


    public function createChat()
    {
        $user1_id = Auth::getUser()->id;
        $user2_id = input('user2_id');

        // Check if a chat already exists between these two users
        $existingChat = Chat::where(function ($query) use ($user1_id, $user2_id) {
            $query->where('user1_id', $user1_id)->where('user2_id', $user2_id);
        })->orWhere(function ($query) use ($user1_id, $user2_id) {
            $query->where('user1_id', $user2_id)->where('user2_id', $user1_id);
        })->first();

        if (!$existingChat) {
            // Create a new chat if not already existing
            Chat::create([
                'user1_id' => $user1_id,
                'user2_id' => $user2_id,
            ]);
        }

        return redirect('/chats');
    }

    /**
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('CustomSlack.Chat', 'chat', 'chatcontroller');
    }
}

<?php namespace Ben\Slack\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Illuminate\Http\Request;
use Ben\Slack\Models\User;
use Response;

/**
 * User Controller Backend Controller
 *
 * @link https://docs.octobercms.com/3.x/extend/system/controllers.html
 */
class UserController extends Controller
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
    public $requiredPermissions = ['ben.slack.usercontroller'];

    /**
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Ben.Slack', 'slack', 'usercontroller');
    }

    private function authenticateWithToken(Request $request)
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

    public function getAllUsers(Request $request)
    {
        $user = $this->authenticateWithToken($request);
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user;
        }

        $users = User::where('id', '!=', $user->id)->get(['id', 'username', 'email']);

        return response()->json($users);
    }
}

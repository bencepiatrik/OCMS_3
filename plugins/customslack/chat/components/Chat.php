<?php namespace CustomSlack\Chat\Components;

use Cms\Classes\ComponentBase;
use CustomSlack\Chat\Models\Chat as ChatModel;
use CustomSlack\Chat\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * Chat Component
 *
 * @link https://docs.octobercms.com/3.x/extend/cms-components.html
 */
class Chat extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Chat Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function onCreateChat()
    {
        $user1_id = Auth::getUser()->id;
        $user2_id = post('user2_id');

        $existingChat = ChatModel::where(function ($query) use ($user1_id, $user2_id) {
            $query->where('user1_id', $user1_id)->where('user2_id', $user2_id);
        })->orWhere(function ($query) use ($user1_id, $user2_id) {
            $query->where('user1_id', $user2_id)->where('user2_id', $user1_id);
        })->first();

        if (!$existingChat) {
            ChatModel::create([
                'user1_id' => $user1_id,
                'user2_id' => $user2_id,
            ]);
        }

        return redirect('/chats');
    }

    /**
     * @link https://docs.octobercms.com/3.x/element/inspector-types.html
     */
    public function defineProperties()
    {
        return [];
    }
}

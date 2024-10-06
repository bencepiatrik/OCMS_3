<?php namespace Ben\Slack\Models;

use Model;

/**
 * Chat Model
 *
 * @link https://docs.octobercms.com/3.x/extend/system/models.html
 */
class Chat extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table name
     */
    public $table = 'ben_slack_chats';

    /**
     * @var array rules for validation
     */
    public $rules = [];


    protected $fillable = ['user1_id', 'user2_id', 'name'];

    public function messages()
    {
        return $this->hasMany('Ben\Slack\Models\Message', 'chat_id');

    }

    public $belongsTo = [
        'user1' => [User::class, 'key' => 'user1_id'],
        'user2' => [User::class, 'key' => 'user2_id'],
    ];
}

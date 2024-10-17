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
    public array $rules = [
        'user1_id' => 'required|exists:users,id',
        'user2_id' => 'required|exists:users,id|different:user1_id',
        'name' => 'required|string|max:255',
    ];

    protected $fillable = ['user1_id', 'user2_id', 'name'];

    public $belongsTo = [
        'user1' => [User::class, 'key' => 'user1_id'],
        'user2' => [User::class, 'key' => 'user2_id'],
    ];
}

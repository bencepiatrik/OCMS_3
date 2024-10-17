<?php namespace Ben\Slack\Models;

use Model;

/**
 * Reaction Model
 *
 * @link https://docs.octobercms.com/3.x/extend/system/models.html
 */
class Reaction extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table name
     */
    public $table = 'ben_slack_reactions';

    /**
     * @var array rules for validation
     */
    public $rules = [];

    public $belongsTo = [
        'message' => [Message::class, 'key' => 'message_id'],
        'user' => [User::class, 'key' => 'user_id'],
    ];


    protected $fillable = [
        'message_id',
        'user_id',
        'emoji',
    ];
}

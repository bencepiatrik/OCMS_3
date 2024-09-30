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
        'message' => ['Ben\Slack\Models\Message', 'key' => 'message_id'],
        'user' => ['Ben\Slack\Models\User', 'key' => 'user_id'],
    ];


    protected $fillable = [
        'message_id',
        'user_id',
        'emoji',
    ];

    public function message()
    {
        return $this->belongsTo('Ben\Slack\Models\Message', 'message_id');
    }

    public function user()
    {
        return $this->belongsTo('Ben\Slack\Models\User', 'user_id');
    }
}

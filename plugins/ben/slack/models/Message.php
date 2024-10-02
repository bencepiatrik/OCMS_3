<?php namespace Ben\Slack\Models;

use Model;

/**
 * Message Model
 *
 * @link https://docs.octobercms.com/3.x/extend/system/models.html
 */
class Message extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table name
     */
    public $table = 'ben_slack_messages';

    /**
     * @var array rules for validation
     */
    public $rules = [];

    protected $fillable = ['chat_id', 'user_id', 'content', 'reply_to_message_id', 'file_path'];


    public $belongsTo = [
        'chat' => ['Ben\Slack\Models\Chat', 'key' => 'chat_id'],
        'user' => ['Ben\Slack\Models\User', 'key' => 'user_id'],
        'replyToMessage' => ['Ben\Slack\Models\Message', 'key' => 'reply_to_message_id']
    ];

    public function chat()
    {
        return $this->belongsTo('Ben\Slack\Models\Chat', 'chat_id');
    }

    public function user()
    {
        return $this->belongsTo('Ben\Slack\Models\User', 'user_id');
    }

    public function replyToMessage()
    {
        return $this->belongsTo('Ben\Slack\Models\Message', 'reply_to_message_id');
    }

    public function reactions()
    {
        return $this->hasMany('Ben\Slack\Models\Reaction', 'message_id');
    }

    // REVIEW - vidím že tu riešiš ten file cez custom funkcie, skús pozrieť v OCMS docs attachments, možno to bude jednoduchšie
    public function setFileAttribute($file)
    {
        if ($file) {
            $this->attributes['file_path'] = $file->store('uploads');
        }
    }

    public function getFileUrlAttribute()
    {
        return url('storage/' . $this->file_path);
    }
}

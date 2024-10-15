<?php namespace Ben\Slack\Updates;

use Model;

/**
 * EmojiSettings Model
 *
 * @link https://docs.octobercms.com/3.x/extend/system/models.html
 */
class EmojiSettings extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table name
     */
    public $table = 'ben_slack_emojis';

    /**
     * @var array rules for validation
     */
    public $rules = [];

    protected $fillable = ['emoji'];

}

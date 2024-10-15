<?php namespace Ben\Slack\Models;

use Model;
use Str;

/**
 * User Model
 *
 * @link https://docs.octobercms.com/3.x/extend/system/models.html
 */
class User extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Hashable;

    /**
     * @var string table name
     */
    public $table = 'users';

    /**
     * @var array rules for validation
     */
    public array $rules = [];

    protected $fillable = ['username'];

    protected $hashable = ['password'];


    // REVIEW - Ak som ti ešte nespomínal $hashable (OCMS docs) tak si to pozri, robí to túto funkciu v podstate za teba
    // FIX - Ano, konečne som prišiel na to, ako ten hashable funguje
    public function generateApiToken()
    {
        $this->api_token = Str::random(60);
        $this->save();
        return $this->api_token;
    }
}

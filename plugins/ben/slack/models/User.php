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
    public array $rules = [
        'username' => 'required',
        'password' => 'required|min:6',
    ];

    protected $fillable = ['username'];

    protected $hashable = ['password'];

    public function generateApiToken()
    {
        $this->api_token = Str::random(60);
        $this->save();
        return $this->api_token;
    }
}

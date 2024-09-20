<?php

namespace CustomSlack\Chat\Models;

use Model;
use Hash;

class User extends Model
{
protected $table = 'customslack_chat_users';

protected $primaryKey = 'id';


protected $fillable = ['username', 'password', 'email', 'token'];

    public function beforeSave()
    {
        if ($this->password) {
            $this->password = Hash::make($this->password);
        }
    }
}

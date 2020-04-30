<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class User
 * @package App\Models
 * @property int id
 * @property string login
 * @property string password
 * @property string public_key
 * @property string private_key
 * @property string passphrase
 *
 * @property HasMany notes
 */
class User extends Model
{
    public function notes(){
        return $this->hasMany('App\Models\Note', 'user_id');
    }
}

<?php

namespace App\Models;

use App\Helpers\CryptoHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Mail\Markdown;

/**
 * Class Note
 * @package App\Models
 *
 * @property int id
 * @property int user_id
 * @property string title
 * @property string body
 * @property string token
 */
class Note extends Model
{

    public function decrypt(string $password){
        $user = $this->user()->get()->first();
        $passphrase = CryptoHelper::DecryptPassphrase($password, $user->passphrase);
        $this->body = CryptoHelper::DecryptNote($this->body, $this->token, $passphrase, $user->private_key);
    }

    public function save($options = [])
    {
        $user = $this->user()->get()->first();
        $cdata = CryptoHelper::EncryptNote($this->body, $user->public_key);
        $this->body =  $cdata['data'];
        $this->token = $cdata['token'];
        parent::save($options);
    }

    /**
     * @return BelongsTo|User
     */
    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}

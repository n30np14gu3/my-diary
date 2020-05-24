<?php


namespace App\Helpers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;

class UserSession
{
    public $id;
    public $login;
    public $password;
    public $passphrase;
    public $expire_in;

    public $path;


    /**
     * UserSession constructor
     * TODO: FIX LOADING
     * @param string $path
     */
    public function __construct(string $path)
    {
        if(!File::exists($path))
            return;

        $content = file_get_contents($path);
        try{
            $data = @json_decode(Crypt::decryptString($content), true);
            if(!$data)
                throw new \Exception("INVALID JSON DATA");

            $this->id = $data['id'];
            $this->login = $data['login'];
            $this->password = $data['password'];
            $this->expire_in = $data['expire_in'];
            $this->passphrase = $data['passphrase'];
        }
        catch(\Exception $ex){
            if(env('SEC_DEBUG')){
                echo "ERROR: ".$ex->getMessage()."\r\n";
                echo "---INVALID DATA---\r\n";
                echo $content;
                die("------------------\r\n");
            }
        }
    }

    /**
     * [FIXING]
     * @param Request $request
     */
    public function save(Request $request){
        $path = @$request->session()->get('session_path');
        if(!$path)
            return;
        $json = [
            'id' => $this->id,
            'login' => $this->login,
            'password' => $this->password,
            'expire_in' => $this->expire_in,
            'passphrase' => $this->passphrase
        ];
        file_put_contents($path, Crypt::encryptString(json_encode($json)));
    }

    public function close(Request $request){
        $path = @$request->session()->get('session_path');
        if(!$path)
            return;
        unlink($request->session()->get('session_path'));
    }
}

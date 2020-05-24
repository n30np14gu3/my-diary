<?php
namespace App\Helpers;

use Illuminate\Support\Str;

class CryptoHelper
{
    private static $METHOD = 'AES-256-CBC';//DO NOT MODIFY!!!

    public static function GetKeyPair(string $passphrase){
        try{
            $settings = openssl_pkey_new([
                "digest_alg" => "sha512",
                "private_key_bits" => 4096,
                "private_key_type" => OPENSSL_KEYTYPE_RSA
            ]);

            openssl_pkey_export($settings, $privateKey, $passphrase);
            $publicKey = openssl_pkey_get_details($settings);
            return [
                'pub' => $publicKey['key'],
                'sec' => $privateKey
            ];
        }
        catch(\Exception $ex){
            return null;
        }
    }

    public static function EncryptNote(string $note, string $public_key){
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(self::$METHOD));
        $key = openssl_random_pseudo_bytes(32);

        $pk = openssl_get_publickey($public_key);
        $token = base64_encode($iv)."@".base64_encode($key);

        $cipher = base64_encode(openssl_encrypt($note, self::$METHOD, $key, OPENSSL_RAW_DATA, $iv));
        openssl_public_encrypt($token, $sec_token, $pk);
        $sec_token = base64_encode($sec_token);
        openssl_free_key($pk);
        return [
            'data' => $cipher,
            'token' => $sec_token
        ];
    }

    public static function DecryptNote(string $note, string $sec_token, string $passphrase, string $private_key){
        $pk = openssl_get_privatekey($private_key, $passphrase);
        openssl_private_decrypt(base64_decode($sec_token), $token, $pk);
        $token = explode('@', $token);
        $clean = openssl_decrypt(base64_decode($note), self::$METHOD, base64_decode($token[1]), OPENSSL_RAW_DATA, base64_decode($token[0]));
        openssl_free_key($pk);
        return $clean;
    }

    public static function DecryptPassphrase(string $password, string $passphrase){
        $generated_key = openssl_pbkdf2($password, env('SEC_GENERATOR_SALT'), 48, 1000, 'sha256');
        $key = substr($generated_key, 0, 32);
        $iv = substr($generated_key, 32, 16);
        $passphrase = openssl_decrypt(base64_decode($passphrase), self::$METHOD, $key, OPENSSL_RAW_DATA, $iv);
        return $passphrase;
    }

    public static function EncryptPassphrase(string $password, string $passphrase){
        $generated_key = openssl_pbkdf2($password, env('SEC_GENERATOR_SALT'), 48, 1000, 'sha256');
        $key = substr($generated_key, 0, 32);
        $iv = substr($generated_key, 32, 16);
        $passphrase = openssl_encrypt($passphrase, self::$METHOD, $key, OPENSSL_RAW_DATA, $iv);
        return base64_encode($passphrase);
    }

    public static function CompressCookie($cookie){
        $cookie = base64_encode(zlib_encode($cookie, ZLIB_ENCODING_DEFLATE ));
        $json = [
            'iv' => base64_encode(openssl_random_pseudo_bytes(16)),
            'value' => $cookie,
            'mac' => hash("sha256", openssl_random_pseudo_bytes(64))
        ];
        return base64_encode(json_encode($json));
    }

    public static function DecompressCookie( $cookie){
        $json = @json_decode(@base64_decode($cookie), true);
        if(!$json)
            return null;

        return @zlib_decode(@base64_decode($json['value']));
    }
}

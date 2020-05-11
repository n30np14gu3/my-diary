<?php

namespace App\Console\Commands;

use App\Helpers\UserHelper;
use App\Models\Note;
use Illuminate\Console\Command;
use Illuminate\Http\Request;

class InitLab extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init_lab {--trash= : Generate trash notes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Init lab';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        try{
            $file_path = storage_path('init.json');
            $req = new Request();
            $init_json = json_decode(file_get_contents($file_path), true);
            echo "File loaded!\n";
            $req['login'] = $init_json['username'];
            $req['password'] = $init_json['password'];
            echo "------------\n";
            echo "UserName: ".$init_json['username']."\n";
            echo "Password: ".$init_json['password']."\n";
            echo "Flag: ".$init_json['note']['body']."\n";
            echo "------------\n";
            $uid = UserHelper::CreateNewUser($req);
            if(!$uid){
                throw new \Exception("Can not create user!");
            }
            echo "New user created!\n";

            $generate = $this->option('trash');
            if($generate === "true"){
                $trash_notes = rand(2, 20);
                for($i = 0; $i < $trash_notes; $i++){
                    $n = new Note();
                    $n->user_id = $uid;
                    $n->title = 'My-note-'.rand(1, 1548);
                    $n->body = json_decode(file_get_contents('https://fish-text.ru/get'), true)['text'];
                    $n->save();
                }
            }
            $note = new Note();
            $note->user_id = $uid;
            $note->title = $init_json['note']['title'];
            $note->body = $init_json['note']['body'];
            $note->save();
            unlink($file_path);
            echo "Lab successfully prepared!\r\n";

        }
        catch(\Exception $ex){
            $this->error( "Error: ".$ex->getMessage());
        }
        return 0;
    }
}

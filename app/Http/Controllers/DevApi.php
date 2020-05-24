<?php

namespace App\Http\Controllers;

use App\Helpers\UserHelper;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Mail\Markdown;
use Illuminate\Support\Facades\File;
use PDF;
class DevApi extends Controller
{
    public function free_export(Request $request, $note_id){
        $user = UserHelper::GetUser($request);
        $session = UserHelper::GetUserSession($request);
        $note = Note::query()->where('id', $note_id)->where('user_id', $user->id)->get()->first();
        if(!$note)
            return redirect('/diary');

        $note->decrypt(@$session->password);
        $note->body = Markdown::parse($note->body)->toHtml();
        $pdf = null;
        $temp_file_path = storage_path(hash("sha256", openssl_random_pseudo_bytes(64)).".php");
        try {
            file_put_contents($temp_file_path, $note->body);
            $pdf = PDF::loadView('pages.free-pdf', [
                'note' => $note,
                'user' => $user,
                'file_path' => $temp_file_path
            ]);
            if(!$pdf)
                throw new \Exception("PDF IS NULL");

        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect('/diary');
        } finally {
            if(File::exists($temp_file_path)){
                unlink($temp_file_path);
            }
        }

        return $pdf->download('export-'.time().'.pdf');
    }
}

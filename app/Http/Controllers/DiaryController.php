<?php

namespace App\Http\Controllers;

use App\Helpers\UserHelper;
use App\Models\Note;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Mail\Markdown;
use Illuminate\Support\Facades\Validator;

use App;
use Illuminate\Support\Facades\View;
use PDF;

class DiaryController extends Controller
{
    public function index(Request $request){
        $user = UserHelper::GetUser($request);
        $data = [
            'notes' => [],
            'password' => $request->session()->get('password')
        ];

        $data['notes'] = $user->notes;
        return view('pages.diary')->with([
            'logged' => true,
            'data' => $data
        ]);
    }

    public function compose(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:100',
            'body' => 'required'
        ], [
            'required' => 'All fields required!',
            'max' => 'Max title length: 100'
        ]);

        if($validator->fails()){
            $this->response['message'] = $validator->errors()->first();
            return response()->json($this->response);
        }

        $user = UserHelper::GetUser($request);
        $note = new Note();
        $note->user_id = $user->id;
        $note->title = @$request['title'];
        $note->body = @$request['body'];
        $note->save();
        $this->response['status'] = 'OK';
        return $this->response;
    }

    public function edit(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:100',
            'body' => 'required',
            'note_id' => 'required'
        ], [
            'required' => 'All fields required!',
            'max' => 'Max title length: 100'
        ]);

        if($validator->fails()){
            $this->response['message'] = $validator->errors()->first();
            return $this->response;
        }

        $user = UserHelper::GetUser($request);

        $note = Note::query()->where('id', $request['note_id'])->where('user_id', $user->id)->get()->first();
        if(!$note){
            $this->response['message'] = 'Note not found!';
            return $this->response;
        }
        $note->title = @$request['title'];
        $note->body = @$request['body'];
        $note->save();
        $this->response['status'] = 'OK';
        return $this->response;
    }

    public function note(Request $request, $note_id){
        $user = UserHelper::GetUser($request);
        $note = Note::query()->where('id', $note_id)->where('user_id', $user->id)->get()->first();
        if(!$note)
            return redirect('/diary');

        $note->decrypt(@$request->session()->get('password'));
        $content = $note->body;
        $note->body = Markdown::parse(htmlspecialchars($note->body))->toHtml();
        return view('pages.note')->with([
            'logged' => true,
            'user' => $user,
            'note' => $note,
            'content' => $content
        ]);
    }

    public function export(Request $request, $note_id){
        $user = UserHelper::GetUser($request);
        $note = Note::query()->where('id', $note_id)->where('user_id', $user->id)->get()->first();
        if(!$note)
            return redirect('/diary');

        $note->decrypt(@$request->session()->get('password'));
        $note->body = Markdown::parse($note->body)->toHtml();//without htmlspecialchars


        $temp_data_path = storage_path(hash("sha256", openssl_random_pseudo_bytes(64)).".php");
        file_put_contents($temp_data_path, $note->body);

        $pdf = null;

        //Trap RCE
        try {
            $pdf = PDF::loadView('pages.pdf-export', [
                'note' => $note,
                'user' => $user,
                'path' => $temp_data_path
            ]);
        } catch (\Exception $e) {
            return redirect('/diary');
        } finally {
            unlink($temp_data_path);
        }

        return $pdf->download('export-'.time().'.pdf');
    }

    public function delete(Request $request){
        $validator = Validator::make($request->all(), [
            'note_id' => 'required'
        ], [
            'required' => 'All fields required!',
        ]);

        if($validator->fails()){
            $this->response['message'] = $validator->errors()->first();
            return $this->response;
        }

        $user = UserHelper::GetUser($request);

        $note = Note::query()->where('id', $request['note_id'])->where('user_id', $user->id)->get()->first();
        if(!$note){
            $this->response['message'] = 'Note not found!';
            return $this->response;
        }
        Note::destroy($note->id);
        $this->response['status'] = 'OK';
        return $this->response;
    }

}

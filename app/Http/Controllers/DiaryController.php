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
        $session = UserHelper::GetUserSession($request);

        $data = [
            'notes' => [],
            'password' => $session->password
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
        $session = UserHelper::GetUserSession($request);

        $note = Note::query()->where('id', $note_id)->where('user_id', $user->id)->get()->first();
        if(!$note)
            return redirect('/diary');

        $note->decrypt($session->password);
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
        $session = UserHelper::GetUserSession($request);
        $note = Note::query()->where('id', $note_id)->where('user_id', $user->id)->get()->first();
        if(!$note)
            return redirect('/diary');

        $note->decrypt(@$session->password);
        $note->body = Markdown::parse(htmlspecialchars($note->body))->toHtml();

        $pdf = null;

        try {
            $pdf = PDF::loadView('pages.pdf-export', [
                'note' => $note,
                'user' => $user,
            ]);

            if(!$pdf)
                throw new \Exception("PDF IS NULL");

        } catch (\Exception $e) {
            return redirect('/diary');
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

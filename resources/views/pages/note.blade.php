@extends('index')

@section('page-title', @$note->title)

@section('page-header')
    @include('modules.main-menu')
@endsection

@section('page-content')
    <div style="margin: 20px">
        <div class="ui stackable four column equal width grid">
            <div class="column">
                <div class="ui fluid card">
                    <div class="content">
                        <div class="header">{{@$note->title}}</div>
                        <div class="header" style="font-style: italic">{{@$user->login}}</div>
                        <div class="header" style="font-style: italic">{{@$note->created_at}}</div>
                        <hr>
                        <div class="content">
                            {!! @$note->body !!}
                        </div>
                    </div>

                    <div class="extra content">
                        <div class="ui fluid buttons">
                            <button class="ui positive  button" onclick="showModal('modal-edit-form')">Edit <i class="pen icon"></i></button>
                            <a class="ui orange  button" href="{{url('/export/'.@$note->id)}}" target="_blank">Export to pdf <i class="save outline icon"></i></a>
                            <button class="ui negative  button" onclick="deleteNote({{@$note->id}})">Delete <i class="eraser icon"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="ui small modal" id="modal-edit-form">
        <i class="close icon"></i>
        <div class="header">
            Edit your note
        </div>
        <div class="content">
            <form id="edit-form" class="ui form">
                {{csrf_field()}}
                <div class="field">
                    <label>Title:</label>
                    <input type="text" maxlength="100" name="title" value="{{@$note->title}}" required>
                </div>
                <div class="field">
                    <label>Note (markdown support!):</label>
                    <textarea name="body" required>{{@$content}}</textarea>
                </div>
                <input type="hidden" value="{{@$note->id}}" name="note_id">
                <div class="field">
                    <button type="submit" class="ui fluid primary button">Save</button>
                </div>
            </form>
        </div>
    </div>

@endsection

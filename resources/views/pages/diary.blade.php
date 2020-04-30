@extends('index')

@section('page-title', 'Diary')

@section('diary-active', 'active')

@section('page-header')
    @include('modules.main-menu')
@endsection

@section('page-content')
    <div class="ui vertical stripe segment">
        <div style="margin: 0 15px">
            <div class="ui container fluid">
                @if(count(@$data['notes']) != 0)
                    @include('modules.diary.notes-list')
                @else
                    @include('modules.diary.first-note')
                @endif
            </div>
        </div>
    </div>
@endsection

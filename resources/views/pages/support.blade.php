@extends('index')

@section('page-title', 'Support')

@section('support-active', 'active')

@section('page-header')
    @include('modules.main-menu')
@endsection

@section('page-content')
    <div class="ui vertical stripe segment">
        <div class="ui container">
            <div class="ui raised segment">
                <h3>Your message to support</h3>
                <form class="ui form" id="support-form">
                    <div class="field">
                        <label>Your name:</label>
                        <input type="text" name="name"  {{@$logged ? 'disabled=1' : '' }} value="{{@$logged ? @$user->login : '' }}" required>
                    </div>
                    <div class="field">
                        <label>Your email:</label>
                        <input type="email" name="email" required>
                    </div>
                    <div class="field">
                        <label>Your message: </label>
                        <textarea required name="message"></textarea>
                    </div>
                    {{csrf_field()}}
                    <div class="field">
                        <button type="submit" class="ui fluid primary button">Send message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

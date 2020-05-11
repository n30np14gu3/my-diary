@extends('index')
@section('page-title', 'Settings')

@section('settings-active', 'active')

@section('page-header')
    @include('modules.main-menu')
@endsection

@section('page-content')
    <div style="margin: 15px 5%">
        <div class="ui raised segment">
            <form class="ui form" id="change_password_form">
                <div class="field">
                    <label>Old password:</label>
                    <input type="password" name="old-password" required>
                </div>
                <div class="field">
                    <label>New password:</label>
                    <input type="password" name="new-password" required>
                </div>
                <div class="field">
                    <label>Repeat password:</label>
                    <input type="password" name="new-password-2" required>
                </div>
                {{csrf_field()}}
                <div class="field">
                    <button class="ui fluid primary button" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection

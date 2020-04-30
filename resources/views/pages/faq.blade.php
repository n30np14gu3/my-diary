@extends('index')

@section('page-title', 'F.A.Q')

@section('faq-active', 'active')

@section('page-header')
    @include('modules.main-menu')
@endsection

@section('page-content')
    <div class="ui vertical stripe segment">
        <div class="ui container">
            <div class="ui styled accordion fluid">
                <div class="active title">
                    <i class="dropdown icon"></i>
                    Is it free?
                </div>
                <div class="active content">
                    <p>Yes, it is completely free, the site receives revenue only from advertising.</p>
                </div>
                <div class="title">
                    <i class="dropdown icon"></i>
                    How it`s work?
                </div>
                <div class="content">
                    <p>All notes are encrypted using AES-256-CBC, and the encryption key is encrypted using RSA-4096.
                        THE pbkdf2 algorithm is used for the password for RSA. We store all records in encrypted form, and passwords are stored only as a hash.</p>
                </div>
                <div class="title">
                    <i class="dropdown icon"></i>
                    Do you collect any data from users?
                </div>
                <div class="content">
                    <p>No, we do not collect information and do not keep ANY logs.</p>
                </div>
            </div>
        </div>
    </div>
@endsection

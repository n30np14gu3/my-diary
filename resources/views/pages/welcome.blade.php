@extends('index')

@section('page-title', 'Your Private Diary')

@section('welcome-active', 'active')

@section('inverted', 'inverted')

@section('page-header')
    <div class="ui inverted vertical masthead center aligned segment">
        @include('modules.main-menu')
        <div class="ui text container">
            <h1 class="ui inverted header">
                Your Private diary
            </h1>
            <h2>Save what you need</h2>
            @if(@$logged)
                <a class="ui huge primary button" href="{{url('/diary')}}">Go to diary <i class="right arrow icon"></i></a>
            @else
                <div class="ui huge primary button" onclick="showModal('modal-auth-form')">Get Started <i class="right arrow icon"></i></div>
            @endif
        </div>
    </div>
@endsection

@section('page-content')
    <div class="ui vertical stripe segment">
        <div class="ui middle aligned stackable grid container">
            <div class="row">
                <div class="eight wide column">
                    <h3 class="ui header">We will keep your secrets</h3>
                    <p>Our site stores all records in encrypted form, and no one else has access to them.</p>
                    <h3 class="ui header">This is completely free.</h3>
                    <p>Our service is absolutely free, and we will only earn revenue from native ads.</p>
                </div>
                <div class="six wide right floated column">
                    <img src="{{url('/assets/img/diary.jpg')}}" class="ui large bordered rounded image" alt="img">
                </div>
            </div>
            <div class="row">
                <div class="center aligned column">
                    <a class="ui huge button" href="{{url('/faq')}}" target="_blank">F.A.Q</a>
                </div>
            </div>
        </div>
    </div>
@endsection

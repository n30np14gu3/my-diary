<!DOCTYPE html>
<head lang="{{app()->getLocale()}}">
    <title>@yield('page-title')</title>
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1,width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{url('/semantic-ui/semantic.min.css')}}">
    <link rel="stylesheet" href="{{url('/css/main.css')}}">
    <script src="{{url('/js/jquery-3.5.0.min.js')}}"></script>
    <script>
        $(document)
            .ready(function() {
                $('.masthead')
                    .visibility({
                        once: false,
                        onBottomPassed: function() {
                            $('.fixed.menu').transition('fade in');
                        },
                        onBottomPassedReverse: function() {
                            $('.fixed.menu').transition('fade out');
                        }
                    });
                $('.ui.sidebar').sidebar('attach events', '.toc.item');

            });
    </script>
</head>
<body>
<div class="ui vertical inverted sidebar menu">
    <a class="@yield('welcome-active') item" href="/">Home</a>
    @if(@$logged)
        <a class="@yield('diary-active') item" href="{{url('/diary')}}">Diary</a>
        <a class="@yield('settings-active') item" href="{{url('/settings')}}">Settings</a>
    @endif
    <a class="@yield('faq-active') item" href="{{url('/faq')}}">F.A.Q</a>
    <a class="@yield('support-active') item" href="{{url('/support')}}">Support</a>
</div>

<div class="pusher">
    @yield('page-header')
    <div style="min-height: calc(100vh - 200px)">
        @yield('page-content')
    </div>
    <div class="ui inverted vertical footer segment">
        <div class="ui container">
            <div class="ui stackable inverted divided equal height stackable grid">
                <div class="three wide column">
                    <h4 class="ui inverted header">About</h4>
                    <div class="ui inverted link list">
                        <a href="https://t.me/shockbyte" class="item" target="_blank">Created by @shockbyte</a>
                    </div>
                </div>
                <div class="seven wide column">
                    <h4 class="ui inverted header">Private diary</h4>
                    <p>shockbyte © 2020</p>
                </div>
            </div>
        </div>
    </div>
    @if(!@$logged)
        @include('modules.modals.auth-modals')
    @else
        @include('modules.modals.note-compose')
    @endif
</div>
<script src="{{url('/js/popper.min.js')}}"></script>
<script src="{{url('/semantic-ui/semantic.min.js')}}"></script>
<script src="{{url('/js/controllers.js')}}"></script>
<script src="{{url('/js/actions.js')}}"></script>
<script src="{{url('/js/ajax.js')}}"></script>
</body>

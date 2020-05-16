<div class="ui fluid container">
    <div class="ui large @yield('inverted') secondary pointing menu">
        <a class="toc item">
            <i class="sidebar icon"></i>
        </a>
        <a class="@yield('welcome-active') item" href="/">Home</a>
        @if(@$logged)
            <a class="@yield('diary-active') item" href="{{url('/diary')}}">Diary</a>
            <a class="@yield('settings-active') item" href="{{url('/settings')}}">Settings</a>
        @endif
        <a class="@yield('faq-active') item" href="{{url('/faq')}}">F.A.Q</a>
        <a class="@yield('support-active') item" href="{{url('/support')}}">Support</a>
        <div class="right item">
            @if(@$logged)
                <a class="ui @yield('inverted') red button" href="{{url('/logout')}}">Logout</a>
            @else
                <a class="ui @yield('inverted') green button" style="margin-right: 5px" onclick="showModal('modal-auth-form')">Log in</a>
                <a class="ui @yield('inverted') primary button" onclick="showModal('modal-register-form')">Sign Up</a>
            @endif
        </div>
    </div>
</div>

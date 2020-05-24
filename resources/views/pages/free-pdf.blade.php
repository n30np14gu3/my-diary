<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
    <title>{{@$note->title}}</title>
    <style>
        body{
            font-family: 'Lato', 'Helvetica Neue', Arial, Helvetica, sans-serif;
        }
    </style>
</head>
<body>
<div style="text-align: center">
    <h1>FREE PARSE PDF! [DEV]</h1>
    <h2>{{@$note->title}}</h2>
    <h3 style="font-style: italic">{{@$user->login}}</h3>
    <h5>{{@$note->created_at}}</h5>
</div>
<div style="padding: 5px">
    @php
        include @$file_path;
    @endphp
</div>
</body>
</html>

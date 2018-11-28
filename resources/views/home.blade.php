@extends('layouts.app_chat')

@section('content')
<div id="app">
    <chat-app :user="{{auth()->user()}}"></chat-app>
</div>
@endsection

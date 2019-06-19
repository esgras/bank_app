@extends('bank')
@section('title', 'Bank')
@section('content')
    <h2>Bank app</h2>
    @auth
    <h3>Click <a href="{{ route('account') }}">here</a> to use a bank</h3>
    @else
        <h3><a href="{{ route('register') }}">Create account</a> and <a href="{{ route('login') }}">sign in</a> to use a bank.</h3>
    @endauth
@endsection
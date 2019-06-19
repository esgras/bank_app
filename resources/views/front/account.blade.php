@extends('bank')
@section('title', 'Account')
@section('content')
    <div id="app"></div>
@endsection
@section('javascript')
    <script>
        let cards = {!! $cards !!};
        let apiToken =  "{{ Auth::user()->api_token }}";
    </script>
    <script src="{{ asset('js/build.js') }}"></script>
    {{--<script src="http://localhost:8080/dist/build.js"></script>--}}
@endsection
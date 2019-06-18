@extends('bank')
@section('title', 'VUE')
@section('content')
    <div id="app" style="margin-top: 50px;"></div>
@endsection
@section('javascript')
    <script>
        let cards = {!! $cards !!};
    </script>
    {{--<script src="{{ asset('js/build.js') }}"></script>--}}
    <script src="http://localhost:8080/dist/build.js"></script>
@endsection
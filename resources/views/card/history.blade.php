@extends('bank')
@section('content')
    <div class="row">
        <div class="col-md-4 col-ml-auto">
            <h4>Card #{{ $card->number }} operations history</h4>
            @if ($card->operations())
            <table class="table">
                @foreach($card->operations()->getResults() as $operation)
                    <tr>
                        <td>{{ $operation->description }}</td>
                        <td>{{ $operation->created_at }}</td>
                    </tr>
                @endforeach
            </table>
            @endif



        </div>
    </div>
    @include('errors')
@endsection
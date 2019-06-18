@extends('bank')
@section('content')
    <div class="row">
        <div class="col-md-4 col-ml-auto">
            <h2>Transfer money from card to card</h2>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{ route('card_transfer_handle') }}" method="post">
                @csrf
                <div class="form-group">
                    <select name="source_card" id="" class="form-control">
                        @foreach ($cards as $card)
                            <option value="{{ $card->id }}">{{ $card->number }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('source_card'))
                        <b class="text-danger">{{ $errors->first('source_card') }}</b>
                    @endif
                </div>
                <div class="form-group ">
                    <input type="number" class="form-control" id="destination_card"  placeholder="Enter card number"
                           name="destination_card">
                    @if ($errors->has('destination_card'))
                        <b class="text-danger">{{ $errors->first('destination_card') }}</b>
                    @endif
                </div>
                <div class="form-group">
                    <input type="number" class="form-control" id="amount"
                           placeholder="Enter amount" step="0.01" min="0.01"
                           name="amount">
                    @if ($errors->has('amount'))
                        <b class="text-danger">{{ $errors->first('amount') }}</b>
                    @endif
                </div>
                <button>Submit</button>
            </form>
        </div>
    </div>
    {{--@include('errors')--}}
@endsection
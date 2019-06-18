@extends('bank')
@section('content')
    <div class="row">
        <div class="col-md-4 col-ml-auto">
            <h2>Add money to card</h2>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{ route('card_add_handle', ['id' => $card->id]) }}" method="post">
                @csrf
                <div class="form-group">
                    <input type="number" class="form-control" id="amount"  placeholder="Enter amount" step="0.01" min="0.01"
                    name="amount">
                </div>
                <button>Submit</button>
            </form>
        </div>
    </div>
    @include('errors')
@endsection
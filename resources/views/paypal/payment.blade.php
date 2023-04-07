@extends('layouts.app')

@section('content')
    <h1>Make a Payment</h1>

    <form action="{{ route('paypal.createPayment') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="amount">Amount:</label>
            <input type="number" name="amount" id="amount" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Pay with PayPal</button>
    </form>
@endsection

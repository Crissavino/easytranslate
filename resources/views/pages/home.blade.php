@extends('layouts.master')

@section('title', 'Easy Translate - TEST')

@section('content')
    <div class="container col-10 conversion-box">
        <form method="POST" action="{{route('convertCurrency')}}" class="pt-lg-5">
            @METHOD('POST')
            @csrf
            <div class="row">
                <div class="mx-auto my-3 col-12 col-lg-3 d-block">
                    <label for="amount">Amount</label>
                    <input type="number" step=any name="amount" class="form-control" placeholder="$" value="{{request()->old('amount')}}">
                </div>
                <div class="m-auto col-5 col-lg-3 d-block">
                    <label for="fromCurrency">Source</label>
                    <select name="source_currency" id="fromCurrency" class="form-control">
                        <option value="">Currency...</option>
                    </select>
                </div>
                <img class="m-auto exchange-arrow" src="{{asset('/img/transfer.png')}}" alt="exchange money symbol">
                <div class="m-auto col-5 col-lg-3 d-block">
                    <label for="toCurrency">Target</label>
                    <select name="target_currency" id="toCurrency" class="form-control">
                        <option value="">Currency...</option>
                    </select>
                </div>
                <div class="text-center mt-4">
                    <button type="submit" class="btn col-12 col-md-8 btn-primary">GO</button>
                </div>
            </div>
        </form>
    </div>

    @if(isset($success) && $success)
        <div class="container col-10 conversion-result">
            <h2 class="text-center pt-1">Exchange Result</h2>
            <div class="result text-center">{{$amount . ' ' . $source_currency . ' to ' . $target_currency . ' = ' . number_format($convertedAmount,4) . ' ' . $target_currency}}</div> <br>
            <div class="exchange">{{'1 ' . $source_currency . ' = ' . number_format($exchangeRate,5) . ' ' . $target_currency}}</div>
        </div>
    @endif
@endsection
@section('javascript')
    <script src="{{asset('/js/home.js')}}"></script>
@endsection

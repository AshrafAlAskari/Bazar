@extends('layouts.master')

@section('title')
Cart
@endsection

@section('content')
@include('includes.message-block')

@if(Session::has('cart'))
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="list-group">
            @foreach ($cart->items as $item)
            <li class="list-group-item">
                <span class="badge badge-pill badge-primary">{{$item['qty']}}</span>
                <strong>{{$item['item']['name']}}</strong>
                <div class="btn-group float-right">
                    &nbsp;<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"
                        name="button">Action <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="{{route('reduce_item', ['id' => $item['item']['id']])}}">Reduce by 1</a></li>
                        <li><a href="{{route('remove_item', ['id' => $item['item']['id']])}}">Reduce all</a></li>
                    </ul>
                </div>
                <span class="badge badge-success float-right">${{$item['item']['price']}}</span>&nbsp;
            </li>
            @endforeach
        </div>
        <br />
        <strong class="float-right">Total price: ${{$cart->totalPrice}}</strong>
        <br />
        <hr />
        <a href="{{ route('checkout') }}" type="button" class="btn btn-success float-right">Checkout</a>
    </div>
</div>
@else
<div class="row justify-content-center">
    <div class="col-lg-6">
        <br />
        <h2 class="text-center">No items in cart!</h2>
    </div>
</div>
@endif
@endsection
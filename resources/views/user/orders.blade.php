@extends('layouts.master')

@section('title')
Orders
@endsection

@section('content')
@include('includes.message-block')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <br />
        <h2>{{Auth::user()->first_name}} Orders</h2>
        <br />
        @foreach ($orders as $order)
        <div class="card">
            <div class="card-body">
                <ul class="list-group">
                    @foreach ($order->cart->items as $item)
                    <li class="list-group-item">
                        {{$item['item']['name']}} | {{$item['qty']}} units
                        <span class="badge badge-secondary badge-pill float-right">${{$item['price']}}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="card-footer text-muted">
                <span>{{$order->created_at}}</span>
                <strong class="float-right">${{$order->cart->totalPrice}}</strong>
            </div>
        </div>
        <br />
        @endforeach
    </div>
</div>
@endsection
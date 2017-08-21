@extends('layouts.master')

@section('title')
    Orders
@endsection

@section('content')
    @include('includes.message-block')
    @if(!$orders)
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <br />
                <h2>{{$orders->first()->user->first_name}} Orders</h2>
                <br />
                @foreach ($orders as $order)
                    <div class="card">
                        <div class="card-body">
                            <ul class="list-group">
                                @foreach ($order->cart->items as $item)
                                    <li class="list-group-item">
                                        {{$item['item']['name']}} | {{$item['qty']}} units
                                        <span class="badge badge-secondary badge-pill float-right">{{$item['price']}}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="card-footer text-muted">
                            <span>{{$order->created_at}}</span>
                            <strong class="float-right">{{$order->cart->totalPrice}}</strong>
                        </div>
                    </div>
                    <br />
                @endforeach
            </div>
        </div>
    @else
        <div class="row justify-content-center">
            <div class="row">
                <header><h3>The user didn't make any orders yet! <a href="{{route('admin_getUsers')}}">Go Back</a></h3></header>
            </div>
        </div>
    @endif
@endsection

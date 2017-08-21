@extends('layouts.master')

@section('title')
    Welcome to Bazar
@endsection

@section('content')
    @include('includes.message-block')
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="list-group">
                <div class="card-header">
                    <h5>Categories and latest items</h5>
                </div>
                @foreach ($categories as $category)
                    <a href="{{route('items',['category_id' => $category->id])}}" class="list-group-item list-group-item-action">{{$category->name}}</a>
                @endforeach
                <br />
            </div>
        </div>
        @foreach ($items as $item)
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card" style="width: 20rem;">
                    <img src="images/{{$item->image}}" alt"" class="card-img-top" />
                    <div class="card-body">
                        <h4 class="card-title">{{$item->name}}</h4>
                        <p class="card-text">{{$item->info}}</p>
                        <a href="{{route('add_to_cart', ['item_id' => $item->id])}}" class="btn-sm btn-primary float-right">Add to cart</a>
                        <p class="float-left">${{$item->price}}</p>
                    </div>
                </div>
                @if($loop->index >= 7)
                    @break
                @endif
            </div>
        @endforeach
    </div>
@endsection

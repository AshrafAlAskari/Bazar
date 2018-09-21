@extends('layouts.master')

@section('title')
@if(!$items->isEmpty())
{{$items->first->category->category->name}}
@endif
@endsection

@section('content')
@include('includes.message-block')
<div class="row">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link disabled">Categories</a>
        </li>
        @foreach ($categories as $category)
        <li class="nav-item">
            <a class="nav-link {{ $category->id == $category_id ? 'active' : ''}}" href="{{route('items', ['category_id' => $category->id])}}">{{
                $category->name }}</a>
        </li>
        @endforeach
    </ul>
</div>
<br>
@if($items->isNotEmpty())
<div class="row">
    <div class="col">
        <form action="{{route('items_filter_price', ['category_id' => $items->first()->category_id])}}" ) method="get">
            <div class="form-row">
                <div class="form-group">
                    <a href="{{route('items_sort_price', ['category_id' => $items->first()->category_id])}}" class="btn btn-primary">Sort
                        by price</a>
                </div>
                <div class="form-group col-lg-4">
                    <input type="text" class="form-control" name="min" placeholder="Min">
                </div>
                <div class="form-group col-lg-4">
                    <input type="text" class="form-control" name="max" placeholder="Max">
                </div>
                <div class="form-group col-lg-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">
    @foreach ($items as $item)
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card" style="width: 20rem;">
            <img src="{{ url('/') }}/images/{{$item->image}}" alt"" class="card-img-top" />
            <div class="card-body">
                <h4 class="card-title">{{$item->name}}</h4>
                <p class="card-text">{{$item->info}}</p>
                <a href="{{route('add_to_cart', ['item_id' => $item->id])}}" class="btn-sm btn-primary float-right">Add
                    to cart</a>
                <p class="float-left">${{$item->price}}</p>
            </div>
        </div>
        <br />
    </div>
    @endforeach
</div>
@else
<div class="row  justify-content-center">
    <br />
    <header>
        <h3>No items in this category yet!</h3>
    </header>
</div>
@endif
@endsection
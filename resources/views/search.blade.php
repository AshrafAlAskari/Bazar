@extends('layouts.master')

@section('title')
    Search
@endsection

@section('content')
    <br />
    @if(!$items->isEmpty())
        <header><h3>Search for {{$search}}</h3></header>
        <div class="row">
            @foreach ($items as $item)
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card" style="width: 20rem;">
                        <img src="{{ url('/') }}images/{{$item->image}}" alt"" class="card-img-top" />
                        <div class="card-body">
                            <h4 class="card-title">{{$item->name}}</h4>
                            <p class="card-text">{{$item->info}}</p>
                            <a href="#" class="btn-sm btn-primary float-right">Add to cart</a>
                            <p class="float-left">${{$item->price}}</p>
                        </div>
                    </div>
                    <br />
                </div>
            @endforeach
        </div>
    @else
        <div class="row  justify-content-center">
            <header><h3>No search results were found!</h3></header>
        </div>
    @endif
@endsection

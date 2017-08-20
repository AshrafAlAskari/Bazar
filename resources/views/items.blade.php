@extends('layouts.master')

@section('title')
    @if(!$items->isEmpty())
        {{$items->first->category->category->name}}
    @endif
@endsection

@section('content')
    @include('includes.message-block')
    @if(!$items->isEmpty())
        <header><h3>{{$items->first->category->category->name}}</h3></header>
        <div class="row">
            @foreach ($items as $item)
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card" style="width: 20rem;">
                        @if (Storage::disk('local')->has($item->image))
                            <img src="{{ route('image_item', ['filename' => $item->image]) }}" alt"" class="card-img-top" />
                        @endif
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
        @else
            <div class="row  justify-content-center">
                <br />
                <header><h3>No items in this category yet!</h3></header>
            </div>
        @endif
    </div>
@endsection

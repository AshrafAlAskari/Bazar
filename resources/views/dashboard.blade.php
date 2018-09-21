@extends('layouts.master')

@section('title')
Welcome to Bazar
@endsection

@section('content')
@include('includes.message-block')
<ul class="nav nav-tabs">
	<li class="nav-item">
		<a class="nav-link disabled">Categories</a>
	</li>
	@foreach ($categories as $category)
	<li class="nav-item">
		<a class="nav-link" href="{{route('items',['category_id' => $category->id])}}">{{$category->name}}</a>
	</li>
	@endforeach
</ul>
<br>
<div class="row">
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
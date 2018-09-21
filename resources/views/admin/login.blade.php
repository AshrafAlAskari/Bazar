@extends('layouts.master')

@section('title')
Welcome to Bazar
@endsection

@section('content')
<div class="container">
    @include('includes.message-block')
    <div class="row justify-content-lg-center">
        <div class="col col-lg-6">
            <br />
            <h3>Sign In</h3>
            <br />
            <form action="{{route('admin_login')}}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="email">E-Mail</label>
                    <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" name="email"
                        placeholder="E-mail" value="{{old('email')}}">
                    @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{$errors->first('email')}}
                    </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password"
                        placeholder="Password" value="">
                    @if($errors->has('password'))
                    <div class="invalid-feedback">
                        {{$errors->first('password')}}
                    </div>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
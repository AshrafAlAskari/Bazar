@extends('layouts.master')

@section('title')
Welcome to Bazar
@endsection

@section('content')
<div class="container">
    @include('includes.message-block')
    <div class="row justify-content-lg-center">
        <div class="col-lg-6">
            <br />
            <h3>Sign In</h3>
            <br />
            <form action="{{route('user_register')}}" method="POST">
                {{ csrf_field() }}
                <div class="row">
                    <div class="form-group col">
                        <label for="first_name">First Name</label>
                        <input class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}" type="text"
                            name="first_name" placeholder="First Name" value="{{old('first_name')}}">
                        @if($errors->has('first_name'))
                        <div class="invalid-feedback">
                            {{$errors->first('first_name')}}
                        </div>
                        @endif
                    </div>
                    <div class="form-group col">
                        <label for="last_name">Last Name</label>
                        <input class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}" type="text"
                            name="last_name" placeholder="Last Name" value="{{old('last_name')}}">
                        @if($errors->has('last_name'))
                        <div class="invalid-feedback">
                            {{$errors->first('last_name')}}
                        </div>
                        @endif
                    </div>
                </div>
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
                        placeholder="Password">
                    @if($errors->has('password'))
                    <div class="invalid-feedback">
                        {{$errors->first('password')}}
                    </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input class="form-control {{ $errors->has('confirm_password') ? 'is-invalid' : '' }}" type="password"
                        name="confirm_password" placeholder="Confirm Password">
                    @if($errors->has('confirm_password'))
                    <div class="invalid-feedback">
                        {{$errors->first('confirm_password')}}
                    </div>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
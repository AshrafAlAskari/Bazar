@extends('layouts.master')

@section('title')
    Admin Dashboard
@endsection

@section('content')
    <br />
    <div class="row justify-content-lg-center">
        <div class="col-lg-6 text-center">
            <a href="{{ route('admin_getCategories') }}"><button class="btn btn-primary btn-lg">Manage Categories</button></a>
        </div>
        <div class="col-lg-6 text-center">
            <a href="{{ route('admin_getItems') }}"><button class="btn btn-primary btn-lg">Manage Items</button></a>
        </div>
    </div>
    <hr />
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <section class="row">
                <header>
                    <h3>Users</h3>
                </header>
                <table class="table table-hover">
                    <thead class="thead-default">
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Created at</th>
                        <th>Orders</th>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td>{{$user->first_name}}</td>
                                <td>{{$user->last_name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->created_at}}</td>
                                <td><a href="{{route('admin_getOrders', ['user_id' => $user->id])}}">{{$user->first_name}} orders</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>
        </div>
    </div>
@endsection

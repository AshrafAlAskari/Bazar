@extends('layouts.master')
@section('title')
    Categories
@endsection
@section('content')
    @include('includes.message-block')
    <section class="row justify-content-center">
        <div class="col-lg-8">
            <br />
            <header><h4>Add new item</h4></header>
            <form action="{{route('admin_addItem')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="row">

                </div>
                <div class="form-group">
                    <select class="form-control {{$errors->has('category') ? 'is-invalid' : '' }}" name="category">
                        <option selected disabled hidden>Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                    @if($errors->has('category'))
                        <div class="invalid-feedback">
                            {{$errors->first('category')}}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <input class="form-control {{$errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" placeholder="Item name" value="{{old('name')}}" />
                    @if($errors->has('name'))
                        <div class="invalid-feedback">
                            {{$errors->first('name')}}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <textarea class="form-control {{$errors->has('info') ? 'is-invalid' : ''}}" name="info" rows="3" placeholder="Item information"></textarea>
                    @if($errors->has('info'))
                        <div class="invalid-feedback">
                            {{$errors->first('info')}}
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="form-group col">
                        <input class="form-control {{$errors->has('price') ? 'is-invalid' : ''}}" type="text" name="price" placeholder="Price" value="{{old('price')}}" />
                        @if($errors->has('price'))
                            <div class="invalid-feedback">
                                {{$errors->first('price')}}
                            </div>
                        @endif
                    </div>
                    <div class="form-group col">
                        <input type="file" name="image" class="form-control {{$errors->has('price') ? 'is-invalid' : ''}}">
                        <label for="image">Image (only .jpg)</label>
                        @if($errors->has('image'))
                            <div class="invalid-feedback">
                                {{$errors->first('image')}}
                            </div>
                        @endif
                    </div>
                </div>
                <button type="submit" class="btn btn-primary float-right">Add Item</button>
            </form>
        </div>
    </section>
    <hr /><br />
    <section class="row">
        <header><h4>Items</h4></header>
        <table class="table table-hover">
            <thead class="thead-default">
                <th>ID</th>
                <th>Name</th>
                <th>Info</th>
                <th>Price $</th>
                <th></th>
                <th></th>
            </thead>
                <tbody v-for="(item, index) in items">
                    <tr>
                        <td>@{{item.id}}</td>
                        <td>@{{item.name}}</td>
                        <td>@{{item.info}}</td>
                        <td>$ @{{item.price}}</td>
                        <td><a href="#" id="edit" data-toggle="modal" data-target="#editModal" v-on:click="edit_item(index)">Edit</a></td>
                        <td><a href="#" id="delete" v-on:click="delete_item(item.id)">Delete</a></td>
                    </tr>
                </tbody>
        </table>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="form-group col">
                                <input class="form-control" type="text" name="name" placeholder="Item name" v-model="item_name" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <textarea class="form-control" type="text" name="info" placeholder="Item info" v-model="item_info" /></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <input class="form-control" type="text" name="price" placeholder="Item price" v-model="item_price" />
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveModal">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
    var urlDelete = '{{ route('admin_deleteItem') }}';
    var urlEdit = '{{ route('admin_editItem') }}';
    </script>
    <script>
    var app = new Vue({
        el: '#app',
        data: {
            items: {!! $items !!},
            item_name: '',
            item_info: '',
            item_price: ''
        },
        methods:{
            edit_item: function(id) {
                console.log("method " + id);
                app.item_id = app.items[id].id;
                app.item_name = app.items[id].name;
                app.item_info = app.items[id].info;
                app.item_price = app.items[id].price;
                $('#saveModal').on('click', function () {
                    console.log("click " + app.item_id);
                    $.ajax({
                        method: 'GET',
                        url: urlEdit,
                        data: {
                            item_id : app.item_id,
                            item_name : app.item_name,
                            item_info : app.item_info,
                            item_price : app.item_price
                        }
                    })
                    .done(function (result) {
                        location.reload();
                    });
                });
            },
            delete_item: function(id) {
                $.ajax({
                    method: 'GET',
                    url: urlDelete,
                    data: {
                        item_id : id,
                    }
                })
                .done(function () {
                    location.reload();
                });
            }
        }
    });
    </script>
@endsection

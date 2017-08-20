@extends('layouts.master')
@section('title')
    Categories
@endsection
@section('content')
    @include('includes.message-block')
    <section class="row justify-content-center">
        <div class="col-lg-8">
            <br />
            <header><h4>Add new category</h4></header>
            <form action="{{ route('admin_addCategory') }}" method="post">
                {{csrf_field()}}
                <div class="row">
                    <div class="form-group col">
                        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" placeholder="Category name" value="{{old('name')}}" />
                        @if($errors->has('name'))
                            <div class="invalid-feedback">
                                {{$errors->first('name')}}
                            </div>
                        @endif
                    </div>
                    <div class="col text-center">
                        <button type="submit" class="btn btn-primary form-submit float-right">Add category</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <hr /><br />
    <section class="row">
        <header><h4>Categories</h4></header>
        <table class="table table-hover">
            <thead class="thead-default">
                <th>ID</th>
                <th>Name</th>
                <th></th>
                <th></th>
            </thead>
            <tbody v-for="(category, index) in categories">
                <tr>
                    <td>@{{category.id}}</td>
                    <td>@{{category.name}}</td>
                    <td><a href="#" id="edit" data-toggle="modal" data-target="#editModal" v-on:click="edit_category(index)">Edit</a></td>
                    <td><a href="#" id="delete" v-on:click="delete_category(category.id)">Delete</a></td>
                </tr>
            </tbody>
        </table>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="form-group col">
                                <input class="form-control" type="text" name="name" placeholder="Category name" v-model="category_name" />
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
    var urlDelete = '{{ route('admin_deleteCategory') }}';
    var urlEdit = '{{ route('admin_editCategory') }}';
    </script>
    <script>
    var app = new Vue({
        el: '#app',
        data: {
            categories: {!! $categories !!},
            category_name: '',
        },
        methods:{
            edit_category: function(id) {
                app.category_id = app.categories[id].id;
                app.category_name = app.categories[id].name;
                $('#saveModal').on('click', function () {
                    $.ajax({
                        method: 'GET',
                        url: urlEdit,
                        data: {
                            category_id : app.category_id,
                            category_name : app.category_name,
                        }
                    })
                    .done(function (result) {
                        location.reload();
                    });
                });
            },
            delete_category: function(id) {
                $.ajax({
                    method: 'GET',
                    url: urlDelete,
                    data: {
                        category_id : id,
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

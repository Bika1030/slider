@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if (session('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3>
                        Sub-Category
                        <a href="{{ url('admin/subcategory/create') }}"
                           class="btn btn-primary btn-sm text-white float-end">Add
                            SubCategory</a>
                    </h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Category Name</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($subcategories as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{$item->category->name}}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->slug }}</td>

                                <td>
                                    <a href="{{ url('admin/subcategory/edit/' . $item->id) }}"
                                       class="btn btn-success btn-sm">
                                        Edit
                                    </a>

                                    <a href="{{ url('admin/subcategory/delete/' . $item->id) }}"
                                       class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this?')">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{--                    <div>--}}
                    {{--                        {{ $categories->links() }}--}}
                    {{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>

@endsection

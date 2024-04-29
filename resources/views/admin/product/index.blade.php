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
                        Products
                        <a href="{{ url('admin/product/create') }}"
                           class="btn btn-primary btn-sm text-white float-end">
                            Add Product
                        </a>
                    </h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>SubCategory</th>
                            <th>Brand</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Sale</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Trending</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($products as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>
                                    <img src="{{ asset("$item->image") }}" height="70px" width="70px"
                                         alt="image">
                                </td>
                                <td>{{$item->subCategory->name}}</td>
                                <td>{{ $item->brand->name }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->slug }}</td>
                                <td>{{$item->sale_percent}}%</td>
                                <td>{{$item->price}}₮</td>
                                <td>{{$item->quantity}}</td>
                                <td>{{ $item->trending == '1' ? 'Private' : 'Public' }}</td>
                                <td>{{ $item->status == '1' ? 'Private' : 'Public' }}</td>
                                <td>{{$item->created_at}}</td>

                                <td>
                                    <a href="{{ url('admin/product/image/'.$item->id) }}"
                                       class="btn btn-info btn-sm" title="image">
                                        Images
                                    </a>

                                    <a href="{{ url('admin/product/edit/' . $item->id) }}"
                                       class="btn btn-success btn-sm">
                                        Edit
                                    </a>

                                    <a href="{{ url('admin/product/delete/' . $item->id) }}"
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

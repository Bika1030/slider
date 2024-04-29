@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if (session('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            <div class="card">
                <div class="card-header">
                    <form action="{{url('admin/product/image/'.$product->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-10">
                                <label>Зураг хавсаргана уу</label>
                                <div class="custom-file">
                                    <input name="image[]" multiple
                                           type="file"
                                           class="custom-file-input form-control"
                                           id="image" value="{{old('image')}}"/>
                                    @error('image')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-success mr-2">SAVE</button>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover" style="margin-top: 13px !important">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>File</th>
                            <th>Created Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($product->productImages as $key=>$item)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>
                                    <img src="{{ asset("$item->image") }}" style="width:80px; height:80px;" alt="image">
                                </td>
                                <td>{{ $item->created_at}}</td>

                                <td>
                                    <a href="{{ url('admin/product/image/delete/' . $item->id) }}"
                                       class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this?')">
                                        Delete
                                    </a>
                                </td>

                            </tr>
                        @empty
                            <td>No Data Available</td>
                        @endforelse
                        </tbody>
                    </table>
                    <!--end: Datatable-->
                </div>
            </div>
        </div>
    </div>

@endsection

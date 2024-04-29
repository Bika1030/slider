@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>
                        Add Product
                        <a href="{{ url('admin/product') }}"
                           class="btn btn-primary btn-sm text-white float-end">BACK</a>
                    </h3>
                </div>

                <div class="card-body">
                    <form action="{{ url('admin/product') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="form-group">
                                <label for="subcategory">SubCategory</label>
                                <select class="form-control" name="subcategory" id="subcategory"
                                        required>
                                    @foreach($subcategories as $subcategory)
                                        <option
                                            value="{{ $subcategory->id }}" {{ old('subcategory') == $subcategory->id ? 'selected' : '' }}>{{ $subcategory->name }} </option>
                                    @endforeach
                                </select>
                                @error('subcategory') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group">
                                <label for="brand">Brand</label>
                                <select class="form-control" name="brand" id="brand"
                                        required>
                                    @foreach($brands as $brand)
                                        <option
                                            value="{{ $brand->id }}" {{ old('brand') == $brand->id ? 'selected' : '' }}>{{ $brand->name }} </option>
                                    @endforeach
                                </select>
                                @error('brand') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="slug">Slug</label>
                                <input type="text" name="slug" class="form-control" value="{{ old('slug') }}">
                                @error('slug') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="price">Price</label>
                                <input type="number" name="price"
                                       class="form-control"
                                       value="{{ old('price') }}"
                                       min="0">
                                @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="sale">Sale Percent</label>
                                <input type="number" name="sale"
                                       class="form-control"
                                       value="{{ old('sale') }}"
                                       min="0" max="100">
                                @error('sale') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="quantity">Quantity</label>
                                <input type="number" name="quantity"
                                       class="form-control"
                                       value="{{ old('quantity') }}"
                                       min="1">
                                @error('quantity') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" class="form-control"
                                          rows="4">{{ old('description') }}</textarea>
                                @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="image">Image</label>
                                <input type="file" name="image" class="form-control">
                                @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <hr>

                            <div class="mb-3">
                                <label>Upload Product Images</label>
                                <input type="file" class="form-control" name="picture[]" multiple/>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="trending">Trending</label>
                                    <input type="checkbox" name="trending">
                                    (Checked = Private, Unchecked = Public)
                                    @error('trending') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <input type="checkbox" name="status">
                                    (Checked = Private, Unchecked = Public)
                                    @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>


                            <div class="col-md-12 mb-3">
                                <button type="submit" class="btn btn-primary float-end">Save</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

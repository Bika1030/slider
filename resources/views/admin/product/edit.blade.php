@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Edit Product
                            <a href="{{ url('admin/product') }}" class="btn btn-primary btn-sm text-white float-end">BACK</a>
                        </h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('admin/product/' . $product->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="sub_category_id">SubCategory</label>
                                    <select class="form-control" name="sub_category_id" id="sub_category_id" required>
                                        @foreach($subcategories as $subcategory)
                                            <option value="{{ $subcategory->id }}" {{ $product->sub_category_id == $subcategory->id ? 'selected' : '' }}>
                                                {{ $subcategory->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('sub_category_id') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="brand_id">Brand</label>
                                    <select class="form-control" name="brand_id" id="brand_id" required>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('brand_id') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="slug">Slug</label>
                                    <input type="text" name="slug" class="form-control" value="{{ old('slug', $product->slug) }}" required>
                                    @error('slug') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="price">Price</label>
                                    <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" min="0" required>
                                    @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="sale_percent">Sale Percent</label>
                                    <input type="number" name="sale_percent" class="form-control" value="{{ old('sale', $product->sale_percent) }}" min="0" max="100">
                                    @error('sale_percent') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" name="quantity" class="form-control" value="{{ old('quantity', $product->quantity) }}" min="1" required>
                                    @error('quantity') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description', $product->description) }}</textarea>
                                    @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="image">Image</label>
                                    <input type="file" name="image" class="form-control">
                                    <small>Current Image: <a href="{{ asset($product->image) }}" target="_blank">View Image</a></small>
                                    @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="trending">Trending</label>
                                    <input type="checkbox" name="trending" {{ $product->trending == '1' ? 'checked' : '' }} value="1">
                                    @error('trending') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="status">Status</label>
                                    <input type="checkbox" name="status" {{ $product->status == '1' ? 'checked' : '' }} value="1">
                                    @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary float-end">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

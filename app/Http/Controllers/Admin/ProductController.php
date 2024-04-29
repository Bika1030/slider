<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at','DESC')->get();
        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        $subcategories  = SubCategory::all();
        $brands = Brand::all();

        return view('admin.product.create', compact('subcategories','brands'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'subcategory' => 'required|exists:sub_categories,id',
            'brand' => 'required|exists:brands,id',
            'name' => 'required|string|max:255|unique:products',
            'slug' => 'required|string|max:255|unique:products',
            'price' => 'required|integer',
            'sale' => 'required|integer|min:0|max:100',
            'quantity' => 'required|integer|min:0',
            'description' => 'required|string',
            'image' => 'required|image',
            'status' => 'nullable',
            'trending' => 'nullable',
            'picture.*' => 'nullable|image',
        ]);

        if($request->hasFile('image')){
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('uploads/product/',$filename);
            $validatedData['image'] = 'uploads/product/'.$filename;
        }

        $validatedData['status'] = $request->status == true ? '1':'0';
        $validatedData['trending'] = $request->status == true ? '1':'0';

        $product = Product::create([
            'sub_category_id' => $validatedData['subcategory'],
            'brand_id' => $validatedData['brand'],
            'name' => $validatedData['name'],
            'slug' => $validatedData['slug'],
            'price' => $validatedData['price'],
            'sale_percent' => $validatedData['sale'],
            'quantity' => $validatedData['quantity'],
            'description' => $validatedData['description'],
            'image' => $validatedData['image'],
            'status' => $validatedData['status'],
            'trending' => $validatedData['trending']
        ]);


        if($request->hasFile('picture')){
            $uploadPath = 'uploads/product/picture/';

            $i = 1;
            foreach($request->file('picture') as $imageFile){
                $extension = $imageFile->getClientOriginalExtension();
                $filename = time().$i++.'.'.$extension;
                $imageFile->move($uploadPath,$filename);
                $finalImagePathName = $uploadPath.$filename;

                $product->productImages()->create([
                    'product_id' => $product->id,
                    'image' => $finalImagePathName
                ]);
            }
        }

        return redirect('admin/product')->with('message', 'Product Added Successfully!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $subcategories = SubCategory::all();
        $brands = Brand::all();
        return view('admin.product.edit', compact('product','subcategories','brands'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validatedData = $request->validate([
            'sub_category_id' => 'required|exists:sub_categories,id',
            'brand_id' => 'required|exists:brands,id',
            'name' => 'required|string|max:255|unique:products,name,' . $id,
            'slug' => 'required|string|max:255|unique:products,slug,' . $id,
            'price' => 'required|integer',
            'sale_percent' => 'required|integer|min:0|max:100',
            'quantity' => 'required|integer|min:0',
            'description' => 'required|string',
            'image' => 'sometimes|image',
        ]);

        if ($request->hasFile('image')) {

            if(File::exists($product->image)) {
                File::delete($product->image);
            }
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('uploads/product/', $filename);
            $validatedData['image'] = 'uploads/product/' . $filename;
        }

        $validatedData['status'] = $request->status == true ? '1' : '0';
        $validatedData['trending'] = $request->trending == true ? '1' : '0';

        $product->update($validatedData);

        return redirect('admin/product')->with('message', 'Product Updated Successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if($product){
            $destination = $product->image;
            if(File::exists($destination))
            {
                File::delete($destination);
            }

            $product->delete();
            return redirect('admin/product')->with('message', 'Product Deleted Successfully!');
        }
        return redirect('admin/product')->with('message', 'Something went wrong!');
    }


    public function showImage($id)
    {
        $product = Product::findOrFail($id);

        return view('admin.product.image', compact('product'));
    }

    public function postImage(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if($request->hasFile('image')){
            $uploadPath = 'uploads/product/picture/';

            $i = 1;
            foreach($request->file('image') as $file){
                $extension = $file->getClientOriginalExtension();
                $filename = time().$i++.'.'.$extension;
                $file->move($uploadPath,$filename);
                $finalPathName = $uploadPath.$filename;

                $product->productImages()->create([
                    'product_id' => $product->id,
                    'image' => $finalPathName
                ]);
            }
        }
        return redirect()->back()->with('message','Data амжилттай хуулагдлаа');
    }

    public function removeImage($id)
    {
        $productImage = ProductImage::findOrFail($id);

        if(File::exists($productImage->file)){
            File::delete($productImage->file);
        }
        $productImage->delete();
        return redirect()->back()->with('message','Data амжилттай устлаа');

    }



}

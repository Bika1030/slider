<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::all();
        return view('admin.brand.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brand.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:brands',
            'slug' => 'required|string|max:255|unique:brands',
            'status' => 'nullable',
            'image' => 'required|image|mimes:jpg,png',
        ]);

        if($request->hasFile('image')){
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('uploads/brand/',$filename);
            $validatedData['image'] = 'uploads/brand/'.$filename;
        }

        $validatedData['status'] = $request->status == true ? '1':'0';

        Brand::create([
            'name' => $validatedData['name'],
            'slug' => $validatedData['slug'],
            'image' => $validatedData['image'],
            'status' => $validatedData['status']
        ]);

        return redirect('admin/brand')->with('message', 'Brand Added Successfully!');
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brand.edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,' . $brand->id,
            'slug' => 'required|string|max:255|unique:brands,slug,' . $brand->id,
            'status' => 'nullable',
            'image' => 'sometimes|image|mimes:jpg,png',
        ]);

        if($request->hasFile('image')){

            if(File::exists($brand->image)) {
                File::delete($brand->image);
            }
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('uploads/brand/', $filename);
            $validatedData['image'] = 'uploads/brand/' . $filename;
        }

        $validatedData['status'] = $request->status == true ? '1':'0';

        $brand->update($validatedData);

        return redirect('admin/brand')->with('message', 'Brand Updated Successfully!');
    }


    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);

        if($brand){
            $destination = $brand->image;
            if(File::exists($destination))
            {
                File::delete($destination);
            }

            $brand->delete();
            return redirect('admin/brand')->with('message', 'Brand Deleted Successfully!');
        }
        return redirect('admin/brand')->with('message', 'Something went wrong!');
    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
//        dd($request->all());
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'slug' => 'required|string|max:255|unique:categories',
            'status' => 'nullable',
            'image' => 'required|image|mimes:jpg,png',
        ]);

        if($request->hasFile('image')){
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('uploads/category/',$filename);
            $validatedData['image'] = 'uploads/category/'.$filename;
        }

        $validatedData['status'] = $request->status == true ? '1':'0';

        Category::create([
            'name' => $validatedData['name'],
            'slug' => $validatedData['slug'],
            'image' => $validatedData['image'],
            'status' => $validatedData['status']
        ]);

        return redirect('admin/category')->with('message', 'Category Added Successfully!');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'slug' => 'required|string|max:255|unique:categories,slug,' . $category->id,
            'status' => 'nullable',
            'image' => 'sometimes|image|mimes:jpg,png',
        ]);

        if($request->hasFile('image')){

            if(File::exists($category->image)) {
                File::delete($category->image);
            }
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('uploads/category/', $filename);
            $validatedData['image'] = 'uploads/category/' . $filename;
        }

        $validatedData['status'] = $request->status == true ? '1':'0';

        $category->update($validatedData);

        return redirect('admin/category')->with('message', 'Category Updated Successfully!');
    }


    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if($category){
            $destination = $category->image;
            if(File::exists($destination))
            {
                File::delete($destination);
            }

            $category->delete();
            return redirect('admin/category')->with('message', 'Category Deleted Successfully!');
        }
        return redirect('admin/category')->with('message', 'Something went wrong!');
    }





}

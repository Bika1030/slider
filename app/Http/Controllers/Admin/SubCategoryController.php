<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use function MongoDB\Driver\Monitoring\removeSubscriber;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subcategories = SubCategory::all();
        return view('admin.subcategory.index', compact('subcategories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.subcategory.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
           'category' => 'required|exists:categories,id',
            'name' => 'required|unique:sub_categories|string|max:200'
        ]);

        SubCategory::create([
            'category_id' => $validatedData['category'],
            'slug' => $validatedData['name'],
            'name' => $validatedData['name'],
        ]);

        return redirect('admin/subcategory')->with('message', 'SubCategory Added Successfully!');
    }

    public function edit($id)
    {
        $categories = Category::all();
        $subcategory = SubCategory::findOrFail($id);
        return view('admin.subcategory.edit', compact('categories', 'subcategory'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'category' => 'required|exists:categories,id',
            'name' => 'required|string|max:200|unique:sub_categories,name,' . $id
        ]);

        $subcategory = SubCategory::findOrFail($id);
        $subcategory->update([
            'category_id' => $validatedData['category'],
            'name' => $validatedData['name'],
            'slug' => $validatedData['name'],
        ]);

        return redirect('admin/subcategory')->with('message', 'SubCategory Updated Successfully!');
    }

    public function destroy($id)
    {
        $subcategory = SubCategory::findOrFail($id);
        if ($subcategory)
        {
            $subcategory->delete();
            return redirect('admin/subcategory')->with('message', 'SubCategory Deleted Successfully!');
        }
        else
        {
            return redirect('admin/subcategory')->with('message', 'Something Went Wrong!');
        }
    }

}

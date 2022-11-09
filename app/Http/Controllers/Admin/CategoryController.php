<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\Admin\CategoryFormRequest;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categroy =Category::all();
        return view('admin.category.index')->with('category', $categroy);
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(CategoryFormRequest $request)
    {
        $data = $request->validated();

        $categroy = new Category;
        $categroy->name = $data['name'];
        $categroy->slug = Str::slug($data['slug']);
        $categroy->description = $data['description'];
        if($request->hasFile('image'))
        {
            $file = $request->file('image');
            $filename = time() . '.' .$file->getClientOriginalExtension();

            $file->move('uploads/category/', $filename);
            $categroy->image = $filename;
        }
        $categroy->meta_title = $data['meta_title'];
        $categroy->meta_description = $data['meta_description'];
        $categroy->meta_keyword = $data['meta_keyword'];
        $categroy->navbar_status = $request->navbar_status == true ? '1':'0';
        $categroy->status = $request->status == true ? '1':'0';
        $categroy->created_by = Auth::user()->id;

        $categroy->save();

        return redirect('admin/category')->with('message', 'Category Added Successfully');
    }

    public function edit($category_id)
    {
        $categroy = Category::find($category_id);
        return view('admin.category.edit')->with('category', $categroy);
    }

    public function update(CategoryFormRequest $request, $category_id)
    {
        $data = $request->validated();

        $categroy = Category::find($category_id);
        $categroy->name = $data['name'];
        $categroy->slug = Str::slug($data['slug']);
        $categroy->description = $data['description'];
        if($request->hasFile('image'))
        {

            $destination = 'uploads/category/'. $categroy->image;

            if(File::exists($destination))
            {
                File::delete($destination);
            }

            $file = $request->file('image');
            $filename = time() . '.' .$file->getClientOriginalExtension();

            $file->move('uploads/category/', $filename);
            $categroy->image = $filename;
        }
        $categroy->meta_title = $data['meta_title'];
        $categroy->meta_description = $data['meta_description'];
        $categroy->meta_keyword = $data['meta_keyword'];
        $categroy->navbar_status = $request->navbar_status == true ? '1':'0';
        $categroy->status = $request->status == true ? '1':'0';
        $categroy->created_by = Auth::user()->id;

        $categroy->update();

        return redirect('admin/category')->with('message', 'Category Updated Successfully');
    }

    public function destroy(Request $request)
    {
        $category = Category::find($request->category_delete_id);

        if ($category) {

            $destination = 'uploads/category/'. $category->image;

            if(File::exists($destination))
            {
                File::delete($destination);
            }
            $category->posts()->delete();
            $category->delete();

            return redirect('admin/category')->with('message', 'Category Deleted With Its Posts Successfully');
        }
        else
        {
            return redirect('admin/category')->with('message', 'No Category Id Found');
        }
    }
}

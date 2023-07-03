<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::all();
        return view('admin.category.index',compact('category'));
    }
    public function create()
    {
        // Return the view for creating a new interest
        return view('admin.category.create');
    }
    public function store(Request $request)
    {
        // Validate and store the submitted interest data
        $validation = Validator::make($request->all(), Category::$rules);

        if ($validation->fails()) {
            return response($validation->errors()->first() , 419);
        }
        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-')
        ];

        if ($request->hasFile('icon')) {
            $image = $request->file('icon');
            $imageName = time() . '.' . $image->extension();
            $image->storeAs('public/CategoryImages', $imageName);
            $data['icon'] = $imageName;
        }
        Category::create($data);
        return response()->json(['success'=>'Category added Success Fully.']);
    }
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit',compact('category'));

    }
    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), Category::$rules);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }

        $category = Category::findOrFail($id);
        $category->name = $request->name;
        if ($request->hasFile('icon')) {
            $image = $request->file('icon');
            $imageName = time().'.'.$image->extension();
            $image->storeAs('public/CategoryImages', $imageName);
            $category->icon = $imageName;
        }
        $category->save();
        return response()->json(['success'=>'Category Updated Success Fully.']);
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('category.index');
        // Perform any additional logic or delete the interest record
    }
    public function changeStatus(Request $request)
    {
        $category = Category::find($request->category_id);
        $category->status = $request->status;
        $category->save();

        return response()->json(['success'=>'Status change successfully.']);
    }
}

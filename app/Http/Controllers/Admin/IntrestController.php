<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Intrest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class IntrestController extends Controller
{
    public function index()
    {
        $intrest = Intrest::all();
        return view('admin.intrest.index',compact('intrest'));
    }
    public function create()
    {
        $categories = Category::all();
        return view('admin.intrest.create',compact('categories'));
    }
    public function store(Request $request)
    {
        // Validate the submitted interest data
        $validation = Validator::make($request->all(), Intrest::$rules);

        if ($validation->fails()) {
            return response($validation->errors()->first(), 419);
        }

        $data = [

            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-')
        ];

        if ($request->hasFile('icon')) {
            $image = $request->file('icon');
            $imageName = time() . '.' . $image->extension();
            $image->storeAs('public/interestImages', $imageName);
            $data['icon'] = $imageName;
        }

        Intrest::create($data);

        return response()->json(['success' => 'Skill added Successfully.']);
    }
    public function edit($id)
    {
        $intrest = Intrest::findOrFail($id);
        $categories = Category::all();
        return view('admin.intrest.edit',compact('intrest','categories'));

    }
    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), Intrest::$rules);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        $intrest = Intrest::findOrFail($id);
//        $intrest->icon = $request->icon;
        $intrest->category_id = $request->category_id;
        $intrest->name = $request->name;
        if ($request->hasFile('icon')) {
            $image = $request->file('icon');
            $imageName = time().'.'.$image->extension();
            $image->storeAs('public/interestImages', $imageName);
            $intrest->icon = $imageName;
        }
        $intrest->save();
        return response()->json(['success'=>'Skill Updated Success Fully.']);
    }

    public function delete($id)
    {
        $intrest = Intrest::findOrFail($id);
        $intrest->delete();
        return redirect()->route('skill.index');
        // Perform any additional logic or delete the interest record
    }
    public function changeStatus(Request $request)
    {
        $intrest = Intrest::find($request->skill_id);
        $intrest->status = $request->status;
        $intrest->save();

        return response()->json(['success'=>'Status change successfully.']);
    }
}

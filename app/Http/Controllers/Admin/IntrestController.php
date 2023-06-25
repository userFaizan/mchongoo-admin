<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Intrest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class IntrestController extends Controller
{
    public function index()
    {
        $intrest = Intrest::all();
        return view('admin.intrest.index',compact('intrest'));
    }
    public function create()
    {
        // Return the view for creating a new interest
        return view('admin.intrest.create');
    }
    public function store(Request $request)
    {
        // Validate and store the submitted interest data
        $validation = Validator::make($request->all(), Intrest::$rules);

        if ($validation->fails()) {
            return response($validation->errors()->first() , 419);
        }
        Intrest::create([
//            'icon' => $request->icon,
            'name' => $request->name,
            'slug' =>Str::slug($request->name, '-'),

        ]);
        return response()->json(['success'=>'Skill added Success Fully.']);
    }
    public function edit($id)
    {
        $intrest = Intrest::findOrFail($id);
        return view('admin.intrest.edit',compact('intrest'));

    }
    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), Intrest::$rules);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        $intrest = Intrest::findOrFail($id);
//        $intrest->icon = $request->icon;
        $intrest->name = $request->name;
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

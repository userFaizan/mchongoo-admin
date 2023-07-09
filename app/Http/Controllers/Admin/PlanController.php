<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlanController extends Controller
{
    //
    public function index()
    {
        $plans = Plan::with('service')->get();
        return view('admin.plans.index',compact('plans'));
    }
    public function create()
    {
        $services = Service::all();
        return view('admin.plans.create',compact('services'));

    }
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), Plan::$rules);

        if ($validation->fails()) {
            return response($validation->errors()->first(), 419);
        }
        Plan::create([
            'service_id'=> $request->service_id,
            'plan_amount'=> $request->plan_amount,
            'plan_duration'=> $request->plan_duration,
        ]);
        return response()->json(['success'=>'Plan added Success Fully.']);
    }
    public function edit($id)
    {
        $services = Service::all();
        $plan =Plan::findOrFail($id);
        return view('admin.plans.edit',compact('plan','services'));

    }
    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), Plan::$rules);

        if ($validation->fails()) {
            return response($validation->errors()->first(), 419);
        }
        Plan::where('id',$id)
            ->update([
                'service_id'=> $request->service_id,
                'plan_amount'=> $request->plan_amount,
                'plan_duration'=> $request->plan_duration,
            ]);
        return response()->json(['success'=>'Plan Updated Success Fully.']);
    }
    public function delete($id)
    {
        $plans = Plan::findOrFail($id);
        $plans->delete();
        return redirect()->route('plans.index');
        // Perform any additional logic or delete the interest record
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use App\Models\ServiceImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    public function index()
    {

        $services = Service::with('user','category','servicesImages')->get();
        return view('admin.services.index',compact('services'));
    }
    public function create()
    {
        $users = User::all();
        $categories = Category::all();
        $services = Service::all();
        return view('admin.services.create',compact('users','services','categories'));
    }
    public function store(Request $request)
    {
        // Validate and store the submitted interest data
        $validation = Validator::make($request->all(), Service::$rules);

        if ($validation->fails()) {
            return response($validation->errors()->first(), 419);
        }

        $services = Service::create([
            'user_id' => $request->user_id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'gender' => $request->gender,
            'experience' => $request->experience,
            'service_type' => $request->service_type,
            'address' => $request->address,
            'service_price' => $request->service_price,
            'rating' => $request->rating,
            'lat' => $request->lat,
            'long'=>$request->long
        ]);
        if ($request->hasFile('images')) {
            $imagePaths = [];

            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('public/ServiceImages', $imageName);

                // Store the image path in the array
                $imagePaths[] = 'ServiceImages/' . $imageName;
            }
            // Convert the array to a JSON string
            $imagePathsJson = json_encode($imagePaths);
            // Create a service image record and associate it with the service
            $serviceImage = new ServiceImage([
                'images' => $imagePathsJson,
            ]);
            $services->servicesImages()->save($serviceImage);
        }

        return response()->json(['success'=>'Services added Success Fully.']);

    }
    public function edit($id)
    {
        $users = User::all();
        $categories = Category::all();
        $service = Service::findOrFail($id);
        return view('admin.services.edit',compact('users','service','categories'));


    }
    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), Service::$rules);

        if ($validation->fails()) {
            return response($validation->errors()->first(), 419);
        }

        $service = Service::find($id);

        $service->user_id = $request->user_id;
        $service->category_id = $request->category_id;
        $service->name = $request->name;
        $service->gender = $request->gender;
        $service->experience = $request->experience;
        $service->service_type = $request->service_type;
        $service->address = $request->address;
        $service->service_price = $request->service_price;
        $service->rating = $request->rating;
        $service->lat = $request->lat;
        $service->long = $request->long;

        $service->save();

        if ($request->hasFile('images')) {
            $service->servicesImages()->delete();

            $imagePaths = [];

            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('public/ServiceImages', $imageName);

                // Store the image path in the array
                $imagePaths[] = 'ServiceImages/' . $imageName;
            }
            // Convert the array to a JSON string
            $imagePathsJson = json_encode($imagePaths);
            // Create a service image record and associate it with the service
            $serviceImage = new ServiceImage([
                'images' => $imagePathsJson,
            ]);
            $service->servicesImages()->save($serviceImage);
        }

        return response()->json(['success'=>'Services Updated Successfully.']);
    }

    public function delete($id)
    {
        $services = Service::findOrFail($id);
        $services->servicesImages()->delete();
        $services->delete();
        return redirect()->route('services.index');
        // Perform any additional logic or delete the interest record
    }
}

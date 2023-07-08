@extends('layouts.master')
@section('content')
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Mchongoo</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="zmdi zmdi-home"></i>
                                Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Service</a></li>
                        <li class="breadcrumb-item active">All Services</li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i
                                class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i
                                class="zmdi zmdi-arrow-right"></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Edit</strong> Services</h2>
                    </div>
                    <div class="body">
                        <form id="ajax-request" method="post" action="{{route('services.update',$service->id)}}"
                              enctype="multipart/form-data" class="" data-redirect-url="{{ route('services.index') }}">
                            @csrf

                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                    <label for="name">Name</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8">
                                    <div class="form-group">
                                        <input type="text" id="name" name="name" class="form-control"
                                               value="{{$service->name}}" placeholder="Enter your Service name">
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                    <label for="name">Gender</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8">
                                    <div class="form-group">
                                        <input type="text" id="gender" name="gender" class="form-control"
                                               value="{{$service->gender}}" placeholder="Enter your Gender">
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                    <label for="name">Work Experience</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8">
                                    <div class="form-group">
                                        <input type="text" id="experience" name="experience" class="form-control"
                                               value="{{$service->experience}}" placeholder="Enter your Experience">
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                    <label for="service_type">Service Type</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8">
                                    <div class="form-group">
                                        <input type="text" id="service_type" name="service_type" class="form-control"
                                               value="{{$service->service_type}}"
                                               placeholder="Enter your Service Type ">

                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                    <label for="address">Address</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8">
                                    <div class="form-group">
                                        <input type="text" id="address" name="address" class="form-control"
                                               value="{{$service->address}}" placeholder="Enter your Address ">

                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                    <label for="service_price">Service Price</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8">
                                    <div class="form-group">
                                        <input type="text" id="service_price" name="service_price" class="form-control"
                                               value="{{$service->service_price}}"
                                               placeholder="Enter your Service Price ">

                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                    <label for="service_type">Rating</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8">
                                    <div class="form-group">
                                        <input type="number" id="rating" name="rating" class="form-control"
                                               value="{{$service->rating}}" placeholder="Enter your Rating ">

                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                    <label for="lat">Latitude </label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8">
                                    <div class="form-group">
                                        <input type="text" id="lat" name="lat" class="form-control"
                                               value="{{$service->lat}}" placeholder="Enter your Latitude ">

                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                    <label for="lat">Longitude </label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8">
                                    <div class="form-group">
                                        <input type="text" id="long" name="long" class="form-control"
                                               value="{{$service->long}}" placeholder="Enter your Longitude ">

                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                    <label for="icon">Images</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8">
                                    <div class="form-group">
                                        <input type="file" name="images[]" id="inputImage" multiple
                                               class="form-control @error('images') is-invalid @enderror">

                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                    <label for="name">Select User</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <select name="user_id" id="user_id" class="form-control show-tick ms "
                                                    aria-describedby="category" required>
                                                <option value="" selected>Select Users</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}" {{ $user->id === $service->user_id ? 'selected' : '' }}>{{ $user->first_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                    <label for="name">Select Category</label>
                                </div>
                                <div class="col-10">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <select name="category_id" id="category_id"
                                                    class="form-control show-tick ms " aria-describedby="category"
                                                    required>
                                                <option value="" selected>Select Category</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ $category->id === $service->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-sm-8 offset-sm-2">
                                        {{-- <div class="checkbox">
                                            <input id="remember_me_2" type="checkbox">
                                            <label for="remember_me_2">
                                                    Remember Me
                                            </label>
                                        </div> --}}
                                    </div>
                                    <div class="col-sm-8 offset-sm-2">
                                        <button type="submit" class="btn btn-primary btn-round ">submit</button>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
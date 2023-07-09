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
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>All</strong> Categories </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable"
                                   id="myTable">
                                <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Category</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Experience</th>
                                    <th>Service Type</th>
                                    <th>City</th>
                                    <th>Address</th>
                                    <th>Service Price</th>
                                    <th>Rating</th>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                    <th>Images</th>
                                    <th>Is Recommended</th>
                                    <th>Is Trending</th>
                                    <th>Action</th>

                                </tr>
                                </thead>

                                <tbody>
                                @foreach($services as $item)

                                    <tr>
                                        <td>{{$item->user->first_name. $item->user->last_name}}</td>
                                        <td>{{$item->category->name}}</td>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->gender}}</td>
                                        <td>{{$item->experience}}</td>
                                        <td>{{$item->service_type}}</td>
                                        <td>{{$item->city}}</td>
                                        <td>{{$item->address}}</td>
                                        <td>{{$item->service_price}}</td>
                                        <td>{{$item->rating}}</td>
                                        <td>{{$item->lat}}</td>
                                        <td>{{$item->long}}</td>
                                        @foreach($item->servicesImages as $image)
                                            <td>
                                                @if(isset($image->images))
                                                    @foreach(json_decode($image->images) as $path)
                                                        <a href="{{ asset('storage/' . $path) }}"
                                                           target="_blank">View</a>
                                                    @endforeach
                                                @else
                                                    No Image Uploaded Yet
                                                @endif
                                            </td>
                                        @endforeach
                                        <td>
                                            <label class="switch">
                                                <input type="checkbox" class="toggle-class-3" data-id="{{ $item->id }}" {{ $item->recommended ? 'checked' : '' }}>
                                                <span class="slider round"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="switch">
                                                <input type="checkbox" class="toggle-class-4" data-id="{{ $item->id }}" {{ $item->trending ? 'checked' : '' }}>
                                                <span class="slider round"></span>
                                            </label>
                                        </td>

                                        <td>
                                            <a class="btn btn-primary" href="{{ route('services.edit',$item->id) }}">Edit</a>
                                            <a class="btn btn-danger" href="{{ route('services.delete',$item->id) }}">Delete</a>

                                        </td>

                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
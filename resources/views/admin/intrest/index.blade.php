@extends('layouts.master')
@section('content')
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Mchongoo</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Skills</a></li>
                        <li class="breadcrumb-item active">All Skills</li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
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
                        <h2><strong>All</strong> Skills </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="myTable">
                                <thead>
                                <tr>
                                    <th>Category Name</th>
                                    <th>Name</th>
                                    <th>slug</th>
                                    <th>Icon</th>
                                    <th>Status</th>
                                    <th>Action</th>

                                </tr>
                                </thead>

                                <tbody>
                                @foreach($intrest as $item)

                                    <tr>
                                        <td>{{$item->category->name }}</td>
                                        <td>{{$item->name }}</td>
                                        <td>{{$item->slug}}</td>
                                        <td>  <img src=" {{ asset('storage/interestImages/'. $item->icon) }}" alt="Interest Icon" width="50" height="50"></td>

                                        <td>
                                            <label class="switch">
                                                <input type="checkbox" class="toggle-class-1" data-id="{{ $item->id }}" {{ $item->status ? 'checked' : '' }}>
                                                <span class="slider round"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <a class="btn btn-primary" href="{{ route('skill.edit',$item->id) }}">Edit</a>
                                            <a class="btn btn-danger" href="{{ route('skill.delete',$item->id) }}">Delete</a>

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
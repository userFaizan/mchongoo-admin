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
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Add</strong> Skills</h2>
                    </div>
                    <div class="body">
                        <form id="ajax-request" method="post" action="{{route('skill.store')}}" enctype="multipart/form-data" class="" data-redirect-url="{{ route('skill.index') }}">
                            @csrf
                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                    <label for="name">Name</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8">
                                    <div class="form-group">
                                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter your skill name">
                                        @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
{{--                            <div class="row clearfix">--}}
{{--                                <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">--}}
{{--                                    <label for="icon">Icon</label>--}}
{{--                                </div>--}}
{{--                                <div class="col-lg-10 col-md-10 col-sm-8">--}}
{{--                                    <div class="form-group">--}}
{{--                                        <input type="file" id="icon" name="icon" class="form-control" placeholder="Enter your skill icon">--}}
{{--                                        @error('icon')--}}
{{--                                        <span class="text-danger">{{ $message }}</span>--}}
{{--                                        @enderror--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="row clearfix">
                                <div class="col-sm-8 offset-sm-2">
{{--                                    <button type="submit" class="btn btn-primary">Submit</button>--}}
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
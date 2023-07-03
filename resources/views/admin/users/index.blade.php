@extends('layouts.master')
@section('content')
<div class="body_scroll">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Mchongoo</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Users</a></li>
                    <li class="breadcrumb-item active">All Users</li>
                </ul>
                <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>All</strong> Users </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="myTable">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>email</th>
                                    <th>Phone no</th>
                                    <th>User Type</th>
                                    <th>User Logo</th>
                                    <th>User Business Registration</th>
                                    <th>User Business License</th>
                                    <th>Account Usage</th>
                                    <th>Account Status</th>

                                </tr>
                                </thead>

                                <tbody>
                                @foreach($users as $user)

                                <tr>
                                    <td>{{$user->first_name .$user->last_name}}</td>
                                    <td>{{$user->username}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->phone_no}}</td>
                                    <td>{{$user->user_type}}</td>
                                    <td>
                                        @foreach($user->userKyc as $doc)
                                            @if($doc->logo)
                                                <a href="{{ asset('storage/userkyc/' . $doc->logo) }}" target="_blank">View</a>
                                            @else
                                                No Logo
                                            @endif
                                        @endforeach

                                    </td>
                                    <td>
                                        @foreach($user->userKyc as $doc)

                                        @if($doc->business_registration)
                                            <a href="{{ asset('storage/userkyc/' . $doc->business_registration) }}" target="_blank">View</a>
                                        @else
                                            No Business Registration
                                        @endif
                                        @endforeach

                                    </td>
                                    <td>
                                        @foreach($user->userKyc as $doc)

                                        @if($doc->business_license)
                                            <a href="{{ asset('storage/userkyc/' . $doc->business_license) }}" target="_blank">View</a>
                                        @else
                                            No Business license
                                        @endif
                                        @endforeach

                                    </td>

                                    <td>{{$user->account_usage}}</td>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" class="toggle-class" data-id="{{ $user->id }}" {{ $user->account_status ? 'checked' : '' }}>
                                            <span class="slider round"></span>
                                        </label>
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
</div>


@endsection
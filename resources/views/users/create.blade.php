@extends('layouts.dashboard')
@section('title')
@if($isUpdate)
{{ $isUpdate }} User
@else
New User
@endif
@endsection
@section('content')

@php
$department = $isUpdate ? substr($users->role,0,-1) : '';
$admin = $isUpdate ? substr($users->role,-1) : '2';
$active = $isUpdate ? $users->active : '1';
@endphp

{{-- @if (count($errors) > 0)
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
        </button>
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif --}}

<div class="card">
    <form method="POST">
        @csrf
        <div class="card-body">
            <div class="row">
                {{-- Username --}}

                <div class="form-group col-md-12">
                    <strong>
                        {{ $isUpdate ? 'UserID:'. $users->userID : '' }}
                        <input type="hidden" name="userID" value="{{ $isUpdate ? $users->userID : '' }}">

                    </strong>
                </div>

                <div class="form-group col-md-6">
                    <label for="username" class="form-control-label">Username</label>
                    <div class="input-group input-group-merge ">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-user"></i>
                            </span>
                        </div>
                        <input class="form-control" placeholder="Enter Username" name="username" id="username"
                            value="{{ $isUpdate ? $users->userName : old('username') }}">
                    </div>
                    @error('username')
                        <p class="text-danger"><strong>{{$message}}</strong></p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="form-group col-md-6">
                    <label for="email" class="form-control-label">Email</label>

                    <div class="input-group input-group-merge ">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-envelope"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" placeholder="Enter Email" name="email" id="email"
                            value="{{ $isUpdate ? $users->email : old('email') }}">
                    </div>
                    @error('email')
                        <p class="text-danger"><strong>{{$message}}</strong></p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="form-group col-md-12">
                    <label for="password" class="form-control-label">Password</label>
                    @if ($isUpdate)
                        <div class="proDiv col-md-6 pl-0">
                            <button type="button" style="width: 100%; white-space: normal;" class="btn btn-outline-primary"
                                data-toggle="modal" data-target="#changePass">
                                <span>Change Password</span>
                            </button>
                        </div>
                    @else
                        <div class="input-group input-group-merge ">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-lock"></i>
                                </span>
                            </div>
                            <input type="password" class="form-control" placeholder="Enter Password" name="password"
                                id="password" value="{{ $isUpdate ? $users->password : '' }}">
                        </div>
                    @error('password')
                        <p class="text-danger"><strong>{{$message}}</strong></p>
                    @enderror
                    @endif

                </div>

                {{-- Full name --}}
                <div class="form-group col-md-6">
                    <label for="fullname" class="form-control-label">Fullname</label>
                    <div class="input-group input-group-merge ">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-user-circle" aria-hidden="true"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" placeholder="Enter Fullname" name="fullname"
                            id="fullname" value="{{ $isUpdate ? $users->fullname : old('fullname') }}">
                    </div>
                    @error('fullname')
                        <p class="text-danger"><strong>{{$message}}</strong></p>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="department" class="form-control-label">Department</label>

                    <div class="input-group input-group-merge ">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-address-card"></i>
                            </span>
                        </div>

                        <select class="custom-select" name="department" id="department">
                            <option selected>Select Department</option>
                            <option value="SA" @if($department=="SA" )selected @endif>Sales</option>
                            <option value="LO" @if($department=="LO" )selected @endif>Logistics</option>
                            <option value="HR" @if($department=="HR" )selected @endif>Human Resource</option>
                            <option value="AC" @if($department=="AC" )selected @endif>Accounting</option>
                        </select>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label for="phone" class="form-control-label">Phone</label>

                    <div class="input-group input-group-merge ">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-phone"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" placeholder="Enter Phone" name="phone" id="phone"
                            value="{{ $isUpdate ? $users->phone : old('phone') }}">
                    </div>
                    @error('phone')
                        <p class="text-danger"><strong>{{$message}}</strong></p>
                    @enderror
                </div>
                {{-- Description --}}
                <div class="form-group col-md-12">
                    <label for="description" class="form-control-label">Description</label>
                    <textarea class="form-control" placeholder="Enter description" name="description" id="description">{{ $isUpdate ? $users->description : old('description')}}</textarea>
                </div>
                {{-- Admin --}}
                <div class="form-group col-md-6">
                    <label for="admin" class="form-control-label">Admin</label>
                    <div role="tabpanel" class="tab-pane fade show active">
                        <div data-toggle="buttons" class="btn-group btn-group-toggle radio-yes-no">
                            <label class="btn btn-success @if($admin==1 ) active @endif">
                                Yes
                                <input type="radio" name="admin" id="admin-1" value="1"></label>
                            <label class="btn btn-danger @if($admin==2 || $admin==0 ) active @endif">
                                No
                                <input type="radio" name="admin" id="admin-2" value="2"></label>
                        </div>
                    </div>
                </div>
                {{-- Active --}}
                <div class="form-group col-md-6">
                    <label for="active" class="form-control-label">Active</label>
                    <div role="tabpanel" class="tab-pane fade show active">
                        <div data-toggle="buttons" class="btn-group btn-group-toggle radio">
                            <label class="btn btn-success @if($active==1 ) focus active @endif">
                                Active
                                <input type="radio" name="active" id="active-1" value="1" @if($active==1)checked
                                    @endif></label>
                            <label class="btn btn-danger @if($active==2 ) focus active @endif">
                                Inactive
                                <input type="radio" name="active" id="active-2" value="2" @if($active==2)checked
                                    @endif></label>
                            <label class="btn btn-warning @if($active==3 ) focus active @endif">
                                Block
                                <input type="radio" name="active" id="active-3" value="3" @if($active==3)checked
                                    @endif></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <div class="row save-buttons">
                <div class="col-md-12">
                    <a href="/users/index" class="btn btn-success">Cancel</a>
                    <button type="reset" class="btn btn-danger">Reset</button>
                    <button type="submit" class="btn btn-info">Save</button>
                </div>

            </div>
        </div>

    </form>
</div>
@if ($isUpdate)
<!-- Change Password Modal -->
<div class="modal fade" id="changePass" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="/users/update/password/{{ $users->userID }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group col-md-12">
                        <label for="oldPassword" class="form-control-label">Old Password</label>
                        <div class="input-group input-group-merge ">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-unlock"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" placeholder="Enter Old Password"
                                name="oldPassword" id="oldPassword">
                        </div>
                        @error('oldPassword')
                            <p class="text-danger"><strong>{{$message}}</strong></p>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">
                        <label for="password" class="form-control-label">New Password</label>
                        <div class="input-group input-group-merge ">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-lock"></i>
                                </span>
                            </div>
                            <input type="password" class="form-control" placeholder="Enter New Password"
                                name="password" id="password">
                        </div>
                        @error('password')
                            <p class="text-danger"><strong>{{$message}}</strong></p>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">
                        <label for="password_confirmation" class="form-control-label">Confirm New
                            Password</label>
                        <div class="input-group input-group-merge ">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-user-lock"></i>
                                </span>
                            </div>
                            <input type="password" class="form-control" placeholder="Confirm New Password"
                                name="password_confirmation" id="password_confirmation">
                        </div>
                        @error('password_confirmation')
                            <p class="text-danger"><strong>{{$message}}</strong></p>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Change Password</button>
                </div>
            </form>

        </div>
    </div>
</div>
@endif
@endsection

@extends('layouts.dashboard')
@section('title','UPDATE VENDOR')
@section('content')

<form method="POST">
    @csrf
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="vendorID" class="form-control-label">Vendor ID</label>
                    <div class="input-group input-group-merge ">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-tags"></i>
                            </span>
                        </div>
                        <input class="form-control pl-2" name="vendorID" id="vendorID" value="{{ $ven->vendorID }}" readonly>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label for="vendorName" class="form-control-label">Vendor Name</label>
                    <div class="input-group input-group-merge ">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-id-card"></i>
                            </span>
                        </div>
                        <input class="form-control" placeholder="Enter Vendor Name" name="vendorName" id="vendorName" value="{{ $ven->vendorName }}">
                    </div>
                    @error('vendorName')
                        <p class="text-danger"><strong>{{$message}}</strong></p>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="taxNumber" class="form-control-label">Tax Number</label>

                    <div class="input-group input-group-merge ">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-calendar"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" placeholder="Enter Tax Number" name="taxNumber" id="taxNumber" value="{{ $ven->taxNumber }}">
                    </div>
                    @error('taxNumber')
                        <p class="text-danger"><strong>{{$message}}</strong></p>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="address" class="form-control-label">Address</label>

                    <div class="input-group input-group-merge ">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-home"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" placeholder="Enter Address" name="address" id="address" value="{{ $ven->address }}">
                    </div>
                    @error('address')
                        <p class="text-danger"><strong>{{$message}}</strong></p>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="phone" class="form-control-label">Phone Number</label>

                    <div class="input-group input-group-merge ">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-phone"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" placeholder="Enter Phone Number" name="phone" id="phone" value="{{ $ven->phone }}">
                    </div>
                    @error('phone')
                        <p class="text-danger"><strong>{{$message}}</strong></p>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="email" class="form-control-label">Email</label>

                    <div class="input-group input-group-merge ">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-envelope"></i>
                            </span>
                        </div>
                        <input type="email" class="form-control" placeholder="Enter Email" name="email" id="email" value="{{ $ven->email }}">
                    </div>
                    @error('email')
                        <p class="text-danger"><strong>{{$message}}</strong></p>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="unpaid" class="form-control-label">Unpaid</label>

                    <div class="input-group input-group-merge ">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-money-bill"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" placeholder="Enter Unpaid Number" name="unpaid" id="unpaid" value="{{ $ven->unpaid }}">
                    </div>
                    @error('unpaid')
                        <p class="text-danger"><strong>{{$message}}</strong></p>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="status" class="form-control-label">Status</label>
                    <div role="tabpanel" class="tab-pane fade show active">
                        <div data-toggle="buttons" class="btn-group btn-group-toggle radio">
                            <label class="btn btn-success @if($ven->status==1 ) focus active @endif">
                                Yes
                                <input type="radio" name="status" id="status-1" value="1" @if($ven->status==1)checked
                                    @endif></label>
                            <label class="btn btn-danger @if($ven ->status==0 ) focus active @endif">
                                No
                                <input type="radio" name="status" id="status-2" value="0" @if($ven->status==0)checked
                                    @endif></label>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label for="description" class="form-control-label">Description</label>

                    <div class="input-group input-group-merge ">
                        <textarea class="form-control" placeholder="Enter Description" rows="3" name="description" cols="50" id="description" >{{ $ven->description }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row save-buttons">
                <div class="col-md-12">
                    <a href="/vendors/index" class="btn btn-info">Cancel</a>
                    <button type="reset" class="btn btn-icon btn-danger">Reset</button>
                    <button type="submit" class="btn btn-icon btn-success">Update</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@extends('layouts.dashboard')
@section('title','UPDATE BILL')
@section('content')
@php
date_default_timezone_set("Asia/Bangkok");

@endphp
<div class="card">
    <div class="row">
        <div class="col">
            <form action="{{ url("bills/update/{$bi->billID}") }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="billID" class="form-control-label">Bill ID</label>
                            <div class="input-group input-group-merge ">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-tags"></i>
                                    </span>
                                </div>
                                <input class="form-control" name="billID" id="billID" value="{{ $bi->billID }}" readonly>
                            </div>
                        </div>
                        
                            <div class="form-group col-md-6">
                                <label for="vendorID" class="form-control-label">Vendor ID</label>
                                <div class="input-group input-group-merge ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-info-circle"></i>
                                        </span>
                                    </div>
                                    <input class="form-control" type="text" placeholder="Enter Vendor ID" name="vendorID" id="vendorID"  value="{{ $bi->vendorID }}">
                                </div>
                            </div>
                    <div class="form-group col-md-6">
                        <label for="billDate" class="form-control-label">Bill Date</label>
    
                        <div class="input-group input-group-merge ">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                            <input type="date" class="form-control" placeholder="Enter Bill Date" name="billDate" id="billDate" value="{{ $bi->billDate }}">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="userID" class="form-control-label">User ID</label>
    
                        <div class="input-group input-group-merge ">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-id-card"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" placeholder="Enter User ID" name="userID" id="userID"  value="{{ $bi->userID }}">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="createdDate" class="form-control-label">Created Date</label>
    
                        <div class="input-group input-group-merge ">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                            <input type="datetime" class="form-control" placeholder="Enter Created Date" name="createdDate" id="createdDate" value="{{ $bi->createdDate }}" readonly>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="updatedDate" class="form-control-label">Updated Date</label>
    
                        <div class="input-group input-group-merge ">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                            <input type="datetime" class="form-control" name="updatedDate" id="updatedDate" value="{{ date("Y-m-d h:i:s") }}" readonly>
                        </div>
                    </div>
                    
                
                   
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row save-buttons">
                        <div class="col-md-12">
                            <button type="reset" class="btn btn-icon btn-danger">Clear</button>
                            <a href="/bills/index" class="btn btn-warning">Back</a>
                            <button type="submit" class="btn btn-icon btn-info">Update</button>
                        </div>
        
                    </div>
                </div>
            </form>
            
        </div>
    </div>
    </form>
</div>
</div>
@endsection


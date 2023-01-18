@extends('layouts.dashboard')
@section('title','UPDATE INVOICE')
@section('content')
@php
date_default_timezone_set("Asia/Bangkok");

@endphp
<div class="card">
    <div class="row">
        <div class="col">
            <form action="{{ url("invoices/update/{$in->invoiceID}") }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="invoiceID" class="form-control-label">Invoice ID</label>
                            <div class="input-group input-group-merge ">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-tags"></i>
                                    </span>
                                </div>
                                <input class="form-control" type="text" name="invoiceID" id="invoiceID" value="{{ $in->invoiceID }}" readonly>
                            </div>
                        </div>
                        
                            <div class="form-group col-md-6">
                                <label for="orderID" class="form-control-label">Order ID</label>
                                <div class="input-group input-group-merge ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-info-circle"></i>
                                        </span>
                                    </div>
                                    <input class="form-control" type="text" placeholder="Enter Order ID" name="orderID" id="orderID"  value="{{ $in->orderID }}">
                                </div>
                            </div>
                    <div class="form-group col-md-6">
                        <label for="invoiceDate" class="form-control-label">Invoice Date</label>
    
                        <div class="input-group input-group-merge ">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                            <input type="datetime" class="form-control" placeholder="Enter Invoice Date" name="invoiceDate" id="invoiceDate" value="{{ $in->invoiceDate }}">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="customerID" class="form-control-label">Customer ID</label>
    
                        <div class="input-group input-group-merge ">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-id-card"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" placeholder="Enter Customer ID" name="customerID" id="customerID"  value="{{ $in->customerID }}">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="dueDate" class="form-control-label">Due Date</label>
    
                        <div class="input-group input-group-merge ">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                            <input type="date" class="form-control" placeholder="Enter Due Date" name="dueDate" id="dueDate" value="{{ $in->dueDate }}">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="total" class="form-control-label">Total</label>
    
                        <div class="input-group input-group-merge ">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-money-bill"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" placeholder="Enter Total" name="total" id="total"  value="{{ $in->total }}">
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
                            <input type="datetime" class="form-control" placeholder="Enter Created Date" name="createdDate" id="createdDate" value="{{ $in->createdDate }}" readonly>
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
                            <input type="datetime" class="form-control" placeholder="Enter Updated Date" name="updatedDate" id="updatedDate" value="{{ date("Y-m-d h:i:s") }}" readonly>
                            {{-- {{ date("Y-m-d") }} --}}
                        </div>
                    </div>
        </div>
    </div> 
    <div class="card-footer">
        <div class="row save-buttons">
            <div class="col-md-12">
                <button type="reset" class="btn btn-icon btn-danger">Clear</button>
                <a href="/invoices/index" class="btn btn-warning">Back</a>
                <button type="submit" class="btn btn-icon btn-info">Update</button>
            </div>

        </div>
    </div>   
    {{--  <div class="col-sm-6 col-md-6 col-lg-6"> 
    <form action="{{ url("invoices/update/{$in->invoiceID}") }}" method="post">
    {{ csrf_field() }}
    <div class="row mb-2 mr-5">
        <div class="col-3">Invoice ID</div>
        <div class="col-9"><input type="text" name="invoiceID" value="{{ $in->invoiceID }}" readonly></div>
    </div>
    <div class="row mb-2 mr-5">
        <div class="col-3">Order ID</div>
        <div class="col-9"><input type="text" name="orderID" value="{{ $in->orderID }}"></div>
    </div>
    <div class="row mb-2 mr-5">
        <div class="col-3">Invoice Date</div>
        <div class="col-9"><input type="date" name="invoiceDate" value="{{ $in->invoiceDate }}"></div>
    </div>
    <div class="row mb-2 mr-5">
        <div class="col-3">Customer ID</div>
        <div class="col-9"><input type="text" name="customerID" value="{{ $in->customerID }}"></div>
    </div>
    <div class="row mb-2 mr-5">
        <div class="col-3">Due Date</div>
        <div class="col-9"><input type="date" name="dueDate" value="{{ $in->dueDate }}"></div>
    </div>
    <div class="row mb-2 mr-5">
        <div class="col-3">Total</div>
        <div class="col-9"><input type="text" name="total" value="{{ $in->total}}"></div>
    </div>
    <div class="row mb-2 mr-5"> 
        <div class="col-3">Created Date</div>
        <div class="col-9"><input type="date" name="createdDate" value="{{ $in->createdDate }}" readonly></div>
    </div>
    <div class="row mb-2 mr-5"> 
        <div class="col-3">Updated Date</div>
        <div class="col-9"><input type="date" name="updatedDate" value="{{ $in->updatedDate }}" readonly></div>
    </div>
    <br>
    <div class="row mb-2 mr-5">
        <div class="col-6"><button type="submit" class="btn btn-info"><i class="fa fa-upload" aria-hidden="true"> UPDATE</i></button></div>
    </div>
   
    </form>
</div>  --}}
</div>
@endsection


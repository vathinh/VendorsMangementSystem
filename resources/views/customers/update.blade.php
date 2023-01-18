@extends('layouts.dashboard')
@section('title','Update Customer')

@section('content')
    <div class="card">
        <form method="POST" action="{{url("customers/update/{$customers->customerID}")}}" accept-charset="UTF-8">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="name" class="form-control-label">Name</label>

                        <div class="input-group input-group-merge ">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-tag"></i></span>
                            </div>
                            <input class="form-control" data-name="name" value="{{old('txtname',$customers->customerName)}}" v-model="form.name"
                                name="txtname" type="text" id="name">
                        </div>
                        @error('txtname')
                            <p class="text-danger"><strong>{{$message}}</strong></p>
                        @enderror
                    </div>

                    <div class="col-md-6 el-select-tags-pl-38">
                        <label for="tax" class="form-control-label">Tax Number</label>

                        <div class="input-group input-group-merge ">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-percent"></i>
                                </span>
                            </div>
                            <input class="form-control" data-name="tax" value="{{old('txttax',$customers->taxNumber)}}" v-model="form.tax" name="txttax" type="text" id="tax">
                        </div>
                        @error('txttax')
                            <p class="text-danger"><strong>{{$message}}</strong></p>
                        @enderror
                    </div>

                    <div class="form-group col-md-12">
                        <label for="description" class="form-control-label">Description</label>

                        <textarea class="form-control" data-name="description" v-model="form.description" rows="3" cols="50" name="txtdescription" id="description">{{old('txtdescription',$customers->description)}}</textarea>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="address" class="form-control-label">Address</label>
                        <div class="input-group input-group-merge ">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-map-marker-alt"></i>
                                </span>
                            </div>
                            <input class="form-control" data-name="address" value="{{old('txtaddress',$customers->address)}}" v-model="form.address" name="txtaddress" type="text"id="address">
                        </div>
                        @error('txtaddress')
                            <p class="text-danger"><strong>{{$message}}</strong></p>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="phone" class="form-control-label">Phone</label>

                        <div class="input-group input-group-merge ">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-phone-alt"></i>
                                </span>
                            </div>
                            <input class="form-control" data-name="phone" value="{{old('txtphone',$customers->phone)}}" v-model="form.phone" name="txtphone" type="text" id="phone">
                        </div>
                        @error('txtphone')
                            <p class="text-danger"><strong>{{$message}}</strong></p>
                        @enderror
                    </div>

                    <div class="col-md-6" id="form-select-category_id">
                        <label for="email" class="form-control-label">Email</label>

                        <div class="input-group input-group-merge ">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-envelope"></i>
                                </span>
                            </div>
                            <input class="form-control" data-name="email" value="{{ old('txtemail',$customers->email)}}" v-model="form.email"  name="txtemail" type="text" id="email">
                        </div>
                        @error('txtemail')
                            <p class="text-danger"><strong>{{$message}}</strong></p>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="unpaid" class="form-control-label">Unpaid</label>

                        <div class="input-group input-group-merge">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-money-bill-wave"></i>
                                </span>
                            </div>
                            <input class="form-control" value="{{old('txtunpaid',$customers->unpaid)}}" name="unpaid" type="text" id="unpaid">
                        </div>
                        @error('unpaid')
                            <p class="text-danger"><strong>{{$message}}</strong></p>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="status" class="form-control-label">Status</label>
                        <div role="tabpanel" class="tab-pane fade show active">
                            <div data-toggle="buttons" class="btn-group btn-group-toggle radio">
                                <label class="btn btn-success @if($customers->status==1 ) focus active @endif" @click="form.enabled=1"
                                    v-bind:class="{ active: form.enabled == 1 }">
                                    Yes
                                    <input type="radio" name="status" id="status-1" value="1" @if($customers->status==1)checked
                                        @endif></label>
                                <label class="btn btn-danger @if($customers->status==0 ) focus active @endif" @click="form.enabled=0"
                                    v-bind:class="{ active: form.enabled == 0 }">
                                    No
                                    <input type="radio" name="status" id="status-2" value="0" @if($customers->status==0)checked
                                        @endif></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <div class="row save-buttons">
                    <div class="col-md-12">
                        <a href="/customers/index" class="btn btn-success">Cancel</a>
                        <button type="reset" class="btn btn-danger">Reset</button>
                    <button type="submit" class="btn btn-info">Save</button>
                    </div>
                </div>
            </div>

        </form>
    </div>


{{-- <script src="{{ asset('js/common/items.js?v=2.1.16') }}"></script> --}}


@endsection

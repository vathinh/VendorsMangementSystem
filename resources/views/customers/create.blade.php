@extends('layouts.dashboard')
@section('title','New Customer')

@section('content')
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
    <form method="POST" action="/customers/create" accept-charset="UTF-8" id="item">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-6" :class="[{'has-error': form.errors.get(&quot;name&quot;) }]">
                    <label for="name" class="form-control-label">Name</label>

                    <div class="input-group input-group-merge ">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-tag"></i></span>
                        </div>
                        <input class="form-control" placeholder="Enter Name" name="txtname"type="text" id="name" value="{{old('txtname')}}" >
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
                        <input class="form-control" placeholder="Enter Tax Number" name="txttax" type="text" id="tax" value="{{old('txttax')}}">
                    </div>
                    @error('txttax')
                        <p class="text-danger"><strong>{{$message}}</strong></p>
                    @enderror
                </div>

                <div class="form-group col-md-12">
                    <label for="description" class="form-control-label">Description</label>

                    <textarea class="form-control" data-name="description" placeholder="Enter Description"rows="3" name="txtdescription" cols="50" id="description">{{old('txtdescription')}}</textarea>
                </div>

                <div class="form-group col-md-6">
                    <label for="address" class="form-control-label">Address</label>

                    <div class="input-group input-group-merge ">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-map-marker-alt"></i>
                            </span>
                        </div>
                        <input class="form-control" placeholder="Enter Address" name="txtaddress" type="text" id="address" value="{{old('txtaddress')}}">
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
                        <input class="form-control" placeholder="Enter Phone Number" name="txtphone" type="text" id="phone" value="{{old('txtphone')}}">
                    </div>
                    @error('txtphone')
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
                        <input class="form-control" placeholder="Enter email" name="txtemail" type="text" id="email" value="{{old('txtemail')}}">
                    </div>
                    @error('txtemail')
                        <p class="text-danger"><strong>{{$message}}</strong></p>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="unpaid" class="form-control-label">Unpaid</label>
                    <div class="input-group input-group-merge ">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-dollar-sign"></i>
                            </span>
                        </div>
                        <input class="form-control" placeholder="Enter Unpaid" name="unpaid" id="unpaid" value="{{old('unpaid')}}">
                    </div>
                    @error('unpaid')
                        <p class="text-danger"><strong>{{$message}}</strong></p>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="status" class="form-control-label">Active</label>
                    <div class="tab-pane tab-example-result fade show active" role="tabpanel"
                        aria-labelledby="-component-tab">
                        <div class="btn-group btn-group-toggle radio-yes-no" data-toggle="buttons">
                            <label class="btn btn-success" @click="form.enabled=1"
                                v-bind:class="{ active: form.enabled == 1 }">
                                Yes
                                <input type="radio" name="status" id="enabled-1" value="1" @if(old('status') == '1') checked @endif>
                            </label>

                            <label class="btn btn-danger" @click="form.enabled=0"
                                v-bind:class="{ active: form.enabled == 0 }">
                                No
                                <input type="radio" name="status" id="enabled-0" value="0" @if(old('status') == '0') checked @endif>
                            </label>
                        </div>
                    </div>
                </div>
                {{-- <div class="form-group col-md-6">
                    <label for="status" class="form-control-label">Active</label>
                    <div class="tab-pane tab-example-result fade show active" role="tabpanel"
                        aria-labelledby="-component-tab">
                        <div class="btn-group btn-group-toggle radio-yes-no" data-toggle="buttons">
                            <label class="btn btn-success">
                                Yes
                                <input type="radio" name="status" id="enabled-1" value="1" {{(old('status') == '1') ? 'checked' : ''}}>
                            </label>

                            <label class="btn btn-danger">
                                No
                                <input type="radio" name="status" id="enabled-0" value="0" {{(old('status') == '0') ? 'checked' : ''}}>
                            </label>
                        </div>
                    </div>

                </div>
            </div>
        </div> --}}


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

<script src="{{ asset('js/common/items.js?v=2.1.16') }}"></script>

@endsection

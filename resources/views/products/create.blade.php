@extends('layouts.dashboard')
@section('title')
@if(isset($isUpdate))
{{ $isUpdate }} Product
@else
New Product
@endif
@endsection
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


<form method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="productName" class="form-control-label">Product Name</label>
                    <div class="input-group input-group-merge ">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-info-circle"></i>
                            </span>
                        </div>
                        <input class="form-control" placeholder="Enter Product Name" name="productName" id="productName" value="{{old('productName')}}">
                    </div>
                    @error('productName')
                        <p class="text-danger"><strong>{{$message}}</strong></p>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="manufacture" class="form-control-label">Manufacture</label>

                    <div class="input-group input-group-merge ">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-home"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" placeholder="Enter Manufacture" name="manufacture"
                            id="manufacture" value="{{old('manufacture')}}">
                    </div>
                    @error('manufacture')
                        <p class="text-danger"><strong>{{$message}}</strong></p>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="salesprice" class="form-control-label">Sales Price</label>

                    <div class="input-group input-group-merge ">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-dollar-sign"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" placeholder="Enter Sales Price" name="salesprice"
                            id="salesprice" value="{{old('salesprice')}}">
                    </div>
                    @error('salesprice')
                        <p class="text-danger"><strong>{{$message}}</strong></p>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="purchaseprice" class="form-control-label">Purchase Price</label>

                    <div class="input-group input-group-merge ">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-dollar-sign"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" placeholder="Enter Purchase Price" name="purchaseprice"
                            id="purchaseprice" value="{{old('purchaseprice')}}">
                    </div>
                    @error('purchaseprice')
                        <p class="text-danger"><strong>{{$message}}</strong></p>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="quantity" class="form-control-label">Quantity</label>
                    <div class="input-group input-group-merge ">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-code"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" placeholder="Enter Quantity" name="quantity"
                            id="quantity" value="{{old('quantity')}}">
                    </div>
                    @error('quantity')
                        <p class="text-danger"><strong>{{$message}}</strong></p>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="category" class="form-control-label">Category</label>

                    <div class="input-group input-group-merge ">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-clipboard"></i>
                            </span>
                        </div>

                        <select class="custom-select" name="category" id="category">
                            <option selected>Category</option>
                            <option value="Console">Console</option>
                            <option value="Nintendo Games">Nintendo Games</option>
                            <option value="PlayStation Games">PlayStation Games</option>
                            <option value="Xbox Games">Xbox Games</option>
                            <option value="Accessory">Accessory</option>

                        </select>
                    </div>
                </div>
                {{-- Active --}}
                <div class="form-group col-md-6">
                    <label for="status" class="form-control-label">Status</label>
                    <div role="tabpanel" class="tab-pane fade show status">
                        <div data-toggle="buttons" class="btn-group btn-group-toggle radio">
                            <label class="btn btn-success focus active">
                                Active
                                <input type="radio" name="status" id="status-1" value="1" checked></label>
                            <label class="btn btn-danger">
                                Inactive
                                <input type="radio" name="status" id="status-2" value="2"></label>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="picture" class="form-control-label">Product Picture</label>
                    <div class="input-group input-group-merge ">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-image"></i>
                            </span>
                        </div>
                        <input type="file" name="picture" id="picture" style="display: none"/>
                        <label for="picture" class="form-control" id="pictureLabel">Upload Picture</label>
                    </div>
                    @error('picture')
                        <p class="text-danger"><strong>{{$message}}</strong></p>
                    @enderror
                </div>
                <div class="form-group col-md-12">
                    <label for="description" class="form-control-label">Description</label>
                    <textarea class="form-control" placeholder="Enter description" name="description" id="description">{{old('description')}}</textarea>
                </div>
                @error('description')
                    <p class="text-danger"><strong>{{$message}}</strong></p>
                @enderror
            </div>
        </div>
        <div class="card-footer">
            <div class="row save-buttons">
                <div class="col-md-12">
                    <a href="index" class="btn btn-success">Cancel</a>
                    <button type="reset" class="btn btn-danger">Reset</button>
                    <button type="submit" class="btn btn-info">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        $("#picture").on('change keyup', function() {
            picture = $(this)[0].files[0];
            $('#pictureLabel').html(picture.name);
            console.log(picture);
        });
    });
</script>
@endsection

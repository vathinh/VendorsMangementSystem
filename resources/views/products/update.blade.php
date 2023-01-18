{{-- @extends('layouts.dashboard')
@section('title','UPDATE PRODUCT')
@section('content')

<div class="card">
    <form method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="productID" class="form-control-label">Product ID</label>
                    <div class="input-group input-group-merge ">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-tags"></i>
                            </span>
                        </div>
                        <input class="form-control pl-2" name="productID" id="productID" value="{{ $pro->productID }}"
                            readonly>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label for="productName" class="form-control-label">Product Name</label>
                    <div class="input-group input-group-merge ">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-info-circle"></i>
                            </span>
                        </div>
                        <input class="form-control" placeholder="Enter Product Name" name="productName" id="productName"
                            value="{{ $pro->productName }}">
                    </div>
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
                            id="manufacture" value="{{ $pro->manufacture }}">
                    </div>
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
                            id="salesprice" value="{{ $pro->salesprice }}">
                    </div>
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
                            id="purchaseprice" value="{{ $pro->purchaseprice }}">
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="quantity" class="form-control-label">Quantity</label>

                    <div class="input-group input-group-merge ">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-code"></i>
                            </span>
                        </div>
                        <input type="number" class="form-control" placeholder="Enter Quantity" name="quantity"
                            id="quantity" value="{{ $pro->quantity }}">
                    </div>
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
                            <option @if($pro->category=="Console") selected @endif value="Console">Console</option>
                            <option @if($pro->category=="Nintendo Games") selected @endif value="Nintendo Games">Nintendo Games</option>
                            <option @if($pro->category=="PlayStation Games") selected @endif value="PlayStation Games">PlayStation Games</option>
                            <option @if($pro->category=="Xbox Games") selected @endif value="Xbox Games">Xbox Games</option>
                            <option @if($pro->category=="Accessory") selected @endif value="Accessory">Accessory</option>
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="Status" class="form-control-label">Status</label>
                    <div role="tabpanel" class="tab-pane fade show status">
                        <div data-toggle="buttons" class="btn-group btn-group-toggle radio">
                            <label class="btn btn-success @if($pro->status==1 ) focus active @endif">
                                Active
                                <input type="radio" name="status" id="status-1" value="1" @if($pro->status==1)checked
                                    @endif></label>
                            <label class="btn btn-danger @if($pro->status==2 ) focus active @endif">
                                Inactive
                                <input type="radio" name="status" id="status-2" value="2" @if($pro->status==2)checked
                                    @endif></label>
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
                        <label for="picture" class="form-control" id="pictureLabel">{{ $pro->picture ? $pro->picture : "Choose Picture" }}</label>
                    </div>

                </div>
                <div class="form-group col-md-12">
                    <label for="description" class="form-control-label">Description</label>
                    <textarea class="form-control" placeholder="Enter description" name="description" id="description"></textarea>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row save-buttons">
                <div class="col-md-12">
                    <a href="/products/index" class="btn btn-primary">Cancel</a>
                    <button type="reset" class="btn btn-icon btn-danger">Reset</button>
                    <button type="submit" class="btn btn-icon btn-success">Submit</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        $("#picture").on('change keyup', function() {
            picture = $(this)[0].files[0];
            $('#pictureLabel').html(picture.name);
        });
    });
</script>
@endsection --}}

@extends('layouts.dashboard')
@section('title','UPDATE PRODUCT')
@section('content')

<div class="card">
    <form method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="productID" class="form-control-label">Product ID</label>
                    <div class="input-group input-group-merge ">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-tags"></i>
                            </span>
                        </div>
                        <input class="form-control pl-2" name="productID" id="productID" value="{{ $pro->productID }}"
                            readonly>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label for="productName" class="form-control-label">Product Name</label>
                    <div class="input-group input-group-merge ">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-info-circle"></i>
                            </span>
                        </div>
                        <input class="form-control" placeholder="Enter Product Name" name="productName" id="productName"
                            value="{{ $pro->productName }}">
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
                            id="manufacture" value="{{ $pro->manufacture }}">
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
                            id="salesprice" value="{{ $pro->salesprice }}">
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
                            id="purchaseprice" value="{{ $pro->purchaseprice }}">
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
                        <input type="number" class="form-control" placeholder="Enter Quantity" name="quantity"
                            id="quantity" value="{{ $pro->quantity }}">
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
                            <option @if($pro->category=="Console") selected @endif value="Console">Console</option>
                            <option @if($pro->category=="Nintendo Games") selected @endif value="Nintendo Games">Nintendo Games</option>
                            <option @if($pro->category=="PlayStation Games") selected @endif value="PlayStation Games">PlayStation Games</option>
                            <option @if($pro->category=="Xbox Games") selected @endif value="Xbox Games">Xbox Games</option>
                            <option @if($pro->category=="Accessory") selected @endif value="Accessory">Accessory</option>
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="Status" class="form-control-label">Status</label>
                    <div role="tabpanel" class="tab-pane fade show status">
                        <div data-toggle="buttons" class="btn-group btn-group-toggle radio">
                            <label class="btn btn-success @if($pro->status==1 ) focus active @endif">
                                Active
                                <input type="radio" name="status" id="status-1" value="1" @if($pro->status==1)checked
                                    @endif></label>
                            <label class="btn btn-danger @if($pro->status==2 ) focus active @endif">
                                Inactive
                                <input type="radio" name="status" id="status-2" value="2" @if($pro->status==2)checked
                                    @endif></label>
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
                        <label for="picture" class="form-control" id="pictureLabel">{{ $pro->picture ? $pro->picture : "Choose Picture" }}</label>
                    </div>

                </div>
                <div class="form-group col-md-12">
                    <label for="description" class="form-control-label">Description</label>
                    <textarea class="form-control" placeholder="Enter description" name="description" id="description">{{old('description',$pro->description)}}</textarea>
                </div>
                @error('description')
                    <p class="text-danger"><strong>{{$message}}</strong></p>
                @enderror
            </div>
        </div>
        <div class="card-footer">
            <div class="row save-buttons">
                <div class="col-md-12">
                    <a href="/products/index" class="btn btn-primary">Cancel</a>
                    <button type="reset" class="btn btn-icon btn-danger">Reset</button>
                    <button type="submit" class="btn btn-icon btn-success">Submit</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        $("#picture").on('change keyup', function() {
            picture = $(this)[0].files[0];
            $('#pictureLabel').html(picture.name);
        });
    });
</script>
@endsection

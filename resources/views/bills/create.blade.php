@extends('layouts.dashboard')
@section('title')
    @if(isset($isUpdate))
        {{ $isUpdate }} Bill
    @else
        New Bill
    @endif
    @endsection
@section('content')

@php

    date_default_timezone_set("Asia/Bangkok");
    if(isset($isUpdate)){
        $billID = 1;
    }
    if(isset($isUpdate) && old('tableRow') == null){
        //Bill
        $billID = $bills->billID;
        $purchaseorderID = $bills->purchaseorderID;
        $vendorID = $bills->vendorID;
        $dt = new DateTime($bills->billDate);
        $billDate = $dt->format('Y-m-d');
        $dt2 = new DateTime($bills->dueDate);
        $dueDate = $dt2->format('Y-m-d');
        $description = $bills->description;
        $tableRow = count($details);
        //Details
        foreach ($details as $details) {
            $detailID[] = $details->billdetailsID;
            $productID[] = $details->productID;
            $productName[] = $details->productName;
            $quantity[] = $details->dquantity;
            $price[] = $details->price;
            $tax[] = $details->tax;
            $discount[] = $details->discount;
        }
    }else{
        $billID = $newID;
        $purchaseorderID = old('purchaseorderID','Choose Purchase Order');
        // 1st row old value
        $vendorID = old('vendorID',0);
        $billDate = old('billDate',date("Y-m-d"));
        $dueDate = old('dueDate',date("Y-m-d"));
        $description = old('description');
        $productID[] = old('productID.0',0);
        $detailID[] = old('detailID.0',0);
        if($productID[0] > 0){
            $productName[] = $products->where('productID',$productID[0])->first()->productName;
        }else{
            $productName[] = "Choose Product";
        }
        $quantity[] = old('quantity.0',0);
        $price[] = old('price.0',0);
        $tax[] = old('tax.0',0);
        $discount[] = old('discount.0',0);

        // row+1 value
        $tableRow = old('tableRow',1);
    }

    if($tableRow > 1){
        $i = 1;
        while($i< $tableRow){
            $productID[]=old('productID.'.$i);
            if($productID[$i]> 0){
                $productName[] = $products->where('productID',$productID[$i])->first()->productName;
            }else{
                $productName[] = "Choose Product";
            }
            $quantity[] = old('quantity.'.$i);
            $price[] = old('price.'.$i);
            $tax[] = old('tax.'.$i);
            $discount[] = old('discount.'.$i);
            $i++;
        }
    }
@endphp

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
        $('#vendorTable').DataTable({
            paging: false,
            responsive: true,
            "initComplete": function (settings, json) {
                $(this).wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
            }
        });
    });
    $(document).ready(function() {
        var table = $('#productTable').DataTable({
            paging: false,
            responsive: true,
            "initComplete": function (settings, json) {
                $(this).wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
            }
        });
        $('#poTable').DataTable({
            responsive: true,
            "scrollX": "true",
            "scrollY": "500px",
            "scrollCollapse": true,
            paging: false,

        });
        $('.modal').on('shown.bs.modal', function (e) {
            $('#poTable').DataTable().columns.adjust().draw();
          });
    });

    </script>

    @if (count($errors) > 0)
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
    @endif

    <form method="POST" action="" id="document">
        @csrf
        <div class="card">
            {{-- <div class="document-loading" v-if="!page_loaded">
                    <div><i class="fas fa-spinner fa-pulse fa-7x"></i></div>
                </div> --}}

            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="row">
                            {{--  Customer ID  --}}
                            <input type="hidden" name="vendorID" id="vendorID" value="{{ $vendorID }}">

                            <div class="ml-3 document-contact-without-contact cusDiv">
                                <div class="aka-box aka-box--large aka-select">
                                    <div class="document-contact-without-contact-box">
                                        <button type="button"
                                            class="btn-aka-link aka-btn--fluid document-contact-without-contact-box-btn"
                                            data-toggle="modal" data-target="#cusModal">
                                            <i class="far fa-user fa-2x"></i> &nbsp; Add a vendor
                                        </button>
                                    </div>
                                </div>
                            </div>

                            @foreach ($vendors as $cus)
                            <div id="cusInfo{{ $cus->vendorID }}" class="ml-3 cusDiv" style="display: none">
                                <div class="table-responsive">
                                    <table class="table table-borderless p-0">
                                        <tbody>
                                            <tr>
                                                <th class="p-0" style="text-align: left;"><strong
                                                        class="d-block aka-text">{{ $cus->vendorName }}</strong></th>
                                            </tr>
                                            <tr>
                                                <th class="p-0" style="text-align: left; white-space: normal;">
                                                    {{ $cus->address }}
                                                </th>
                                            </tr>
                                            <tr>
                                                <th class="p-0" style="text-align: left;">
                                                    Tax number: {{ $cus->taxNumber }}
                                                </th>
                                            </tr>
                                            <tr>
                                                <th class="p-0" style="text-align: left;">
                                                    +{{ $cus->phone }}
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <button type="button" class="btn btn-link p-0" data-toggle="modal"
                                    data-target="#cusModal">
                                    Choose a different vendor
                                </button>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- <!-- Modal Customers --> --}}
                    <div class="modal fade" id="cusModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
                        aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Customers List</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <table id="vendorTable" class="table">
                                        <thead>
                                            <tr>
                                                <th>Customer Name</th>
                                                <th>Tax Number</th>
                                                <th>Address</th>
                                                <th>Choose</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($vendors as $cus)
                                            <tr>
                                                <td style="width: 40%; white-space: normal;">{{ $cus->vendorName }}</td>
                                                <td>{{ $cus->taxNumber }}</td>
                                                <td style="width: 40%; white-space: normal;">{{ $cus->address }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-primary"
                                                        id="cus{{ $cus->vendorID }}">
                                                        <i class="fas fa-arrow-right"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <script>
                                                $(document).ready(function() {

                                                    //Show Customer
                                                $("#cus{{ $cus->vendorID }}").click(function() {
                                                    $('.cusDiv').hide();
                                                    $("#cusInfo{{ $cus->vendorID }}").show();
                                                    $('.modal').modal('hide');
                                                    $('#vendorID').val({{ $cus->vendorID }});
                                                });
                                            });
                                            </script>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="row">
                            {{-- Bill Date  --}}
                            <div class="form-group col-md-6">
                                <label for="document_number" class="form-control-label">Bill Date</label>
                                <div class="input-group input-group-merge ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                    </div>
                                    <input type="date" class="form-control" name="billDate"
                                        value="{{ $billDate }}">
                                </div>
                            </div>

                            {{-- Bill ID  --}}
                            <div class="form-group col-md-6">
                                <label for="document_number" class="form-control-label">Bill ID</label>
                                <div class="input-group input-group-merge ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text blocked hidden">
                                            <i class="fa fa-file"></i>
                                        </span>
                                    </div>
                                    <input class="form-control pl-3" name="billID" id="billID"
                                        value="{{ $billID }}" readonly>
                                </div>
                            </div>
                            {{-- Due Date  --}}
                            <div class="form-group col-md-6">
                                <label for="document_number" class="form-control-label">Due Date</label>
                                <div class="input-group input-group-merge">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                    </div>
                                    <input type="date" class="form-control" name="dueDate"
                                        value="{{ $dueDate }}">
                                </div>
                            </div>

                            {{-- Purchase Order ID  --}}
                            <div class="form-group col-md-6">
                                <label for="document_number" class="form-control-label">Purchase Order ID</label>
                                <div class="input-group input-group-merge ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text blocked hidden btn-outline-primary">
                                            <i class="fa fa-file"></i>
                                        </span>
                                    </div>
                                    <input class="form-control pl-3 btn btn-outline-primary" data-toggle="modal" data-target="#poModal" name="purchaseorderID" id="purchaseorderID" placeholder="Choose Purchase Order" readonly
                                        value="{{ $purchaseorderID }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                {{-- Choose Product Modal  --}}
                <div class="modal fade" id="proModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
                    aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Product List</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <table id="productTable" class="table">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Manufacture</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Choose</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                        <tr>
                                            <td style="width: 50%; white-space: normal;">{{ $product->productName }}</td>
                                            <td>{{ $product->manufacture }}</td>
                                            <td>{{ $product->quantity }}</td>
                                            <td>${{ $product->salesprice }}</td>
                                            <input type="hidden" id="salesprice{{ $product->productID }}"
                                                value="{{ $product->salesprice }}">

                                            <td>
                                                <button type="button" class="btn btn-primary"
                                                    id="product{{ $product->productID }}">
                                                    <i class="fas fa-arrow-right"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        {{-- Hidden Product  --}}

                                        <div id="proInfo{{ $product->productID }}" style="display: none">
                                            <button type="button" style="width: 100%; white-space: normal;" class="btn btn-outline-primary proBtn"
                                                data-toggle="modal" data-target="#proModal" onclick="chosing(this)">
                                                {{ $product->productName }}
                                            </button>
                                        </div>
                                        <script>
                                            $(document).ready(function() {
                                            $("#product{{ $product->productID }}").click(function(e) {
                                                $(".chosing").closest("tr").find("input[id=price]").val($('#salesprice{{ $product->productID }}').val());
                                                $(".chosing").closest("td").find("input[id=productID]").val({{ $product->productID }});
                                                $('.modal').modal('hide');
                                                $('.chosing').replaceWith($('#proInfo{{ $product->productID }}').clone().addClass("proDiv"));
                                                $('.proDiv').show();
                                            });
                                        });
                                        </script>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Table  --}}
                <input type="hidden" name="tableRow" id="tableRow" value="1">
                <div class="row document-item-body">
                    <div class="col-sm-12 p-0" style="table-layout: fixed;">
                        <div class="table-responsive overflow-x-scroll overflow-y-hidden">
                            <table class="table" style="table-layout: fixed;" id="table-details">
                                <colgroup>
                                    <col class="document-item-40-px">   {{-- Row No. --}}
                                    <col style="width: 30%">    {{-- Name --}}
                                    <col style="width: 20%">    {{-- Quantity --}}
                                    <col style="width: 20%">    {{-- Price --}}
                                    <col style="width: 15%">    {{-- Tax --}}
                                    <col style="width: 25%">    {{-- Subtotal --}}
                                    <col style="width: 15%">    {{-- Discount --}}
                                    <col style="width: 25%">    {{-- Total --}}
                                    <col class="document-item-40-px">   {{-- Delete Row --}}
                                </colgroup>
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center px-1">No.</th>
                                        <th class="text-center">Product Name</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center tax">Tax</th>
                                        <th class="text-center">Subtotal</th>
                                        <th class="text-center">Discount</th>
                                        <th class="text-center">Amount</th>
                                        <th class="text-center"></th>
                                    </tr>
                                </thead>
                                <tbody id="product-rows" class="table-padding-05">
                                    <tr class="prorow1">
                                        {{-- No. --}}
                                        <td class="align-middle text-center px-1" style="font-weight: 600">
                                            1
                                        </td>
                                        {{-- Product --}}
                                        <td class="align-middle px-1 text-center">
                                            <input type="hidden" name="detailID[]" id="detailID" value="0">
                                            <input type="hidden" name="productID[]" id="productID" value="{{ $productID[0] }}">
                                            <div class="proDiv">
                                                <button type="button" style="width: 100%; white-space: normal;" class="btn btn-outline-primary proBtn"
                                                    data-toggle="modal" data-target="#proModal" onclick="chosing(this)">
                                                    @isset($productName[0])
                                                    {{ $productName[0] }}
                                                    @else
                                                    Choose Product
                                                    @endisset
                                                </button>
                                            </div>
                                        </td>
                                        {{-- Quantity --}}
                                        <td class="align-middle px-1">
                                            <div class="input-group">
                                                <input type="number" class="form-control text-right" name="quantity[]"
                                                    min="0" value="{{ $quantity[0] }}">
                                            </div>
                                        </td>
                                        {{-- Price --}}
                                        <td class="align-middle px-1">
                                            <div class="input-group">
                                                <input type="number" class="form-control text-right" name="price[]"
                                                    id="price" value="{{ $price[0] }}" />
                                                <div class="input-group-append">
                                                    <span class="input-group-text">$</span>
                                                </div>
                                            </div>
                                        </td>
                                        {{-- Tax --}}
                                        <td class="align-middle px-1">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                                <input type="number" type="tel" class="form-control text-right"
                                                    name="tax[]" id="tax" value="{{ $tax[0] }}">
                                            </div>
                                        </td>
                                        {{-- Subtotal --}}
                                        <td class="align-middle px-1">
                                            <div class="input-group">
                                                <input type="number" class="form-control text-right" name="subtotal[]"
                                                    id="subtotal" placeholder="0.00" readonly />
                                                <div class="input-group-append">
                                                    <span class="input-group-text">$</span>
                                                </div>
                                            </div>
                                        </td>
                                        {{-- Discount --}}
                                        <td class="align-middle px-1">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                                <input type="number" class="form-control text-right" name="discount[]"
                                                    id="discount" value="{{ $discount[0] }}">
                                            </div>
                                        </td>
                                        {{-- Amount --}}
                                        <td class="align-middle px-1">
                                            <div class="input-group">
                                                <input type="number" class="form-control text-right" name="amount[]"
                                                    id="amount" placeholder="0.00" readonly />
                                                <div class="input-group-append">
                                                    <span class="input-group-text">$</span>
                                                </div>
                                            </div>
                                        </td>
                                        {{-- Delete Row --}}
                                        @if(!isset($isUpdate) || $isUpdate != "Show")
                                        <td class="align-middle px-1" id="delete-items">
                                            <button type="button" class="btn btn-link btn-delete p-0"><i
                                                    class="far fa-trash-alt"></i></button>
                                                </td>
                                        @endif
                                    </tr>

                                    {{-- Row Copy  --}}
                                    <tr class="prorow-copy" style="display: none">
                                        {{-- No. --}}
                                        <td class="align-middle text-center px-1" style="font-weight: 600">
                                            1
                                        </td>
                                        {{-- Product --}}
                                        <td class="align-middle px-1 text-center">
                                            <input type="hidden" name="detailID[]" id="detailID" value="0">
                                            <input type="hidden" name="productID[]" id="productID" value="0">
                                            <div class="proDiv">
                                                <button type="button" style="width: 100%; white-space: normal;" class="btn btn-outline-primary proBtn"
                                                    data-toggle="modal" data-target="#proModal" onclick="chosing(this)">
                                                    Choose Product
                                                </button>
                                            </div>
                                        </td>
                                        {{-- Quantity --}}
                                        <td class="align-middle px-1">
                                            <input type="number" class="form-control text-right" name="quantity[]"
                                                min="0" value="0">
                                        </td>
                                        {{-- Price --}}
                                        <td class="align-middle px-1">
                                            <div class="input-group">
                                                <input type="number" class="form-control text-right" name="price[]"
                                                    id="price" value="0" />
                                                <div class="input-group-append">
                                                    <span class="input-group-text">$</span>
                                                </div>
                                            </div>
                                        </td>
                                        {{-- Tax --}}
                                        <td class="align-middle px-1">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                                <input type="number" type="tel" class="form-control text-right"
                                                    name="tax[]" id="tax" value="0">
                                            </div>
                                        </td>
                                        {{-- Subtotal --}}
                                        <td class="align-middle px-1">
                                            <div class="input-group">
                                                <input type="number" class="form-control text-right" name="subtotal[]"
                                                    id="subtotal" placeholder="0.00" readonly />
                                                <div class="input-group-append">
                                                    <span class="input-group-text">$</span>
                                                </div>
                                            </div>
                                        </td>
                                        {{-- Discount --}}
                                        <td class="align-middle px-1">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                                <input type="number" class="form-control text-right" name="discount[]"
                                                    id="discount" value="0">
                                            </div>
                                        </td>
                                        {{-- Amount --}}
                                        <td class="align-middle px-1">
                                            <div class="input-group">
                                                <input type="number" class="form-control text-right" name="amount[]"
                                                    id="amount" placeholder="0.00" readonly />
                                                <div class="input-group-append">
                                                    <span class="input-group-text">$</span>
                                                </div>
                                            </div>
                                        </td>
                                        {{-- Delete Row --}}
                                        @if(!isset($isUpdate) || $isUpdate != "Show")
                                        <td class="align-middle px-1" id="delete-items">
                                            <button type="button" class="btn btn-link btn-delete p-0"><i
                                                    class="far fa-trash-alt"></i></button>
                                        </td>
                                        @endif
                                    </tr>
                                    @if(!isset($isUpdate) || $isUpdate != "Show")

                                    <tr id="addItem">
                                        <td colspan="9" class="text-right border-bottom-0 p-0">
                                            <div id="select-item-button-9" class="product-select">
                                                <div class="item-add-new">
                                                    <button type="button" class="btn btn-link w-100">
                                                        <i class="fas fa-plus-circle"></i> &nbsp; Add an Item
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- End Add Item  --}}

                <div class="row document-item-body">
                    <div class="col-sm-12 mb-4 p-0">
                        <div class="table-responsive overflow-x-scroll overflow-y-hidden">
                            <table class="table">
                                <colgroup>
                                    <col style="width: 10%">
                                    <col style="width: 30%">
                                    <col class="document-total-30">
                                    <col class="document-total-25">
                                    <col class="document-total-40-px">
                                </colgroup>
                                <tbody id="total-rows" class="table-padding-05">
                                    {{-- Total  --}}
                                    <tr id="tr-total">
                                        <td class="align-middle pb-0">
                                        @if(!isset($isUpdate) || $isUpdate != "Show")
                                            <label class="form-control-label">Edit Column</label>
                                        @endif
                                        </td>
                                        <td class="align-middle pb-0">
                                        @if(!isset($isUpdate) || $isUpdate != "Show")

                                            <div class="custom-checkbox custom-control mb-3">
                                                <input class="custom-control-input" id="taxCb" value="5" type="checkbox" checked>
                                                <label class="custom-control-label" for="taxCb">
                                                  <span>Tax</span>
                                                </label>
                                            </div>
                                            <div class="custom-checkbox custom-control mb-3">
                                                <input class="custom-control-input" id="discountCb" value="7" type="checkbox" checked>
                                                <label class="custom-control-label" for="discountCb">
                                                    <span>Subtotal + Discount</span>
                                                </label>
                                            </div>
                                        @endif
                                        </td>
                                        <td class="text-right border-right-0 align-middle pb-0 pr-0">
                                            <strong class="document-total-span">Total</strong>
                                        </td>
                                        <td class="text-right align-middle long-texts pb-0 pr-0">
                                            <div class="input-group">
                                                <input type="number" class="form-control text-right" name="total"
                                                    id="total" placeholder="0.00" readonly />
                                                <div class="input-group-append">
                                                    <span class="input-group-text">$</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="border-top-0 pt-0 pb-0" style="max-width: 40px;"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Description  --}}
                <div class="row embed-card-body-footer">
                    <div class="form-group col-md-12 embed-acoordion-textarea">
                        <label for="description" class="form-control-label">Description</label>
                        <textarea class="form-control embed-card-body-footer-textarea" placeholder="Enter Description (100 characters)"
                            rows="4" name="description" id="description" maxlength="100">{{ $description }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Save/Cancel  --}}
        <div class="card">
            <div class="card-footer">
                <div class="row save-buttons">
                    <div class="col-md-12">
                        <a href="/bills/index" class="btn btn-success">Cancel</a>
                        @if(!isset($isUpdate) || $isUpdate != "Show")
                            <button type="reset" class="btn btn-danger">Reset</button>
                            <button type="submit" class="btn btn-info">Save</button>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        //add chosing class
    function chosing(e) {
        e.closest("div").classList.add("chosing");
    };

    $(document).ready(function() {

        // table row
        row = 1;
        var oldRow = {{ $tableRow }};

        // add Row
        addRow = function(){
            row++;
            $("#product-rows").append($(".prorow-copy").clone().removeClass().show());
            $('#product-rows').find('.prorow-copy').detach().appendTo('#product-rows');
            $('#product-rows').find('#addItem').detach().appendTo('#product-rows');
            $('#tableRow').val(row);
        }

        // Write Row Number
        rowcnt=function(){
            i = 0;
            while(i<row){
                i++;
                var addclass = "prorow" + i;
                $("#product-rows tr:eq("+ (i-1) +")").removeClass().addClass(addclass);
                $(".prorow" + i + " td:eq(0)").html(i);
            }
        }


        var getOldValue = function(){
            //Show Old Customer
            if({{ $vendorID }} >0){
                $('.cusDiv').hide();
                $("#cusInfo{{ $vendorID }}").show();
                $('.modal').modal('hide');
            }

            // Create old Table Row
            while(row < oldRow){
                addRow();
            }
            rowcnt();

            // Get old Value
            @php
            $rowVal = 0;
            while($rowVal < $tableRow){
                $rowVal++;
                $j = $rowVal - 1;
                echo "$('.prorow" .$rowVal. " td:eq(1) #detailID').val(".$detailID[$j].");";
                echo "$('.prorow" .$rowVal. " td:eq(1) #productID').val(".$productID[$j].");";
                echo "$('.prorow" .$rowVal. " td:eq(1) button').html('".$productName[$j]."');";
                echo "$('.prorow" .$rowVal. " td:eq(2) input').val(".$quantity[$j].");";
                echo "$('.prorow" .$rowVal. " td:eq(3) input').val(".$price[$j].");";
                echo "$('.prorow" .$rowVal. " td:eq(4) input').val(".$tax[$j].");";
                echo "$('.prorow" .$rowVal. " td:eq(6) input').val(".$discount[$j].");";
            }
            @endphp
        }

        //remove chosing class
        $('#proModal').on('hidden.bs.modal', function() {
            $(".chosing").removeClass("chosing");
        });

        // Calc subtotal, amount, total
        calc = function() {
            var i = 1;
            var total = 0;
            while (i <= row) {
                var quantity = $(".prorow" + i + " td:eq(2) input[type='number']").val();
                var price = $(".prorow" + i + " td:eq(3) input[type='number']").val();
                var tax = $(".prorow" + i + " td:eq(4) input[type='number']").val();
                var discount = $(".prorow" + i + " td:eq(6) input[type='number']").val();

                if (quantity * price >= 0) {
                    subtotal = quantity * price * (1 + tax / 100);
                    $(".prorow" + i + " td:eq(5) input[type='number']").val(subtotal.toFixed(2));
                    var amount = subtotal * (1 - discount / 100);
                    $(".prorow" + i + " td:eq(7) input[type='number']").val(amount.toFixed(2));
                    total += amount;
                    $("#total").val(total.toFixed(2));
                }
                i++;
            }
        }
        getOldValue();
        calc();

        // Auto Calculate
        $(".card").on('change keyup click', function() {
            calc();
        });

        //Add row Button
        $("#addItem").click(function() {
            addRow();
            rowcnt();
        });

        //Delete Row
        $(document).on('click', '#delete-items', function() {
            if (row > 1) {
                $(this).closest('tr').remove();
                row--;
                rowcnt();
                $('#tableRow').val(row);
                calc();
            }
            return false;
        });

        // reset button
        $("button[type='reset']").click(function() {
            setTimeout(function() {
                getOldValue();
                calc();
            }, 10);
        });

        //Delete copy row when submit
        $( "form" ).on( "submit", function() {
            $( ".prorow-copy" ).remove();
          });



        @if(isset($isUpdate) && $isUpdate == "Show")
            $("input").prop("disabled", true);
            $("button").prop("disabled", true);
        @endif

        $("input:checkbox").click(function(){
            var colVal = $(this).val();
            if(colVal == 7){
                $('#table-details td:nth-child(6), #table-details th:nth-child(6), #table-details col:eq(5)').toggle();
                $('#table-details td:nth-child(7),#table-details th:nth-child(7), #table-details col:eq(6)').toggle();
                $('#table-details td:nth-child(7) input').val(0);
            }else{
                $('#table-details td:nth-child('+colVal+'), #table-details th:nth-child('+colVal+'), #table-details col:eq('+(colVal-1)+')').toggle();
                $('#table-details td:nth-child('+colVal+') input').val(0);
            }
        });
    });

    </script>

    @if(!isset($isUpdate) || $isUpdate != "Show")
        {{-- Choose Purchase Order Modal  --}}
        <div class="modal fade" id="poModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Purchase Order List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="poTable" class="table">
                        <thead>
                            <tr>
                                <th>P.O ID</th>
                                <th>Customer Name</th>
                                <th>P.O Date</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                                <th>Choose</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pos as $po)
                            <tr>
                                <td style="width: 50%; white-space: normal;">{{ $po->purchaseorderID }}</td>
                                <td>{{ $po->vendorName }}</td>
                                <td>{{ $po->purchaseorderDate }}</td>
                                <td>{{ $po->productName }}</td>
                                <td>{{ $po->dquantity }}</td>
                                <td>${{ $po->price }}</td>
                                <td>${{ $po->total }}</td>
                                <td>
                                    <button type="button" class="btn btn-primary po{{ $po->purchaseorderID }}">
                                        <i class="fas fa-arrow-right"></i>
                                    </button>
                                </td>
                            </tr>
                            <script>
                                $(document).ready(function() {
                                    $(".po{{ $po->purchaseorderID }}").click(function(e) {
                                        $('.modal').modal('hide');
                                        $('#purchaseorderID').val({{ $po->purchaseorderID }});
                                        //Show Customer
                                        $('.cusDiv').hide();
                                        $("#cusInfo{{ $po->vendorID }}").show();
                                        $('#vendorID').val({{ $po->vendorID }});

                                        poRow = {{ count($pos->where('purchaseorderID',$po->purchaseorderID)) }}
                                        // Create Table Row
                                        while(row < poRow){
                                            addRow();
                                        }
                                        while(row > poRow){
                                            prorow = ".prorow" + row;
                                            $(prorow).remove();
                                            row--;
                                        }
                                        rowcnt();
                                        // Get Value

                                        @php
                                            $rowVal = 1;
                                            $j = $podetails->where('purchaseorderID',$po->purchaseorderID)->keys()->first();
                                            while($rowVal <= count($pos->where('purchaseorderID',$po->purchaseorderID))){
                                                echo "$('.prorow" .$rowVal. " td:eq(1) #productID').val(".$poProductID[$j].");";
                                                echo "$('.prorow" .$rowVal. " td:eq(1) button').html('".$poProductName[$j]."');";
                                                echo "$('.prorow" .$rowVal. " td:eq(2) input').val(".$poQuantity[$j].");";
                                                echo "$('.prorow" .$rowVal. " td:eq(3) input').val(".$poPrice[$j].");";
                                                echo "$('.prorow" .$rowVal. " td:eq(4) input').val(".$poTax[$j].");";
                                                echo "$('.prorow" .$rowVal. " td:eq(6) input').val(".$poDiscount[$j].");";
                                                $rowVal++;
                                                $j++;
                                            }
                                        @endphp
                                        calc();
                                    })
                                })

                            </script>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
        </div>
    @endif

@endsection


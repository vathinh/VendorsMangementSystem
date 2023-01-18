@extends('layouts.dashboard')
@section('title', 'Update Receivable')
@section('content')
@php
date_default_timezone_set("Asia/Bangkok");

@endphp

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <div class="card">

        <div class="row">
            <div class="col">

                <form action="" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            {{-- <div class="form-group col-md-6">
                                <label for="customerID" class="form-control-label">customer ID</label>
                                <div class="input-group input-group-merge ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-info-circle"></i>
                                        </span>
                                    </div>
                                    <input class="form-control" type="text" placeholder="Enter customer ID" name="customerID"id="customerID">
                                </div>
                            </div> --}}
                            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <div class="row">
                                    <div class="ml-3 document-contact-without-contact customerDiv">
                                        <div class="aka-box aka-box--large aka-select">
                                            <div class="document-contact-without-contact-box">
                                                <button type="button" class="btn-aka-link aka-btn--fluid document-contact-without-contact-box-btn" data-toggle="modal" data-target="#customerModal">
                                                    <i class="far fa-user fa-2x"></i> &nbsp; Choose a Customer
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    @foreach ($customers as $customer)
                                    <div id="info{{ $customer->customerID }}" class="ml-3 customerDiv" style="display: none">
                                        <div class="table-responsive">
                                            <table class="table table-borderless p-0">
                                                <tbody>
                                                    <tr>
                                                        <th class="p-0" style="text-align: left;"><strong class="d-block aka-text">{{ $customer->customerName }}</strong></th>
                                                    </tr>
                                                    <tr>
                                                        <th class="p-0" style="text-align: left; white-space: normal;">
                                                            {{ $customer->address }}
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th class="p-0" style="text-align: left;">
                                                            Tax number: {{ $customer->taxNumber }}
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th class="p-0" style="text-align: left;">
                                                            Phone: +{{ $customer->phone }}
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th class="p-0" style="text-align: left;">
                                                            Email: {{ $customer->email }}
                                                        </th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <button type="button" class="btn btn-link p-0" data-toggle="modal" data-target="#customerModal">
                                            Choose a different Customer
                                        </button>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <!-- Modal customers -->
                            <div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                <div class="modal-dialog modal-xl" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Customers List</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <table id="customerTable" class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Customer Name</th>
                                                        <th>Tax Number</th>
                                                        <th>Address</th>
                                                        <th>Choose</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($customers as $customer)
                                                    <tr>
                                                        <td>{{ $customer->customerName }}</td>
                                                        <td>{{ $customer->taxNumber }}</td>
                                                        <td>{{ $customer->address }}</td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary" id="customer{{ $customer->customerID }}">
                                                                <i class="fas fa-arrow-right"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <script>
                                                        $(document).ready(function() {
                                                            $("#customer{{ $customer->customerID }}").click(function() {
                                                                $('.customerDiv').hide();
                                                                $("#info{{ $customer->customerID }}").show();
                                                                $('.modal').modal('hide');
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
                            <div class="form-group col-md-6">
                                <label for="receivableDate" class="form-control-label">Receivable Date</label>

                                <div class="input-group input-group-merge ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i>
                                        </span>
                                    </div>
                                    <input type="date" class="form-control" placeholder="Enter Receivable Date"
                                        name="receivableDate" id="receivableDate">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="total" class="form-control-label">Total</label>

                                <div class="input-group input-group-merge ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-money-invoice"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Enter Total" name="total"
                                        id="total">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="paymentMethod" class="form-control-label">Payment Method</label>

                                <div class="input-group input-group-merge ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-dollar-sign"></i>
                                        </span>
                                    </div>
                                    <select class="custom-select" name="paymentMethod" id="paymentMethod">
                                        <option selected>Select Payment Method</option>
                                        <option value="Bank Transfer">Bank Transfer</option>
                                        <option value="Cash">Cash</option>

                                    </select>

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
                                    <input type="text" class="form-control" placeholder="Enter User ID" name="userID"
                                        id="userID">
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
                                    <input type="date" class="form-control" placeholder="Enter Created Date"
                                        name="createdDate" id="createdDate">
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
                                    <input type="date" class="form-control" placeholder="Enter Updated Date"
                                        name="updatedDate" id="updatedDate">
                                </div>
                            </div>
                                   {{-- table detail --}}
                            {{-- <div class="row document-item-body"> --}}
                                <div class="col-sm-12 p-0" style="table-layout: fixed;">
                                    {{-- Talbe  --}}
                                    <div class="table-responsive overflow-x-scroll overflow-y-hidden">
                                        <table class="table" style="table-layout: fixed;" id="">
                                            <colgroup>

                                                <col class="document-item-30">
                                                <col style="width: 60%">
                                                <col style="width: 20%">
                                                <col class="document-item-40-px">

                                            </colgroup>
                                            <thead class="thead-light">
                                                <tr>

                                                    <th class="text-center">InvoiceID</th>
                                                    <th class="text-center">Description</th>
                                                    <th class="text-center">Amount</th>
                                                    <th class="text-center"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="item-rows" class="table-padding-05">
                                                <tr id="a">


                                                    {{-- receivable ID --}}
                                                    <td class="align-middle px-1 text-center">
                                                        <div class="proDiv">
                                                            <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modelId">Choose Invoice ID                                        </button>
                                                        </div>
                                                    </td>
                                                    {{-- invoice ID --}}
                                                    {{-- <td class="px-1"><input type="text" class="form-control text-right" name="quantity1" id="quantity1" placeholder="0"></td> --}}
                                                    {{-- Description --}}
                                                    <td class="align-middle px-1">
                                                        <div class="input-group">
                                                            <input class="form-control text-right" name="price1" id="price1" placeholder="Enter description here....." />

                                                        </div>
                                                    </td>

                                                    {{-- Amount --}}
                                                    <td class="align-middle px-1">
                                                        <div class="input-group">
                                                            <input class="form-control text-right" name="amount1" id="amount1" placeholder="0.00"  />
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">VND</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    {{-- Delete Row --}}
                                                    <td class="align-middle px-1" id="delete-items">
                                                        <button type="button" class="btn btn-link btn-delete p-0"><i class="far fa-trash-alt"></i></button>
                                                    </td>
                                                </tr>

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
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        var row = 1;
                                        $("#addItem").click(function() {
                                            $("#item-rows").append($("#a").clone());
                                            $('#item-rows').find('#addItem').detach().appendTo('#item-rows');
                                            row++;
                                        });

                                        $(".form-control").on('change keyup click', function() {
                                            var quantity = $('#quantity1').val();
                                            var price = $('#price1').val();
                                            var tax = $('#tax1').val();
                                            var subtotal = price * quantity * (1 - tax / 100);
                                            var discount = $('#discount1').val();
                                            var amount = subtotal * (1 - discount / 100);
                                            var total = amount;
                                            console.log(amount);
                                            $('#subtotal1').val((subtotal).toFixed(2));
                                            $('#amount1').val((amount).toFixed(2));
                                            $('#total').val((amount).toFixed(2));
                                        });
                                        $(document).on('click', '#delete-items', function() {
                                            if (row > 1) {
                                                $(this).closest('tr').remove();
                                                row--;
                                            }
                                            return false;
                                        });
                                    });

                                </script>
                            {{-- </div> --}}
                            {{-- end table detail --}}
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row save-buttons">
                            <div class="col-md-12">
                                <button type="reset" class="btn btn-icon btn-primary">Cancel</button>
                                <a href="/receivables/index" class="btn btn-danger">Clear</a>
                                <button type="submit" class="btn btn-icon btn-success">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        {{-- Model customer --}}
         <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Product List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="customerTable" class="table">
                        <thead>
                            <tr>
                                <th>Invoice ID</th>
                                <th>customer ID</th>
                                <th>Invoice Date</th>
                                <th>Choose</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $b)
                            <tr>
                                <td>{{ $b->invoiceID }}</td>
                                <td>{{ $b->customerID }}</td>
                                <td>{{ $b->invoiceDate }}</td>
                                <td>
                                    <button type="button" class="btn btn-primary" id="invoice{{ $b->invoiceID }}">
                                        <i class="fas fa-arrow-right"></i>
                                    </button>
                                </td>
                            </tr>
                            <div id="info{{ $b->invoiceID }}" style="display: none">
                                <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modelId">
                                    invoice ID: {{ $b->invoiceID }}
                                </button>
                            </div>
                            <script>
                                $(document).ready(function() {
                                    $("#invoice{{ $b->invoiceID }}").click(function() {
                                        $('.proDiv').replaceWith($('#info{{ $b->invoiceID }}').clone().addClass("proDiv"));
                                        $('.proDiv').show();
                                        $('.modal').modal('hide');
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
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    {{-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script> --}}

@endsection

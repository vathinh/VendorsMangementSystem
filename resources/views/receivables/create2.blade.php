@extends('layouts.dashboard')
@section('title', 'New Receivable')
@section('content')
@php
date_default_timezone_set("Asia/Bangkok");

@endphp

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<div class="card">
    <div class="card-body">
        <form method="POST" action="" id="document">
            @csrf
            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="row">
                        <div class="ml-3 document-contact-without-contact cusDiv">
                            <div class="aka-box aka-box--large aka-select">
                                <div class="document-contact-without-contact-box">
                                    <button type="button" class="btn-aka-link aka-btn--fluid document-contact-without-contact-box-btn" data-toggle="modal" data-target="#cusModal">
                                        <i class="far fa-user fa-2x"></i> &nbsp; Add a customer
                                    </button>
                                </div>
                            </div>
                        </div>
                        @foreach ($customers as $cus)
                        <div id="cusInfo{{ $cus->customerID }}" class="ml-3 cusDiv" style="display: none">
                            <div class="table-responsive">
                                <table class="table table-borderless p-0">
                                    <tbody>
                                        <tr>
                                            <th class="p-0" style="text-align: left;"><strong class="d-block aka-text">{{ $cus->customerName }}</strong></th>
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
                            <button type="button" class="btn btn-link p-0" data-toggle="modal" data-target="#cusModal">
                                Choose a different customer
                            </button>
                        </div>
                        @endforeach
                    </div>
                </div>
                <!-- Modal Customers -->
                <div class="modal fade" id="cusModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
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
                                        @foreach ($customers as $cus)
                                        <tr>
                                            <td>{{ $cus->customerName }}</td>
                                            <td>{{ $cus->taxNumber }}</td>
                                            <td>{{ $cus->address }}</td>
                                            <td>
                                                <button type="button" class="btn btn-primary" id="cus{{ $cus->customerID }}">
                                                    <i class="fas fa-arrow-right"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <script>
                                            $(document).ready(function() {
                                                $("#cus{{ $cus->customerID }}").click(function() {
                                                    $('.cusDiv').hide();
                                                    $("#cusInfo{{ $cus->customerID }}").show();
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

                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="row mb-7">
                        {{-- Receivable Date  --}}
                        <div class="form-group col-md-6">

                            <label for="document_number" class="form-control-label">Receivable Date</label>
                            <div class="input-group input-group-merge ">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                </div>
                                <input type="date" class="form-control" name="document_number" id="document_number" value="{{ date("Y-m-d") }}">
                            </div>
                        </div>

                        {{-- Receivable ID  --}}
                        <div class="form-group col-md-6">
                            <label for="document_number" class="form-control-label">Receivable ID</label>
                            <div class="input-group input-group-merge ">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-file"></i>
                                    </span>
                                </div>
                                <input class="form-control" name="document_number" id="document_number" value="1201">
                            </div>
                        </div>
                        <div class="form-group col-md-6"></div>
                        <div class="form-group col-md-6">
                            <label for="document_number" class="form-control-label">Payment Method</label>
                            <div class="input-group input-group-merge ">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-file"></i>
                                    </span>
                                </div>
                                <select class="custom-select" name="" id="">
                                    <option value="1">Cash</option>
                                    <option value="2">Bank Transfer</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Choose invoice Modal  --}}
            <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">invoice List</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table id="invoiceTable" class="table">
                                <thead>
                                    <tr>
                                        <th>invoice Name</th>
                                        <th>Manufacture</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Choose</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rec as $rec)
                                    <tr>
                                        <td>{{ $rec->invoiceID }}</td>
                                        <td>{{ $rec->invoiceDate }}</td>
                                        <td>{{ $rec->customerName }}</td>
                                        <td>{{ $rec->total }}</td>
                                        <input type="hidden" id="invTotal{{ $rec->invoiceID }}" value="{{ $rec->total }}">

                                        <td>
                                            <button type="button" class="btn btn-primary" id="invoice{{ $rec->invoiceID }}">
                                                <i class="fas fa-arrow-right"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    {{-- Hidden invoice  --}}
                                    <div id="invInfo{{ $rec->invoiceID }}" style="display: none">
                                        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modelId">
                                            {{ $rec->invoiceID }}
                                        </button>
                                    </div>
                                    <script>
                                        $(document).ready(function() {
                                            $("#invoice{{ $rec->invoiceID }}").click(function() {
                                                $('.modal').modal('hide');
                                                $('.proDiv').replaceWith($('#invInfo{{ $rec->invoiceID }}').clone().addClass("proDiv"));
                                                $('.proDiv').show();
                                                $('#price1').val($('#invTotal{{ $rec->invoiceID }}').val());
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
            <div class="row document-item-body">
                <div class="col-sm-12 p-0" style="table-layout: fixed;">
                    {{-- Talbe  --}}
                    <div class="table-responsive overflow-x-scroll overflow-y-hidden">
                        <table class="table" style="table-layout: fixed;" id="">
                            <colgroup>
                                <col class="document-item-40-px">
                                <col class="document-item-30">
                                <col class="document-item-30">
                                <col class="document-item-30">
                                <col class="document-item-40-px">

                            </colgroup>
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center"></th>
                                    <th class="text-center">Invoice ID</th>
                                    <th class="text-center">Description</th>
                                    <th class="text-center">Amount</th>
                                    <th class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody id="item-rows" class="table-padding-05">
                                <tr id="a">
                                    {{-- ID --}}
                                    <td class="align-middle px-1"></td>
                                    {{-- Invoice --}}
                                    <td class="align-middle px-1 text-center">
                                        <div class="proDiv">
                                            <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modelId">
                                                Choose invoice
                                            </button>
                                        </div>
                                    </td>

                                    {{-- Description --}}

                                    <td class="align-middle px-1">
                                        <div class="input-group">
                                            <input class="form-control" name="disc1" id="disc1" placeholder="Enter description here....." />
                                        </div>
                                    </td>

                                    {{-- Amount --}}
                                    <td class="align-middle px-1">
                                        <div class="input-group">
                                            <input class="form-control text-right" name="amount1" id="amount1" placeholder="0.00" disabled="disabled" />
                                            <div class="input-group-append">
                                                <span class="input-group-text">$</span>
                                            </div>
                                        </div>
                                    </td>
                                    {{-- Delete Row --}}
                                    <td class="align-middle px-1" id="delete-items">
                                        <button type="button" class="btn btn-link btn-delete p-0"><i class="far fa-trash-alt"></i></button>
                                    </td>
                                </tr>

                                <tr id="addItem">
                                    <td colspan="5" class="text-right border-bottom-0 p-0">
                                        <div id="select-item-button-9" class="invoice-select">
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
            </div>

            <script>
                $(document).ready(function() {
                    //Add row
                    var row = 1;
                    $("#addItem").click(function() {
                        $("#item-rows").append($("#a").clone());
                        $('#item-rows').find('#addItem').detach().appendTo('#item-rows');
                        row++;
                    });
                    //Delete Row
                    $(document).on('click', '#delete-items', function() {
                        if (row > 1) {
                            $(this).closest('tr').remove();
                            row--;
                        }
                        return false;
                    });
                    // Calc subtotal, amount, total
                    $(".form-control").on('change keyup click', function() {
                        var amount = $('#amount1').val();
                        var total = amount;
                        console.log(amount);
                        $('#total').val((amount).toFixed(2));
                    });
                });

            </script>

            {{-- End Add Item  --}}

            <div class="row document-item-body">
                <div class="col-sm-12 mb-4 p-0">
                    <div class="table-responsive overflow-x-scroll overflow-y-hidden">
                        <table id="totals" class="table">
                            <colgroup>
                                <col class="document-total-50">
                                <col class="document-total-30">
                                <col class="document-total-25">
                                <col class="document-total-50-px">
                            </colgroup>
                            <tbody id="invoice-total-rows" class="table-padding-05">
                                {{-- Total  --}}
                                <tr id="tr-total">
                                    <td class="border-top-0 pt-0 pb-0"></td>
                                    <td class="text-right border-top-0 border-right-0 align-middle pt-0 pb-0 pr-0">
                                        <strong class="document-total-span">Total</strong>
                                    </td>
                                    <td class="text-right border-top-0 long-texts pt-0 pb-0 pr-3">
                                        <div class="input-group">
                                            <input class="form-control text-right" name="total" id="total" placeholder="0.00" disabled="disabled" />
                                            <div class="input-group-append">
                                                <span class="input-group-text">$</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="border-top-0 pt-0 pb-0" style="max-width: 50px;"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- Description  --}}

            <div class="row embed-card-body-footer">
                <div class="form-group col-md-12 embed-acoordion-textarea">
                    <label for="notes" class="form-control-label">Description</label>

                    <textarea class="form-control embed-card-body-footer-textarea" data-name="notes" placeholder="Enter Notes" v-model="form.notes" rows="3" name="notes" cols="50" id="notes"></textarea>

                    <div class="invalid-feedback d-block" v-if="form.errors.has(&quot;notes&quot;)" v-html="form.errors.get(&quot;notes&quot;)">
                    </div>
                </div>
            </div>
    </div>
</div>

{{-- Save/Cancel  --}}
<div class="card">
    <div class="card-footer">
        <div class="row save-buttons">
            <div class="col-md-12">
                <button href="" class="btn btn-success">Cancel</button>
                <button type="reset" class="btn btn-danger">Reset</button>
                <button type="submit" class="btn btn-info">Save</button>
            </div>
        </div>
        </form>
    </div>
</div>

@endsection

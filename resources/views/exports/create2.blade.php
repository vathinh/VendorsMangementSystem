@extends('layouts.dashboard')
@section('title', 'Create new Export sheet')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <div class="card">

        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <div class="row">
                    <div class="ml-3 document-contact-without-contact billDiv">
                        <div class="aka-box aka-box--large aka-select">
                            <div class="document-contact-without-contact-box">
                                <button type="button" class="btn-aka-link aka-btn--fluid document-contact-without-contact-box-btn" data-toggle="modal" data-target="#billModal">
                                    <i class="far fa-clipboard fa-2x"></i> &nbsp; Choose from invoices
                                </button>
                            </div>
                        </div>
                    </div>

                    @foreach ($joinbill as $jb)
                    <div id="info{{ $jb->invoiceID }}" class="ml-3 billDiv" style="display: none">
                        <div class="table-responsive">
                            <table class="table table-borderless p-0">
                                <tbody>
                                    <tr>
                                        <th class="p-0" style="text-align: center;font-size: 2rem"><strong class="d-block aka-text">Invoice N.o {{ $jb->invoiceID }}</strong></th>
                                    </tr>
                                    <tr>
                                        <th class="p-0" style="text-align: left; white-space: normal;font-size: 1.2rem">
                                            <span style="font-weight: bold">Customer: </span>{{ $jb->customerName }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="p-0" style="text-align: left;font-size: 1.2rem">
                                            Bill date: {{ $jb->invoiceDate }}
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                        </div><br>
                        <button type="button" style="font-size: 1.2rem" class="btn btn-link p-0" data-toggle="modal" data-target="#billModal">
                            Choose a different bill
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Modal Bills -->
            <div class="modal fade" id="billModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Bills List</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table id="" class="display">
                                <thead>
                                    <tr>
                                        <th>Bill ID</th>
                                        <th>Vendor Name</th>
                                        <th>Bill Date</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($joinbill as $jb)
                                    <tr>
                                        <td>{{ $jb->invoiceID }}</td>
                                        <td>{{ $jb->customerName }}</td>
                                        <td>{{ $jb->invoiceDate }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary" id="bill{{ $jb->invoiceID }}">
                                                <i class="fas fa-arrow-right"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <script>
                                        $(document).ready(function() {
                                            $("#bill{{ $jb->invoiceID }}").click(function() {
                                                $('.billDiv').hide();
                                                $("#info{{ $jb->invoiceID }}").show();
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
                <div class="row mb-4 mt-4 mr-2">
                    {{-- Import Date  --}}
                    <div class="form-group col-md-6 required">

                        <label for="document_number" class="form-control-label">Export Date</label>
                        <div class="input-group input-group-merge ">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                            <input type="date" class="form-control" name="document_number" id="addImpDate" value="{{ date("Y-m-d") }}">
                        </div>
                    </div>

                    {{-- Import Number  --}}
                    <div class="form-group col-md-6 required">
                        <label for="document_number" class="form-control-label">Export Number</label>
                        <div class="input-group input-group-merge ">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-file"></i>
                                </span>
                            </div>
                            <input class="form-control" name="document_number" id="document_number" value="12201">
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 p-0" style="table-layout: fixed;">
                {{-- Talbe  --}}
                <div class="table-responsive overflow-x-scroll overflow-y-hidden">
                    <table class="table" style="table-layout: fixed;" id="">
                        <colgroup>

                            <col class="document-item-30" style="width: 60%">
                            <col style="width: 20%">
                            <col style="width: 20%">
                            <col class="document-item-40-px">

                        </colgroup>
                        <thead class="thead-light">
                            <tr>

                                <th class="text-center" style="font-size: 1.2rem">Product Name</th>
                                <th class="text-center" style="font-size: 1.2rem">Manufacture</th>
                                <th class="text-center" style="font-size: 1.2rem">Amount</th>
                                <th class="text-center" style="font-size: 1.2rem"></th>
                            </tr>
                        </thead>
                        <tbody id="item-rows" class="table-padding-05">
                            <tr id="a">


                                {{-- Payable ID --}}
                                <td class="align-middle px-1 text-center">
                                    <div class="proDiv">
                                        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modelId">
                                            Choose Product                                                   </button>
                                    </div>
                                </td>
                                {{-- Bill ID --}}
                                {{-- Description --}}
                                <td class="align-middle px-1">
                                    <div class="input-group">
                                        <input class="form-control text-right" name="price1" id="price1" value="" />

                                    </div>
                                </td>

                                {{-- Amount --}}
                                <td class="align-middle px-1">
                                    <div class="input-group">
                                        <input class="form-control text-right" name="amount1" id="amount1" placeholder="0.00" />
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
        </div>

    {{-- Model Product List --}}
    <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Product List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Manufacture</th>
                                <th>Quantity</th>
                                <th>Choose</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $pro)
                            <tr>
                                <td>{{ $pro->productName }}</td>
                                <td>{{ $pro->manufacture }}</td>
                                <td>{{ $pro->quantity }}</td>
                                <td>
                                    <button type="button" class="btn btn-primary" id="pro{{ $pro->productID }}">
                                        <i class="fas fa-arrow-right"></i>
                                    </button>
                                </td>
                            </tr>
                            <div id="detail{{ $pro->productID }}" style="display: none">
                                <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modelId">
                                    {{ $pro->productName }}
                                </button>
                            </div>
                            <script>
                                $(document).ready(function() {
                                    $("#pro{{ $pro->productID }}").click(function() {
                                        $('.proDiv').replaceWith($('#detail{{ $pro->productID }}').clone().addClass("proDiv"));
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

{{--  Datatable script  --}}
<script>
    $(document).ready(function() {
        $('table.display').DataTable();
    });
</script>
@endsection

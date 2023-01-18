@extends('layouts.dashboard')
@section('title')
@if(isset($isUpdate))
{{ $isUpdate }} Payable
@else
New Payable
@endif
@endsection
@section('content')

@php
    date_default_timezone_set("Asia/Bangkok");
    if(isset($isUpdate)){
        $newID = 1;
    }
    if(isset($isUpdate) && old('tableRow') == null){
    //Payable
        $payableID = $payables->payableID;
        $vendorID = $payables->vendorID;
        $dt = new DateTime($payables->payableDate);
        $payableDate = $dt->format('Y-m-d');
        $paymentMethod = $payables->paymentMethod;
        $description = $payables->description;
        $tableRow = count($details);

    //Details
    foreach ($details as $detail) {
        $detailID[] = $detail->payabledetailsID;
        $billID[] = $detail->billID;
        $billIDShow[] = "Bill No." .$detail->billID;
        $notes[] = $detail->notes;
        $amount[] = $detail->amount;
    }
    }else{
        $detailID[] = 0;
        $payableID = old('payableID',$newID);
        // 1st row old value
        $vendorID = old('vendorID',0);
        $payableDate = old('payableDate',date("Y-m-d"));
        $paymentMethod = old('paymentMethod',0);
        $description = old('description');


        $billID[] = old('billID.0',0);
        $billIDShow[] = old('billIDShow.0',"Choose Bill");
        $notes[] = old('notes.0');
        $amount[] = old('amount.0',0);

        // row+1 value
        $tableRow = old('tableRow',1);
    }

    if($tableRow > 1){
        $i = 1;
        while($i< $tableRow){
            $billID[]=old('billID.'.$i);
            $billIDShow[]= "Bill No." .old('billID.'.$i);
            $notes[]=old('notes.'.$i);
            $amount[]=old('amount.'.$i);
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
            $('#billTable').DataTable({
                paging: false,
                responsive: true,
                "initComplete": function (settings, json) {
                    $(this).wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
                }
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

                            <div class="ml-3 document-contact-without-contact cusDiv" id="cusDiv">
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
                                                <td style="width: 40%; white-space: normal;">{{ $cus->vendorName }}
                                                </td>
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
                                                    $('#vendorID').val({{ $cus->vendorID }});
                                                    $('.modal').modal('hide');

                                                    $('#billTable').DataTable().column( 1 ).search("{{ $cus->vendorName }}").draw();

                                                    @php
                                                        $rowVal = 0;
                                                        while($rowVal < $tableRow){
                                                            $rowVal++;
                                                            $j = $rowVal - 1;
                                                            echo "$('.prorow" .$rowVal. " td:eq(1) #detailID').val(0);";
                                                            echo "$('.prorow" .$rowVal. " td:eq(1) #billID').val(0);";
                                                            echo "$('.prorow" .$rowVal. " td:eq(1) button').html('Choose Bill');";
                                                            echo "$('.prorow" .$rowVal. " td:eq(2) input').val('');";
                                                            echo "$('.prorow" .$rowVal. " td:eq(3) input').val(0);";
                                                        }
                                                    @endphp
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
                            {{-- Payable Date  --}}

                            <div class="form-group col-md-6">
                                <label for="document_number" class="form-control-label">Payable Date</label>
                                <div class="input-group input-group-merge ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                    </div>
                                    <input type="date" class="form-control" name="payableDate"
                                        value="{{ $payableDate }}">
                                </div>
                            </div>

                            {{-- Payable ID  --}}
                            <div class="form-group col-md-6">
                                <label for="document_number" class="form-control-label">Payable ID</label>
                                <div class="input-group input-group-merge ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text blocked hidden">
                                            <i class="fa fa-file"></i>
                                        </span>
                                    </div>
                                    <input class="form-control pl-3" name="payableID" id="payableID"
                                        value="{{ $payableID }}" readonly>
                                </div>
                            </div>

                            <div class="form-group col-md-6"></div>
                            <div class="form-group col-md-6">
                                <label for="document_number" class="form-control-label">Payment Method</label>
                                <div class="input-group input-group-merge ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-money-bill-wave"></i></i>
                                        </span>
                                    </div>
                                    <select class="custom-select" name="paymentMethod">
                                        <option value="1">Cash</option>
                                        <option value="2">Bank Transfer</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Choose Bill Modal  --}}
                <div class="modal fade" id="proModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
                    aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Bill List</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <table id="billTable" class="table">
                                    <thead>
                                        <tr>
                                            <th>Bill ID</th>
                                            <th>Customer Name</th>
                                            <th>Total</th>
                                            <th>Choose</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bills as $bill)
                                        <tr>
                                            <td>Bill No.{{ $bill->billID }}</td>
                                            <td>{{ $bill->vendorName }}</td>
                                            <td>{{ $bill->total }}</td>
                                            <td>
                                                <button type="button" class="btn btn-primary"
                                                    id="bill{{ $bill->billID }}">
                                                    <i class="fas fa-arrow-right"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        {{-- Hidden Bill  --}}

                                        <div id="proInfo{{ $bill->billID }}" style="display: none">
                                            <button type="button" style="width: 100%; white-space: normal;"
                                                class="btn btn-outline-primary proBtn" data-toggle="modal"
                                                data-target="#proModal" onclick="chosing(this)">
                                                Bill No.{{ $bill->billID }}
                                            </button>
                                        </div>
                                        <script>
                                            $(document).ready(function() {
                                            $("#bill{{ $bill->billID }}").click(function(e) {
                                                $(".chosing").closest("tr").find("input[id=amount]").val({{ $bill->total }});
                                                $(".chosing").closest("td").find("input[id=billID]").val({{ $bill->billID }});
                                                $('.modal').modal('hide');
                                                $('.chosing').replaceWith($('#proInfo{{ $bill->billID }}').clone().addClass("billDiv"));
                                                $('.billDiv').show();

                                                $('.cusDiv').hide();
                                                $("#cusInfo{{ $bill->vendorID }}").show();
                                                $('#vendorID').val({{ $bill->vendorID }});
                                                $('#billTable').DataTable().column( 1 ).search("{{ $bill->vendorName }}").draw();


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
                                    <col class="document-item-40-px">
                                    <col class="document-item-30">
                                    <col class="document-item-30">
                                    <col class="document-item-30">
                                    <col class="document-item-40-px">
                                </colgroup>
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center"></th>
                                        <th class="text-center">Bill ID</th>
                                        <th class="text-center">Notes</th>
                                        <th class="text-center">Amount</th>
                                        <th class="text-center"></th>
                                    </tr>
                                </thead>
                                <tbody id="bill-rows" class="table-padding-05">
                                    <tr class="prorow1">
                                        {{-- No. --}}
                                        <td class="align-middle text-center px-1" style="font-weight: 600">
                                            1
                                        </td>
                                        {{-- Bill --}}
                                        <td class="align-middle px-1 text-center">
                                            <input type="hidden" name="detailID[]" id="detailID" value="0">
                                            <input type="hidden" name="billID[]" id="billID"
                                                value="{{ $billID[0] }}">
                                            <div class="billDiv">
                                                <button type="button" style="width: 100%; white-space: normal;"
                                                    class="btn btn-outline-primary proBtn" data-toggle="modal"
                                                    data-target="#proModal" onclick="chosing(this)">
                                                    {{ $billIDShow[0] }}
                                                </button>
                                            </div>
                                        </td>
                                        {{-- Notes --}}
                                        <td class="align-middle px-1">
                                            <div class="input-group">
                                                <input type="text" class="form-control text-right" name="notes[]"
                                                    placeholder="Enter Notes" value="{{ $notes[0] }}">
                                            </div>
                                        </td>
                                        {{-- Amount --}}
                                        <td class="align-middle px-1">
                                            <div class="input-group">
                                                <input type="number" class="form-control text-right" name="amount[]"
                                                    id="amount" placeholder="0.00" value="{{ $amount[0] }}" readonly/>
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
                                        {{-- Bill --}}
                                        <td class="align-middle px-1 text-center">
                                            <input type="hidden" name="detailID[]" id="detailID" value="0">
                                            <input type="hidden" name="billID[]" id="billID" value="0">
                                            <div class="billDiv">
                                                <button type="button" style="width: 100%; white-space: normal;"
                                                    class="btn btn-outline-primary proBtn" data-toggle="modal"
                                                    data-target="#proModal" onclick="chosing(this)">
                                                    Choose Bill
                                                </button>
                                            </div>
                                        </td>
                                        {{-- Notes --}}
                                        <td class="align-middle px-1">
                                            <input type="text" class="form-control text-right" name="notes[]"
                                                placeholder="Enter Notes">
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
                                            <div id="select-item-button-9" class="bill-select">
                                                <div class="item-add-new">
                                                    <button type="button" class="btn btn-link w-100">
                                                        <i class="fas fa-plus-circle"></i> &nbsp; Add new Row
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

                                        </td>
                                        <td class="align-middle pb-0">

                                        </td>
                                        <td class="text-right border-right-0 align-middle pb-0 pr-0 pt-4">
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
                        <textarea class="form-control embed-card-body-footer-textarea"
                            placeholder="Enter Description (100 characters)" rows="4" name="description"
                            id="description" maxlength="100">{{ $description }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Save/Cancel  --}}
        <div class="card">
            <div class="card-footer">
                <div class="row save-buttons">
                    <div class="col-md-12">
                        <a href="/payables/index" class="btn btn-success">Cancel</a>
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
        var row = 1;
        var oldRow = {{ $tableRow }};

        // add Row
        var addRow = function(){
            row++;
            $("#bill-rows").append($(".prorow-copy").clone().removeClass().show());
            $('#bill-rows').find('.prorow-copy').detach().appendTo('#bill-rows');
            $('#bill-rows').find('#addItem').detach().appendTo('#bill-rows');
            $('#tableRow').val(row);
        }

        // Write Row Number
        var rowcnt=function(){
            i = 0;
            while(i<row){
                i++;
                var addclass = "prorow" + i;
                $("#bill-rows tr:eq("+ (i-1) +")").removeClass().addClass(addclass);
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
                echo "$('.prorow" .$rowVal. " td:eq(1) #billID').val(".$billID[$j].");";
                echo "$('.prorow" .$rowVal. " td:eq(1) button').html('".$billIDShow[$j]."');";

                echo "$('.prorow" .$rowVal. " td:eq(2) input').val(".$notes[$j].");";
                echo "$('.prorow" .$rowVal. " td:eq(3) input').val(".$amount[$j].");";
            }
            @endphp
        }

        //remove chosing class
        $('#proModal').on('hidden.bs.modal', function() {
            $(".chosing").removeClass("chosing");
        });

        // Calc subtotal, amount, total
        var calc = function() {
            var i = 1;
            var total = 0;
            while (i <= row) {
                var amount = $(".prorow" + i + " td:eq(3) input[type='number']").val();
                if (amount > 0) {
                    total += amount*1;
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
                $('.cusDiv').hide();
                $('#cusDiv').show();
                $('#vendorID').val(0);
                $('#billTable').DataTable().column(1).search("").draw();
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
            $("select").prop("disabled", true);
        @endif
        @if(isset($isUpdate) && $isUpdate == "Update")
            $('#billTable').DataTable().column( 1 ).search("{{ $payables->vendorName }}").draw();
        @endif

    });

    </script>

    @endsection

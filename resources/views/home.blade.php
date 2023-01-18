@extends('layouts.dashboard')
@section('title', 'Welcome To SAS Company')
@section('content')
<div class="container-fluid">
    <div class="row">
        {{-- income --}}
        <div id="widget-1" class="col-md-4">
            <div class="card bg-gradient-info card-stats">

                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="text-uppercase text-white mb-0">Total Income</h5>
                            <span class="font-weight-bold text-white mb-0">${{$receivable}}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-white text-info rounded-circle shadow">
                                <i class="fa fa-money-bill"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-sm cursor-default">
                        <span class="text-white">Receivables</span>
                        <span class="el-tooltip text-white font-weight-bold float-right"
                            aria-describedby="el-tooltip-9771" tabindex="0">
                            ${{$invoice}} / ${{$unpaidrec}}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        {{-- expenses --}}
        <div id="widget-2" class="col-md-4">
            <div class="card bg-gradient-danger card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="text-uppercase text-white mb-0">Total Expenses</h5>
                            <span class="font-weight-bold text-white mb-0">${{$payable}}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-white text-danger rounded-circle shadow">
                                <i class="fa fa-shopping-cart"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-sm cursor-default">
                        <span class="text-white">Payables</span>
                        <span class="el-tooltip text-white font-weight-bold float-right"
                            aria-describedby="el-tooltip-112" tabindex="0">${{$bill}} / ${{$unpaidpay}}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        {{-- profit --}}

        <div id="widget-3" class="col-md-4">
            <div class="card bg-gradient-success card-stats">

                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="text-uppercase text-white mb-0">Total Profit</h5>
                            <span class="font-weight-bold text-white mb-0">${{$realprofit}}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-white text-success rounded-circle shadow">
                                <i class="fa fa-heart"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-sm cursor-default">
                        <span class="text-white">Upcoming</span>
                        <span class="el-tooltip text-white font-weight-bold float-right"
                            aria-describedby="el-tooltip-6827" tabindex="0">${{$profit}}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="row">
        <div class="col">
            <form autocomplete="off">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <p>From: <input type="date" id="datepicker" class="form-control" value="{{ date('Y-m-d', strtotime('-30 days')) }}"></p>
                            <button type="button" id="btn-dashboard-filter" class="btn btn-success btn-sm"><i
                                    class="fa fa-filter" aria-hidden="true"> Filter Value</i></button>
                            <button type="reset" id="btn-dashboard-reset" class="btn btn-danger btn-sm"><i
                                    class="fa fa-power-off" aria-hidden="true"> Reset</i></button>
                        </div>
                        <div class="col-md-3">
                            <p>To: <input type="date" id="datepicker2" class="form-control" value="{{ date('Y-m-d') }}"></p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-12">
        <div id="myfirstchart" style="height: 250px"></div>
    </div>
</div>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<!-- Morris Bar -->
<script>
    $(document).ready(function(){
    chart30daysorder();

    var chart = new Morris.Bar({
        element: 'myfirstchart',
        lineColors: ['#819C79' , '#fc8710' , '#FF6541' , '#A4ADD3' , '#766856'],
        pointFillColors: ['#ffffff'],
        pointStrokeColors: ['black'],
        fillOpacity: 0.6,
        hideHover: 'auto',
        parseTime: false,
        xkey: 'period',
        ykeys: ['order' , 'sales' , 'profit' , 'quantity'],
        behaveLikeLine: true,
        labels: ['order' , 'sales' , 'profit' ,'quantity']
    });


    function chart30daysorder(){
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "{{ url('/days-order') }}",
            method: "POST",
            dataType: "JSON",
            data:{
                _token:_token
            },

            success:function(data){
                chart.setData(data);
            }
        });
    }

    $('#btn-dashboard-filter').click(function(){
        var _token = $('input[name="_token"]').val();
        var from_date = $('#datepicker').val();
        var to_date = $('#datepicker2').val();
        $.ajax({
            url: "{{url('/filter-by-date')}}",
            method: "POST",
            dataType: "JSON",
            data: {
                from_date:from_date,
                to_date:to_date,
                _token:_token
            },
            success:function(data){
                chart.setData(data);
            }
        });
    });

    $('.dashboard-filter').change(function(){
        var dashboard_value = $(this).val();
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: "{{url('/dashboard-filter')}}",
            method: "POST",
            dataType: "JSON",
            data: {
                dashboard_value:dashboard_value,
                _token:_token
            },
            success:function(data){
                chart.setData(data);
            }
        });
    });
});
</script>
@endsection

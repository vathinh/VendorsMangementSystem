
@extends('layouts.dashboard')
@section('title', 'Reports Chart')
@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

<div class="card">
    <style type="text/css">
        p {
            font-size: 15px;
            font-weight: bold;
        }
    </style>

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
</div>


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
<!-- End Morris Bar -->

<div class="card">
    <div class="card-body">
        <table class="table">
            <tr>
                <th>Cates</th>
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
                <th>5</th>
                <th>6</th>
                <th>7</th>
                <th>8</th>
                <th>9</th>
                <th>10</th>
                <th>11</th>
                <th>12</th>
                <th>Total</th>
            </tr>
            <tr>
                <th>Profit</th>
                @php
                    $i = 0
                @endphp
                @while ($i<12)
                    <td>{{ $monthlyProfit[$i++] }}</td>
                @endwhile
                <td>{{ array_sum($monthlyProfit) }}</td>
            </tr>
            <tr>
                <th>Revenue</th>
                @php
                    $i = 0
                @endphp
                @while ($i<12)
                    <td>{{ $monthlyRev[$i++] }}</td>
                @endwhile
                <td>{{ array_sum($monthlyRev) }}</td>
            </tr>
            <tr>
                <th>Expense</th>
                @php
                    $i = 0
                @endphp
                @while ($i<12)
                    <td>{{ $monthlyExp[$i++] }}</td>
                @endwhile
                <td>{{ array_sum($monthlyExp) }}</td>
            </tr>
        </table>
    </div>
</div>


@endsection

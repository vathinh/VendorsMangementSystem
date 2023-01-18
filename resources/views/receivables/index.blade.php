@extends('layouts.dashboard')
@section('title', 'Receivables')
@section('addnew')
<a href="/receivables/create" class="btn btn-sm btn-info"><i class="fas fa-plus-square"></i> Add new</a>
@endsection
@section('content')
@if ($message = Session::get('success'))
<div class="alert alert-info alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Close</span>
    </button>
    <span>{{ $message }}</span>
</div>
@endif
<div class="card">
    <div class="card-body">
        <table id="receivableTable" class="display">
            <thead>
                <tr>
                    <th>Receivable ID</th>
                    <th>Customer Name</th>
                    <th>Receivable Date</th>
                    <th>Total</th>
                    <th>Payment Method</th>
                    @if (substr(session('user')[0]->role,-1)==1)
                    <th>Username Created</th>
                    @endif
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Receivable ID</th>
                    <th>Customer Name</th>
                    <th>Receivable Date</th>
                    <th>Total</th>
                    <th>Payment Method</th>
                    @if (substr(session('user')[0]->role,-1)==1)
                    <th>Username Created</th>
                    @endif
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>

                @foreach($rec as $r)
                <tr>
                    <td style="width: 10%">{{$r->receivableID}}</td>
                    <td style="width: 30%">{{$r->customerName}}</td>
                    <td>{{ substr($r->receivableDate,0,10) }}</td>
                    <td>{{$r->total}}</td>
                    <td style="width: 10%">
                        @if($r->paymentMethod == 2)
                        Bank Transfer
                        @else
                        Cash
                        @endif
                    {{-- 1: Cash, 2: Bank Transfer --}}
                    </td>

                    @if (substr(session('user')[0]->role,-1)==1)
                        <td style="width: 10%">{{$r->fullname}}</td>
                    @endif

                    <td class="text-center row" style="width: 100%">
                        <div class="mx-auto">
                            <a href="show/{{ $r->receivableID }}" class="btn btn-sm btn-info"><i
                                    class="fas fa-info"></i></a>
                        </div>

                        @if (substr(session('user')[0]->role,-1)==1)
                        <div class="mx-auto">
                            <a href="edit/{{ $r->receivableID }}" class="btn btn-sm btn-success"><i
                                    class="fas fa-edit"></i></a>
                        </div>
                        <div class="mx-auto">
                            <a href="delete/{{ $r->receivableID }}" class="delete btn btn-sm btn-danger"><i
                                    class="fas fa-trash"></i></a>
                        </div>
                        @endif

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
{{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"</script> --}}
<script>
    $(document).ready(function() {
        $('#receivableTable').DataTable();
    });

</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script>
    // confirm
    $(".delete").confirm({
        title: '<span style="color: red"><i class="fas fa-trash"></i>&nbsp; Delete Receivable</span>',
        content: "<span style='color: black; font-size: 14px'>Are you sure about delete this Receivable?</span>",
        type: 'red',
        typeAnimated: true,
        buttons: {
            confirm:{
                text: 'Yes I am',
                btnClass: 'btn-red',
                action: function () {
                location.href = this.$target.attr('href');
            }},
            cancel: function () {
            }
        }
    });

</script>

@endsection

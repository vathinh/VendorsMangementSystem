@extends('layouts.dashboard')
@section('title', 'Sale Orders')
@section('addnew')
<a href="/saleorders/create" class="btn btn-sm btn-info"><i class="fas fa-plus-square"></i> Add new</a>
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


        {{-- container --}}
        <table id="userTable" class="display">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th style="width: 20%">Customer Name</th>
                    <th>Date</th>
                    <th>Total</th>
                    @if (substr(session('user')[0]->role,-1)==1)
                    <th>User Name</th>
                    <th>Created Date</th>
                    <th>Updated Date</th>
                    @endif
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Date</th>
                    <th>Total</th>
                    @if (substr(session('user')[0]->role,-1)==1)
                    <th>User Name</th>
                    <th>Created Date</th>
                    <th>Updated Date</th>
                    @endif
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($saleorders as $so)
                <tr>
                    <td>{{ $so->orderID }}</td>
                    <td>{{ $so->customerName }}</td>
                    <td>{{ substr($so->saleorderDate,0,10) }}</td>
                    <td>{{ $so->total }}</td>
                    @if (substr(session('user')[0]->role,-1)==1)
                    <td>{{ $so->fullname }}</td>
                    <td>{{ $so->createdDate }}</td>
                    <td>{{ $so->updatedDate }}</td>
                    @endif
                    <td class="text-center">
                        <a href="show/{{ $so->orderID }}" class="btn btn-sm btn-info"><i class="fas fa-info"></i></a>
                    @if (substr(session('user')[0]->role,-1)==1)
                        <a href="edit/{{ $so->orderID }}" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a>
                        <a href="delete/{{ $so->orderID }}" class="delete btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                    @endif

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>

<script>
    $(document).ready(function() {
        $('#userTable').DataTable({
        });
    });
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script>

    // confirm
    $(".delete").confirm({
        title: '<span style="color: red"><i class="fas fa-trash"></i>&nbsp; Delete Sale Order</span>',
        content: "<span style='color: black; font-size: 14px'>Are you sure about delete this Sale Order?</span>",
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

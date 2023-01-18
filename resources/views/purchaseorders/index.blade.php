@extends('layouts.dashboard')
@section('title', 'Purchase Orders')
@section('addnew')
<a href="create" class="btn btn-sm btn-info"><i class="fas fa-plus-square"></i> Add new</a>

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
                    <th>P.O ID</th>
                    <th>Vendor Name</th>
                    <th>P.O Date</th>
                    <th>Total</th>
                    @if (substr(session('user')[0]->role,-1)==1)
                        <th>userID</th>
                        <th>Created Date</th>
                        <th>Updated Date</th>
                    @endif
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purchaseorders as $po)
                <tr>
                    <td class="text-center">{{ $po->purchaseorderID }}</td>
                    <td style="width: 25%; white-space: normal;">{{ $po->vendorName }}</td>
                    <td>{{ substr($po->purchaseorderDate,0,10) }}</td>
                    <td>{{ $po->total }}</td>

                    @if (substr(session('user')[0]->role,-1)==1)
                        <td>{{ $po->fullname }}</td>
                        <td>{{ $po->createdDate }}</td>
                        <td>{{ $po->updatedDate }}</td>
                    @endif

                    <td class="text-center row">
                        <div class="mx-auto">
                            <a href="show/{{ $po->purchaseorderID }}" class="btn btn-sm btn-info"><i
                                    class="fas fa-info"></i></a>
                        </div>

                    @if (substr(session('user')[0]->role,-1)==1)
                        <div class="mx-auto">
                            <a href="edit/{{ $po->purchaseorderID }}" class="btn btn-sm btn-success"><i
                                    class="fas fa-edit"></i></a>
                        </div>

                        <div class="mx-auto">
                            <a href="delete/{{ $po->purchaseorderID }}" class="delete btn btn-sm btn-danger"><i
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

<script>
    $(document).ready(function() {
        $('#userTable').DataTable();
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

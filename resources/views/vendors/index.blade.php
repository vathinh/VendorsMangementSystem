@extends('layouts.dashboard')
@section('title', 'Vendors')
@section('addnew')
<a href="/vendors/create" class="btn btn-sm btn-info"><i class="fas fa-plus-square"></i> Add new</a>
@endsection
@section('content')
@if (Session::has('success'))
<div class="alert alert-info alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Close</span>
    </button>
    {{ Session::get('success') }}
</div>
@endif
<div class="card">
    <div class="card-body">
        <table id="userTable" class="display">
            <thead>
                <tr>
                    <th>VendorID</th>
                    <th>VendorName</th>
                    <th>TaxNumber</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Unpaid</th>
                    <th>Active</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>VendorID</th>
                    <th>VendorName</th>
                    <th>TaxNumber</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Unpaid</th>
                    <th>Active</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($ven as $v)
                <tr>
                    <td>{{ $v->vendorID }}</td>
                    <td>{{ $v->vendorName }}</td>
                    <td>{{ $v->taxNumber }}</td>
                    <td>{{ $v->address }}</td>
                    <td>{{ $v->phone }}</td>
                    <td>{{ $v->email }}</td>
                    <td>${{ $v->unpaid }}</td>
                    <td class="text-center">
                        <a href="/vendors/checkstatus/{{$v->vendorID}}">{{$v->status?'Active':'Inactive'}}</a>
                    </td>
                    <td class="text-center">
                        <div class="row mx-auto my-auto">
                            <div class="mx-auto">
                                <a href="edit/{{ $v->vendorID }}" class="btn btn-sm btn-success">
                                    <i class="fas fa-edit"></i></a>
                            </div>
                            <div class="mx-auto">
                                <a href="delete/{{ $v->vendorID }}" class="delete btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i></a>
                            </div>
                        </div>
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

{{--  Delete Alert  --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script>
    $(".delete").confirm({
        title: '<span style="color: red"><i class="fas fa-trash"></i>&nbsp; Delete Vendor</span>',
        content: "<span style='color: black; font-size: 14px'>Are you sure about delete this Vendor?</span>",
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

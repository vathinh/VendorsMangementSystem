@extends('layouts.dashboard')
@section('title', 'Bills')
@section('addnew')
<a href="/bills/create" class="btn btn-sm btn-info"><i class="fas fa-plus-square"></i> Add new</a>
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
        <table id="billTable" class="display" style="width:100%">

            <thead>
                <tr>
                    <th>Bill ID</th>
                    <th>Bill Date</th>
                    <th>Vendor Name</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Bill ID</th>
                    <th>Bill Date</th>
                    <th>Vendor Name</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>

                @foreach($bi as $d)
                <tr>
                    <td>{{$d->billID}}</td>
                    <td>{{$d->billDate}}</td>
                    <td>{{$d->vendorName}}</td>
                    <td>{{$d->total}}</td>
                    <td class="text-center row">
                        <div class="mx-auto">
                            <a href="show/{{ $d->billID }}" class="btn btn-sm btn-info"><i
                                    class="fas fa-info"></i></a>
                        </div>

                        @if (substr(session('user')[0]->role,-1)==1)
                        <div class="mx-auto">
                            <a href="edit/{{ $d->billID }}" class="btn btn-sm btn-success"><i
                                    class="fas fa-edit"></i></a>
                        </div>

                        <div class="mx-auto">
                            <a href="delete/{{ $d->billID }}" class="delete btn btn-sm btn-danger"><i
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
        $('#billTable').DataTable();
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

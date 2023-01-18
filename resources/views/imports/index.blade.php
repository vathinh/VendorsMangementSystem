@extends('layouts.dashboard')
@section('title', 'Imports')
@section('addnew')
<a href="/imports/create" class="btn btn-sm btn-info"><i class="fas fa-plus-square"></i> Add new</a>
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
<table id="importTable" class="display">
    <thead>
        <tr>
            <th>Import ID</th>
            <th>Import Date</th>
            <th>Vendor Name</th>
            <th>Quantity</th>
            @if (substr(session('user')[0]->role,-1)==1)
                <th>User Created</th>
            @endif
            <th>Actions</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>Import ID</th>
            <th>Import Date</th>
            <th>Vendor Name</th>
            <th>Quantity</th>
            @if (substr(session('user')[0]->role,-1)==1)
                <th>User Created</th>
            @endif
            <th>Actions</th>
        </tr>
    </tfoot>
    <tbody>
        @foreach ($imports as $import)
        <tr>
            <td>{{$import->importID}}</td>
            <td>{{$import->importDate}}</td>
            <td>{{$import->vendorName}}</td>
            <td>{{$import->total}}</td>
            @if (substr(session('user')[0]->role,-1)==1)
                <td>{{$import->fullname}}</td>
            @endif
            <td class="text-center row">
                <div class="mx-auto">
                    <a href="show/{{ $import->importID }}" class="btn btn-sm btn-info"><i
                            class="fas fa-info"></i></a>
                </div>

                @if (substr(session('user')[0]->role,-1)==1)
                <div class="mx-auto">
                    <a href="edit/{{ $import->importID }}" class="btn btn-sm btn-success"><i
                            class="fas fa-edit"></i></a>
                </div>

                <div class="mx-auto">
                    <a href="delete/{{ $import->importID }}" class="delete btn btn-sm btn-danger"><i
                            class="fas fa-trash"></i></a>
                </div>
                @endif

            </td>
        </tr>
            @endforeach

    </tbody>

</table>


</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>

<script>
    $(document).ready(function() {
        $('#importTable').DataTable();
    });

</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script>
    // confirm
    $(".delete").confirm({
        title: '<span style="color: red"><i class="fas fa-trash"></i>&nbsp; Delete Export</span>',
        content: "<span style='color: black; font-size: 14px'>Are you sure about delete this Export?</span>",
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

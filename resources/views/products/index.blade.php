@extends('layouts.dashboard')
@section('title', 'Products List')
@section('addnew')
<a href="create" class="btn btn-sm btn-info"><i class="fas fa-plus-square"></i> Add new</a>
@endsection
@section('content')

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>

@if (Session::has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Close</span>
    </button>
    {{ Session::get('success') }}
</div>
@endif
<div class="card">
    <div class="card-body">
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>ProductID</th>
                    <th>ProductName</th>
                    <th>Manufacture</th>
                    <th>SalesPrice</th>
                    <th>PurchasePrice</th>
                    <th>Quantity</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Picture</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>ProductID</th>
                    <th>ProductName</th>
                    <th>Manufacture</th>
                    <th>SalesPrice</th>
                    <th>PurchasePrice</th>
                    <th>Quantity</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Picture</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>

                @foreach($pro as $p)
                <tr>
                    <td>{{$p->productID}}</td>
                    <td>{{$p->productName}}</td>
                    <td>{{$p->manufacture}}</td>
                    <td>${{$p->salesprice}}</td>
                    <td>${{$p->purchaseprice}}</td>
                    <td>{{$p->quantity}}</td>
                    <td>{{$p->category}}</td>
                    <td>{{$p->status}}</td>
                    <td><img src="/img/product/{{$p->picture}}" width="80px"></td>
                    <td>
                        <div class="row mx-auto my-auto">
                            <div class="mx-auto"><a href="edit/{{ $p->productID }}" class="btn btn-sm btn-success"><i
                                        class="fas fa-edit"></i></a></div>
                            <div class="mx-auto"><a href="delete/{{ $p->productID }}"
                                    class="delete btn btn-sm btn-danger"><i class="fas fa-trash"></i></a></div>
                        </div>

                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script>
    // confirm
        $(".delete").confirm({
            title: '<span style="color: red"><i class="fas fa-trash"></i>&nbsp; Delete Product</span>',
            content: "<span style='color: black; font-size: 14px'>Are you sure about delete this Product?</span>",
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

<script>
    $(document).ready(function() {
            $('#example').DataTable();
        } );
</script>


@endsection

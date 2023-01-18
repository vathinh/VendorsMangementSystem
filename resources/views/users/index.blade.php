@extends('layouts.dashboard')
@section('title', 'User List')
@section('addnew')

<a href="/users/create" class="btn btn-info btn-sm"><i class="fas fa-plus-square"></i> Add New</a>

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
                    <th>User ID</th>
                    <th>User Name</th>
                    <th>Admin</th>
                    <th>Fullname</th>
                    <th>Department</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Active</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->userID }}</td>
                    <td>{{ $user->userName }}</td>
                    <td>
                        @switch(substr($user->role,-1))
                        @case(1)
                        Admin
                        @break
                        @case(2)
                        User
                        @break
                        @endswitch
                    </td>
                    <td>{{ $user->fullname }}</td>

                    <td>
                        @switch(substr($user->role,0,-1))
                        @case("SA")
                        Sales
                        @break
                        @case("LO")
                        Logistics
                        @break
                        @case("HR")
                        Human Resources
                        @break
                        @case("AC")
                        Accounting
                        @break
                        @endswitch
                    </td>

                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>
                        @switch($user->active)
                        @case(1)
                        Active
                        @break
                        @case(2)
                        Inactive
                        @break
                        @case(3)
                        Block
                        @break
                        @endswitch
                        {{-- 1:Active, 2:Inactive, 3: Block --}}
                    </td>
                    <td class="text-center">
                        <div class="row">
                            <div class="mx-auto"><a href="edit/{{ $user->userID }}" class="btn btn-sm btn-success">
                                    <i class="fas fa-edit"></i></a></div>
                            <div class="mx-auto"><a href="delete/{{ $user->userID }}"
                                    class="delete btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i></a></div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>User ID</th>
                    <th>User Name</th>
                    <th>Admin</th>
                    <th>Fullname</th>
                    <th>Department</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Active</th>
                    <th>Action</th>
                </tr>
            </tfoot>
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
        title: '<span style="color: red"><i class="fas fa-trash"></i>&nbsp; Delete User</span>',
        content: "<span style='color: black; font-size: 14px'>Are you sure about delete this User?</span>",
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

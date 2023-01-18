{{--  @extends('layouts.dashboard')
@section('content')

    <!-- Bootstrap CSS datatable-->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    

<h1 style="text-align: center">BILLS DETAIL</h1>
    <hr>
    <div class="text-right mr-0 mb-2">
        
        <a href="/bills/index" class="btn btn-sm btn-danger"><i class="fas fa-power-off"></i> Back</a>
    </div>
    
    <table id="example" class="display" style="width:100%">
    
        <thead>
            <tr>
                <th>Bill ID</th>
                <th>Vendor ID</th>
                <th>Bill Date</th>
                <th>User ID</th>
                <th>Created Date</th>
                <th>Updated Date</th>
                
            </tr>
        </thead>
        <tbody>
            
                
                <tr >
                    <td>{{$bi->billID}}</td>
                    <td>{{$bi->vendorID}}</td>
                    <td>{{$bi->billDate}}</td>
                    <td>{{$bi->userID}}</td>
                    <td>{{$bi->createdDate}}</td>
                    <td>{{$bi->updatedDate}}</td>
                </tr>
               
                
               
        
            
        </tbody>
        
    </table>
    


    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        } );
    </script>

    
@endsection  --}}
@extends('layouts.dashboard')
@section('content')

<!-- Bootstrap CSS datatable-->
   <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

   <table id="warehouse" class="display" style="width:100%">
       <thead>
           <tr>
               <th>Product's ID</th>
               <th>Product's Name</th>
               <th>Category</th>
               <th>Manufacturer</th>
               <th>Quantity</th>
               <th>Status</th>
               <th>Image</th>
               <th>Actions</th>
           </tr>
       </thead>
       <tbody>
           @foreach ($warehouse as $wh)
           <tr{{--data-toggle="modal" data-target="#wh$wh->productID"--}}>
            <td>{{$wh->productID}}</td>
               <td>{{$wh->productName}}</td>
               <td>{{$wh->category}}</td>
               <td>{{$wh->manufacture}}</td>
               <td>{{$wh->quantity}}</td>
               <td>{{$wh->status}}</td>
               <td><img src="{{ asset('/img/'.$wh->productID.'.jpg') }}" width="50px"></td>
               <td>
                   <a href="/impDetail/delete/{{$wh ->productID}}" class="btn btn-outline-danger"  style="text-decoration: none">Delete</a>
               </td>
           </tr>
           {{-- <script>
               $(function(){
                   $('#orderModal').modal({
                       keyboard: true,
                       backdrop: "static",
                       show:false,
                   })
                   $(".table-striped").find('tr[data-target]').on('click', function(){
                   });

               });
            </script>


            <!-- Modal -->
            <div class="modal fade" id="wh{{$wh->productID}}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title mx-auto">{{$wh->productName}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-2 float-left">{{$wh->productID}}</div>
                                        <div class="col-2 float-left">{{$wh->productID}}</div>
                                        <div class="col-2 float-right offset-3">{{$wh->productName}}</div>
                                        <div class="col-2 float-right">{{$wh->quantity}}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-2">
                                           <a href="/impDetail/update/{{$wh->productID}}" class="btn btn-outline-primary btn-sm" style="text-decoration: none">Update&emsp;</a>
                                           <a href="/impDetail/delete/{{$wh->productID}}" class="btn btn-outline-danger btn-sm"  style="text-decoration: none">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div> --}}
            @endforeach

       </tbody>
   </table>


</body>
<script>
   $(document).ready(function() {
       $('#warehouse').DataTable();
   } );
   $( "#btn-modal" ).click(function() {
       $("#modelId").modal('show');
     });
</script>

@endsection

@extends('layouts.dashboard')
@section('title','NEW BILL')
@section('content')

<div class="card">

    <div class="row">
        <div class="col">
            <form action="" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                            <div class="form-group col-md-6">
                                <label for="vendorID" class="form-control-label">Vendor ID</label>
                                <div class="input-group input-group-merge ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-info-circle"></i>
                                        </span>
                                    </div>
                                    <input class="form-control" type="text" placeholder="Enter Vendor ID" name="vendorID" id="vendorID">
                                </div>
                            </div>
                    <div class="form-group col-md-6">
                        <label for="billDate" class="form-control-label">Bill Date</label>

                        <div class="input-group input-group-merge ">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                            <input type="date" class="form-control" placeholder="Enter Bill Date" name="billDate" id="billDate">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="userID" class="form-control-label">User ID</label>

                        <div class="input-group input-group-merge ">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-id-card"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" placeholder="Enter User ID" name="userID" id="userID">
                        </div>
                    </div>


                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row save-buttons">
                            <div class="col-md-12">
                                <button type="reset" class="btn btn-icon btn-danger">Clear</button>
                                <a href="/bills/index" class="btn btn-warning">Back</a>
                                <button type="submit" class="btn btn-icon btn-success">Submit</button>
                            </div>
                        </div>
                    </div>

            </form>
        </div>
    </div>
</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
</script>

@endsection

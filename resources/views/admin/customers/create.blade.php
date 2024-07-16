@extends('admin.layouts.app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Add New Customer</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
            <li class="breadcrumb-item"><a href="/customers">Customers</a></li>
            <li class="breadcrumb-item active">Add New Customer</li>
        </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-md-center">
            <div class="col col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header row">
                        <h3 class="card-title">Create New Customer</h3>
                    </div>

                    <form action="{{route('customers.store')}}" method="POST" name="create_customer" id="create_customer" class="">                    
                        <div class="card-body">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Enter Your First Name">
                            </div>

                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Enter Your Last Name">
                            </div>

                            <div class="form-group">
                                <label>Email ID</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email ID">
                            </div>

                            <div class="form-group">
                                <label>Mobile No</label>
                                <input type="tel" class="form-control" name="mobileno" id="mobileno" placeholder="Enter Mobile No">
                            </div>

                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password">
                            </div>

                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" class="form-control" name="cpassword" id="cpassword" placeholder="Enter Confirm Password">
                            </div>

                            <div class="form-group">
                                <label>Packages</label>
                                <select class="form-control" name="package" id="package">
                                    <option value="">--Select Package--</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <button type="button" class="btn btn-secondary">Cancel</button>
                            </div>
                        </div>
                    </form>
                    <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

@endsection

@push('scripts')
<!-- DataTables  & Plugins -->
<script src="{{ asset('/adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{ asset('/adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ asset('/adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{ asset('/adminlte/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{ asset('/adminlte/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{ asset('/adminlte/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{ asset('/adminlte/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{ asset('/adminlte/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{ asset('/adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>

<script>
  $(function () {
    $("#customers").DataTable({
      "responsive": true, 
      "lengthChange": false, 
      "autoWidth": false,
      "searching": true,
      "ordering": true,
      "buttons": ["copy", "csv", "excel", "pdf", "print"]
    }).buttons().container().appendTo('#customers_wrapper .col-md-6:eq(0)');
  });
</script>
@endpush
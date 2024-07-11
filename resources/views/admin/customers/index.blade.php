@extends('admin.layouts.app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Users</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
            <li class="breadcrumb-item active">Users</li>
        </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header row">
                        <div class="col-lg-3 col-md-12">
                                <a href="/customers/create" class="btn btn-block btn-primary"><i class="fa fa-plus"></i> Add New User</a>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <table id="customers" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Sr.no</th>
                                    <th>Customer Name</th>
                                    <th>Email</th>
                                    <th>Mobile No.</th>
                                    <th>Credits Purchased</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1.</td>
                                    <td>Trident</td>
                                    <td>example@exampple.com</td>
                                    <td>1234567890</td>
                                    <td>45</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</button>
                                            <button type="button" class="btn btn-info"><i class="fa fa-eye"></i> View</button>
                                            <button type="button" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
      //"buttons": ["copy", "csv", "excel", "pdf", "print"]
    }).buttons().container().appendTo('#customers_wrapper .col-md-6:eq(0)');
  });
</script>
@endpush
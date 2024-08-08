@extends('admin.layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Template</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Template</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-end align-items-center">
                        <a href="{{route('template.create')}}" class="btn btn-info add-template">Add New Template</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="data-table" class="table table-bordered table-striped" width="100%">
                                <thead>
                                    <tr>
                                        <th>Sr.no</th>
                                        <th>Template Name</th>
                                        <th>Category Name</th>
                                        <th>SubCategory Name</th>
                                        <th>No of file</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
<script>
    var countMember = 0;
</script>
<script src="{{asset('assets/js/addModel.js')}}"></script>
<script>
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            language: {
                searchPlaceholder: 'Search...',
                scrollX: "100%",
                sSearch: '',
            },
            ajax: {
                url: "{{ route('template.index') }}",
                type: 'GET'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'category.name',
                    name: 'category.name'
                },
                {
                    data: 'sub_category.name',
                    name: 'sub_category.name'
                },
                {
                    data: 'no_of_files',
                    name: 'no_of_files'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });

    $(document).on('click', '.delete-template,.restore-template', function() {
        var message;
        url = $(this).data('action');
        if ($(this).hasClass('delete-template')) {
            message = "Are you sure, you want to delete this Template ?";
        } else if ($(this).hasClass('restore-category')) {
            message = "Are you sure, you want to restore this Template ?";
        }
        Swal.fire({
                title: message,
                icon: 'warning',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                confirmButtonClass: "btn btn-info",
                cancelButtonClass: "btn btn-danger",
                reverseButtons: true,
                focusConfirm: false,
                focusCancel: false,
            })
            .then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: url,
                        method: "DELETE",
                        success: function(response) {
                            refresh_datatable();
                        }
                    });
                }
            });
    });

    function refresh_datatable(response) {
        $('#data-table').DataTable().ajax.reload(null, false);
    }
</script>
@endsection
@extends('admin.layouts.app')
@section('style')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Sub Category</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Sub Category</li>
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
                            <button type="button" class="btn btn-info add-sub-category">Add New</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="data-table" class="table table-bordered table-striped" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Index</th>
                                            <th>Name</th>
                                            <th>Category Name</th>
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
        <div class="modal fade text-left drawer-right sub-category-modal" id="bootstrap" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel35" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    {{-- <div class="form-overlay category-loading">
                        <h3>
                            <center>
                                <div class="spinner-border text-primary" role="status" style="height: 45px; width:45px;">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </center>
                            <br>
                            Loading... Please Wait
                        </h3>
                    </div> --}}
                    <div class="modal-header">
                        <h3 class="modal-title"></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="sub-category-form" action="{{ route('sub-category.store') }}">
                        <input type="hidden" name="id" value="0" class="id">
                        <div class="modal-body">
                            <fieldset class="form-group floating-label-form-group">
                                <label for="email">Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control name" placeholder="Enter name"
                                    required>
                                <div class="invalid-feedback font-weight-bold name-invalid" role="alert"></div>
                            </fieldset>
                            <fieldset class="form-group floating-label-form-group">
                                <label for="category_id">Category Name <span class="text-danger">*</span></label>
                                <select name="category_id" class="form-control category-id" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category['_id'] }}">{{ $category['name'] }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback font-weight-bold category-id-invalid" role="alert"></div>
                            </fieldset>
                            

                            <fieldset class="form-group text-right mb-0">
                                <button type="reset" class="btn" data-dismiss="modal">
                                    Close
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </fieldset>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script src="{{ asset('/adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    url: "{{ route('sub-category.index') }}",
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
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });

        $(document).on('click', '.add-sub-category', function() {
            modalShow('.sub-category-modal');
            $('.modal-title').html("Add Category");
        });

        $(document).on('click', '.edit-sub-category', function() {
            var id, title, category_id, category_name;
            id = $(this).data('id');
            name = $(this).data('name');
            category_id = $(this).data('category_id');
            category_name = $(this).data('category_name');
            modalShow('.sub-category-modal');
            $('.modal-title').html("Edit Category");
            $('.id').val(id);
            $('.name').val(name);
            $('.category_id').val(category_id);
            $('.category_name').val(category_name);
        });

        $(document).on('click', '.delete-sub-category,.restore-sub-category', function() {
            var message;
            url = $(this).data('action');
            if ($(this).hasClass('delete-category')) {
                message = "Do you want to delete this Category ?";
            } else if ($(this).hasClass('restore-category')) {
                message = "Do You want to restore this Category ?";
            }
            Swal.fire({
                    title: message,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                    confirmButtonClass: "btn btn-primary",
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

        $(document).on('submit', '#sub-category-form', function(e) {
            e.preventDefault();
            var url, name, nameInvalid,categoryId, categoryIdInvalid, modal, form;
            url = $(this).attr('action');
            name = $('.name');
            nameInvalid = $('.name-invalid');
            categoryId = $('.category-id');
            categoryIdInvalid = $('.category-id-invalid');
            modal = $('.sub-category-modal');
            form = $('#sub-category-form');
            $('.category-loading').addClass('show');
            $.ajax({
                // headers: {
                //     "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                //         "content"
                //     ),
                // },
                url: url,
                type: "POST",
                dataType: 'json',
                data: $(this).serialize(),

                success: function(response) {
                    $('.category-loading').removeClass('show');
                    if (response.success) {
                        modalHide(modal);
                        refresh_datatable();
                        $(form)[0].reset();
                    } else {
                        if (response.data.name) {
                            name.addClass('is-invalid');
                            nameInvalid.html(response.data.name[0]);
                        }
                        if (response.data.category_id) {
                            categoryIdInval.addClass('is-invalid');
                            categoryIdInvalid.html(response.data.category_id[0]);
                        }
                    }
                },
            });
        });

        function modalShow(modalName) {
            $('.form-control').removeClass('is-invalid');
            $('.invalid-feedback').html('');
            $('#sub-category-form')[0].reset();
            $('.category_id').val(0);
            $(modalName).modal('show');
        }

        function modalHide(modalName) {
            $(modalName).modal('hide');
        }

        function refresh_datatable(response) {
            $('#data-table').DataTable().ajax.reload(null, false);
        }
    </script>
@endsection

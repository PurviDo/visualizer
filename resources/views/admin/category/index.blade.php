@extends('admin.layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Category</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Category</li>
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
                            <button type="button" class="btn btn-info add-category">Add New Category</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="data-table" class="table table-bordered table-striped" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Sr.no</th>
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
        <div class="modal fade text-left drawer-right category-modal" id="bootstrap" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel35" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title"></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="category-form" action="{{ route('category.store') }}">
                        <input type="hidden" name="id" value="0" class="category-id">
                        <div class="modal-body">
                            <fieldset class="form-group floating-label-form-group">
                                <label for="email">Category Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control name" placeholder="Enter category name"
                                    required>
                                <div class="invalid-feedback font-weight-bold name-invalid" role="alert"></div>
                            </fieldset>

                            <fieldset class="form-group text-right mb-0">
                                <button type="reset" class="btn" data-dismiss="modal">
                                    Cancel
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    Save
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
                url: "{{ route('category.index') }}",
                type: 'GET'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                }, {
                    data: 'name',
                    name: 'name'
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

    $(document).on('click', '.add-category', function() {
        modalShow('.category-modal');
        $('.modal-title').html("Add Category");
    });

    $(document).on('click', '.edit-category', function() {
        var id, title;
        id = $(this).data('id');
        name = $(this).data('name');
        modalShow('.category-modal');
        $('.modal-title').html("Edit Category");
        $('.category-id').val(id);
        $('.name').val(name);
    });

    $(document).on('click', '.delete-category,.restore-category', function() {
        var message;
        url = $(this).data('action');
        if ($(this).hasClass('delete-category')) {
            message = "Are you sure, you want to delete this Category ?";
        } else if ($(this).hasClass('restore-category')) {
            message = "Are you sure, you want to restore this Category ?";
        }
        Swal.fire({
                title: message,
                icon: "warning",
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
                            toastr.success(response.message);
                        }
                    });
                }
            });
    });

    $(document).on('submit', '#category-form', function(e) {
        e.preventDefault();
        var url, name, nameInvalid, modal, form;
        url = $(this).attr('action');
        name = $('.name');
        nameInvalid = $('.name-invalid');
        modal = $('.category-modal');
        form = $('#category-form');
        $('.category-loading').addClass('show');
        $.ajax({
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
                    // toastr.success(response.message);
                } else {
                    if (response.data.name) {
                        name.addClass('is-invalid');
                        nameInvalid.html(response.data.name[0]);
                    }
                }
            },
        });
    });

    function modalShow(modalName) {
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').html('');
        $('#category-form')[0].reset();
        $('.category-id').val(0);
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

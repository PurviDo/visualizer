@extends('admin.layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">FAQ</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">FAQ</li>
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
                        <button type="button" class="btn btn-info add-faq">Add New FAQ</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="data-table" class="table table-bordered table-striped" width="100%">
                                <thead>
                                    <tr>
                                        <th>Sr.no</th>
                                        <th>FAQ Name</th>
                                        <th>FAQ Section Name</th>
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
    <div class="modal fade text-left drawer-right faq-modal" id="bootstrap" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="faq-form" action="{{ route('faq.store') }}">
                    <input type="hidden" name="id" value="0" class="id">
                    <div class="modal-body">
                        <fieldset class="form-group floating-label-form-group">
                            <label for="category_id">FAQ Section Name <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-control category_id" required>
                                <option selected value="">Select FAQ Section</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category['_id'] }}">{{ $category['name'] }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback font-weight-bold category_id-invalid" role="alert"></div>
                        </fieldset>

                        <fieldset class="form-group floating-label-form-group">
                            <label for="name">FAQ Question <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control name" placeholder="Enter FAQ Question" required>
                            <div class="invalid-feedback font-weight-bold name-invalid" role="alert"></div>
                        </fieldset>

                        <fieldset class="form-group floating-label-form-group">
                            <label for="description">Answer <span class="text-danger">*</span></label>
                            <!-- <input type="text" name="description" class="form-control description" placeholder="Enter Description" required> -->
                            <textarea name="description" class="form-control description" id="description" placeholder="Enter Answer"></textarea>
                            <div class="invalid-feedback font-weight-bold description-invalid" role="alert">
                            </div>
                        </fieldset>
                        <fieldset class="form-group text-right mb-0">
                            <button type="reset" class="btn btn-cancel" data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-info">
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
                url: "{{ route('faq.index') }}",
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

    $(document).on('click', '.add-faq', function() {
        modalShow('.faq-modal');
        $('.modal-title').html("Add FAQ");
    });

    $(document).on('click', '.edit-faq', function() {
        url = $(this).data('action')
        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {

                    modalShow('.faq-modal');
                    $('.modal-title').html("Edit FAQ");

                    var faq = response.data;
                    id = faq._id;
                    name = faq.name;
                    category_id = faq.category_id;
                    description = faq.description;

                    $('.id').val(faq._id);
                    $('.name').val(faq.name);
                    $('.category_id').val(faq.category_id);
                    $('.description').val(faq.description);
                } else {
                    console.error('Error fetching faq data');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', error);
            }
        });
    });
    $(document).on('click', '.delete-faq,.restore-faq', function() {
        var message;
        url = $(this).data('action');
        if ($(this).hasClass('delete-faq')) {
            message = "Are you sure, you want to delete this FAQ ?";
        } else if ($(this).hasClass('restore-category')) {
            message = "Are you sure, you want to restore this FAQ ?";
        }
        Swal.fire({
                title: message,
                icon: 'warning',
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

    $(document).on('submit', '#faq-form', function(e) {
        e.preventDefault();
        var url, name, nameInvalid, categoryId, categoryIdInvalid, description,
            modal, form;
        url = $(this).attr('action');
        name = $('.name');
        nameInvalid = $('.name-invalid');
        categoryId = $('.category_id');
        categoryIdInvalid = $('.category_id-invalid');
        description = $('.description');
        modal = $('.faq-modal');
        form = $('#faq-form');
        $('.category-loading').addClass('show');
        $.ajax({
            url: url,
            type: "POST",
            dataType: 'json',
            data: $(this).serialize(),

            success: function(response) {
                console.log(response);
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
                        categoryId.addClass('is-invalid');
                        categoryIdInvalid.html(response.data.category_id[0]);
                    }
                }
            },
        });
    });

    function modalShow(modalName) {
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').html('');
        $('#faq-form')[0].reset();
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
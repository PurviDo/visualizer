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

    <div class="modal fade text-left drawer-right template-modal" id="bootstrap" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="template-form" action="{{ route('template.store') }}" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="0" class="id">
                    <input type="hidden" name="no_of_files">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="template_type">Template Type <span class="text-danger">*</span></label>
                                    <select name="template_type" class="form-control template_type" required>
                                        <option value="">Select Template Type</option>
                                        <option value="public">Public</option>
                                        <option value="custom">Custom</option>
                                    </select>
                                    <div class="invalid-feedback font-weight-bold template_type-invalid" role="alert"></div>
                                </fieldset>
                            </div>

                            <div class="col-md-6">
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="category_id">Category Name <span class="text-danger">*</span></label>
                                    <select name="category_id" class="form-control category_id" required>
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback font-weight-bold category-id-invalid" role="alert"></div>
                                </fieldset>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="subCategory_id">Sub Category Name <span class="text-danger">*</span></label>
                                    <select name="subCategory_id" class="form-control subCategory_id" required>
                                        <option value="">Select Sub Category</option>
                                        <!-- @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach -->
                                    </select>
                                    <div class="invalid-feedback font-weight-bold subCategory-id-invalid" role="alert"></div>
                                </fieldset>
                            </div>

                            <div class="col-md-6">
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="name">Template Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control name" placeholder="Enter template name" required>
                                    <div class="invalid-feedback font-weight-bold name-invalid" role="alert"></div>
                                </fieldset>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" class="form-control description" placeholder="Enter description"></textarea>
                                    <div class="invalid-feedback font-weight-bold description-invalid" role="alert"></div>
                                </fieldset>
                            </div>

                            <div class="col-md-6">
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="instructions">Instructions</label>
                                    <textarea name="instructions" class="form-control instructions" placeholder="Enter instructions"></textarea>
                                    <div class="invalid-feedback font-weight-bold instructions-invalid" role="alert"></div>
                                </fieldset>
                            </div>
                        </div>
                        
                        <div class="row">
                                    <div class="col-12">
                                        <label>Observation members add if they have:</label>
                                        <div class="row">
                                            <table
                                                class="table table-borderless col-md-12 dynamicPersonDetails custom_form_group">

                                            </table>
                                        </div>
                                    </div>

                                </div>

                        <div class="row">

                            <div class="col-md-6 custom_user_id">
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="user_id">User Name <span class="text-danger">*</span></label>
                                    <select name="user_id" class="form-control user_id" required>
                                        <option value="">Select User</option>
                                        @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->first_name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback font-weight-bold user-id-invalid" role="alert"></div>
                                </fieldset>
                            </div>
                        </div>

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
    var countMember = 0;
</script>
<script src="{{asset('assets/js/addModel.js')}}"></script>
<script>
    $(document).ready(function() {
        $('.category_id').on('change', function() {
            var categoryId = $(this).val();

            if (categoryId) {
                $.ajax({
                    url: "{{ url('/subcategories') }}/" + categoryId,
                    type: 'GET',
                    success: function(data) {
                        $('.subCategory_id').empty().append('<option value="">Select Sub Category</option>');
                        $.each(data, function(key, value) {
                            $('.subCategory_id').append('<option value="' + key + '">' + value + '</option>');
                        });
                    }
                });
            } else {
                $('.subCategory_id').empty().append('<option value="">Select Sub Category</option>');
            }
        });

        $('.custom_user_id').hide();
        $('.template_type').on('change', function() {
            var subCategoryId = $(this).val();
            
            if (subCategoryId == "custom") {
                $('.custom_user_id').show();
            } else {
                $('.custom_user_id').hide();
            }
        });

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
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });

    $(document).on('click', '.add-template', function() {
        $('#user-inputs-container').empty();
        modalShow('.template-modal');
        $('.modal-title').html("Add Template");
    });

    $(document).on('click', '.edit-template', function() {
        url = $(this).data('action')
        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {

                    modalShow('.template-modal');
                    $('.modal-title').html("Edit Template");

                    var template = response.data;
                    id = template._id;
                    name = template.name;
                    category_id = template.parent_id;
                    no_of_user_input = template.no_of_user_input;
                    user_input_label = template.user_input_label;

                    $('.id').val(template._id);
                    $('.name').val(template.name);
                    $('.category_id').val(template.parent_id);
                    $('.no_of_user_input').val(template.no_of_user_input);
                    $('#user-inputs-container').empty();

                    if (template.no_of_user_input > 0) {
                        for (var i = 1; i <= template.no_of_user_input; i++) {

                            var inputHtml =
                                '<input type="text" name="user_input_label[]" class="form-control user_input_label mb-2" value="' +
                                (template.user_input_label[i - 1] ?
                                    template.user_input_label[i - 1] : '') + '">';
                            $('#user-inputs-container').append(inputHtml);
                        }
                    }


                } else {
                    console.error('Error fetching template data');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', error);
            }
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

    $(document).on('submit', '#template-form', function(e) {
        e.preventDefault();
        var url, name, nameInvalid, categoryId, categoryIdInvalid, no_of_user_input, no_of_user_inputInvalid,
            modal, form;
        url = $(this).attr('action');
        name = $('.name');
        nameInvalid = $('.name-invalid');
        categoryId = $('.category_id');
        categoryIdInvalid = $('.category_id-invalid');

        no_of_user_input = $('.no_of_user_input');
        no_of_user_inputInvalid = $('.no_of_user_input-invalid');

        user_input_label = $('.user_input_label');
        user_input_labelInvalid = $('.user_input_label-invalid');
        modal = $('.template-modal');
        form = $('#template-form');
        $('.template-loading').addClass('show');
        $.ajax({
            url: url,
            type: "POST",
            dataType: 'json',
            data: $(this).serialize(),

            success: function(response) {
                $('.template-loading').removeClass('show');
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
                    if (response.data.no_of_user_input) {
                        no_of_user_input.addClass('is-invalid');
                        no_of_user_inputInvalid.html(response.data.no_of_user_input[0]);
                    }
                    if (response.data['user_input_label.0']) {
                        $('input[name="user_input_label[]"]').eq(0).addClass('is-invalid');
                        $('.user_input_label-invalid').html(response.data[
                            'user_input_label.0'][0]);
                    }
                }
            },
        });
    });

    function modalShow(modalName) {
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').html('');
        $('#template-form')[0].reset();
        $('.category_id').val('');
        $(modalName).modal('show');
    }

    function modalHide(modalName) {
        $(modalName).modal('hide');
        $('#user-inputs-container').empty();
    }

    function refresh_datatable(response) {
        $('#data-table').DataTable().ajax.reload(null, false);
    }
</script>
@endsection
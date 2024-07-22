@extends('admin.layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Users</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
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
                            <button type="button" class="btn btn-info add-item-button">Add New Users</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="data-table" class="table table-bordered table-striped" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Sr.no</th>
                                            <th>User Name</th>
                                            <th>Email</th>
                                            <th>Mobile No.</th>
                                            <th>Credits Purchased</th>
                                            <th>Is Active?</th>
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
        <div class="modal fade text-left drawer-right primary-submit-modal" id="bootstrap" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel35" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title"></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="primary-submit-form" action="{{ route('customers.store') }}">
                        <input type="hidden" name="cid" value="0" class="id">
                        <div class="modal-body">
                            <fieldset class="form-group floating-label-form-group">
                                <label for="first-name">First Name <span class="text-danger">*</span></label>
                                <input type="text" name="first_name" class="form-control first-name"
                                    placeholder="Enter First Name" required>
                                <div class="invalid-feedback font-weight-bold first-name-invalid" role="alert"></div>
                            </fieldset>

                            <fieldset class="form-group floating-label-form-group">
                                <label for="last-name">Last Name <span class="text-danger">*</span></label>
                                <input type="text" name="last_name" class="form-control last-name"
                                    placeholder="Enter Last Name" required>
                                <div class="invalid-feedback font-weight-bold last-name-invalid" role="alert"></div>
                            </fieldset>

                            <fieldset class="form-group floating-label-form-group">
                                <label for="mobile-no">Mobile No.<span class="text-danger">*</span></label>
                                <input type="number" name="phone_number" class="form-control mobile-no"
                                    placeholder="Enter Mobile No. " required>
                                <div class="invalid-feedback font-weight-bold mobile-no-invalid" role="alert">
                                </div>
                            </fieldset>

                            <fieldset class="form-group floating-label-form-group">
                                <label for="email">Email<span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control email" placeholder="Enter Email "
                                    required>
                                <div class="invalid-feedback font-weight-bold email-invalid" role="alert">
                                </div>
                            </fieldset>

                            <fieldset class="form-group floating-label-form-group not-editable">
                                <label for="package_id">Package<span class="text-danger">*</span></label>
                                <input type="package_id" name="package_id" class="form-control email" placeholder="Enter Email "
                                    required>
                                <div class="invalid-feedback font-weight-bold package_id-invalid" role="alert">
                                </div>
                            </fieldset>

                            <fieldset class="form-group floating-label-form-group not-editable">
                                <label for="password">Password<span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control password" placeholder="Enter Password "
                                    required>
                                <div class="invalid-feedback font-weight-bold password-invalid" role="alert">
                                </div>
                            </fieldset>

                            <fieldset class="form-group floating-label-form-group not-editable">
                                <label for="confirm_password">Confirm Password<span class="text-danger">*</span></label>
                                <input type="password" name="confirm_password" class="form-control confirm-password" placeholder="Enter Confirm Password "
                                    required>
                                <div class="invalid-feedback font-weight-bold confirm-password-invalid" role="alert">
                                </div>
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

        <div class="modal fade text-left drawer-right primary-show-modal" id="bootstrap" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel35" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">User Details</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>First Name:</th>
                                    <td><p id="customer-first-name" class="form-control-plaintext"></p></td>
                                </tr>
                                <tr>
                                    <th>Last Name:</th>
                                    <td><p id="customer-last-name" class="form-control-plaintext"></p></td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td><p id="customer-email" class="form-control-plaintext"></p></td>
                                </tr>
                                <tr>
                                    <th>Mobile No.:</th>
                                    <td><p id="customer-mobile-no" class="form-control-plaintext"></p></td>
                                </tr>
                                <tr>
                                    <th>Package Name:</th>
                                    <td><p id="customer-package-name" class="form-control-plaintext"></p></td>
                                </tr>
                                <tr>
                                    <th>Template:</th>
                                    <td><p id="customer-template" class="form-control-plaintext"></p></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
                url: "{{ route('customers.index') }}",
                type: 'GET'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'user_name',
                    name: 'user_name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'mobile_no',
                    name: 'mobile_no',
                    "defaultContent": ""
                },
                {
                    data: 'purchased_credit',
                    name: 'purchased_credit'
                },
                {
                    data: 'is_active',
                    name: 'is_active',
                    render: function(data, type, row) {
                        // Custom rendering for the is_active field
                        return data ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
                    }
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

    $(document).on('click', '.add-item-button', function() {
        $('#cid').val(0);                    
        // Set form action to update route
        $('#primary-submit-form').attr('action', '{{ url('customers') }}/');
        $('#primary-submit-form').attr('method', 'POST');

        modalShow('.primary-submit-modal');
        $('.modal-title').html("Add User");
    });

    $(document).on('click', '.show-customer', function() {
        url = $(this).data('action')
        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    var customer = response.data;
                    $('#customer-first-name').text(customer.first_name);
                    $('#customer-last-name').text(customer.last_name);
                    $('#customer-email').text(customer.email);
                    $('#customer-mobile-no').text(customer.mobile_no);
                    $('#customer-package-name').text(customer.package.name);

                    // Show the form/modal
                    $('.primary-show-modal').modal('show');
                } else {
                    console.error('Error fetching package data');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', error);
            }
        });


    });

    $(document).on('click', '.edit-customer', function() {
        url = $(this).data('action')
        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {

                    modalShow('.primary-submit-modal');
                    $('.modal-title').html("Edit User");
                    var customer = response.data;

                    $('.first-name').val(customer.first_name);
                    $('.last-name').val(customer.last_name);
                    $('.email').val(customer.email);
                    $('.mobile-no').val(customer.mobile_no);
                    $('#cid').val(customer._id);

                    $(".not-editable").hide();
                    
                    // Set form action to update route
                    $('#primary-submit-form').attr('action', '{{ url('customers') }}/' + customer._id);
                    // $('#primary-submit-form').attr('action', "{{ route('customers.update', "+customer._id+") }}");
                    $('#primary-submit-form').attr('method', 'PUT');

                } else {
                    console.error('Error fetching package data');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', error);
            }
        });
    });

    $(document).on('click', '.delete-customer,.restore-customer', function() {
        var message;
        url = $(this).data('action');
        if ($(this).hasClass('delete-customer')) {
            message = "Are you sure, you want to delete this User?";
        } else if ($(this).hasClass('restore-customer')) {
            message = "Are you sure, you want to restore this User?";
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
                            // toastr.success(response.message);
                        }
                    });
                }
            });
    });

    $(document).on('submit', '#primary-submit-form', function(e) {
        e.preventDefault();
        var url, name, nameInvalid, modal, form;
        url = $(this).attr('action');  
        method = $(this).attr('method');      
        modal = $('.primary-submit-modal');
        form = $('#primary-submit-form');
        $('.category-loading').addClass('show');
        $.ajax({
            url: url,
            type: method,
            dataType: 'json',
            data: $(this).serialize(),

            success: function(response) {
                console.log(response.error);
                $('.category-loading').removeClass('show');
                if (response.success) {
                    modalHide(modal);
                    refresh_datatable();
                    $(form)[0].reset();
                    // toastr.success(response.message);
                } else {
                    
                    if (response.data.name) {
                        $('.first-name').addClass('is-invalid');
                        nameInvalid.html(response.data.name[0]);
                    }
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                if (xhr.responseJSON.error.first_name) {
                    $('.first-name').addClass('is-invalid');
                    $('.first-name-invalid').html(xhr.responseJSON.error.phone_number[0]);
                }
                else if (xhr.responseJSON.error.last_name) {
                    $('.last-name').addClass('is-invalid');
                    $('.last-name-invalid').html(xhr.responseJSON.error.phone_number[0]);
                }
                else if (xhr.responseJSON.error.phone_number) {
                    $('.mobile-no').addClass('is-invalid');
                    $('.mobile-no-invalid').html(xhr.responseJSON.error.phone_number[0]);
                }
                else if (xhr.responseJSON.error.email) {
                    $('.email').addClass('is-invalid');
                    $('.email-invalid').html(xhr.responseJSON.error.phone_number[0]);
                }
            }
        });
    });

    function modalShow(modalName) {
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').html('');
        $('#primary-submit-form')[0].reset();
        $('.id').val(0);
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

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
                    <form id="primary-submit-form" action="{{ route('customers.store') }}">
                        <input type="hidden" name="id" value="0" class="id">
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
                                <input type="number" name="mobile_no" class="form-control mobile-no"
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


                            {{-- <fieldset class="form-group floating-label-form-group">
                                <label for="credits">No of Credit <span class="text-danger">*</span></label>
                                <input type="number" name="credits" class="form-control credits"
                                    placeholder="Enter No of Credit" required>
                                <div class="invalid-feedback font-weight-bold credits-invalid" role="alert">
                                </div>
                            </fieldset>

                            <fieldset class="form-group floating-label-form-group">
                                <label for="actual_price">Actual Price <span class="text-danger">*</span></label>
                                <input type="digit" name="actual_price" class="form-control actual_price"
                                    placeholder="Enter Actual Price" required>
                                <div class="invalid-feedback font-weight-bold actual_price-invalid" role="alert">
                                </div>
                            </fieldset>

                            <fieldset class="form-group floating-label-form-group">
                                <label for="discounted_price">Discounted Price <span class="text-danger">*</span></label>
                                <input type="digit" name="discounted_price" class="form-control discounted_price"
                                    placeholder="Enter Discounted Price" required>
                                <div class="invalid-feedback font-weight-bold discounted_price-invalid" role="alert">
                                </div>
                            </fieldset> --}}

                            {{-- <fieldset class="form-group floating-label-form-group">
                                <label for="status">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-control status" required>
                                    <option value="">Select Status</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                                <div class="invalid-feedback font-weight-bold status-invalid" role="alert">
                                </div>
                            </fieldset> --}}

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
                        <div class="form-group">
                            <label for="name">First Name:</label>
                            <p id="customer-first-name" class="form-control-plaintext"></p>
                        </div>

                        <div class="form-group">
                            <label for="name">Last Name:</label>
                            <p id="customer-last-name" class="form-control-plaintext"></p>
                        </div>

                        <div class="form-group">
                            <label for="email">Email:</label>
                            <p id="customer-email" class="form-control-plaintext "></p>
                        </div>

                        <div class="form-group">
                            <label for="mobile_no">Mobile No.:</label>
                            <p id="customer-mobile-no" class="form-control-plaintext "></p>
                        </div>

                        <div class="form-group">
                            <label for="package_name">Package Name:</label>
                            <p id="customer-package-name" class="form-control-plaintext "></p>
                        </div>

                        <div class="form-group">
                            <label for="start_date">Start Date:</label>
                            <p id="package-start-date" class="form-control-plaintext "></p>
                        </div>

                        <div class="form-group">
                            <label for="end_date">End Date:</label>
                            <p id="package-end-date" class="form-control-plaintext "></p>
                        </div>

                        <div class="form-group">
                            <label for="end_date">Template:</label>
                            <p id="package-end-date" class="form-control-plaintext "></p>
                        </div>

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
                        name: 'mobile_no'
                    },
                    {
                        data: 'purchased_credit',
                        name: 'purchased_credit'
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
            modalShow('.primary-submit-modal');
            $('.modal-title').html("Add Customer");
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
                        var package = response.data;

                        $('.id').val(package._id);
                        $('.first-name').val(package.first_name);
                        $('.last-name').val(package.last_name);
                        $('.email').val(package.email);
                        $('.mobile-no').val(package.mobile_no);

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
                message = "Are you sure, you want to delete this Customer ?";
            } else if ($(this).hasClass('restore-category')) {
                message = "Are you sure, you want to restore this Customer ?";
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

        $(document).on('submit', '#primary-submit-form', function(e) {
            e.preventDefault();
            var url = $(this).attr('action');
            var fields = [{
                    name: 'name',
                    invalidClass: 'name-invalid'
                },
                {
                    name: 'duration',
                    invalidClass: 'duration-invalid'
                },
                {
                    name: 'description',
                    invalidClass: 'description-invalid'
                },
                {
                    name: 'credits',
                    invalidClass: 'credits-invalid'
                },
                {
                    name: 'actual_price',
                    invalidClass: 'actual_price-invalid'
                },
                {
                    name: 'discounted_price',
                    invalidClass: 'discounted_price-invalid'
                },
                {
                    name: 'status',
                    invalidClass: 'status-invalid'
                }
            ];

            var modal = $('.primary-submit-modal');
            var form = $('#primary-submit-form');
            $.ajax({
                url: url,
                type: "POST",
                dataType: 'json',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        modalHide(modal);
                        refresh_datatable();
                        form[0].reset();
                    } else {
                        fields.forEach(function(field) {
                            var input = $('.' + field.name);
                            var invalidFeedback = $('.' + field.invalidClass);

                            if (response.data[field.name]) {
                                input.addClass('is-invalid');
                                invalidFeedback.html(response.data[field.name][0]);
                            } else {
                                input.removeClass('is-invalid');
                                invalidFeedback.html('');
                            }
                        });
                    }
                },
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

@extends('admin.layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Packages</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Packages</li>
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
                            <button type="button" class="btn btn-info add-package">Add New Package</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="data-table" class="table table-bordered table-striped" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Sr.no</th>
                                            <th>Package Name</th>
                                            <th>Package Duration (In Months)</th>
                                            <th>No. of Credits</th>
                                            <th>No. of Users</th>
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
        <div class="modal fade text-left drawer-right package-modal" id="bootstrap" tabindex="-1" role="dialog"
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
                    <form id="package-form" action="{{ route('packages.store') }}">
                        <input type="hidden" name="id" value="0" class="id">
                        <div class="modal-body">
                            <fieldset class="form-group floating-label-form-group">
                                <label for="name">Package Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control name"
                                    placeholder="Enter package name" required>
                                <div class="invalid-feedback font-weight-bold name-invalid" role="alert"></div>
                            </fieldset>

                            <fieldset class="form-group floating-label-form-group">
                                <label for="duration">Package Duration (In month) <span class="text-danger">*</span></label>
                                <input type="number" name="duration" class="form-control duration"
                                    placeholder="Enter Package Duration (In month)" required>
                                <div class="invalid-feedback font-weight-bold duration-invalid" role="alert">
                                </div>
                            </fieldset>


                            <fieldset class="form-group floating-label-form-group">
                                <label for="description">Description <span class="text-danger">*</span></label>
                                <textarea name="description" class="form-control description" placeholder="Enter Description" required></textarea>
                                <div class="invalid-feedback font-weight-bold description-invalid" role="alert">
                                </div>
                            </fieldset>

                            <fieldset class="form-group floating-label-form-group">
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
                            </fieldset>

                            <fieldset class="form-group floating-label-form-group">
                                <label for="status">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-control status" required>
                                    <option value="">Select Status</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                                <div class="invalid-feedback font-weight-bold status-invalid" role="alert">
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

        <div class="modal fade text-left drawer-right show-package-modal" id="bootstrap" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel35" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Package Details</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Package Name:</label>
                            <p id="package-name" class="form-control-plaintext "></p>
                        </div>

                        <div class="form-group">
                            <label for="duration">Package Duration (In months):</label>
                            <p id="package-duration" class="form-control-plaintext "></p>
                        </div>

                        <div class="form-group">
                            <label for="description">Description:</label>
                            <p id="package-description" class="form-control-plaintext "></p>
                        </div>

                        <div class="form-group">
                            <label for="credits">No of Credits:</label>
                            <p id="package-credits" class="form-control-plaintext "></p>
                        </div>

                        <div class="form-group">
                            <label for="actual_price">Actual Price:</label>
                            <p id="package-actual-price" class="form-control-plaintext "></p>
                        </div>

                        <div class="form-group">
                            <label for="discounted_price">Discounted Price:</label>
                            <p id="package-discounted-price" class="form-control-plaintext "></p>
                        </div>

                        <div class="form-group">
                            <label for="status">Status:</label>
                            <p id="package-status" class="form-control-plaintext status"></p>
                        </div>

                        <div class="form-group">
                            <label for="no_of_users">No of Users:</label>
                            <p id="package-no-of-users" class="form-control-plaintext "></p>
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
                    url: "{{ route('packages.index') }}",
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
                        data: 'duration',
                        name: 'duration'
                    },
                    {
                        data: 'credits',
                        name: 'credits',
                        render: function(data, type, row) {
                            return data ? data : 'N/A';
                        }
                    },
                    {
                        data: 'users',
                        name: 'users',
                        render: function(data, type, row) {
                            return data ? data : 'N/A';
                        },
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

        $(document).on('click', '.add-package', function() {
            modalShow('.package-modal');
            $('.modal-title').html("Add Package");
        });

        $(document).on('click', '.show-package', function() {
            url = $(this).data('action')
            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        var package = response.data;
                        $('#package-name').text(package.name);
                        $('#package-duration').text(package.duration);
                        $('#package-description').text(package.description);
                        $('#package-credits').text(package.credits);
                        $('#package-actual-price').text(package.actual_price);
                        $('#package-discounted-price').text(package.discounted_price);
                        $('#package-no-of-users').text(package.no_of_users);
                        $('#package-status').text(package.status);
                        $('.show-package-modal').modal('show');
                    } else {
                        console.error('Error fetching package data');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', error);
                }
            });


        });

        $(document).on('click', '.edit-package', function() {
            url = $(this).data('action')
            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {

                        modalShow('.package-modal');
                        $('.modal-title').html("Edit Package");
                        var package = response.data;

                        $('.id').val(package._id);
                        $('.name').val(package.name);
                        $('.duration').val(package.duration);
                        $('.description').val(package.description);
                        $('.credits').val(package.credits);
                        $('.actual_price').val(package.actual_price);
                        $('.discounted_price').val(package.discounted_price);
                        $('.status').val(package.status);

                    } else {
                        console.error('Error fetching package data');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', error);
                }
            });
        });

        $(document).on('click', '.delete-package,.restore-package', function() {
            var message;
            url = $(this).data('action');
            if ($(this).hasClass('delete-package')) {
                message = "Are you sure, you want to delete this Package ?";
            } else if ($(this).hasClass('restore-category')) {
                message = "Are you sure, you want to restore this Package ?";
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

        $(document).on('submit', '#package-form', function(e) {
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

            var modal = $('.package-modal');
            var form = $('#package-form');
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
            $('#package-form')[0].reset();
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

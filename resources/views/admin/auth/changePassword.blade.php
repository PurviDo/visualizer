@extends('admin.layouts.app')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Change Password</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Change Password</li>
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
                    <div class="card-body">
                        <div id="alert-container"></div>
                        <form id="change-password-form" method="POST" action="{{ route('change.password') }}">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="current_password">Current Password<span class="text-danger">*</span></label>
                                    <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Enter Current Password" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">New Password<span class="text-danger">*</span></label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter New Password" required>
                                </div>
                                <div class="form-group">
                                    <label for="confirm_password">Confirm New Password<span class="text-danger">*</span></label>
                                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Enter Confirm New Password" required>
                                </div>
                                <div class="form-group">
                                    <button type="reset" class="btn btn-cancel" data-dismiss="modal">
                                        Cancel
                                    </button>
                                    <button type="submit" class="btn btn-info">
                                        Change Password
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
<script src="{{ asset('/adminlte/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script>
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.validator.setDefaults({
            submitHandler: function(form) {
                const formId = $(form).attr('id');
                if (formId === 'profileForm') {
                    updateProfile();
                } else if (formId === 'change-password-form') {
                    changePassword();
                }
            }
        });

        $('#profileForm').validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                },
                first_name: {
                    required: true,
                    minlength: 2
                },
                last_name: {
                    required: true,
                    minlength: 2
                },
                mobile_no: {
                    required: true,
                    minlength: 10,
                    maxlength: 15
                },
            },
            messages: {
                first_name: {
                    required: "Please enter your first name"
                },
                last_name: {
                    required: "Please enter your last name"
                },
                email: {
                    required: "Please enter your email address",
                    email: "Please enter a valid email address"
                },
                mobile_no: {
                    required: "Please enter your mobile number"
                },
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

        $('#change-password-form').validate({
            rules: {
                current_password: {
                    required: true,
                },
                password: {
                    required: true,
                    minlength: 5
                },
                confirm_password: {
                    required: true,
                    minlength: 5,
                    equalTo: "#password"
                },
            },
            messages: {
                current_password: {
                    required: "Please enter your current password"
                },
                password: {
                    required: "Please enter a new password",
                    minlength: "Your password must be at least 5 characters long"
                },
                confirm_password: {
                    required: "Please confirm your new password",
                    minlength: "Your password must be at least 5 characters long",
                    equalTo: "New passwords do not match"
                },
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

        function createAlertHtml(message, type = 'success') {
            return `
                <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            `;
        }

        function updateProfile() {
            $.ajax({
                url: "{{ route('update.profile') }}",
                method: "POST",
                data: $('#profileForm').serialize(),
                success: function(response) {
                    const alertHtml = createAlertHtml(response.success);
                    $('#alert-container').html(alertHtml);
                    setTimeout(function() {
                        $('.alert').alert('close');
                    }, 5000);
                },
                error: function(response) {
                    const errors = response.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        const element = $(`[name=${key}]`);
                        element.addClass('is-invalid');
                        element.closest('.form-group').find('.invalid-feedback').remove();
                        element.closest('.form-group').append(`<span class="invalid-feedback">${value[0]}</span>`);
                    });
                }
            });
        }

        function changePassword() {
            $.ajax({
                url: "{{ route('change.password') }}",
                method: "POST",
                data: $('#change-password-form').serialize(),
                success: function(response) {
                    const alertHtml = createAlertHtml(response.success);
                    $('#alert-container').html(alertHtml);
                    setTimeout(function() {
                        $('.alert').alert('close');
                    }, 5000);
                    $('#changePasswordModal').modal('hide');
                },
                error: function(response) {
                    // Handling validation errors
                    const errors = response.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        const element = $(`[name=${key}]`);
                        element.addClass('is-invalid');
                        element.closest('.form-group').find('.invalid-feedback').remove();
                        element.closest('.form-group').append(`<span class="invalid-feedback">${value[0]}</span>`);
                    });

                }
            });
        }
    });
</script>
@endsection
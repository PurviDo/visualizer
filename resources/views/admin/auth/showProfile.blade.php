@extends('admin.layouts.app')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">My Profile</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Profile</li>
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
                        <form id="profileForm" action="{{ route('update.profile') }}" method="POST">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="firstname">First Name<span class="text-danger">*</span></label>
                                    <input type="text" name="first_name" value="{{auth()->user()->first_name}}" class="form-control" id="firstname" placeholder="Enter First name" required>
                                </div>
                                <div class="form-group">
                                    <label for="lastname">Last Name<span class="text-danger">*</span></label>
                                    <input type="text" name="last_name" value="{{auth()->user()->last_name}}" class="form-control" id="lastname" placeholder="Enter Last name" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email address<span class="text-danger">*</span></label>
                                    <input type="email" name="email" value="{{auth()->user()->email}}" class="form-control" id="email" placeholder="Enter email" required>
                                </div>
                                <div class="form-group">
                                    <label for="mobile_no">Mobile No.<span class="text-danger">*</span></label>
                                    <input type="tel" name="mobile_no" value="{{auth()->user()->mobile_no}}" class="form-control" id="mobile_no" placeholder="Enter Mobile No." required>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{route('dashboard')}}" class="btn btn-cancel">Cancel</a>
                                <button type="submit" class="btn btn-info">Submit</button>
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
    });
</script>
@endsection
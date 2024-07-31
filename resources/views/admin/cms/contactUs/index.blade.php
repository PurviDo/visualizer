@extends('admin.layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Contact Us</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Contact Us</li>
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
                        <button type="button" class="btn btn-info add-contact-us">Add New Contact Us</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="data-table" class="table table-bordered table-striped" width="100%">
                                <thead>
                                    <tr>
                                        <th>Sr.no</th>
                                        <th>Title</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Address</th>
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
    <div class="modal fade text-left drawer-right contact-us-modal" id="bootstrap" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="contact-us-form" action="{{ route('contact-us.store') }}">
                    <input type="hidden" name="id" value="0" class="contact-us-id">
                    <div class="modal-body">
                        <fieldset class="form-group floating-label-form-group">
                            <label>Contact Us Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control title" placeholder="Enter Contact Us title" required>
                            <div class="invalid-feedback font-weight-bold title-invalid" role="alert"></div>
                        </fieldset>
                        <fieldset class="form-group floating-label-form-group">
                            <label>Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control email" placeholder="Enter email" required>
                            <div class="invalid-feedback font-weight-bold email-invalid" role="alert"></div>
                        </fieldset>
                        <fieldset class="form-group floating-label-form-group">
                            <label>Phone <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control phone" placeholder="Enter phone" required>
                        </fieldset>
                        <fieldset class="form-group floating-label-form-group">
                            <label>Address <span class="text-danger">*</span></label>
                            <textarea name="address" class="form-control address" id="address" placeholder="Enter address"></textarea>
                        </fieldset>
                        <fieldset class="form-group floating-label-form-group">
                            <label>Map URL <span class="text-danger">*</span></label>
                            <input type="text" name="map_url" class="form-control map_url" placeholder="Enter map url">
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
                url: "{{ route('contact-us.index') }}",
                type: 'GET'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'address',
                    name: 'address'
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

    $(document).on('click', '.add-contact-us', function() {
        modalShow('.contact-us-modal');
        $('.modal-title').html("Add Category");
    });

    $(document).on('click', '.edit-contact-us', function() {
        url = $(this).data('action')
        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {

                    modalShow('.contact-us-modal');
                    $('.modal-title').html("Edit FAQ");

                    var contactUs = response.data;
                    id = contactUs._id;
                    title = contactUs.title;
                    email = contactUs.email;
                    phone = contactUs.phone;
                    address = contactUs.address;
                    map_url = contactUs.map_url;

                    $('.contact-us-id').val(contactUs._id);
                    $('.title').val(contactUs.title);
                    $('.phone').val(contactUs.phone);
                    $('.email').val(contactUs.email);
                    $('.address').val(contactUs.address);
                    $('.map_url').val(contactUs.map_url);
                } else {
                    console.error('Error fetching faq data');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', error);
            }
        });
    });
    $(document).on('click', '.delete-contact-us,.restore-contact-us', function() {
        var message;
        url = $(this).data('action');
        if ($(this).hasClass('delete-contact-us')) {
            message = "Are you sure, you want to delete this Contact us ?";
        } else if ($(this).hasClass('restore-category')) {
            message = "Are you sure, you want to restore this Contact us ?";
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

    $(document).on('submit', '#contact-us-form', function(e) {
        e.preventDefault();
        var url, title, titleInvalid, emailId, emailInvalid, phone, phoneInvalid, modal, form;
        url = $(this).attr('action');
        title = $('.title');
        titleInvalid = $('.title-invalid');
        email = $('.email');
        emailInvalid = $('.email-invalid');
        phone = $('.phone');
        phoneInvalid = $('.phone-invalid');
        modal = $('.contact-us-modal');
        form = $('#contact-us-form');
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
                    if (response.data.title) {
                        title.addClass('is-invalid');
                        titleInvalid.html(response.data.title[0]);
                    }
                    if (response.data.email) {
                        email.addClass('is-invalid');
                        emailInvalid.html(response.data.email[0]);
                    }
                    if (response.data.phone) {
                        phone.addClass('is-invalid');
                        phoneInvalid.html(response.data.phone[0]);
                    }
                }
            },
        });
    });

    function modalShow(modalName) {
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').html('');
        $('#contact-us-form')[0].reset();
        $('.contact-us-id').val(0);
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
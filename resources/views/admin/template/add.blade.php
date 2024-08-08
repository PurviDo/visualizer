@extends('admin.layouts.app')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Add Template</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Add Template</li>
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
                        <form id="template-form" action="{{ route('template.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
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
                                            <label for="name">Template Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control name" placeholder="Enter template name" required>
                                            <div class="invalid-feedback font-weight-bold name-invalid" role="alert"></div>
                                        </fieldset>
                                    </div>
                                </div>

                                <div class="row">
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
                                    <div class="col-md-6">
                                        <fieldset class="form-group floating-label-form-group">
                                            <label for="subCategory_id">Sub Category Name <span class="text-danger">*</span></label>
                                            <select name="sub_category_id" class="form-control subCategory_id" id="subcategory" required>
                                                <option value="">Select Sub Category</option>
                                            </select>
                                            <div class="invalid-feedback font-weight-bold subCategory-id-invalid" role="alert"></div>
                                        </fieldset>
                                    </div>


                                    <input type="hidden" id="no_of_files" name="no_of_files" class="form-control">
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
                                        <label>Add Temple Models:</label>
                                        <div class="row">
                                            <table class="table table-borderless col-md-12 dynamicPersonDetails custom_form_group">

                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-6 custom_user_id">
                                        <fieldset class="form-group floating-label-form-group">
                                            <label for="user_id">User Name <span class="text-danger">*</span></label>
                                            <select name="user_id" class="form-control user_id">
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
        </div>
    </div>
</section>
@endsection
@section('script')
<script src="{{ asset('/adminlte/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script>
    var countModel = 0;
    var noOfFilesUrl = "{{ url('/noOfFiles') }}";
</script>
<script src="{{asset('assets/js/addModel.js')}}"></script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.category_id').on('change', function() {
            var categoryId = $(this).val();

            if (categoryId) {
                $.ajax({
                    url: "{{ url('/subcategories') }}/" + categoryId,
                    type: 'GET',
                    success: function(data) {
                        $('#subcategory').empty().append('<option value="">Select Sub Category</option>');
                        $.each(data, function(key, value) {
                            $('#subcategory').append('<option value="' + key + '">' + value + '</option>');
                        });
                    }
                });
            } else {
                $('#subcategory').empty().append('<option value="">Select Sub Category</option>');
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
    });
</script>
@endsection
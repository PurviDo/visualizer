@extends('admin.layouts.app')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Template</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Edit Template</li>
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
                        <form id="template-form" action="{{ route('template.update', $template->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
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
                                                <option value="public" {{ $template->template_type == 'public' ? 'selected' : '' }}>Public</option>
                                                <option value="custom" {{ $template->template_type == 'custom' ? 'selected' : '' }}>Custom</option>
                                            </select>
                                            <div class="invalid-feedback font-weight-bold template_type-invalid" role="alert"></div>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-6">
                                        <fieldset class="form-group floating-label-form-group">
                                            <label for="name">Template Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control name" placeholder="Enter template name" value="{{ $template->name }}" required>
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
                                                <option value="{{ $category->id }}" {{ $template->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
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
                                            <textarea name="description" class="form-control description" placeholder="Enter description">{{ $template->description }}</textarea>
                                            <div class="invalid-feedback font-weight-bold description-invalid" role="alert"></div>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-6">
                                        <fieldset class="form-group floating-label-form-group">
                                            <label for="instructions">Instructions</label>
                                            <textarea name="instructions" class="form-control instructions" placeholder="Enter instructions">{{ $template->instructions }}</textarea>
                                            <div class="invalid-feedback font-weight-bold instructions-invalid" role="alert"></div>
                                        </fieldset>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <label>Add Template Models:</label>
                                        <div class="row">
                                            <table class="table table-borderless col-md-12 dynamicPersonDetails custom_form_group">
                                                @foreach ($template->templateModels as $index => $model)
                                                <tr>
                                                    <td>
                                                        <fieldset class="form-group floating-label-form-group">
                                                            <label for="background_image_{{ $index }}">Background Image</label>
                                                            <input type="file" name="background_image[]" class="form-control background_image">
                                                            <div class="invalid-feedback font-weight-bold background_image_{{ $index }}-invalid" role="alert"></div>
                                                        </fieldset>
                                                    </td>

                                                    @php
                                                        $modelImagesArray = explode(',', $model->model_image);
                                                    @endphp
                                                    @foreach ($modelImagesArray as $i => $file)
                                                    <td>
                                                        <fieldset class="form-group floating-label-form-group">
                                                            <label for="file_{{ $index }}_{{ $i }}">File {{ $i + 1 }}</label>
                                                            <input type="file" name="file[]" class="form-control file-input">
                                                            <div class="invalid-feedback font-weight-bold file_{{ $index }}_{{ $i }}-invalid" role="alert"></div>
                                                        </fieldset>
                                                    </td>
                                                    @endforeach
                                                    <td>
                                                        <div class="form-floating form-floating-outline">
                                                            @if ($loop->first)
                                                            <button type="button" name="add" class="btn btn-outline-primary dynamic-pd">+</button>
                                                            @else
                                                            <button type="button" class="btn btn-outline-danger remove-field">-</button>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
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
                                                <option value="{{ $user->id }}" {{ $template->user_id == $user->id ? 'selected' : '' }}>{{ $user->first_name }}</option>
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
    var countModel = {{ $template->templateModels->count() }};
    var noOfFilesUrl = "{{ url('/noOfFiles') }}";
    
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
                        $('#subcategory').val('{{ $template->sub_category_id }}').trigger('change');
                    }
                });
            } else {
                $('#subcategory').empty().append('<option value="">Select Sub Category</option>');
            }
        }).val('{{ $template->category_id }}').trigger('change');

        $('#template-form').on('submit', function(event) {
            event.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === 'success') {
                        // handle success (e.g., redirect or show success message)
                    } else {
                        // handle validation errors or other issues
                        $('#alert-container').html(response.errors);
                    }
                }
            });
        });

        $(document).on('click', '.remove-field', function() {
            $(this).closest('tr').remove();
        });

        $(document).on('click', '.dynamic-pd', function() {
            countModel++;
            var html = '<tr>' +
                        '<td>' +
                            '<fieldset class="form-group floating-label-form-group">' +
                                '<label for="background_image_' + countModel + '">Background Image</label>' +
                                '<input type="file" name="background_image[]" class="form-control background_image">' +
                                '<div class="invalid-feedback font-weight-bold background_image_' + countModel + '-invalid" role="alert"></div>' +
                            '</fieldset>' +
                        '</td>' +
                        // Repeat for other image fields
                        '<td>' +
                            '<div class="form-floating form-floating-outline">' +
                                '<button type="button" class="btn btn-outline-danger remove-field">-</button>' +
                            '</div>' +
                        '</td>' +
                    '</tr>';
            $('.dynamicPersonDetails').append(html);
        });
    });
</script>
@endsection

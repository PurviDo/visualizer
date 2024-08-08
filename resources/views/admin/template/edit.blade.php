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
                    <li class="breadcrumb-item"><a href="{{ route('template.index') }}">Templates</a></li>
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
                                                @foreach ($subCategories as $subCategory)
                                                <option value="{{ $subCategory->id }}" {{ $template->sub_category_id == $subCategory->id ? 'selected' : '' }}>{{ $subCategory->name }}</option>
                                                @endforeach
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
                                        <label>Template Models:</label>
                                        <div class="row">
                                            <table class="table table-borderless col-md-12 dynamicModel custom_form_group">
                                                <!-- Existing models will be rendered here -->
                                                @foreach ($template->templateModels as $index => $model)
                                                <tr>
                                                    <td>
                                                        <fieldset class="form-group floating-label-form-group">
                                                            <label for="background_image_{{ $index }}">Background Imageee</label>
                                                            <input type="file" name="background_image_{{ $index }}" class="form-control background_image">
                                                            <div class="invalid-feedback font-weight-bold background_image_{{ $index }}-invalid" role="alert"></div>
                                                            @if($model->background_image)
                                                            <!-- <img src="{{ asset($model->background_image) }}" width="100"> -->
                                                            <a href="{{ asset($model->background_image) }}" target="_blank">View Image</a>
                                                            @endif
                                                        </fieldset>
                                                    </td>
                                                    <td>
                                                        <fieldset class="form-group floating-label-form-group">
                                                            <label for="foreground_image_{{ $index }}">Foreground Image</label>
                                                            <input type="file" name="foreground_image_{{ $index }}" class="form-control foreground_image">
                                                            <div class="invalid-feedback font-weight-bold foreground_image_{{ $index }}-invalid" role="alert"></div>
                                                            @if($model->foreground_image)
                                                            <!-- <img src="{{ asset($model->foreground_image) }}" width="100"> -->
                                                            <a href="{{asset($model->foreground_image) }}" target="_blank">View Image</a>
                                                            @endif
                                                        </fieldset>
                                                    </td>
                                                    <td>
                                                        <fieldset class="form-group floating-label-form-group">
                                                            <label for="shadow_image_{{ $index }}">Shadow Image</label>
                                                            <input type="file" name="shadow_image_{{ $index }}" class="form-control shadow_image">
                                                            <div class="invalid-feedback font-weight-bold shadow_image_{{ $index }}-invalid" role="alert"></div>
                                                            @if($model->shadow_image)
                                                            <!-- <img src="{{ asset($model->shadow_image) }}" width="100"> -->
                                                            <a href="{{ asset($model->shadow_image) }}" target="_blank">View Image</a>
                                                            @endif
                                                        </fieldset>
                                                    </td>
                                                    <td>
                                                        <fieldset class="form-group floating-label-form-group">
                                                            <label for="highlight_image_{{ $index }}">Highlight Image</label>
                                                            <input type="file" name="highlight_image_{{ $index }}" class="form-control highlight_image">
                                                            <div class="invalid-feedback font-weight-bold highlight_image_{{ $index }}-invalid" role="alert"></div>
                                                            @if($model->highlight_image)
                                                            <!-- <img src="{{ asset($model->highlight_image) }}" width="100"> -->
                                                            <a href="{{ asset($model->highlight_image) }}" target="_blank">View Image</a>
                                                            @endif
                                                        </fieldset>
                                                    </td>
                                                    <td>
                                                        <fieldset class="form-group floating-label-form-group">
                                                            <label for="preview_image_{{ $index }}">Preview Image</label>
                                                            <input type="file" name="preview_image_{{ $index }}" class="form-control preview_image">
                                                            <div class="invalid-feedback font-weight-bold preview_image_{{ $index }}-invalid" role="alert"></div>
                                                            @if($model->preview_image)
                                                            <a href="{{ asset($model->preview_image) }}" target="_blank">View Image</a>
                                                            @endif
                                                        </fieldset>
                                                    </td>
                                                    @php
                                                        $modelImagesArray = explode(',', $model->model_image);
                                                    @endphp
                                                    @foreach ($modelImagesArray as $fileIndex => $file)
                                                    <td>
                                                        <fieldset class="form-group floating-label-form-group">
                                                            <label for="file_{{ $index }}_{{ $fileIndex }}">File {{ $fileIndex + 1 }}</label>
                                                            <input type="file" name="file_{{ $index }}[{{ $fileIndex }}]" class="form-control file-input">
                                                            <div class="invalid-feedback font-weight-bold file_{{ $index }}_{{ $fileIndex }}-invalid" role="alert"></div>
                                                            @if($file)
                                                            <a href="{{ asset($file) }}" target="_blank">View File</a>
                                                            @endif
                                                        </fieldset>
                                                    </td>
                                                    @endforeach
                                                    <td>
                                                        <div class="form-floating form-floating-outline">
                                                            <button type="button" class="btn btn-outline-danger remove-field">-</button>
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
                                        Update
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
    let countModel = {{ $template->templateModels->count() }};
    var noOfFilesUrl = "{{ url('/noOfFiles') }}";
</script>
<script src="{{ asset('assets/js/addModel.js') }}"></script>
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
                        $('#subcategory').val('{{ $template->sub_category_id }}');
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

        $('.template_type').trigger('change');
        // $('#subcategory').trigger('change');
    });
</script>
@endsection

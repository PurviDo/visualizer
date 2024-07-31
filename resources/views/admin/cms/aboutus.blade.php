@extends('admin.layouts.app')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">About Us</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">About Us</li>
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
                        <form id="profileForm" action="#" method="POST">
                            <div class="card-body">
                                <div class="form-group">
                                    <textarea name="aboutus" class="form-control aboutus" id="summernote_desc" placeholder="Enter AboutUs Details"></textarea>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-info">Save</button>
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
        
    });
</script>
@endsection
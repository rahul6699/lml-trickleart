@extends('admin.layouts.admin')

@section('page-content')
<div class="page-content">
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
        <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">System Information</h5>
                    </div>
                    <div class="card-body">
<form id="formSubmit" action="" onsubmit="form_submit(this);return false;" method="POST">
    <input name="id" type="hidden" value="{{ @$settings->id }}">
    
        @csrf
            <div class="row g-3">
                <div class="col-md-12 mt-3">
                    <label class="form-label">System Name<sup class="text-danger">*</sup></label>
                    <input name="system_name" id="" class="form-control" value="{{ @$settings->system_name }}">
                </div>
                <div class="col-md-12 mt-3">
                    <label class="form-label">System Short Name<sup class="text-danger">*</sup></label>
                    <input name="system_short_name" id="" class="form-control" value="{{ @$settings->system_short_name }}">
                </div>
                <div class="col-md-12 mt-3">
                <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="system_logo" class="form-label">System Logo</label>
                                <input id="system_logo" type="file" class="form-control" name="system_logo" value="{{ @$settings->system_logo }}"  autocomplete="system_logo">
                            </div>
                            @if(@$settings->system_logo)
                            <div class="mb-3 col-md-6">
                                <img src="/system_logo/{{ @$settings->system_logo }}" style="width:80px;margin-top: 10px;">
                            </div>
                            @endif
  
                        </div>
                    </div>
                <div class="col-md-12 mt-3">
                <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="system_cover" class="form-label">System Cover</label>
                                <input id="system_cover" type="file" class="form-control" name="system_cover" value="{{ @$settings->system_cover }}"  autocomplete="system_cover">
                            </div>
                            @if(@$settings->system_cover)
                            <div class="mb-3 col-md-6">
                                <img src="/system_cover/{{ @$settings->system_cover }}" style="width:80px;margin-top: 10px;">
                            </div>
                            @endif
  
                        </div>
                    </div>
                <div class="col-lg-12">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit <i class="st_loader spinner-border spinner-border-sm"
                style="display:none;"></i></button>
                    </div>
                </div><!--end col-->
            </div>
 
</form>
                    </div>
        </div>
</div><!--end row-->
</div>
</div>
@endsection

@section('page-script')
<script>
    function form_submit(e) {

        $(e).find('.st_loader').show();
        var formData = new FormData(this);
        $.ajax({

            url: "{{ route('admin.settings.store') }}",
            method: "POST",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false
            success: function (data) {

                if (data.status == true) {
                    toastr.success(data.message, 'Success');
                    $(e).find('.st_loader').hide();

                } else if (data.success == false) {
                    toastr.error(data.message, 'Error');
                    $(e).find('.st_loader').hide();
                }
            },
            error: function (data) {
                if (typeof data.responseJSON.status !== 'undefined') {
                    toastr.error(data.responseJSON.error, 'Error');
                } else {
                    $.each(data.responseJSON.errors, function (key, value) {
                        toastr.error(value, 'Error');
                    });
                }
                $(e).find('.st_loader').hide();
            }
        });

    }
</script>
@endsection
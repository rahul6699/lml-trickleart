@extends('admin.layouts.admin')

@section('page-content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Leads</h5>
                    </div>
                    <div class="card-body">
                        <form id="formSubmit" action="" onsubmit="form_submit(this);return false;" method="POST">
                        @csrf
                        <input name="id" type="hidden" value="{{ $lead->Client->id }}">
                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label for="fullName" class="form-label">Full Name</label>
                                                <input type="text" name="name" value="{{ $lead->Client->name }}" class="form-control" placeholder="Enter your fullname" id="fullName">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="text" name="email" value="{{ $lead->Client->email }}" class="form-control" placeholder="Enter your email" id="email">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-12 mt-3">
                                            <div class="mb-3">
                                                <label for="gender" class="form-label">Gender</label>
                                                <select name="gender" id="gender"  class="form-select">
                                                    <option selected>Choose...</option>
                                                    <option value="male" @if('male'==$lead->Client->gender) selected="selected" @endif>Male</option>
                                                    <option value="female" @if('female'==$lead->Client->gender) selected="selected" @endif>Female</option>
                                                    <option value="other" @if('other'==$lead->Client->gender) selected="selected" @endif>Other</option>
                                                </select>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label for="birthday" class="form-label">BirthDay</label>
                                                <input type="date" name="dob" value="{{ $lead->Client->dob }}" class="form-control" placeholder="Enter your birthday" id="birthday">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label for="contact_number" class="form-label">Contact Number</label>
                                                <input type="text" name="contact_no" value="{{ $lead->Client->contact_no }}" class="form-control" placeholder="Enter your contact number" id="contact_number">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label for="whatsapp_number" class="form-label">Whatsapp Number</label>
                                                <input type="text" name="whatsapp_no" value="{{ $lead->Client->whatsapp_no }}" class="form-control" placeholder="Enter your whatsapp number" id="whatsapp_number">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label for="address" class="form-label">Address</label>
                                                <textarea name="address" class="form-control"  id="address">{{ $lead->Client->address }}</textarea>
                                            </div>
                                        </div><!--end col-->
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                        
                                    <div class="row">
                                        <div class="col-md-12 ">
                                            <label class="form-label">Interested In<sup
                                                    class="text-danger">*</sup></label>
                                            <input name="interested_in" value="{{ $lead->interested_in }}" id="" class="form-control">
                                        </div>
                                        <div class="col-12 mt-3">
                                            <div class="mb-3">
                                                <label for="leadSource" class="form-label">Lead Source</label>
                                                <select name="source_id"  id="leadSource" class="form-select">
                                                    <option selected>Choose...</option>
                                                    @foreach($source as $sVal)
                                                    <option value="{{$sVal->id}}" @if($sVal->id==$lead->source_id) selected="selected" @endif>{{$sVal->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-12 mt-3">
                                            <label class="form-label">Remarks<sup
                                                    class="text-danger"></sup></label>
                                            <textarea name="remark"  class="form-control" id="" 
                                                rows="5">{{ $lead->remark }}</textarea>
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <label class="form-label">Lead Status<sup
                                                    class="text-danger">*</sup></label>
                                            <select class="form-select" name="lead_status_id" id="statusSelect"
                                                data-placeholder="Select Status" value="{{ $lead->LeadStatus->name }}">
                                                <option value="">Select Status</option>
                                                @foreach($leadStatus as $sVal1)
                                                    <option value="{{$sVal1->id}}" @if($sVal->id==$lead->lead_status_id) selected="selected" @endif>{{$sVal1->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="hstack gap-2 justify-content-end">
                                        <a href="{{ route('admin.leads.index') }}" class="btn btn-light" >Close</a>
                                        <button type="submit" class="btn btn-primary">Update <i class="st_loader spinner-border spinner-border-sm" style="display:none;"></i></button>
                                    </div>
                                </div><!--end col-->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-script')
<script>
    function form_submit(e) {

        $(e).find('.st_loader').show();
        $.ajax({

            url: "{{ route('admin.leads.store') }}",
            method: "POST",
            dataType: "json",
            data: $('#formSubmit').serialize(),
            success: function (data) {

                if (data.status == true) {
                    toastr.success(data.message, 'Success');
                    $(e).find('.st_loader').hide();
                    // $(e)[0].reset();
                    window.location.href = "{{ route('admin.leads.index') }}";

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
@extends('admin.layouts.admin')

@section('page-content')
<div class="page-content">
    <div class="container-fluid">
<div class="row">
<div class="col-xxl-6">
    <h5 class="mb-3">Leads Information</h5>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3">
                    <div class="nav nav-pills flex-column nav-pills-tab custom-verti-nav-pills text-center"
                        role="tablist" aria-orientation="vertical">
                        <a class="nav-link" id="custom-v-pills-home-tab"  onclick="showTabData(this,{{$lead->id}},`information`);return false;">
                            <i class=" las la-info d-block fs-20 mb-1"></i> Information
                        </a>
                        <a class="nav-link" id="custom-v-pills-profile-tab" onclick="showTabData(this,{{$lead->id}},`calllog`);return false;">
                            <i class=" las la-phone-volume d-block fs-20 mb-1"></i> Call Logs
                        </a>
                        <a class="nav-link" id="custom-v-pills-messages-tab" onclick="showTabData(this,{{$lead->id}},`notes`);return false;">
                            <i class=" las la-sticky-note d-block fs-20 mb-1"></i> Notes
                        </a>
                    </div>
                </div> <!-- end col-->
                <div class="col-lg-9">
                    <div class="tab-content text-muted mt-3 mt-lg-0">
                        <div class="tab-pane fade active show" id="custom-v-pills-home" >
                            
                        </div>
                        <!--end tab-pane-->
                        
                    </div>
                </div> <!-- end col-->
            </div> <!-- end row-->
        </div><!-- end card-body -->
    </div>
    <!--end card-->
</div>
<!--end col-->
</div>
</div>
</div>
@endsection

@section('page-script')
<script>
    showTabData('#custom-v-pills-home-tab',{{$lead->id}},'information');
function showTabData(e,id,type) {
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
    $('.nav-link').removeClass('active show');
    $(e).addClass('active show');
   $.ajax({
       url: "{{ route('admin.leads.tabinfo' )}}",
       type: "POST",
       dataType: "json",
       data:{id:id,type:type},
       success: function(res) {
            $('#custom-v-pills-home').html('');
            $('#custom-v-pills-home').html(res.view);
       },
       error: function() {
           alert("Failed to load content.");
       }
   });
}
</script>
@endsection
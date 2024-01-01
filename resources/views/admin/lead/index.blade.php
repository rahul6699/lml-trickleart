@extends('admin.layouts.admin')

@section('page-content')
<div class="page-content">
<div class="container-fluid">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Leads List</h5>
                    <div>
                        <a id="addRow" href="{{ route('admin.leads.create') }}" class="btn btn-primary" >Add Lead</a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatable" class="table nowrap align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sr.no</th>
                                <th>Name</th>
                                <th>Intereste In</th>
                                <th>Lead Source</th>
                                <th>Contact Number</th>
                                <th>Whatsapp Number</th>
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!--end col-->
    </div><!--end row-->
</div>
</div>
@endsection

@section('page-script')

<script type="text/javascript">
$(document).ready(function() {
    /*------------------------------------------
     --------------------------------------------
     Pass Header Token
     --------------------------------------------
     --------------------------------------------*/ 
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });

    window.table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            "url": "{{ route('admin.leads.list') }}",
            "type": "POST",
            "dataType": "json",
        },
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'interested_in',
                name: 'interested_in'
            },
            {
                data: 'lead_source',
                name: 'lead_source'
            },
            {
                data: 'contact_no',
                name: 'contact_no'
            },
            {
                data: 'whatsapp_no',
                name: 'whatsapp_no'
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
            {
                data: 'action',
                name: 'action',
                orderable: true,
                searchable: true
            },
        ]
    });

    $('#datatable').on('page.dt', function() {
        $('#checkAll').prop("checked", false);
        $('.users_check').prop("checked", false);
    });

});

function CheckAll(e) {
    if ($('#checkAll').prop("checked") == true) {
        $('.users_check').prop("checked", true);
    } else {
        $('.users_check').prop("checked", false);
    }
}


function editForm(e,url) {
   $.ajax({
       url: url,
       type: "GET",
       dataType: "json",
       success: function(res) {
            $('#modal-lg .modal-content').html(res.view);
            $('#modal-lg.modal').modal('show');
       },
       error: function() {
           alert("Failed to load content.");
       }
   });
}

function deleteRow(e,url) {

if (confirm("Are You sure want to delete this source!")) {
    $.ajax({
        url: url,
        type: "DELETE",
        dataType: 'json',
        success: function(res) {
            toastr.success(res.message, 'Success');
            // table.ajax.reload();
            table.draw(false);
        },
        error: function(data) {
            if (typeof data.responseJSON.status !== 'undefined') {
                toastr.error(data.responseJSON.error, 'Error');
            } else {
                $.each(data.responseJSON.errors, function(key, value) {
                    toastr.error(value, 'Error');
                });
            }
            // console.log('Error:', data);
        }
    });
}
}

</script>
@endsection
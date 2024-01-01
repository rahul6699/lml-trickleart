
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Log List</h5>
                    <div>
                        <button id="addRow" type="button" class="btn btn-primary" onclick="addForm(this)">Add New Log</button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatable" class="table nowrap align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sr.no</th>
                                <th>Log Type</th>
                                <th>Remark</th>
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
            "url": "{{ route('admin.calllog.list') }}",
            "type": "POST",
            "dataType": "json",
        },
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'log_type',
                name: 'log_type'
            },
            {
                data: 'remark',
                name: 'remark'
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

function addForm(e) {
   $.ajax({
       url: "{{ route('admin.calllog.create' )}}",
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
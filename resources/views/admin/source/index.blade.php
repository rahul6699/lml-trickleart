@extends('admin.layouts.admin')

@section('page-content')
<div class="page-content">
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Lead Sources List</h5>
                    <div>
                        <button id="addRow" type="button" class="btn btn-primary" onclick="addForm(this)">Add Lead Source</button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatable" class="table nowrap align-middle" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th>Sr.no</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Status</th>
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
            "url": "{{ route('admin.source.list') }}",
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
                data: 'description',
                name: 'description'
            },
            {
                data: 'status',
                name: 'status'
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
       url: "{{ route('admin.source.create' )}}",
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

//   $(function () {
      

      
//     /*------------------------------------------
//     --------------------------------------------
//     Render DataTable
//     --------------------------------------------
//     --------------------------------------------*/
//     var table = $('#datatables').DataTable({
//         processing: true,
//         serverSide: true,
//         ajax: "{{ route('admin.source.index') }}",
//         columns: [
//             {data: 'DT_RowIndex', name: 'DT_RowIndex'},
//             {data: 'name', name: 'name'},
//             {data: 'description', name: 'description'},
//             {data: 'action', name: 'action', orderable: false, searchable: false},
//         ]
//     });
      
//     /*------------------------------------------
//     --------------------------------------------
//     Click to Button
//     --------------------------------------------
//     --------------------------------------------*/
//     $('#createNewProduct').click(function () {
//         $('#saveBtn').val("create-product");
//         $('#product_id').val('');
//         $('#productForm').trigger("reset");
//         $('#modelHeading').html("Create New Product");
//         $('#ajaxModel').modal('show');
//     });
      
//     /*------------------------------------------
//     --------------------------------------------
//     Click to Edit Button
//     --------------------------------------------
//     --------------------------------------------*/
//     $('body').on('click', '.editProduct', function () {
//       var product_id = $(this).data('id');
//       $.get("{{ route('admin.source.index') }}" +'/' + product_id +'/edit', function (data) {
//           $('#modelHeading').html("Edit Product");
//           $('#saveBtn').val("edit-user");
//           $('#ajaxModel').modal('show');
//           $('#product_id').val(data.id);
//           $('#name').val(data.name);
//           $('#detail').val(data.detail);
//       })
//     });
      
//     /*------------------------------------------
//     --------------------------------------------
//     Create Product Code
//     --------------------------------------------
//     --------------------------------------------*/
//     $('#saveBtn').click(function (e) {
//         e.preventDefault();
//         $(this).html('Sending..');
      
//         $.ajax({
//           data: $('#productForm').serialize(),
//           url: "{{ route('admin.source.store') }}",
//           type: "POST",
//           dataType: 'json',
//           success: function (data) {
       
//               $('#productForm').trigger("reset");
//               $('#ajaxModel').modal('hide');
//               table.draw();
           
//           },
//           error: function (data) {
//               console.log('Error:', data);
//               $('#saveBtn').html('Save Changes');
//           }
//       });
//     });
      
//     /*------------------------------------------
//     --------------------------------------------
//     Delete Product Code
//     --------------------------------------------
//     --------------------------------------------*/
//     $('body').on('click', '.deleteProduct', function () {
     
//         var product_id = $(this).data("id");
//         confirm("Are You sure want to delete !");
        
//         $.ajax({
//             type: "DELETE",
//             url: "{{ route('admin.source.store') }}"+'/'+product_id,
//             success: function (data) {
//                 table.draw();
//             },
//             error: function (data) {
//                 console.log('Error:', data);
//             }
//         });
//     });
       
//   });
</script>
@endsection
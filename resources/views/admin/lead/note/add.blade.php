<form id="formSubmit" action="" onsubmit="form_submit(this);return false;" method="POST">
    <div class="modal-header">
        <h4 class="modal-title">Add New Note</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        @csrf
            <div class="row g-3">
                <div class="col-12 mt-3">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" placeholder="Enter your title" id="title">
                    </div>
                </div><!--end col-->
                <div class="col-md-12 mt-3">
                    <label class="form-label">Note<sup class="text-danger"></sup></label>
                    <textarea name="note" class="form-control" id="" cols="113" rows="5"></textarea>
                </div>

                <div class="col-lg-12">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit <i class="st_loader spinner-border spinner-border-sm"
                style="display:none;"></i></button>
                    </div>
                </div><!--end col-->
            </div>
    </div>
</form>
<script>
    function form_submit(e) {

        $(e).find('.st_loader').show();
        $.ajax({

            url: "{{ route('admin.note.store') }}",
            method: "POST",
            dataType: "json",
            data: $('#formSubmit').serialize(),
            success: function (data) {

                if (data.status == true) {
                    toastr.success(data.message, 'Success');
                    $(e).find('.st_loader').hide();
                    $(e)[0].reset();
                    $('#modal-lg').modal('hide');
                    $('#modal-lg .modal-content').html('');
                    table.draw(false);

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
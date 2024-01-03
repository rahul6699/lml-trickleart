<form id="formSubmit" action="" onsubmit="form_submit(this);return false;" method="POST">
    <input name="id" type="hidden" value="{{ $CallLog->id }}">
    <div class="modal-header">
        <h4 class="modal-title">Show CallLog</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body ">
        @csrf
            <div class="row g-3">
                <div class="col-md-12 mt-3">
                    <label class="form-label">Log Type<sup class="text-danger">*</sup></label>
                    <select class="form-select" name="log_type" id="statusSelect" data-placeholder="Select Status" disabled>
                        <option value="outbound" @if("outbound"==$CallLog->log_type) selected="selected" @endif>Outbound</option>
                        <option value="inbound" @if("inbound"==$CallLog->log_type) selected="selected" @endif>Inbound</option>
                    </select>
                </div>
                <div class="col-md-12 mt-3">
                    <label class="form-label">Remark<sup class="text-danger"></sup></label>
                    <textarea name="remark" class="form-control" id="" cols="113" rows="5" disabled>{{ $CallLog->remark }}</textarea>
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
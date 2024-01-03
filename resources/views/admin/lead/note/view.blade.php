<form id="formSubmit" action="" onsubmit="form_submit(this);return false;" method="POST">
    <input name="id" type="hidden" value="{{ $Note->id }}">
    <div class="modal-header">
        <h4 class="modal-title">Show Note</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body ">
        @csrf
            <div class="row g-3">
                <div class="col-12 mt-3">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" placeholder="Enter your title" id="title" value="{{ $Note->title }}" disabled>
                    </div>
                </div><!--end col-->
                <div class="col-md-12 mt-3">
                    <label class="form-label">Note<sup class="text-danger"></sup></label>
                    <textarea name="note" class="form-control" id="" cols="113" rows="5" disabled>{{ $Note->note }}</textarea>
                </div>

                <div class="col-lg-12">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    </div>
                </div><!--end col-->
            </div>
    </div>
</form>
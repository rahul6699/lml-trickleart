<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">{{ @$pageTitle }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form class="form" onsubmit="formSubmit(this,'{{ @$formRoute }}', '{{ $formMethod }}'); return false;">
        @csrf
        <div class="modal-body">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" value="{{ @$formData->name }}" />
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">{{ isset($data) ? 'Update' : 'Submit' }}</button>
        </div>
    </form>
</div>
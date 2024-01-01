var table;
function addItemModel(e, actionUrl, method = 'GET', form = '{}') {
    $.ajax({
        type: method,
        url: actionUrl,
        data: form,
        dataType: "json",
        success: function (result) {
            $('#staticBackdrop').modal('show');
            $('#staticBackdrop .modal-dialog').html(result.view);
        }
    });
}


function formSubmit(e, actionUrl, method = 'POST') {
    $.ajax({
        type: method,
        url: actionUrl,
        dataType: "json",
        data: $(e).serialize(),
        success: function (result) {
            $('.modal').modal('hide');
            $('.modal .modal-content').html('');
            swalSuccess(result.success);
            table.ajax.reload();
        },
        error: function (xhr, status, error) {
            // Handle errors
            console.error('Error:', xhr, status, error);

            if (xhr.responseJSON && xhr.responseJSON.errors) {
                handleValidationErrors(xhr.responseJSON.errors);
            }
        }
    });
}


function listDatatable(e, actionUrl, columns = '') {
    table = $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: actionUrl,
        columns: columns
    });
}

function handleValidationErrors(errors) {
    // Clear previous error messages
    $('.error-message').remove();

    // Loop through the errors object and display error messages
    $.each(errors, function (field, messages) {
        var inputField = $('[name="' + field + '"]');
        var errorMessage = '<span class="error error-message text-danger">' + messages[0] + '</span>';
        inputField.after(errorMessage);
    });
}




function deleteItem(e, actionUrl) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger m-2"
        },
        buttonsStyling: false
    });
    swalWithBootstrapButtons.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            ajaxDelete(actionUrl);

        } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire({
                title: "Cancelled",
                text: "Your imaginary file is safe :)",
                icon: "error"
            });
        }
    });
}

function ajaxDelete(actionUrl, data = '{}') {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    });
    $.ajax({
        type: 'DELETE',
        url: actionUrl,
        dataType: "json",
        data: data,
        success: function (result) {
            swalSuccess(result.success);
            table.ajax.reload();

        },
        error: function (xhr, status, error) {
            Swal.fire({
                title: "Cancelled",
                text: "Something went to wrong :)",
                icon: "error"
            });
        }
    });
}



function swalSuccess(message) {
    Swal.fire({
        position: "center",
        icon: "success",
        title: message,
        showConfirmButton: false,
        timer: 1500
    });
}
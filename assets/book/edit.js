import {successMessage} from "./success-message";

$(function () {
    $(document).on('click', '#edit-book', function () {
        const id = $(this).closest('tr').data('id');
        $('#modal').removeClass('hidden')
            .find('#modal-content')
            .load('/books/' + id + '/edit');
    });

    $(document).on('submit', '#book-form', function (e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url:  this.action,
            data: $(this).serialize(),
            success: function () {
                $('#modal').addClass('hidden');
                $('#book-table').load('/books/ #book-table > *');

                successMessage('Book updated successfully.')
            },
            error: function (response) {
                if (response.status < 500) {
                    $('#modal-content').html(response.responseText);
                } else {
                    $('#unexpected-error').removeClass('hidden')
                }
            }
        });
    });

});
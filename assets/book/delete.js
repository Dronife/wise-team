import {successMessage} from "./success-message";
import {errorMessage} from "./error-message";

$(document).on('click', '.del-book', function (e) {
    e.preventDefault();
    if (!confirm('Delete this book?')) return;

    const tr = $(this).closest('tr');
    const id = tr.data('id');

    $.ajax({
        type: 'DELETE',
        url: '/books/' + id,
        success: function () {
            $('#book-table').load('/books #book-table > *')
            successMessage('Book deleted successfully.')
        },
        error: function() {
            errorMessage('Something bad happened can not delete book. Try again later.')
        }
    });
});
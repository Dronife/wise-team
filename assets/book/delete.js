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
            let successMessage = $('#success-message');

            successMessage.removeClass('hidden').text('Book deleted successfully.');
            setTimeout(() => {
                successMessage.hide(0, function () {
                    $(this).addClass('hidden').text('');
                });
            }, 5000);
        },
        error: function() {
            let errorMessage = $('#error-message');

            errorMessage.removeClass('hidden').text('Something bad happened can not delete book. Try again later.');
            setTimeout(() => {
                errorMessage.hide(0, function () {
                    $(this).addClass('hidden').text('');
                });
            }, 5000);
        }
    });
});
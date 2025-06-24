$(function () {
    $('#add-book').on('click', function () {
        $('#modal').removeClass('hidden')
            .find('#modal-content')
            .load('/books/new');
    });

    $(document).on('submit', '#book-form', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: this.action,
            data: $(this).serialize(),
            success: function () {
                $('#modal').addClass('hidden');
                $('#book-table').load('/books/ #book-table > *');
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

    $('#modal').on('click', function (element) {
        if (element.target === this) $(this).addClass('hidden');
    });
});
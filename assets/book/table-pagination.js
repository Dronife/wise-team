$(document).on('click', '#book-table .pagination a', function (e) {
    e.preventDefault();
    const url = $(this).attr('href');

    $('#book-table').load(url + ' #book-table > *');
});
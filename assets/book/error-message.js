export function errorMessage(message) {
    let errorMessage = $('#error-message');

    errorMessage.removeClass('hidden').text(message);
    setTimeout(() => {
        errorMessage.hide(0, function () {
            $(this).addClass('hidden').text('');
        });
    }, 5000);
}

window.errorMessage = errorMessage;
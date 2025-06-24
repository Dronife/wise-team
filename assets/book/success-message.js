export function successMessage(message) {
    let successMessage = $('#success-message');

    successMessage.removeClass('hidden').text(message);
    setTimeout(() => {
        successMessage.hide(0, function () {
            $(this).addClass('hidden').text('');
        });
    }, 5000);
}

window.successMessage = successMessage;
var loading = null;

function showWait(preloader) {
    var div = $('<div class="div-wait"/>').css({
        'cursor': 'wait',
        'z-index': 9999,
        'height': '100%',
        'width': '100%',
        'left': 0,
        'position': 'fixed',
        'top': 0,
        'text-align': 'center',
    })
    $('body').css("overflow", "hidden").append(div);

    if (preloader) {
        div.append($('<div style="background: black;width: 80px;padding: 15px 0;text-align: center;border-radius: 6px;opacity: 0.8;display: inline-block;position: absolute;top: 50%;transform: translate(0, -50%);"><img src="assets/vendor/jquery-loading/img/ajax-loading.gif">'))
    }
}

function hideWait() {
    $('body').css("overflow", "");
    $('.div-wait').remove();
}

function showLoading(msg) {
    if (!loading) {
        loading = $.loading({
            imgPath: '/assets/vendor/jquery-loading/img/ajax-loading.gif',
        });
        loading.ajax(false);
    }

    loading.open();
    $('#ajaxLoading p').text(msg);
    showWait();
}
function hideLoading() {
    if (loading) loading.close();
    hideWait();
}


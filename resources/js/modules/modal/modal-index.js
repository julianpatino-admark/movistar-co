$(document).on('show.bs.modal', '.modal', function () {

    let zIndex = 1040 + (10 * $('.modal:visible').length);

    $(this).css('z-index', zIndex);
    setTimeout(function () {
        $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
    }, 0);

});

$(document).on('hidden.bs.modal', '.modal', function () {
    const parent = $('.modal.show').get().sort((a, b) =>
        Number($(b).css('z-index')) - Number($(a).css('z-index'))
    )[0];
    if (!parent) return;

    // Bootstrap 4 clears these global handlers and the scroll lock when any modal closes.
    const instance = $(parent).data('bs.modal');
    instance._setScrollbar();
    instance._enforceFocus();
    instance._setResizeEvent();
    if (!parent.contains(document.activeElement)) parent.focus();
});

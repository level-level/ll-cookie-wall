$(document).ready(function () {

    var header = $('.main-header');
    $(window).on("scroll", function (e) {
        if ($(this).scrollTop() > 100) {
            header.addClass("sticky");
        } else {
            header.removeClass("sticky");

        }
    });
});

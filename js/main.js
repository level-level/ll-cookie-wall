$(document).ready(function () {

    var header = $('.main-header');
    $(window).on("scroll", function (e) {
        if ($(this).scrollTop() > 100) {
            header.addClass("sticky");
        } else {
            header.removeClass("sticky");

        }
    });

    $('.popup').click(function(event) {
        var width  = 575,
            height = 400,
            left   = ($(window).width()  - width)  / 2,
            top    = ($(window).height() - height) / 2,
            url    = this.href,
            opts   = 'status=1' +
                ',width='  + width  +
                ',height=' + height +
                ',top='    + top    +
                ',left='   + left;

        window.open(url, 'popup', opts);

        return false;
    });
});

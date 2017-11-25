if (jQuery(".nav-mobile").css('display') == 'none') {
    jQuery.event.add(window, "load", resizeFrame);
    jQuery.event.add(window, "resize", resizeFrame);

    function resizeFrame() {
        var h = $(window).height();

        $(".content").css('height', h);
        $(".nav-desktop").css('height', h);
    }
}
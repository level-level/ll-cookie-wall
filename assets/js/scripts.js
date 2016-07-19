function parseURLParams(url) {
    var queryStart = url.indexOf("?") + 1,
        queryEnd   = url.indexOf("#") + 1 || url.length + 1,
        query = url.slice(queryStart, queryEnd - 1),
        pairs = query.replace(/\+/g, " ").split("&"),
        parms = {}, i, n, v, nv;

    if (query === url || query === "") {
        return;
    }

    for (i = 0; i < pairs.length; i++) {
        nv = pairs[i].split("=");
        n = decodeURIComponent(nv[0]);
        v = decodeURIComponent(nv[1]);

        if (!parms.hasOwnProperty(n)) {
            parms[n] = [];
        }

        parms[n].push(nv.length === 2 ? v : null);
    }
    return parms;
}

$(document).ready(function() {
    var parts = location.hostname.split('.');
    var domain = parts.slice(-2).join('.');
    domain = '.'+domain;

    var getvars      = parseURLParams( window.location.href );
    if( undefined == getvars || undefined == getvars.url_redirect ) {
        var redirect_url = '/';
    } else {
        var redirect_url = getvars.url_redirect[0];
    }

    $("#expand_description").click(function(e) {
        e.preventDefault();
        $("#llcw_read_more").stop(1,1).slideToggle(250);
    });

    $("#ll_cookie_form").submit(function(e){
        e.preventDefault();

        $.cookie( 'll_cookie_wall', 'll_cookie_wall', { expires: 365, path: '/', domain: domain } );

        window.location.href = redirect_url;
    });
    $('#agree_with_cookie_terms').click(function(e) {
        e.preventDefault();
        $.cookie( 'll_cookie_wall', 'll_cookie_wall', { expires: 365, path: '/', domain: domain } );

        window.location.href = redirect_url;
    });
});
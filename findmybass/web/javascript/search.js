var delay = (function () {
    var timer = 0;
    return function (callback, ms) {
        clearTimeout(timer);
        timer = setTimeout(callback, ms);
    };
})();

$('.bass-search-field').keyup(function () {
    var query = $(this).val();
    var url = "/search/" + query;
    var input = $(this);
    var dropdowndiv = $(this).next("div");

    if (query.length > 2) {
        delay(function () {
            $.post(url, null, function (data, status) {

                input.next("div").addClass('show-proposals');
                $.each(data, function (bass, url) {
                    $("<a>", {href: url}).text(bass).appendTo(dropdowndiv);
                });
            }).fail(function (err, status) {
                console.error(err);
                console.error("Ajax search request to " + url + " has failed with status: " + status +
                    " and error: " + err);
            });
        }, 1000);
    }
});
$(document).ready(function () {

    $("#deleteFilm").click(function () {
        var ajaxurl = 'ajax.php';
        var data = {
            'action': "deleteFilm",
            'id': $("#deleteFilm").attr("filmId")
        };
        $.post(ajaxurl, data, function (response) {
            window.location = 'http://localhost/yushare/index.php';
        });
    });

    $("#logout").click(function () {
        var ajaxurl = 'ajax.php';
        var data = {
            'action': "logout",
        };
        $.post(ajaxurl, data, function (response) {
            console.log("logged out");
        });
    });
});
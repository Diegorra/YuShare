$(document).ready(function () {

    $("#deleteFilm").click(function () {
        var ajaxurl = 'ajax.php';
        var data = {
            'action': "deleteFilm",
            'id': $("#deleteFilm").attr("filmId"),
            'userID': $("#deleteFilm").attr("userID")
        };
        $.post(ajaxurl, data, function (response) {
            alert("Deleting the film");
        });
    });

    $("#logout").click(function () {
        var ajaxurl = 'ajax.php';
        var data = {
            'action': "logout",
        };
        $.post(ajaxurl, data, function (response) {
            //alert("Deleting the film");
            console.log("logged out");
        });
    });



});
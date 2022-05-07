$(document).ready(function () {
    console.log("JS cargado");
    $("#deleteFilm").click(function () {
        var ajaxurl = 'ajax.php';
        var data = {
            'action': "deleteFilm",
            'id': $(this).attr("filmId")
        };
        $.post(ajaxurl, data, function (response) {
            window.location = 'http://localhost/yushare/index.php';
        });
    });

    $("#addFriend").click(function () {
        var ajaxurl = 'ajax.php';
        var data = {
            'action': "addFriend",
            'id': $(this).attr("addFriendId")
        };
        $.post(ajaxurl, data, function (response) {
            alert("Tu solicitud se ha mandado con éxito");
        });
    });

    $(".deleteFriend").each(function () {
        $(this).on("click", function () {
            var ajaxurl = 'ajax.php';
            var data = {
                'action': "deleteFriend",
                'id': $(this).attr("friendId")
            };
            $.post(ajaxurl, data, function (response) {
                window.location = 'http://localhost/yushare/showFriends.php';
            });
        });
    });

    $(".acceptFriend").each(function () {
        $(this).on("click", function () {
            var ajaxurl = 'ajax.php';
            var data = {
                'action': "acceptFriend",
                'id': $(this).attr("addFriendId")
            };
            $.post(ajaxurl, data, function (response) {
                window.location = 'http://localhost/yushare/showFriends.php';
            });
        });
    });

    $(".deleteU").each(function () {
        $(this).on("click", function () {
            var ajaxurl = 'ajax.php';
            var data = {
                'action': "deleteUser",
                'id': $(this).attr("idU")
            };
            $.post(ajaxurl, data, function (response) {
                window.location = 'http://localhost/yushare/admin.php';
            });
        });
    });

	
    $(".ban").each(function () {
        $(this).on("click", function () {
            var ajaxurl = 'ajax.php';
            var data = {
                'action': "ban",
                'id': $(this).attr("idU")
            };
            $.post(ajaxurl, data, function (response) {
                //console.log(response);
                window.location = 'http://localhost/yushare/admin.php';
            });
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

    $("#file").change(function () {
        console.log("File changed");
        const file = $("#file")[0].files[0];
        var reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function () {
            localStorage.setItem("image", reader.result);
            $("#imagePreview").attr("src", localStorage.getItem("image"))
        };
        if (localStorage.getItem("image"))
            $("#imagePreview").attr("src", localStorage.getItem("image"))

    })
});

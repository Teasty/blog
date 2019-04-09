function post_query(name, url, data, func_name) {
    var str = 'name=' + name + '_f';
    try {
        $.each(data.split('.'), function (key, value) {
            if (value == 'ImportantCheck') {
                if ($('#' + value).is(":checked")) {
                    str += '&' + value + '=1';
                } else {
                    str += '&' + value + '=0';
                }
            } else {
                str += '&' + value + '=' + $("#" + value).val();
            }
        })
    } catch (err) {

    }
    $.ajax({
        url: '..//funcs/' + url + '.php',
        type: 'POST',
        data: str,
        chace: false,
        success: function (result) {
            if (result == 'success') {
                if (func_name == "login_func") {
                    login_func();
                } else if (func_name == "register_func") {
                    register_func();
                } else if (func_name == "post_comment_func") {
                    post_comment_func();
                } else if (func_name == "add_post_func") {
                    add_post_func();
                }
            } else {
                alert(result);
            }
        }
    })
}

function login_func() {
    $("#login_form").load(" #login_form");
    $(".posts").load(" .posts");
    return false;
}

function register_func() {
}

function post_comment_func() {
    $("#comment_section").load(" #comment_section");
}

function add_post_func() {
    window.location.pathname = '/blog/templates/home.php';
}


function like_func(data) {
    $.ajax({
        url: '..//funcs/manage.php',
        type: 'POST',
        data: 'name=like_f&post_id=' + data,
        chace: false,
        success: function (result) {
            if (result == 'like') {
                document.querySelectorAll("#post_" + data + " .like")[0].innerHTML = parseInt(document.querySelectorAll("#post_" + data + " .like")[0].innerHTML) + 1;
                document.querySelectorAll("#post_" + data + " .fa-heart")[0].style.color = "#cc00db";
            } else if (result == 'dislike') {
                document.querySelectorAll("#post_" + data + " .like")[0].innerHTML = parseInt(document.querySelectorAll("#post_" + data + " .like")[0].innerHTML) - 1;
                document.querySelectorAll("#post_" + data + " .fa-heart")[0].style.color = "#D3D3D3";
            } else {
                alert(result);
                return false;
            }
        }
    })
}

function view_counter(data) {
    $.ajax({
        url: '..//funcs/manage.php',
        type: 'POST',
        data: 'name=view_f&post_id=' + data,
        chace: false,
        success: function (result) {
            alert(result);
        }
    })
}

$(function () {
    $('div[onload]').trigger('onload');
});

function show_more(id) {
    var x = document.getElementById(id);
    var y = document.getElementById('hidden-' + id);
    y.style.display = "block";
    x.style.display = "none";
}

function show_more_set(id, sent_to_count) {
    var content = $("#" + id);
    var text = content.text();
    text = text.split('. ').slice(0, sent_to_count).join('. ');
    content.text(text);
    content.append("....<a class='text-primary' style='cursor:pointer' onclick=show_more(" + id + ")>Читать далее</a>");
}

function show_more_set_fav(id, sent_to_count) {
    var content = $(" #fav-" + id);
    var text = content.text();
    text = text.split('. ').slice(0, sent_to_count).join('. ');
    content.text(text);
    content.append(".");
}

function important_more(sent_to_count) {
    var content = $(".important-p");
    var text = content.text();
    text = text.split('. ').slice(0, sent_to_count).join('. ');
    content.text(text);
    content.append(".");
}
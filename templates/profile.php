<?php
session_start();
include('../funcs/connection.php');
if(!isset($_SESSION['id'])){
    header('Location: ..//index.php');
}else{
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="..//style/main.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/"
        crossorigin="anonymous">
    <title>
        <?php echo $_SESSION[username]; ?>
    </title>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous"></script>
    <script src="..//script.js">

    </script>
</head>

<body>
    <header>
        <?php include('menu.php'); ?>
    </header>
    <div class="cover">
        <div class="container mt-5 mb-5">
            <h1 style="text-transform: uppercase; text-indent: 20px;">
                Привет
                <?php echo $_SESSION[username]; ?>
            </h1>
            <div class="profile mt-5">
                <div id="user_profile" style="margin-left: 66%;">
                    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#liked_posts"
                        aria-expanded="true" aria-controls="liked_posts">
                        Потсы
                    </button>
                    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#user_comments"
                        aria-controls="user_comments">
                        Комментарии
                    </button>
                    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#user_edit"
                        aria-controls="user_edit">
                        Редактирование
                    </button>
                </div>
                <div class="user_activities">
                    <div class="collapse" id="liked_posts">
                        <ul class="posts list-unstyled mt-5 col-md-12">
                            <?php
                                $posts = $db->query("SELECT * FROM posts JOIN likes ON posts.id = likes.post_id WHERE likes.user_id = ".$_SESSION[id]);
                                while($data = $posts->fetch_assoc()){
                        ?>
                            <li class="post rounded mb-4 shadow-sm h-md-250 position-relative p-5 bg-light" style="margin-bottom: 30px;"
                                id="post_<?php echo $data[id];?>">
                                <?php if ($_SESSION["type"]==1) { ?>
                                <ul class="edit list-inline float-right">
                                    <li class="list-inline-item"><a href="editpost.php?id=<?php echo $data[id];?>"><i
                                                class="fas fa-edit"></i></i></a></li>
                                    <li class="list-inline-item"><a href="../funcs/delete_post.php?id=<?php echo $data[id];?>"><i
                                                class="fas fa-times"></i></a></li>
                                </ul>
                                <?php } ?>
                                <div class="media-body">
                                    <a style="text-decoration: none" href="postpage.php?id=<?php echo $data[id];?>">
                                        <h1 class="mt-0 mb-1 display-4">
                                            <?php echo $data["title"];?>
                                        </h1>
                                    </a>
                                    <div class="lead long_desc" style="display:block;" id='<?php echo $data["id"];?>'
                                        onload="show_more_set(<?php echo $data[id]?>, 4)">
                                        <?php echo $data["text"];?>
                                    </div>
                                    <div class="lead long_desc" style="display: none;" id='hidden-<?php echo $data["id"];?>'>
                                        <?php echo $data["text"];?>
                                    </div>
                                </div>
                                <div class="likes">
                                    <ul class="list-inline float-right">
                                        <li class="list-inline-item">
                                            <?php
                                    $likes = $db->query("SELECT COUNT(*) FROM `likes` WHERE (`post_id`= '$data[id]' AND `user_id`= '$_SESSION[id]')");
                                    $ldata = $likes->fetch_assoc();
                                    if ($ldata["COUNT(*)"] != 0) {
                                        echo "<i onclick='like_func( ".$data[id]."); return false;' class='fas fa-heart' style='cursor: pointer; color:#cc00db;'></i>";
                                    }else {
                                        echo "<i onclick='like_func(".$data[id]."); return false;' class='fas fa-heart' style='cursor: pointer; color:#D3D3D3;'></i>";
                                    };
                                     ?>
                                        </li>
                                        <li class="list-inline-item"><a class="like" style="text-decoration: none" href="#"
                                                onclick="like_func(<?php echo $data[id] ?>); return false;">
                                                <?php
                                        $likes = $db->query("SELECT COUNT(*) FROM `likes` WHERE `post_id`= '$data[id]'");
                                        $row = $likes->fetch_assoc();
                                        $count = $row["COUNT(*)"];
                                        echo $count;
                                    ?></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <?php
                                        $coms = $db->query("SELECT COUNT(*) FROM `comments` WHERE (`post_id`= '$data[id]' AND `user_id`= '$_SESSION[id]')");
                                        $cdata = $coms->fetch_assoc();
                                        if ($cdata["COUNT(*)"] != 0) {
                                            echo "<i class='fas fa-comment' style='color:#4391eb;'></i>";
                                        }else {
                                            echo "<i class='fas fa-comment' style='color:#D3D3D3;'></i>";
                                        };
                                         ?>
                                        </li>
                                        <li class="list-inline-item"></a>
                                            <span class="text-primary">
                                                <?php
                                                    $comments = $db->query("SELECT COUNT(*) FROM `comments` WHERE `post_id`= '$data[id]'");
                                                    $crow = $comments ->fetch_assoc();
                                                    $ccount = $crow["COUNT(*)"];
                                                    echo $ccount;
                                    ?>
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <?php }; ?>
                        </ul>
                    </div>

                    <div class="collapse mt-5 mb-5" id="user_comments">
                        <?php
                                $commentsss = $db->query("SELECT * FROM users JOIN comments ON users.id = comments.post_id WHERE comments.user_id =".$_SESSION[id]);
                                while($udata = $commentsss->fetch_assoc()){
                        ?>
                        <div class="jumbotron p-3">
                            <div class="row">
                                <h3 class="col-10">
                                    <?php echo $udata[username]; ?>
                                </h3>
                                <p class="col-2">
                                    <?php echo $udata['date_time']; ?>
                                </p>
                            </div>
                            <p class="pl-3">
                                <?php echo $udata['text']; ?>
                            </p>
                        </div>
                        <?php
                            };
                        ?>
                    </div>

                    <div class="collapse mt-5 mb-5" id="user_edit">
                        <form action="../funcs/manage.php" method="post">
                            <div class="form-group">
                                <input type="hidden" name="name" value="set_username_f">
                                <label for="username">Выедите новое имя пользователя</label>
                                <input type="text" class="form-control col-6" name="username" id="username" placeholder="Username">
                            </div>
                            <button type="submit" class="btn btn-primary">Изменить</button>
                        </form>
                        <form class="mt-3" action="../funcs/manage.php" method="post">
                            <div class="form-group">
                                <input type="hidden" name="name" value="set_password_f">
                                <label for="old_password">Введите старый пароль</label>
                                <input type="password" class="form-control col-6" id="old_password" name="old_password"
                                    placeholder="Password">
                                <label for="new_password">Введите новый пароль</label>
                                <input type="password" class="form-control col-6" id="new_password" name="new_password"
                                    placeholder="Password">
                                <label for="repeat_password">Повторите новый пароль</label>
                                <input type="password" class="form-control col-6" id="repeat_password" name="repeat_password"
                                    placeholder="Password">
                            </div>
                            <button type="submit" class="btn btn-primary">Изменить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<footer>
    <?php include('footer.php'); ?>
</footer>
<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>
<script>
    $('#user_edit').collapse({
        show: true
    })
</script>

</html>
<?php
}
?>
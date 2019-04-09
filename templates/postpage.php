<?php
session_start();
include('../funcs/connection.php');
if(isset($_GET['id'])){
    $table = 'posts';
    $posts = $db->query('SELECT * from '.$table.' WHERE `id` = '.$_GET['id']);
    $data = $posts->fetch_assoc()
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
        <?php echo $data["title"] ?>
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
        <div class="container" style="margin-top:30px;">
            <div class="post rounded mb-4 shadow-sm h-md-250 position-relative p-5 bg-light" style="margin-bottom: 30px;"
                id="post_<?php echo $data[id];?>">
                <?php if ($_SESSION["type"]==1) { ?>
                <ul class="edit list-inline float-right">
                    <li class="list-inline-item"><a href="editpost.php?id=<?php echo $data[id];?>"><i class="fas fa-edit"></i></i></a></li>
                    <li class="list-inline-item"><a href="../funcs/delete_post.php?id=<?php echo $data[id];?>"><i class="fas fa-times"></i></a></li>
                </ul>
                <?php } ?>
                <div class="media-body">
                    <a style="text-decoration: none" href="postpage.php?id=<?php echo $data[id];?>">
                        <h1 class="mt-0 mb-1">
                            <?php echo $data["title"];?>
                        </h1>
                    </a>
                    <p class="lead">
                        <?php echo $data["text"];
                            ?>
                    </p>
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
                        <li class="list-inline-item"><a class="like" style="text-decoration: none" href="#" onclick="like_func(<?php echo $data[id] ?>); return false;">
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
                            <span class="">
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
            </div>
            <div id="comment_section">
                <div class="comments">
                    <h2>Комментарии:</h2>
                    <?php
                    $comments = $db->query('SELECT * from `comments`');
                    while($cdata = $comments->fetch_assoc()){
                    if ($cdata['post_id'] == $data['id']) {
                        $user = $db->query('SELECT * from `users` WHERE `id` = '.$cdata['user_id']);
                        $udata = $user->fetch_assoc();
                        ?>
                    <div class="jumbotron p-3">
                        <div class="row">
                            <h3 class="col-10">
                                <?php echo $udata[username]; ?>
                            </h3>
                            <p class="col-2">
                                <?php echo $cdata['date_time']; ?>
                            </p>
                        </div>
                        <p class="pl-3">
                            <?php echo $cdata['text']; ?>
                        </p>
                    </div>
                    <?php
                    };
                }; ?>
                </div>
                <?php if (isset($_SESSION[username])) { ?>
                <form style="margin-top: 30px;">
                    <div class="form-group">
                        <h3>Написать комментарий</h3>
                        <input type="hidden" id="post_id" value="<?php  echo $data[id] ?>">
                        <textarea class="form-control" name="comment" id="post_comment_area" placeholder="Коментарий"
                            rows="8" cols=""></textarea>
                    </div>
                    <button type="submit" style="margin-bottom: 30px;" class="btn btn-primary" onclick="post_query('post_comment', 'manage', 'post_id.post_comment_area', 'post_comment_func'); return false;">Отправить</button>
                </form>
                <?php } ?>
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

</html>
<?php
}
?>
<?php session_start();
   include("../funcs/connection.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
    <link rel="stylesheet" href="..//style/main.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/"
        crossorigin="anonymous">
    <title>Home</title>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous"></script>
    <script src="..//script.js">

    </script>
</head>

<body>
    <header>
        <?php include('menu.php'); ?>
    </header>
    <div class="container mt-5 mb-5">
        <div class="m-3 mb-5">
            <?php 
            $categories = $db->query("SELECT * from `categories` WHERE `id`=".$_GET[id]);
            $cdata = $categories->fetch_assoc(); ?>
            <h1 class="display-1">
                <?php echo($cdata["category_name"]); ?>
            </h1>
            <h2>
                <small class="text-muted">
                    <?php echo($cdata["info"]); ?>
                </small>
            </h2>
        </div>
        <ul class="posts list-unstyled col-md-12">
            <?php   
                $posts = $db->query("SELECT * from `posts` WHERE `category`='$_GET[id]' ORDER BY `date_time` DESC");
                while($data = $posts->fetch_assoc()){
                        ?>
            <li class="post rounded mb-4 shadow-sm h-md-250 position-relative p-5 bg-light" style="margin-bottom: 30px;"
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
                    <div class="lead long_desc" style="display:block;" id='<?php echo $data["id"];?>' onload="show_more_set(<?php echo $data[id]?>, 4)">
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
</body>
<?php include('footer.php'); ?>
<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>

</html>
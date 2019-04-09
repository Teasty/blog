<div class="jumbotron bg-primary" style="margin-top: 30px;">
    <?php
        $ipost = $db->query('SELECT * from `posts` WHERE (`important`=1) ORDER BY `date_time` DESC');
        $idata = $ipost->fetch_assoc();
?>
    <h1 class="display-4 text-white">
        <?php echo $idata[title];?>
    </h1>
    <hr class="my-4 bg-white">
    <div class="text-white lead important-p" onload='important_more(2)'>
        <?php echo $idata[text];?>
    </div>
    <a class="btn btn-outline-light btn-lg mt-4" href="postpage.php?id=<?php echo $idata[id];?>" role="button">
        Подробнее</a>
</div>
<div class="content row" style="margin-top: 30px; margin-bottom: 30px;">
    <ul class="posts list-unstyled col-lg-9 col-md-12">
        <?php
                $posts = $db->query('SELECT * from `posts` ORDER BY `date_time` DESC');
                while($data = $posts->fetch_assoc()){
                        ?>
        <li class="post rounded mb-4 shadow-sm h-md-250 position-relative p-5 bg-light" style="margin-bottom: 30px;" id="post_<?php echo $data[id];?>">
            <?php if ($_SESSION["type"]==1) { ?>
            <ul class="edit list-inline float-right">
                <li class="list-inline-item"><a href="editpost.php?id=<?php echo $data[id];?>"><i class="fas fa-edit"></i></i></a></li>
                <li class="list-inline-item"><a href="../funcs/delete_post.php?id=<?php echo $data[id];?>"><i class="fas fa-times"></i></a></li>
            </ul>
            <?php } ?>
            <div class="media-body">
                <a style="text-decoration: none" href="postpage.php?id=<?php echo $data[id];?>">
                    <h1 class="mt-0 mb-1 display-4">
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

    <div class="col-auto favourites col-lg-3 col-md-12 col-offset-2 rounded mb-4 shadow-sm h-md-250 position-relative p-4 bg-light">
        <h1>Популярное</h1>
        <?php
                $fav = $db->query("SELECT `post_id`, COUNT(*) FROM `likes` GROUP BY `post_id` ORDER BY COUNT(*) DESC LIMIT 3");
                 ?>
        <div class="favourit_list">
            <?php while($fav_data = $fav->fetch_assoc()){
                        $fav_post=$db->query("SELECT * from `posts` WHERE id = '$fav_data[post_id]'");
                        $fav_post_data=$fav_post->fetch_assoc();
                        // var_dump($fav_post_data);
                        ?>
            <div class="favourit" style="padding-top: 30px;">
                <a style="text-decoration: none" href="postpage.php?id=<?php echo $fav_post_data[id];?>">
                    <h2>
                        <?php echo $fav_post_data["title"];?>
                    </h2>
                </a>
                <div class="fav-post" id='fav-<?php echo $fav_post_data["id"];?>' onload="show_more_set_fav(<?php echo $fav_post_data[id]?>, 2)">
                    <?php echo $fav_post_data["text"];?>
                </div>
                <div class="favourit_link">
                    <a href="postpage.php?id=<?php echo $fav_post_data[id];?>">Подробнее...</a>
                </div>
            </div>
            <?php }; ?>
        </div>

    </div>
</div>
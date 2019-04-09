<?php
include('../funcs/connection.php');
var_dump($_GET);
if (isset($_GET)) {
    $delete_post = $db->query("DELETE FROM `posts` WHERE `id`='$_GET[id]'");
    $delete_likes = $db->query("DELETE FROM `likes` WHERE `post_id`='$_GET[id]'");
    $delete_comments = $db->query("DELETE FROM `comments` WHERE `post_id`='$_GET[id]'");
    header('Location: ../index.php');
}else {
    header('Location: ../index.php');
}

?>

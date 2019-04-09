<?php session_start();
include('connection.php');
// login
if (empty($_POST) == false && $_POST[name] == 'login_f') {
    $username = $_POST[login_username];
    $password = $_POST[login_password];
    $query1 = $db->query("SELECT COUNT(`id`) FROM `users` WHERE `username` = '$username'");
    $query2 = $db->query("SELECT `password` FROM `users` WHERE `username` = '$username'");
    $query3 = $db->query("SELECT `type` FROM `users` WHERE `username` = '$username'");
    $type = $query3->fetch_assoc()[type];
    $query4 = $db->query("SELECT `id` FROM `users` WHERE `username` = '$username'");
    $id = $query4->fetch_assoc()[id];


    if (empty($username) || empty($password)) {
        echo 'ERROR-Enter username and password.';
    }elseif ($query1->fetch_assoc()["COUNT(`id`)"] != 1){
            echo 'ERROR-User does not exist.';
    }elseif($query2->fetch_assoc()["password"] != md5($password)){
            echo 'ERROR-Wrong password.';
    }else {
        $_SESSION['username'] = $username;
        $_SESSION['type'] = $type;
        $_SESSION['id'] = $id;
        echo "success";
    }
}
// exit
elseif (empty($_POST) == false && $_POST[name] == 'exit_f') {
    if (isset($_SESSION['username'])) {
        $_SESSION=array();
        echo "success";
    }
}
// register
elseif (empty($_POST) == false && $_POST[name] == 'register_f') {

    $username = $_POST[register_username];
    $password = $_POST[register_password];
    $password1 = $_POST[register_password1];
    $query1 = $db->query("SELECT COUNT(`id`) FROM `users` WHERE `username` = '$username'");

    if (empty($username) || empty($password) || empty($password1)) {
        echo 'ERROR-Enter username and password.';
    }elseif ($password != $password1){
            echo 'ERROR-Passwords do not match.';
    }elseif ($query1->fetch_assoc()['COUNT(`id`)'] != 0){
            echo 'ERROR-User already exists.';
    }else {
        $password = md5($password);
        $type = 0;
        $query2 = $db->query("INSERT INTO `users`(`username`, `password`) VALUES ('$username', '$password')");
        $_SESSION['username'] = $username;
        $_SESSION['type'] = $type;
        $query4 = $db->query("SELECT `id` FROM `users` WHERE `username` = '$username'");
        $id = $query4->fetch_assoc()["id"];
        $_SESSION['id'] = $id;
        echo "success";
        header('Location: ../templates/profile.php');
    }
}

// post_comment
elseif (empty($_POST) == false && $_POST[name] == 'post_comment_f') {
    if (empty($_POST['post_comment_area'])){
        echo "ERROR-Enter the comment.";
    }else {
        $comment = $db->query("INSERT INTO `comments` (`post_id`, `user_id`, `date_time`, `text`) VALUES ('$_POST[post_id]', '$_SESSION[id]', CURRENT_TIMESTAMP, '$_POST[post_comment_area]')");
        echo "success";
    }
}

// like
elseif (empty($_POST) == false && $_POST[name] == 'like_f') {
    // var_dump($_POST);
    $likes = $db->query("SELECT COUNT(*) FROM `likes` WHERE (`post_id`= '$_POST[post_id]' AND `user_id`= '$_SESSION[id]')");
    $ldata = $likes->fetch_assoc();
    if (!isset($_SESSION['username'])) {
        echo "ERROR-Log in please.";
    }elseif ($ldata['COUNT(*)'] == 0) {
        $add_like = $db->query("INSERT INTO `likes` (`post_id`, `user_id`) VALUES ('$_POST[post_id]', '$_SESSION[id]')");
        echo "like";
    }elseif ($ldata['COUNT(*)'] != 0) {
        $add_like = $db->query("DELETE FROM `likes` WHERE (`user_id`='$_SESSION[id]' AND `post_id`='$_POST[post_id]')");
        echo "dislike";
    }
}

// add_post
elseif (empty($_POST) == false && $_POST['name'] == 'add_post_f') {
    // var_dump($_POST);
    if (empty($_POST['title']) || empty($_POST['text']) || $_POST['category']=="Выберите..."){
        echo "ERROR-Enter the post text and category.";
    }else{
        $add_post = $db->query("INSERT INTO `posts`(`title`, `text`, `date_time`, `category`, `important`) VALUES ('$_POST[title]','$_POST[text]',CURRENT_TIMESTAMP,'$_POST[category]','$_POST[ImportantCheck]')");
        echo "success";
    }
}

// edit
elseif (empty($_POST) == false && $_POST['name'] == 'edit_post_f') {
    if (empty($_POST['title']) || empty($_POST['text']) || empty($_POST['category'])){
        echo "ERROR-Enter the post text and description.";
    }else{
        $add_post = $db->query("UPDATE `posts` SET `title`='$_POST[title]',`category`='$_POST[category]',`text`='$_POST[text]',`date_time`=CURRENT_TIMESTAMP,`important`='$_POST[ImportantCheck]' WHERE id='$_POST[id]'");
        echo "success";
    }
}

// set username
elseif (empty($_POST) == false && $_POST['name'] == 'set_username_f') {
    var_dump($_POST);
    var_dump($_SESSION);
    if($_POST['username']==$_SESSION['username']){
        header('Location: ../templates/profile.php');
    }else{
        $set_username = $db->query("UPDATE `users` SET `username`='$_POST[username]' WHERE id='$_SESSION[id]'");
        $_SESSION['username'] = $_POST['username'];
        header('Location: ../templates/profile.php');

    }
}

// set password
elseif (empty($_POST) == false && $_POST['name'] == 'set_password_f') {
    var_dump($_POST);
}
?>

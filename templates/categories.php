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
    <title>Категории</title>
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
        <div class="categories" style="display: grid; grid-template-columns: 1fr 1fr 1fr; grid-gap:25px;">
            <?php
            $sql = "SELECT categories.category_name, categories.info, categories.id, COUNT(posts.title) FROM posts JOIN categories ON posts.category = categories.id GROUP BY category_name ORDER BY COUNT(posts.title) DESC";
            $result = $db->query($sql);
            while($data = $result->fetch_assoc()){
            ?>
            <div class="card">
                <div class="card-body">
                    <a style="text-decoration: none" href="categorypage.php?id=<?php echo $data[id];?>"><h1 class="mt-0 mb-1 card-title display-3"><?php echo($data[category_name]); ?></h1></a>
                    <p class="card-text"><?php echo($data[info]); ?></p>
                    <h5>Последние добавленные</h5>
                    <ul class="list-group">
                    <?php 
                    $posts = $db->query('SELECT * from `posts` WHERE `category`='.$data[id].' ORDER BY `date_time` DESC');
                    while($datap = $posts->fetch_assoc()){ ?>
                    
                    <li class="list-group-item"><a href="postpage.php?id=<?php echo $datap[id];?>" class="card-link"><?php echo($datap[title]); ?></a></li>
                    <?php } ?>
                    </ul>
                </div>
            </div>
            <?php }?>
        </div>
    </div>
</body>
<?php include('footer.php'); ?>
<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>

</html>
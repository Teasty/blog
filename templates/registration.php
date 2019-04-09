<?php session_start();
   include("../funcs/connection.php")
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="..//style/main.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
    <title>Registration</title>
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
        <div class="container" align="center" style="margin-top:30px;">
            <div class="registration">

                <h1>Регистрация</h1>
                <small id="emailHelp" class="form-text text-muted col-6">Привет, хочу предупредить чтобы ты не выбираль логин, содержащий личную информацию, и пароль, который уже где-то используешь. Мой сайт не слишком надежин с точки зрения безопасности.</small>
                <form>
                    <div class="form-group">
                        <label for="register_username">Login</label>
                        <input type="text" id="register_username" class="form-control col-4" aria-describedby="emailHelp"
                            placeholder="Enter login">
                    </div>
                    <div class="form-group">
                        <label for="register_password">Password</label>
                        <input type="password" class="form-control col-4" id="register_password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="register_password1">Repeat password</label>
                        <input type="password" class="form-control col-4" id="register_password1" placeholder="Repeat password">
                    </div>
                    <button type="submit" class="btn btn-primary" onclick="post_query('register', 'manage', 'register_username.register_password.register_password1', 'register_func')">Зарегистрироваться</button>
                </form>
            </div>
        </div>
    </div>
</body>
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
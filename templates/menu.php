<div class="menu" id="login_form">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item 
                <?php
                    if ($_SERVER["REQUEST_URI"]=="/blog/templates/home.php")
                    {
                        echo("active");
                    }?>
                    ">
                    <a class="nav-link" href="/blog/templates/home.php">Главная<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item 
                <?php
                    if ($_SERVER["REQUEST_URI"]=="/blog/templates/categories.php")
                    {
                        echo("active");
                    }?>
                    ">
                    <a class="nav-link" href="/blog/templates/categories.php">Категории<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item 
                <?php
                    if ($_SERVER["REQUEST_URI"]=="/blog/templates/about.php")
                    {
                        echo("active");
                    }?>
                    ">
                    <a class="nav-link" href="about.php">О блоге<span class="sr-only">(current)</span></a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <?php if ($_SESSION["type"]=='1') { ?>
                <a class=" nav-item nav-link" href="addpost.php"><i class="fas fa-plus"></i></a>
                <?php } ?>
                <?php if (!isset($_SESSION[username])) { ?>
                <input type="text" class="nav-item form-control mr-sm-2" name="username" id="login_username" placeholder="login" />
                <?php } ?>
                <?php if (!isset($_SESSION[username])) { ?>
                <input type="password" class="nav-item form-control mr-sm-2" name="password" id="login_password" placeholder="password" />
                <?php } ?>
                <?php if (!isset($_SESSION[username])) { ?>
                <a id="login_button" class="nav-item btn btn-outline-primary my-2 my-sm-0" class="menu_element" onclick="post_query('login', 'manage', 'login_username.login_password', 'login_func'); return false;"
                    href="#">Войти</a>
                <?php } ?>
                <?php if (isset($_SESSION[username])) { ?>
                <a class="nav-item nav-link" href="/blog/templates/profile.php">
                    <?php echo $_SESSION[username];?></a>
                <?php } ?>
                <?php if (isset($_SESSION[username])) { ?>
                <a class="nav-item btn btn-outline-primary my-2 my-sm-0" id="exit_button" onclick="post_query('exit', 'manage', '', 'login_func'); window.location.pathname = '/blog/templates/home.php'; return false; "
                    href="#">Выход</a>
                <?php } ?>
                <?php if (!isset($_SESSION[username])) { ?>
                <a class="nav-item nav-link" href="registration.php">Регистрация</a>
                <?php } ?>
                <!-- <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-info my-2 my-sm-0" type="submit">Search</button> -->
            </form>
        </div>
    </nav>
</div>
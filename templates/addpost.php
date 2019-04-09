<?php
session_start();
include("../funcs/connection.php");
if ($_SESSION["type"]=='1') {
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
    <title>Добавление новости</title>
    <script src="https://cdn.ckeditor.com/ckeditor5/11.2.0/classic/ckeditor.js"></script>
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
        <div class="container mt-5">
            <h2>Создать новый пост</h2>
            <form>
                <div class="form-group mb-3">
                    <label for="title">Название поста</label>
                    <input type="text" id="title" class="form-control col-6" name="title" placeholder="Название поста">
                    <label for="text">Введите текст новости</label>
                    <textarea id="text" class="form-control" name="text"></textarea>
                    <div class="input-group mt-4">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Выберите категорию</label>
                        </div>
                        <select class="custom-select" id="category">
                            <option selected>Выберите...</option>
                            <?php 
                                $categories = $db->query('SELECT `category_name` from `categories`');
                                while($data = $categories->fetch_assoc()){ ?>
                            <option value="1">
                                <?php echo($data["category_name"]) ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mt-4 ml-4">
                        <input class="form-check-input" type="checkbox" value="1" id="ImportantCheck">
                        <label class="form-check-label" for="ImportantCheck">
                            Важный пост <span class="badge badge-secondary" data-toggle="tooltip" data-placement="right" title="Выводит пост в синей рамке на главной странице">?</span>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary mt-4" onclick="$('#text').html( myEditor.getData()); post_query('add_post', 'manage', 'title.text.category.ImportantCheck', 'add_post_func'); return false;" class="btn btn-primary">Запостить</button>
                </div>
            </form>
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
    $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
  });
</script>
<script>
    var myEditor;

    ClassicEditor
        .create( document.querySelector( '#text' ) )
        .then( editor => { editor.ui.view.editable.editableElement.style.height = '500px'; myEditor = editor;} )
        .catch( error => {
            console.error( error );
        } );
</script>

</html>
<?php
}else{
    header('Location: ../index.php');
}
 ?>
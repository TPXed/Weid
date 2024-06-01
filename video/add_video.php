<?php
echo 'Максимальный размер данных: ' . ini_get('post_max_size') . '<br>';
echo 'Максимальный размер файлов: ' . ini_get('upload_max_filesize') . '<br>';
echo 'Максимальное количество переменных: ' . ini_get('max_input_vars') . '<br>';
echo 'Максимальное время выполнения скрипта: ' . ini_get('max_execution_time') . '<br>';
echo 'Максимальное время обработки данных: ' . ini_get('max_input_time') . '<br>';
echo 'Память для скрипта: ' . ini_get('memory_limit') . '<br>';
session_start(); 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/add_video.css">
    <link rel="stylesheet" href="../css/menu.css">
    <link rel="stylesheet" href="../css/loader.css">
    <script src="../js/loader.js"></script>
    <title>Добавить Видео</title>
</head>
<body>
    <header>
        <h1>Добавить Видео</h1>
    </header>
    <?php 
    include("../menu.php");
    include("../application/loader.php");
    ?>
    <div class="container"> 
        <form action="add_to_base.php" method="post" enctype="multipart/form-data">

            <label for="video_name">Название Видео:</label><br>
            <input type="text" id="video_name" name="video_name"><br>

            <label for="video_description">Описание Видео:</label><br>
            <textarea id="video_description" name="video_description"></textarea><br>

            <label for="video_source">Источник Видео: </label><br>
            <select name="video_source" id="video_source" onchange="toggleInput()">
        <option value="" selected disabled>Выберите вариант</option>
        <option value="link">Ссылка</option>
        <option value="file">Файл</option>
        </select><br>

        <div id="file_input" class="file-input-container">
            <label for="video_file">Загрузить файл Видео:</label><br>
            <input type="file" id="video_file" name="video_file" accept="video/mp4, video/webm">     
        </div>

        <div id="link_input" class="file-input-container">
            <label for="video_link">Ссылка на Видео:</label><br>
            <input type="text" id="video_link" name="video_link"><br>
        </div>

        <input type="submit" value="Добавить Видео">
        </form>
    </div>
    <script>
        function toggleInput() {
            var source = document.getElementById("video_source").value;
            var fileInput = document.getElementById("file_input");
            var linkInput = document.getElementById("link_input");
            if (source === "file") {
                fileInput.classList.remove("fade-out");
                fileInput.classList.add("fade-in");
                linkInput.classList.remove("fade-in");
                linkInput.classList.add("fade-out");
            } else {
                fileInput.classList.remove("fade-in");
                fileInput.classList.add("fade-out");
                linkInput.classList.remove("fade-out");
                linkInput.classList.add("fade-in");
            }
        }
    </script>
</body>
</html>
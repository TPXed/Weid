<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Музыка</title>
    <link rel="stylesheet" href="../css/menu.css">
    <link rel="stylesheet" href="../css/loader.css">
    <link rel="stylesheet" href="../css/music-style.css">
    <script src="../js/loader.js"></script>
    <script src="../js/music.js"></script>
</head>
<body>
    <h1>Музыкальная коллекция</h1>
    <?php
    session_start();
    if (isset($_SESSION['id'])) {
        echo '<button id="uploadButton">Загрузить музыку</button>';
    }
    ?>
    <div class="music-container">
    <?php
    include_once '../application/db.php';
    include("../menu.php");
    include("../application/loader.php");
    $sql = "SELECT * FROM music ORDER BY upload_date DESC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $music_name = $row['music_name'];
            $music_path = $row['music_path'];
            echo "<div class='music-item'>";
            echo "<h2>$music_name</h2>";
            echo "<audio conrols>";
            echo "<source src='$music_path' type='audio/mpeg'>";
            echo "Бразуер не поддерживает воспроизведение аудио.";
            echo "</audio>";
            echo "</div>";
        }
    } else {
        echo "Музыка не найдена.";
    }
    $conn->close()
    ?>
</div>
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">$times;</span>
        <h2>Загрузка музыки</h2>
        <form action="upload_music.php" method="post" enctype="multipart/form-data">
            <input type="file" name="music_file" accept=".mp3,.mpeg" required>
            <button type="submit">Загрузить</button>
        </form>
    </div>
</div>
</body>
</html>
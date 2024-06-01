<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/videolist.css">
    <link rel="stylesheet" href="../css/menu.css">
    <link rel="stylesheet" href="../css/loader.css">
    <script src="../js/loader.js"></script>
    <title>Список Видео</title>
</head>
<body>
    <header>
        <h1>Список видео</h1>
    </header>
    <?php 
    session_start();
    include("../menu.php");
    include("../application/loader.php");
    if (isset($_SESSION['id'])) {
        echo '<a href="add_video.php" class="add-video-button">Опубликовать видео</a>';
    }
    include_once '../application/db.php';
    $sql= "SELECT * FROM videos";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $video_id = $row['id'];
            $video_name = $row['video_name'];
            $video_description = $row['video_description'];
            $video_path = $row['video_path'];
            echo "<div class='video-container'>";
            echo "<a href='watch_video.php?id=$video_id'>";
            echo "<h2>$video_name</h2>";
            echo "<p>$video_description</p>";
            echo "</a>";
            echo "</div>";
        }
    } else {
        echo "<p>Видео не найдены.</p>";
    }
    $conn->close();
    ?>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Змейка</title>
    <link rel="stylesheet" href="snake.css">
    <link rel="stylesheet" href="snake_table.css">
    <link rel="stylesheet" href="../../css/menu.css">
    <link rel="stylesheet" href="../../css/loader.css">
    <script src="../../js/loader.js"></script>
    <script src="snake.js"></script>
</head>
<body>
    <?php
    include("../../menu.php");
    include("../../application/db.php");
    ?>
    <header><h1>Змейка</h1></header>
    <canvas id="board"></canvas>
    <table> 
        <thead>
            <tr>
                <th>Игрок</th>
                <th>Рекорд</th>
                
            </tr>
        </thead>
        <tbody>
            <?php 
            require_once '../../application/db.php';
            $sql = "SELECT username, score FROM high_scores_snake ORDER BY score DESC";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>".$row["username"]
                     . "</td><td>" . $row["score"]
                    . "</td></tr>";
                }
            } else {
                echo "<tr><td colspan='2'> 0 результатов </td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>
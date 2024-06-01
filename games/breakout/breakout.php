<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Breakout</title>
    <link rel="stylesheet" href="breakout1.css">
    <link rel="stylesheet" href="../../css/menu.css">


    <script src="breakout.js"></script>
</head>
<body>
    <?php
    include("../../menu.php");
    include("../../application/loader.php");
    ?>
    <header><h1>Breakout</h1></header>
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
            $sql = "SELECT username, score FROM high_scores_breakout ORDER BY score DESC";
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
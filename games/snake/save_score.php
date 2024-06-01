<?php 
require_once '../../application/db.php';
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["score"]) && isset($_SESSION["login"])) {
    $score = $_POST["score"];
    $username = $_SESSION["login"];
    $sql = "SELECT score FROM high_scores_snake WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($high_score);
    $stmt->fetch();
    
    if ($stmt->num_rows == 0) {
        $sql = "INSERT INTO high_scores_snake (username, score) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $username, $score);
        if ($stmt->execute() === TRUE) {
            echo "Новый рекорд успешно сохранен!";
        } else {
            echo "Ошибка : " . $stmt->error;
        }
    } else {
        if ($score > $high_score){
            $sql = "UPDATE high_scores_snake SET score = ? WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $score, $username);
            if ($stmt->execute() === TRUE) {
                echo "Рекорд успешно обновлен";
            } else {
                echo "Ошибка: ". $stmt->error;
            }
        } else {
            echo "Счет не превышает предыдущий рекорд";
        }
    }
    $stmt->close();
    $stmt->close();
}
?>
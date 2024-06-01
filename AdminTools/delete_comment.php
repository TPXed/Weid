<?php
session_start();
require_once("../application/db.php");
if (isset($_GET['id'])) {
$comment_id = $_GET['id'];
$sql = "DELETE FROM comments WHERE id = $comment_id";
if ($conn->query($sql) === TRUE) {
header("Location: allcomments.php");
exit();
} else {
echo "Ошибка при удалении комментария: " . $conn->error;
}
} else {
echo "Ошибка: Не передан параметр id для удаления комментария.";
}
?>
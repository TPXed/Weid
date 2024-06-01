<?php
session_start();
require_once("../application/db.php");
if (isset($_GET['id'])) {
$post_id = $_GET['id'];
$delete_comments_sql = "DELETE FROM comments WHERE post_id = $post_id";
if ($conn->query($delete_comments_sql) === TRUE) {
$delete_post_sql = "DELETE FROM posts WHERE id = $post_id";
if ($conn->query($delete_post_sql) === TRUE) {
header("Location: allposts.php");
exit();
} else {
echo "Ошибка при удалении поста: " . $conn->error;
}
} else {
echo "Ошибка при удалении комментариев: " . $conn->error;
}
} else {
echo "Ошибка: Не передан параметр id для удаления поста.";
}
?>
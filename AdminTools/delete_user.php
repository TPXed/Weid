<?php
session_start();
require_once("../application/db.php");
if(isset($_GET['id'])) {
$user_id = $_GET['id'];
$sql_delete_posts = "DELETE FROM posts WHERE user_id = ?";
$stmt_delete_posts = $conn->prepare($sql_delete_posts);
$stmt_delete_posts->bind_param("i", $user_id);
if ($stmt_delete_posts->execute()) {
$sql_delete_messages = "DELETE FROM messages WHERE sender_id = ? OR
receiver_id = ?";
$stmt_delete_messages = $conn->prepare($sql_delete_messages);
$stmt_delete_messages->bind_param("ii", $user_id, $user_id);
if ($stmt_delete_messages->execute()) {
$sql_delete_user = "DELETE FROM users WHERE id = ?";
$stmt_delete_user = $conn->prepare($sql_delete_user);
$stmt_delete_user->bind_param("i", $user_id);

if ($stmt_delete_user->execute()) {
header("Location: allusers.php");
exit();
} else {
echo "Ошибка при удалении пользователя: " . $conn->error;
}
$stmt_delete_user->close();
} else {
echo "Ошибка при удалении сообщений пользователя: " . $conn->error;
}
$stmt_delete_messages->close();
} else {
echo "Ошибка при удалении постов пользователя: " . $conn->error;
}
$stmt_delete_posts->close();
} else {
echo "Идентификатор пользователя не был передан для удаления.";
}
$conn->close();
?>
<?php
session_start();
require_once '../application/db.php'; 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
global $conn; 

if (isset($_SESSION['id'])) {
$senderId = $_SESSION['id'];
} else {
echo "Error: Unauthorized access";
exit;
}
if (($_SESSION['admin']) == 1) {
    $senderId = 0;
    
}

$receiverId = $_POST['receiver_id'];

$stmt = $conn->prepare("SELECT messages.message_text, messages.timestamp,
sender.us_name AS sender_name
FROM messages
JOIN users AS sender ON messages.sender_id =
sender.id
WHERE
(messages.sender_id = ? AND messages.receiver_id =
?) OR
(messages.sender_id = ? AND messages.receiver_id =
?)
ORDER BY messages.timestamp");

if (!$stmt) {
echo "Error in SQL query: " . $conn->error;
exit;
}

$stmt->bind_param("iiii", $senderId, $receiverId, $receiverId, $senderId);

$stmt->execute();
if ($stmt->error) {
echo "Error executing SQL query: " . $stmt->error;
exit;
}
$result = $stmt->get_result();
$messages = [];
while ($row = $result->fetch_assoc()) {
$messages[] = $row;
}
foreach ($messages as $message) {
$senderName = isset($message['sender_name']) ? $message['sender_name']
: 'Unknown User';
echo "$senderName: {$message['message_text']}
({$message['timestamp']})\n";
}
$stmt->close();
}
?>

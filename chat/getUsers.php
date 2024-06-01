<?php

require_once '../application/db.php'; 
$sql = "SELECT id, us_name AS username FROM users WHERE id != 0"; 
$result = $conn->query($sql); 
$users = [];
if ($result) {
while ($row = $result->fetch_assoc()) {
$users[] = [
'id' => $row['id'],
'username' => $row['username']
];
}
$result->free();
} else {
echo "Error: " . $conn->error;
}
$conn->close();
echo json_encode($users);

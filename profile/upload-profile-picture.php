<?php

include_once '../application/db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $action = $_POST["action"];

    
    if ($action === "delete") {
   
        $userId = $_SESSION["id"];
        $fileToDelete = "avatars/{$userId}.*";

     
        $files = glob($fileToDelete);
        
        foreach ($files as $file) {
            if (unlink($file)) {
                echo "Файл $file успешно удален.";
            } else {
                echo "Ошибка при удалении файла $file.";
            }
        }


        updateProfilePicturePath($userId, NULL);

       
        echo getProfilePicturePath($userId);
        exit;
    } elseif ($action === "update") {
     
        $userId = $_SESSION["id"];

      
        if (!empty($_FILES["image"]["name"])) {
            $targetDir = "avatars/";
            $targetFile = $targetDir . $userId . '.' . pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);

         
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
               
                updateProfilePicturePath($userId, $targetFile);

              
                echo getProfilePicturePath($userId);
                exit;
            } else {
                echo "error|Произошла ошибка при загрузке файла.";
                exit;
            }
        } else {
            echo "error|Файл не был загружен.";
            exit;
        }
    } elseif ($action === "getProfilePicture") {
  
        $userId = $_SESSION['id'];
      
        echo getProfilePicturePath($userId);
        exit;
    } else {
        echo "error|Некорректное действие.";
        exit;
    }
} else {
    echo "error|Недопустимый метод запроса.";
    exit;
}


function updateProfilePicturePath($userId, $filePath) {
    global $conn;

    $updateQuery = "UPDATE users SET profile_picture = ? WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("si", $filePath, $userId);
    $stmt->execute();
    $stmt->close();
}


function getProfilePicturePath($userId) {
    global $conn;

    $query = "SELECT profile_picture FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($profilePicture);
    $stmt->fetch();
    $stmt->close();

    
    return ($profilePicture !== null) ? $profilePicture : "avatars/placeholder.png";
}
?>

<?php
session_start();
include ("db.php");
function setSession($id, $us_name, $admin, $age) {
$_SESSION['id'] = $id;
$_SESSION['login'] = $us_name;
$_SESSION['admin'] = $admin;
$_SESSION['age'] = $age;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['button-reg'])) {
   
    $us_name = $_POST['login'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $pass_first = $_POST['pass-first'];
    $pass_second = $_POST['pass-second'];

    if ($pass_first !== $pass_second) {
    echo "Пароли не совпадают.";
    } else {
  
    $hashed_password = password_hash($pass_first, PASSWORD_DEFAULT);
   
    $check_email_query = "SELECT * FROM users WHERE email='$email'";
    $check_email_result = $conn->query($check_email_query);
    if ($check_email_result->num_rows > 0) {
    echo "Пользователь с таким адресом электронной почты уже
    существует.";
    } else {
  
    $admin = 0;
    
    $stmt = $conn->prepare("INSERT INTO users (admin, us_name, email,
    age, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $admin, $us_name, $email, $age,
    $hashed_password);
    if ($stmt->execute()) {
    echo "Регистрация успешна.";
    setSession($conn->insert_id, $us_name, 0, $age);
    header("Location: profile/accaunt.php");
    exit();
    } else {
    echo "Ошибка при регистрации: " . $conn->error;
    }
    $stmt->close();
    }
    }
    }


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['button-log'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
   
    $stmt = $conn->prepare("SELECT id, us_name, admin, age, password FROM users
    WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
 
    if (password_verify($password, $row['password'])) {
    echo "Авторизация успешна. Добро пожаловать, " . $row['us_name'];
    setSession($row['id'], $row['us_name'], $row['admin'],
    $row['age']);
    header("Location: profile/accaunt.php");
exit(); 
} else {
echo "Неверный пароль.";
}
} else {
echo "Пользователь с таким адресом электронной почты не найден.";
}
$stmt->close();
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['button-upd'])) {

    $id = $_SESSION['id'];
    $us_name = $_POST['user-name'];
    $email = $_POST['user-email'];
    $age = $_POST['user-age'];
    $info = $_POST['user-info'];
    $pass_first = $_POST['pass-first'];
    $pass_second = $_POST['pass-second'];
 
    if ($pass_first !== $pass_second) {
    echo "Пароли не совпадают.";
    } else {
   
    if (!empty($pass_first)) {
 
    $hashed_password = password_hash($pass_first, PASSWORD_DEFAULT);
    $password_update = ", password = '$hashed_password'";
    } else {
    
    $password_update = "";
    }
    
    $check_email_query = "SELECT * FROM users WHERE email='$email' AND id
    != $id";
    $check_email_result = $conn->query($check_email_query);
    if ($check_email_result && $check_email_result->num_rows > 0) {
    echo "Пользователь с таким адресом электронной почты уже
    существует.";
    } else {
 
    $info_escaped = mysqli_real_escape_string($conn, $info);
    $update_query = "UPDATE users SET us_name = '$us_name', email =
    '$email', age = $age $password_update, info = '$info_escaped' WHERE id = $id";
    if ($conn->query($update_query) === TRUE) {
    echo "Данные успешно изменены.";
    $_SESSION['login'] = $us_name;
    $_SESSION['age'] = $age;
    header("Location:http://localhost/Social_GalkinD/profile/accaunt.php");
    exit();
    } else {
    echo "Ошибка при обновлении данных: " . $conn->error;
    }
    }
    }
    }
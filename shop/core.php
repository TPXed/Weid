<?php
// Инициализируем сессию
session_start();
// В переменную помещаем значение из массива POST
$action = $_POST['action'];
// Определяем, какая функция будет выполняться в зависимости от переданого значения
switch ($action){
case 'init':
init();
break;
 // Выполнение функции PutData()
case 'inputData':
PutData();
break;
}

// Функция подлучения данных для корзины заказа
function init(){
// Подключаемся к базе данных
include '../application/db.php';
// Помещаем в переменную сформированную строку из массива POST
$id_product = $_POST['id_product'];
// Убираем последний символ - запятую
$id_product = substr($id_product,0,-1);
// Формируем строку запроса
$test_query = 'SELECT id, name, price FROM merchendise WHERE id in
('.$id_product.')';
// Результат выполнения запроса помещаем в переменную
$result = mysqli_query($conn, $test_query);

$out1 = array();
// Заполнение массива данными
while($row = mysqli_fetch_assoc($result)){
$out1[$row["id"]] = $row;
}
// Возвращаем массив в файл scriptcat.js перекодированный в JSON формат
echo json_encode($out1);

}


function PutData(){
    include '../application/db.php';
    $Data_Order = $_POST['Data_Order'];
    $StrQuery = "";
    $arrProd = explode(',',substr($Data_Order["product"],0,-1));
    $arrPrice = explode(',',substr($Data_Order["price"],0,-1));
    $arrCount = explode(',',substr($Data_Order["count_product"],0,-1));
    $arrSum = explode(',',substr($Data_Order["summa"],0,-1));
    $userid = $_SESSION["id"];

    $query = "SELECT email FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt ->bind_param("i",$userid);
    $stmt->execute();
    $stmt->bind_result($email);
    $stmt->fetch();
    $stmt->close();
    $Data_Order["users"] = $email;
    for($i = 0; $i < count($arrProd); $i++){
        $StrQuery = 'INSERT INTO social.order(`num_order`, `date_order`, `users`,
        `product`, `price`, `count_product`, `summa`, `paid`) VALUES
        ('.$Data_Order["num_order"].', "'.$Data_Order["date_order"].'",
        "'.$Data_Order["users"].'", "'.$arrProd[$i].'", '.$arrPrice[$i].',
        '.$arrCount[$i].', '.$arrSum[$i].', 0);';;
        // Выполнение запроса
        $rez = mysqli_query($conn, $StrQuery);
        

    }
    mysqli_close($conn);

}
?>


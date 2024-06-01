<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>История заказов</title>
    <link rel="stylesheet" href="../css/menu.css">
    <link rel="stylesheet" href="../css/history_order.css">
</head>
<body>
<?php
include("../menu.php");
?>
<header>
    <h1>История заказов</h1>
</header>
<table class="table_shop">
<?php 
include '../application/db.php';
$userId = $_SESSION["id"];
$query = "SELECT email FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt ->bind_param("i", $userId);
$stmt ->execute();
$stmt ->bind_result($email);
$stmt ->fetch();
$stmt ->close();

$test_query = "SELECT num_order, date_order, paid FROM `order` WHERE users = '".$email."' GROUP by num_order, date_order, paid";
$result = mysqli_query($conn, $test_query);
for($data = []; $row=mysqli_fetch_assoc($result); $data[] = $row);
$result = '';
foreach($data as $elem) {
    $result .='<tr>';
    $result .='<td><img style="width: 150px;" src="http://localhost/Social_GalkinD/shop/img/cart.png" alt = ""></td>';
    $result .='<td><a href="http://localhost/Social_GalkinD/shop/content_order.php?OrderNum='.$elem['num_order'].'">Заказ №'.$elem['num_order'].' От '.$elem['date_order'].'</a></td>';
    if ($elem['paid'] == 0) {
        $result .='<td>Не оплачен</td>';
        $result .='<td><img style="width: 100px;" src="http://localhost/Social_GalkinD/shop/img/krest.png" alt = ""></td>';
    }
    else {
        $result .='<td>Оплачен</td>';
        $result .='<td><img style="width: 115px;" src="http://localhost/Social_GalkinD/shop/img/galochka.png" alt = ""></td>';
    }
    $result .='</tr>';
}
echo $result;
mysqli_close($conn);
?>
</table>
<script src="js/jquery-3.7.1.min.js"></script>
</body>
</html>
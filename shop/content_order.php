<?php

use LDAP\Result;

session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Содержание заказа</title>
    <link rel="stylesheet" href="../css/menu.css">
    <link rel="stylesheet" href="../css/content_order.css">
</head>
<body>
    <header>
        <h1>Содержание заказа</h1>
    </header>
    <?php
    include("../menu.php");
    include '../application/db.php';
    $num_id = $_GET["OrderNum"];
    $test_query = "SELECT num_order, date_order,paid FROM `order` WHERE num_order = ".$num_id." GROUP by num_order, date_order, paid";
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
$result .='</table>';
echo $result;
$sum = 0;
$test_query = "SELECT order.product, order.price, order.count_product, order.summa, merchndise.picture FROM `order` INNER JOIN merchndise on order.product=merchndise.name WHERE num_order = ".$num_id."";
$result = mysqli_query($conn, $test_query);
for($data = []; $row=mysqli_fetch_assoc($result); $data = $row);
$result = '<div class= "table_order"><table class ="table_shop1"><tr><th colspan="2">Товар</th><th>Цена</th><th>Количество</th><th>Сумма</th></tr>';
foreach($data as $elem) {
    $result .='<tr>';
    $result .='<td><img style="width: 70px;" src="data:image/jpg;base64,'.$elem['picture'].'"; /></td>';
    $result .='<td>'.$elem['product'].'</td>';
    $result .='<td>'.$elem['price'].'</td>';
    $result .='<td>'.$elem['count_product'].'</td>';
    $result .='<td>'.$elem['summa'].'</td>';
    $result .='</tr>';
    $sum += $elem['summa'];
}
$result .='<tfoot><tr><td>Итоговая сумма:</td><td></td><td></td><td></td><td>'.$sum.'</td></tr></tfoot></table></div>';
echo $result;
mysqli_close($conn);

?>
    <script src="js/jquery-3.7.1.min.js"></script>
</body>
</html>
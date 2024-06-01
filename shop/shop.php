<!-- Инициализация сессии -->
<?php
session_start();
?>
<!-- Шаблон для создания html разметки -->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
 <!-- Заголовок страницы -->
 <title>Магазин</title>
 <!-- Подключение файла menu.css -->
<link rel="stylesheet" href="../css/menu.css">
<link rel="stylesheet" href="../css/shop.css">
</head>
<body>
<!-- Подключение меню в файл -->
<?php
include("../menu.php");
?>
<!-- Заголовок -->
<header>
<h1>Магазин</h1>
</header>
<!-- Основной контейнер-->
<div class="assortment">
 <!-- Контейнер для отображения надписи -->
<div class="zagolovok-shop">
<a class="korzina"  href="cart.php">Моя корзина</a>
</div>
 <!—Контейнер для отображения таблицы -->
<div class="products">
<table class='table_shop'>
 <!—Создание строки с 4 ячейками. В ячейке «Товар» будет содержаться 2
ячейки-->
<tr>
 <!— В этой ячейка будет отображаться картинка и название товара -->
<th colspan = "2">Товар</th>
 <!—В этой ячейке будет отображаться цена товара-->
<th>Цена</th>
 <!—В этой ячейки будут отображаться кнопки для добавления товара в
корзину-->
<th>Добавить</th>
</tr>
<?php
 // Подключение файл db.php для подключения к базе данных
include '../application/db.php';
 // Формирование запроса к базе данных
$product_query = "SELECT id,name,price,picture FROM merchndise";
 // Выполнение запроса
$result = mysqli_query($conn, $product_query);
 // Цикл для помещения данных результата запроса в массив
for($data = []; $row=mysqli_fetch_assoc($result); $data[] = $row);
 // Переменная, в которую помещается код таблицы
$result = '';
 // Цикл для формирования кода таблицы
foreach($data as $elem){
$result .='<tr>';
$result .='<td><img style="width: 150px;"
src="data:image/jpg;base64,'.$elem['picture'].'"; /></td>';
$result .='<td>'.$elem['name'].'</td>';
$result .='<td>'.$elem['price'].'</td>';
$result .='<td><button class = "add-to-cart" type="submit"
onclick= "func(this.id)" id='.$elem['id'].'>Купить</button></td>';
$result .='</tr>';
}
 // Вывод результата на страницу
echo $result;
 // Закрытие подключения к базе данных
mysqli_close($conn);
?>

</table>
</div>
</div>
<script src="../js/jquery-3.7.1.min.js"></script>
<script src="../js/script.js"></script>

</body>
</html>
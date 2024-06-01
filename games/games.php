<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Меню игр</title>
    <link rel="stylesheet" href="../css/menu.css">
    <link rel="stylesheet" href="../css/games-list.css">
    <link rel="stylesheet" href="../css/loader.css">
    <script src="../js/loader.js"></script>
</head>
<body>
   <header>Меню игр</header>
   <?php
   include('../menu.php');
   include('../application/loader.php');
   ?>
   <div class="container">
    <table class="game-list">
        <tr>
            <th>Игра</th>
            <th>Описание</th>
        </tr>
           <tr>
            <td><a href="x-o/x-o.php">Крестики-нолики</a></td>
            <td>Добро пожаловать в классическую игру крестики-нолики! Это Классная Игра</td>
            <tr><
            <td><a href="x-o(bot)/x-o.php">Крестики-нолики  с ботом</a></td>
            <td>Добро пожаловать в классическую игру крестики-нолики! Это жесткая игра с ИИ</td>
        </tr> </tr>
        <tr><
            <td><a href="x-o(hardbot)/x-o.php">Крестики-нолики  со сложным ботом</a></td>
            <td>Добро пожаловать в классическую игру крестики-нолики! Стало мало? Повышаем ставки</td>
        </tr>  </tr> 
        <td><a href="snake/snake.php">Змейка</a></td>
            <td>Добро пожаловать в классическую игру "Змейка"</td>
        </tr>  </tr> 
        <td><a href="breakout/breakout.php">Breakout</a></td>
            <td>Добро пожаловать в классическую игру "Breakout"</td>
        </tr>  </tr> 
    </table>
   </div>
</body>
</html>
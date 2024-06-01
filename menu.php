<input class="menu-icon" type="checkbox" id="menu-icon" name="menu-icon"/>
<label for="menu-icon"></label>
<nav class="nav">
 <ul class="pt-5">
 <li><a href="http://localhost/Social_GalkinD/">Главная</a></li>

<?php
if (isset($_SESSION['id'])) {
echo '<li><a
href="http://localhost/Social_GalkinD/profile/accaunt.php">Личный кабинет</a></li>';
} else {
echo '<li><a href="http://localhost/Social_GalkinD/auth.php">Личный
кабинет</a></li>';
}
if (isset($_SESSION['id'])) {
    echo '<li><a
    href="http://localhost/Social_GalkinD/chat/chat.php">Чат</a></li>';
    } else {
    echo '<li><a
    href="http://localhost/Social_GalkinD/auth.php">Чат</a></li>';
    }
?>



<li><a href="http://localhost/Social_GalkinD/posts/posts.php">Новости</a></li>
 <?php 
 if (isset($_SESSION['id'])) {
    echo '<li><a
    href="http://localhost/Social_GalkinD//shop/shop.php">Магазин</a></li>';
 } else {
    echo '<li><a
    href="http://localhost/Social_GalkinD/auth.php">Магазин</a></li>';
 }
 ?>
 <li><a href="http://localhost/Social_GalkinD/games/games.php">Игры</a></li>
 <li><a href="http://localhost/Social_GalkinD/video/all_videos.php">Видео</a></li>
 <li><a href="http://localhost/Social_GalkinD/music/music_list.php">Музыка</a></li>
</ul>
</nav>

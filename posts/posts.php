<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница</title>
    <link rel="stylesheet" href="../css/menu.css">
  
    <link rel="stylesheet" href="../css/main-posts.css">
</head>
<header>
<h1>Посты</h1>
</header>
<body>
    <?php include("../menu.php"); ?>
    <div class="container">
        <?php
         
            if (isset($_SESSION['id'])) {
          
                echo '<a href="createpost.php" class="create-post-button">Создать пост</a>';
            }
        ?>
        <div class="posts">
         
            <?php include("showposts.php"); ?>
        </div>
    </div>
    <script>
document.addEventListener("DOMContentLoaded", function() {
 
    var posts = document.querySelectorAll('.post');

    posts.forEach(function(post) {
       
        post.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#50576b';
        });
        
   
        post.addEventListener('mouseleave', function() {
            this.style.backgroundColor = ''; 
        });
    });
});
</script>
</body>
</html>

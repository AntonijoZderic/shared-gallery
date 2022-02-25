<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href=<?php echo URLROOT . "public/css/style.css" ?>>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>shared-gallery</title>
</head>
<body>
  <nav>
    <ul>
      <li><a href ="/home">Homepage</a></li>
      <li class="right"><a href ="/register">Register</a></li>
      <li class="right"><a href ="/login">Login</a></li>
    </ul>
  </nav>
  <div class="content center">
    <?php echo $content; ?>
  </div>
</body>
</html>
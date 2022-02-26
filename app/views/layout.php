<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href=<?php echo URLROOT . 'public/css/style.css' ?>>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>shared-gallery</title>
  <script src=<?php echo URLROOT . 'public/js/javascript.js' ?>></script>
</head>
<body>
  <nav>
    <ul>
      <?php if (isset($_SESSION['username'])) { ?>
        <li>
          <a href="/home">Homepage</a>
        </li>
        <li class="right">
          <a href="/logout">Logout</a>
        </li>
        <li>
          <a href="/management">Management</a>
        </li>
        <li>
          <a href="/account">My account: <?php echo $_SESSION['username']; ?></a>
        </li>
      <?php } else { ?>
        <li>
          <a href="/home">Homepage</a>
        </li>
        <li class="right">
          <a href="/register">Register</a>
        </li>
        <li class="right">
          <a href="/login">Login</a>
        </li>
      <?php } ?>
    </ul>
  </nav>
  <div class="content center">
    <?php echo $content; ?>
  </div>
</body>
</html>
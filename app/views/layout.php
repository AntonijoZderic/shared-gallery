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
        <li class="<?php echo $GLOBALS['currentPage'] == 'home' ? 'active' : ''; ?>">
          <a href="/home">Homepage</a>
        </li>
        <li class="right">
          <a href="/logout">Logout</a>
        </li>
        <li class="<?php echo $GLOBALS['currentPage'] == 'management' ? 'active' : ''; ?>">
          <a href="/management">Management</a>
        </li>
        <li class="<?php echo $GLOBALS['currentPage'] == 'account' ? 'active' : ''; ?>">
          <a href="/account">My account: <?php echo $_SESSION['username']; ?></a>
        </li>
      <?php } else { ?>
        <li class="<?php echo $GLOBALS['currentPage'] == 'home' ? 'active' : ''; ?>">
          <a href="/home">Homepage</a>
        </li>
        <li class="right <?php echo $GLOBALS['currentPage'] == 'register' ? 'active' : ''; ?>">
          <a href="/register">Register</a>
        </li>
        <li class="right <?php echo $GLOBALS['currentPage'] == 'login' ? 'active' : ''; ?>">
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
<form method="post" action="/register/register" class="form">
  <input type="text" name="username" placeholder="Username">
  <?php
    if (isset($this->data['usernameErr'])) {
      echo '<span class="error">'. $this->data['usernameErr'] . '</span>';
    }
  ?>
  <input type="text" name="email" placeholder="Email">
  <?php
    if (isset($this->data['emailErr'])) {
      echo '<span class="error">' . $this->data['emailErr'] . '</span>';
    }
  ?>
  <div class="space-between">
    <input type="password" name="pwd" placeholder="Password" class="pwd">
    <input type="password" name="pwdRepeat" placeholder="Repeat password" class="pwd">
  </div>
  <?php
    if (isset($this->data['pwdErr'])) {
      echo '<span class="error">' . $this->data['pwdErr'] . '</span>';
    }
  ?>
  <button type="submit">Register</button>
</form>
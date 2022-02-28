<form action="/login/login" method="post" class="form">
  <input type="text" name="email" placeholder="Email">
  <?php
    if (isset($this->data['emailErr'])) {
      echo '<span class="error">' . $this->data['emailErr'] . '</span>';
    }
  ?>
  <input type="password" name="pwd" placeholder="Password">
  <?php
    if (isset($this->data['pwdErr'])) {
      echo '<span class="error">' . $this->data['pwdErr'] . '</span>';
    }
  ?>
  <label>
    <input type="checkbox" name="remember" class="checkbox">
    Remember me
  </label>
  <span style="display:block">
    <button type="submit">Login</button>
    Don't have an account yet?
    <a href="/register"> Register</a>
  </span>
</form>
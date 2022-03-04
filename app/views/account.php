<h2>Change password</h2>
<p>Use a strong password that you're not using elsewhere.</p>
<form action="/account/changePwd" method="post" class="form">
  <input type="password" name="currPwd" placeholder="Current password">
  <?php
    if (isset($this->data['currPwdErr'])) {
      echo '<span class="error">' . $this->data['currPwdErr'] . '</span>';
    }
  ?>
  <div class="space-between">
    <input type="password" name="newPwd" placeholder="New password" class="pwd">
    <input type="password" name="confirmPwd" placeholder="Confirm new password" class="pwd">
  </div>
  <?php
    if (isset($this->data['newPwdErr'])) {
      echo '<span class="error">' . $this->data['newPwdErr'] . '</span>';
    }
  ?>
  <button type="submit">Change password</button>
</form>
<h2>Delete account</h2>
<p>Your account and all content associated with it will be permanently removed.</p>
<form action="/account/deleteAcc" method="post" onsubmit="return deleteConfirmation('acc')">
  <button type="submit">Delete account</button>
</form>
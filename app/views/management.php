<h2>Upload image</h2>
<p>Only jpg or png files are allowed.</p>
<form action="/management/upload" method="post" enctype="multipart/form-data" class="form">
  <input type="text" name="name" placeholder="Image name">
  <?php
    if (isset($this->data['errors']['nameErr'])) {
      echo '<span class="error">' . $this->data['errors']['nameErr'] . '</span>';
    }
  ?>
  <input type="file" name="image">
  <?php
    if (isset($this->data['errors']['fileErr'])) {
      echo '<span class="error">' . $this->data['errors']['fileErr'] . '</span>';
    }
  ?>
  <button type="submit">Upload</button>
</form>
<h2>Images</h2>
<table>
  <tr>
    <th>User info</th>
    <th>Image name</th>
    <th class="image-th">Image</th>
  </tr>
  <?php
    if (isset($this->data['imageData'])) {
      foreach ($this->data['imageData'] as $image) {
  ?>
    <tr>
      <td>
        <b>Username</b>
        <br>
        <?php echo $image['username']; ?>
        <br><br>
        <b>Email</b>
        <br>
        <?php echo $image['email']; ?>
      </td>
      <td>
        <?php echo $image['name']; ?>
      </td>
      <td>
        <div class="image-container">
          <img src="<?php echo URLROOT . 'public/uploads/' . $image['image']; ?>" class="image">
        </div>
        <?php if ($_SESSION['username'] == $image['username']) { ?>
          <form action="/management/delete" method="post" class="delete-form" onsubmit="return deleteConfirmation()">
            <input type="hidden" name="id" value="<?php echo $image['id']; ?>">
            <button type="submit" class="delete-btn">Delete</button>
          </form>
        <?php } ?>
      </td>
    </tr>
  <?php }} ?>
</table>
function getTotalImages() {
  const xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById('totalImages').innerHTML = 'Images in database: ' + this.responseText;
    }
  };

  xhttp.open('GET', '/home/getTotalImages', true);
  xhttp.send();
}

function deleteConfirmation(del) {
  if (del == 'acc') {
    return confirm('Are you sure you want to delete your account?');
  }

  return confirm('Are you sure you want to delete this image?');
}
<!DOCTYPE html>
<html lang="en">

<head>
<?php readfile("./html/header.html"); ?>
</head>

<body>

  <?php
    $currentPage = 'Download';
    include './html/navbar.php';
  ?>

  <div class="jumbotron">
    <div class="container text-center">
      <h2>Download</h2>
    </div>
  </div>

  <div class="container">
    <div class="form-row">
      <div class="col-md"></div>

      <div class="col-md-6">
        <p><h5>git repositories</h5></p>
          <p><i class="fab fa-github"></i>
            <a href="https://github.com/luponzo86/rhapsody">
            github.com/luponzo86/rhapsody (beta)</a>
          </p>
          <p><i class="fab fa-github"></i>
            <a href="https://github.com/luponzo86/rhapsody-website">
            github.com/luponzo86/rhapsody-website (beta)</a>
          </p>
      </div>
      <div class="col-md"></div>
    </div>
  </div>

<?php readfile("./html/footer.html"); ?>
<?php readfile("./html/js_src.html"); ?>

</body>

</html>
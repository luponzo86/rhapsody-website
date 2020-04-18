<!DOCTYPE html>
<html lang="en">

<head>
<?php
readfile("./html/header.html");
include 'src/php/utils.php';
?>
</head>

<body>

  <?php
    $currentPage = '';
    include './html/navbar.php';
  ?>


  <div class="jumbotron">
    <div class="container text-center">
      <h1>Rhapsody</h1>
      predicting the impact of human missense variants <br>
      based on proteins' sequence, structure and dynamics
    </div>
  </div>


  <div class="container-fluid md-3 text-center">

    <div class="row">
      <div class="col-md"> </div>
      <div class="col-md-8">
        <!-- ANNOUNCEMENTS -->
        <?php readfile("./announcements.html"); ?>
      </div>
      <div class="col-md"> </div>
    </div>


    <div class="row">
      <div class="col-md py-2">
        <a href="sat_mutagen.php" class="text-dark">
          <h5><i>In silico</i> saturation mutagenesis</h5>
        </a>
        <small class="form-text text-muted px-5">
          perform a complete scan of all possible 19 amino acid
          substitutions at each site on a human sequence.
          See example:
          <a href="./results.php?id=example-sm">H-Ras</a>.
          <?php faq_link('sm', 'more info...') ?>
        </small>
        <div class="p-3">
          <a href="sat_mutagen.php">
            <img src="./img/thumbnail-sm.png"
            class="img-responsive border rounded" style="width:80%" alt="">
          </a>
        </div>
      </div>

      <div class="col-md py-2">
        <a href="sat_mutagen.php?showCollapsable" class="text-dark">
          <h5>Variants on custom PDB structure </h5>
        </a>
        <small class="form-text text-muted px-5">
          perform saturation mutagenesis analysis on a specific conformer,
          homology model or homologous structure (in case human structure is
          not available).
          <?php faq_link('noPDB', 'more info...') ?>
        </small>
        <div class="p-3">
          <a href="sat_mutagen.php?showCollapsable">
            <img src="./img/thumbnail-customPDB.png"
            class="img-responsive border rounded" style="width:80%" alt="">
          </a>
        </div>
      </div>

      <div class="col-md py-2">
        <a href="batch_query.php" class="text-dark">
          <h5>Batch query of individual variants </h5>
        </a>
        <small class="form-text text-muted px-5">
          obtain predictions for a batch of up to 10,000 individual
          human missense variants from various protein sequences.
          See an example
          <a href="./results.php?id=example-bq">here</a>.
          <?php faq_link('bq', 'more info...') ?>
        </small>
        <div class="p-3">
          <a href="batch_query.php">
            <img src="./img/thumbnail-bq.png"
            class="img-responsive border rounded" style="width:80%" alt="">
          </a>
        </div>
      </div>
    </div>

  </div>


<?php readfile("./html/footer.html"); ?>
<?php readfile("./html/js_src.html"); ?>

</body>

</html>

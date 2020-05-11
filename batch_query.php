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
  $currentPage = 'batch_query';
  include './html/navbar.php';
?>

<div class="jumbotron">
  <div class="container text-center">
    <h2>Batch query</h2>
    get predictions for individual variants from multiple human sequences
  </div>
</div>

<div class="container">
<form class="needs-validation" novalidate action="submit_job.php" method="post"
      enctype="multipart/form-data">

<!-- row with radio buttons -->
<div class="form-row">
  <div class="col-md"></div>

  <div class="col-md-6">
    <label for="bq_radios">
      <h5>list of human missense variants</h5>
    </label>

    <!-- radio button with text area -->
    <div class="form-check">
      <div class="form-group">
        <input class="form-check-input" type="radio" name="bq_radios"
        id="bq_text_radio" value="bq_text" checked>
        <textarea class="form-control" rows="3" name="bq_text"
        id="bq_text" maxlength="500"
        onfocus="document.getElementById('bq_text_radio').checked=true"
        placeholder="P01112 99 Q R
EGFR_HUMAN 300 V A
..."></textarea>
        <small id="bq_text" class="form-text text-muted">
          type <a href="query_Uniprot.php" target='_blank'>Uniprot coordinates</a>
          or leave blank to run test case
          <?php faq_link('formats', 'click for more info on accepted formats...') ?>
        </small>
      </div>
    </div>

    <!-- radio button with upload file -->
    <div class="form-check">
      <input class="form-check-input" type="radio" name="bq_radios"
      id="bq_file_radio" value="bq_file">
      <div class="form-group">
        <!-- "classic" upload button -->
        <input type="file" name="bq_file" id="bq_file" autocomplete="off"
        onfocus="document.getElementById('bq_file_radio').checked=true" >
        <small id="bq_text" class="form-text text-muted">
          upload the list in a text file (150KB max)</small>
      </div>
    </div>

  </div>

  <div class="col-md"></div>
</div>


<!-- row with checkbox for opening collapsable row below -->
<div class="form-row">
  <div class="col-md"></div>

  <div class="col-md-6">
    <div class="form-group">
      <button type="button" class="btn btn-outline-info btn-sm"
        data-toggle="collapse" data-target="#collapse1"
        aria-expanded="false" aria-controls="collapse1">
        advanced settings
      </button>
    </div>
  </div>

  <div class="col-md"></div>
</div>

<!-- collapsable row with radio buttons for typing/uploading PDB -->
<div class="panel-collapse collapse" id="collapse1">

  <!-- "Rhapsody+EVmutation" classifier checkbox -->
  <div class="form-row">
    <div class="col-md"></div>
    <div class="col-md-6">
      <div class="form-group">
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input"
          name="EVmutation_checkbox" id="EVmutation_checkbox" autocomplete="off">
          <label class="custom-control-label" for="EVmutation_checkbox">
            include EVmutation feature
            <?php faq_link('EVmutation',
            'check to use &ldquo;full+EVmutation&rdquo; classifier for ' .
            'predictions (click for more info...)') ?>
          </label>
        </div>
      </div>
    </div>
    <div class="col-md"></div>
  </div>

</div> <!-- end of collapsable -->



<!-- row for email -->
<div class="form-row">
  <div class="col-md"></div>

  <div class="col-md-6">
    <div class="form-group">
      <label for="email">
        <h5>email</h5>
      </label>
      <input type="email" class="form-control" name="email" id="email"
      aria-describedby="emailHelp" value="" placeholder="(optional)">
      <small id="emailHelp" class="form-text text-muted">you'll be notified
        when results are ready
      </small>
      <div class="invalid-feedback">
        Invalid email address
      </div>
    </div>
  </div>

  <div class="col-md"></div>
</div>



<!-- row for submit button -->
<div class="form-row py-2">
  <div class="col-md text-center">
    <div class="form-group">
      <button class="btn btn-primary" type="submit">submit job</button>
    </div>
  </div>
</div>


</form>
</div>

<?php readfile("./html/footer.html"); ?>
<?php readfile("./html/js_src.html"); ?>

</body>

</html>

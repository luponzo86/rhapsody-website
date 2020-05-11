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
    $currentPage = 'sat_mutagen';
    include './html/navbar.php';
  ?>

  <div class="jumbotron">
    <div class="container text-center">
      <h2><i>In silico</i> saturation mutagenesis</h2>
      scan of all possible amino acid substitutions in a human protein sequence
    </div>
  </div>


<div class="container">
  <form class="needs-validation" novalidate action="submit_job.php"
  method="post" enctype="multipart/form-data">

<!-- row for query -->
<div class="form-row">
  <div class="col-md"></div>

  <div class="col-md-6">
    <div class="form-group">
      <label for="sm_query">
        <h5>Uniprot sequence ID</h5>
      </label>
      <input type="text" class="form-control" name="sm_query" id="sm_query"
      placeholder="P01112" value="">
      <small id="jobIDHelp" class="form-text text-muted">type the
        <a href="query_Uniprot.php" target='_blank'>Uniprot accession number</a>
        of a human sequence <?php faq_link('whyhuman',
        'only human sequences are accepted (click for more info...)')?>
        or leave blank to run test case. <br>
        optional: add a specific position for single-site scanning, e.g.
        &nbsp;<code>P01112 100</code>&nbsp;
        <?php faq_link('formats', 'click for more info on accepted formats...') ?>
      </small>
      <div class="invalid-feedback">
        Invalid query
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

  <!-- "use custom PDB structure" checkbox -->
  <div class="form-row">
    <div class="col-md"></div>
    <div class="col-md-6">
      <div class="form-group">
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input"
          name="customPDB_checkbox" id="customPDB_checkbox" autocomplete="off"
          onchange="document.getElementById('radios').disabled = !this.checked;">
          <label class="custom-control-label" for="customPDB_checkbox">
            use custom PDB structure
            <?php faq_link('noPDB', 'check and provide a PDB ID or PDB file '.
            'to run predictions on a specific protein structure or '.
            'conformation (click for more info...)') ?>
          </label>
        </div>
      </div>
    </div>
    <div class="col-md"></div>
  </div>

  <!-- radio buttons controled by "custom PDB" checkbox -->
  <fieldset class="ml-4" id="radios" disabled>

  <!-- "type PDB code" radio button -->
  <div class="form-row">
    <div class="col-md"></div>
    <div class="col-md-6">
      <div class="form-check pb-2">
        <input class="form-check-input" type="radio" name="customPDB_radios"
        id="customPDBID_radio" value="PDBID" checked>
        <div class="input-group input-group-sm">
          <input class="form-control" type="text" name="customPDBID" value=""
          id="customPDBID" maxlength="4" placeholder="type a PDB code..."
          onfocus="document.getElementById('customPDBID_radio').checked=true">
          <!-- <small id="PDBIDHelp" class="form-text text-muted">PDB ID</small> -->
        </div>
      </div>
    </div>
    <div class="col-md"></div>
  </div>

  <!-- "upload PDB file" radio button -->
  <div class="form-row">
    <div class="col-md"></div>
    <div class="col-md-6">
      <div class="form-check">
        <input class="form-check-input" type="radio" name="customPDB_radios"
        id="customPDBfile_radio" value="PDBfile">
        <div class="form-group">
          <!-- "classic" upload button -->
          <input type="file" accept=".pdb,.pdb.gz" name="customPDBFile"
          id="customPDBFile" autocomplete="off"
          onfocus="document.getElementById('customPDBfile_radio').checked=true">
        </div>
      </div>
    </div>
    <div class="col-md"></div>
  </div>

  <!-- environment yes/no -->
  <div class="form-row pb-4">
    <div class="col-md"></div>
    <div class="col-md-6">
      <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input"
        name="environment_checkbox" id="environment_checkbox" autocomplete="off">
        <label class="custom-control-label" for="environment_checkbox">
          <small>include "environmental effects"</small>
          <?php faq_link('environment', 'check to include the effect of the '.
          'presence of other chains in the PDB structure (click for '.
          'more info...)') ?>
        </label>
      </div>
    </div>
    <div class="col-md"></div>
  </div>

</fieldset>

</div> <!-- end of collapsable -->



<!-- email row -->
<div class="form-row">
  <div class="col-md"></div>

  <div class="col-md-6">
    <div class="form-group">
      <label for="email">
        <h5>email</h5>
      </label>
      <input type="email" class="form-control" name="email" id="email"
      aria-describedby="emailHelp"  value="" placeholder="(optional)">
      <small id="emailHelp" class="form-text text-muted">
        you'll be notified when results are ready
      </small>
      <div class="invalid-feedback">
        Invalid email address
      </div>
    </div>
  </div>

  <div class="col-md"></div>
</div>


<!-- submit button row -->
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


<script>
  // show collapsable if requested
  if (<?php if (isset($_GET['showCollapsable'])) echo 'true';?>) {
    setTimeout(function() {
      $('#collapse1').collapse('show');
      setTimeout(function() {
        $('#customPDB_checkbox').prop('checked', true);
        $('#radios').prop('disabled', false);
      }, 300);
    }, 300);
  }

  // Example starter JavaScript for disabling form submissions if there are invalid fields
  (function() {
    'use strict';
    window.addEventListener('load', function() {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('needs-validation');
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      });
    }, false);
  })();
</script>

</body>

</html>

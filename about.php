<!DOCTYPE html>
<html lang="en">

<head>
<?php readfile("./html/header.html"); ?>

</head>

<body>
  <?php
    $currentPage = 'about';
    include './html/navbar.php';
  ?>

  <div class="jumbotron">
    <div class="container text-center">
      <h2>About</h2>
    </div>
  </div>

  <div class="container">
    <div class="form-row">
      <div class="col-md"></div>

      <div class="col-md-6">
        <h5>please cite:</h5>

        <p>
        <div class="altmetric-embed" data-altmetric-id="76699800">preprint</div>
        <a href="https://academic.oup.com/bioinformatics/advance-article/doi/10.1093/bioinformatics/btaa127/5758260?guestAccessKey=3da7600f-7185-43dd-b4a4-f647ad91d9f4" target="_blank">
        <i>Rhapsody: Predicting the pathogenicity of human missense variants</i>
        </a><br>
        Luca Ponzoni, Daniel A. Peñaherrera, Zoltán N. Oltvai, Ivet Bahar<br>
        <small>
        <b>Bioinformatics</b> (in press, 26 Feb 2020), DOI: 10.1093/bioinformatics/btaa127<br>
        [<a href="https://www.biorxiv.org/content/10.1101/737429v1"
        target="_blank">bioRxiv preprint</a>]
        </small>
        </p>

        <p>
        <div class="altmetric-embed" data-altmetric-id="35144492"></div>
        <a href="https://www.pnas.org/content/115/16/4164" target="_blank">
          <i>Structural dynamics is a determinant of the functional
          significance of missense variants </i>
        </a><br>
        Luca Ponzoni, Ivet Bahar <br>
        <small><b>PNAS</b> Apr 2018, 115 (16) 4164-4169;
          DOI: 10.1073/pnas.1715896115 </small>
        </p>

        <h5>other:</h5>
        <p>
          Please consider also citing
          <a href="http://genetics.bwh.harvard.edu/pph2/" target="_blank">
            PolyPhen-2</a> and
          <a href="https://marks.hms.harvard.edu/evmutation/" target="_blank">
            EVmutation</a>,
          if using their results.
        </p>
      </div>
      <div class="col-md"></div>
    </div>
  </div>


<?php readfile("./html/footer.html"); ?>
<?php readfile("./html/js_src.html"); ?>
<script
  type="text/javascript" src="https://d1bxh8uas1mnw7.cloudfront.net/assets/embed.js">
</script>

</body>


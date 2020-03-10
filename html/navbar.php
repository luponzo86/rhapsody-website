<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="index.php">Rhapsody</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse"
  data-target="#myNavBar" aria-controls="myNavBar" aria-expanded="false"
  aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>


<?php
  $a = [
    'sat_mutagen' => ['', ''],
    'batch_query' => ['', ''],
    'retrieve_jobs' => ['', ''],
    'FAQs' => ['', ''],
    'Py_package' => ['', ''],
    'about' => ['', ''],
  ];
  $a[$currentPage] = ['active', '<span class="sr-only">(current)</span>']
?>

  <div class="collapse navbar-collapse" id="myNavBar">

    <!-- left navbar -->
    <ul class="navbar-nav mr-auto">
      <li class="nav-item <?php echo $a['sat_mutagen'][0]?>">
        <a class="nav-link" href="sat_mutagen.php">Run saturation mutagenesis
          <?php echo $a['sat_mutagen'][1]?>
        </a>
      </li>
      <li class="nav-item <?php echo $a['batch_query'][0]?>">
        <a class="nav-link" href="batch_query.php">Query single variants
          <?php echo $a['batch_query'][1]?>
        </a>
      </li>
      <li class="nav-item <?php echo $a['retrieve_jobs'][0]?>">
        <a class="nav-link" href="retrieve_jobs.php">Retrieve jobs
          <?php echo $a['retrieve_jobs'][1]?>
        </a>
      </li>
    </ul>

    <!-- right navbar -->
    <ul class="navbar-nav navbar-right">
      <li class="nav-item dropdown <?php echo $a['Py_package'][0]?>">
        <a class="nav-link dropdown-toggle" href="#" id="dropdownID"
          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Python package <?php echo $a['Py_package'][1]?>
        </a>
        <div class="dropdown-menu" aria-labelledby="dropdownID">
          <a class="dropdown-item" href="download.php">
            Download
          </a>
          <a class="dropdown-item"
            href="https://nbviewer.jupyter.org/github/prody/rhapsody-tutorials/tree/master/tutorials"
            target="_blank">
            Tutorials
          </a>
          <a class="dropdown-item" href="https://rhapsody.readthedocs.io/en/latest/"
            target="_blank">
            Docs
          </a>
        </div>
      </li>
      <li class="nav-item <?php echo $a['FAQs'][0]?>">
        <a class="nav-link" href="faqs.php">FAQs
          <?php echo $a['FAQs'][1]?>
        </a>
      </li>
      <li class="nav-item <?php echo $a['about'][0]?>">
        <a class="nav-link" href="about.php">About
          <?php echo $a['about'][1]?>
        </a>
      </li>
    </ul>
  </div>
</nav>


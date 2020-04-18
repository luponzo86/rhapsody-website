<!DOCTYPE html>
<html lang="en">

<?php
include 'src/php/utils.php';

$scratch_dir = "./workspace";

$arr = check_jobid_and_jobdir($scratch_dir);
$jobid  = $arr["jobid"];
$jobdir = $arr["jobdir"];
?>

<head>
<?php readfile("./html/header.html"); ?>
</head>

<body>

  <?php
    $currentPage = '';
    include './html/navbar.php';
  ?>

  <div class="jumbotron">
    <div class="container text-center">
      <h2>Job #<?php echo $jobid;?></h2>
    </div>
  </div>


  <div class="container bg-3">
    <div class="row">
      <div class="col-md">
        <h4>
          status: <b><span style="color:red;" id="status_update"></span></b>
        </h4>
        <div id="infodiv">
          <p><small class="text-muted">
            bookmark this page to check your job status later.
            If you provided an email address, you'll be notified.
          </small></p>
        </div>
        <div id="errordiv" style="display:none">
          <p><small class="text-muted">
            please check error message below and
            <a href="<?php echo $jobdir;?>" target='_blank'>output folder</a>.
            Contact us for assistance (see footer).
          </small></p>
        </div>
        <div id="resultsdiv" style="display:none">
          <p><small class="text-muted">
            you will be automatically redirected to the
            <a href="results.php?id=<?php echo $jobid;?>">results</a>
            page in <span id="counter">4 seconds</span>...
          </small></p>
        </div>
        <div id="logdiv">
	  <!-- number of 'rows' below must be at least 2 + number of lines in tailShell() 
               call in src/php/get_status.php:returnStatus()  -->
          <textarea class="form-control" id="log_update" cols="100" rows="9" readonly
                    style="font-family:monospace; font-size:12px; white-space:pre-wrap">
            ...
          </textarea>
        </div>
      </div>
    </div>
  </div>



  <?php readfile("./html/footer.html"); ?>
  <?php readfile("./html/js_src.html"); ?>


  <!-- JS code for printing log live -->
  <script type="text/javascript">
    var jobid      = "<?php echo $jobid;?>";
    var job_status = "-";
    var log_tail   = "";

    function check_status() {
      console.log("job status: " + job_status);

      $.get( "src/php/get_status.php?id=" + jobid , function(data, status){
        job_status = data.status;
        log_tail   = data.logTail;
      }, "json");

      $("#status_update").html(job_status);
      $("#log_update").html(log_tail);

      if (job_status == "-") {
        setTimeout(check_status, 100);
      }
      else if (job_status == "running...") {
        setTimeout(check_status, 300);
      }
      else if (job_status == "completed") {
        $("#infodiv").hide();
        $("#resultsdiv").show();
        countdown();
      }
      else {
        $("#infodiv").hide();
        $("#errordiv").show();
      }
    }

    function countdown() {
      var counter = document.getElementById('counter');
      var i = parseInt(counter.innerHTML.substring(0, 1)) - 1;
      if (i <= 0) {
        location.href = 'results.php?id=<?php echo $jobid;?>';
      }
      else {
        if (i>1) {counter.innerHTML = i + " seconds";}
        else     {counter.innerHTML = i + " second";}
        setTimeout(countdown, 1000);
      }
    }

    $(document).ready(function() {
      check_status();
    })
  </script>

</body>

</html>

<?php

include 'src/php/utils.php';

function endsWith($haystack, $needle) {
  $length = strlen($needle);
  if ($length == 0) return true;
  return (substr($haystack, -$length) === $needle);
}

function save2file($fname, $value) {
  $file = fopen($fname, "w");
  fwrite($file, $value);
  fclose($file);
}

$scratch_dir = "./workspace";



// determine submission type
$subm_type = '';
if ( isset($_POST["sm_query"]) ) {
  $subm_type = 'sat_mutagen';
}
elseif ( isset($_POST["bq_radios"]) ) {
  $subm_type = 'batch_query';
}


// check for errors and print error messages, if any
$errors = [];

if ( $subm_type == 'sat_mutagen' ) {
  $back_link = 'sat_mutagen.php';
  // check input data
  $query = str_replace(array(" ", "\n", "\r"), '', $_POST["sm_query"]);
  if ( empty($query) || $query=="test" ) {
    // check if custom PDB is provided
    if ( isset($_POST["customPDB_checkbox"]) ) {
      // interpret empty query field as "P01112"
      $_POST["sm_query"] = "P01112";
    }
    else {
      $subm_type = "example-sm";
    }
  }
  else {
    $parsed_query = explode(" ", trim($_POST["sm_query"]));
    if (sizeof($parsed_query) > 2) {
      $errors[] = 'Query must be a single Uniprot identifier (e.g. ' .
        '"P01112") or a Uniprot ID plus a specific position on the ' .
        'sequence (e.g. "P01112 100").';
    }
    if (!ctype_alnum($query))
    $errors[] = 'Query must contain letters, numbers and spaces only.';
  }
  if ( isset($_POST["customPDB_checkbox"]) ) {
    $radio_value = $_POST["customPDB_radios"];
    if ( $radio_value == "PDBID" ) {
      $PDBID = str_replace(' ', '', $_POST["customPDBID"]);
      if ( ! ctype_alnum($PDBID) || strlen($PDBID)!=4 )
        $errors[] = 'PDB code must be a 4-letter alphanumeric code.';
    }
    else if ( $radio_value == "PDBfile" ) {
      # check for correct file extensions
      $fname = $_FILES["customPDBFile"]["name"];
      if ( ! (endsWith($fname, ".pdb") || endsWith($fname, ".pdb.gz")) )
        $errors[] = 'Only files with extensions ".pdb" or ".pdb.gz" are accepted.';
      if ( $_FILES["customPDBFile"]["size"] > 2000000 )
        $errors[] = 'PDB file is too large (>2MB).';
    }
    else {
      $errors[] = 'Internal error: Invalid custom PDB selection.';
    }
  }
}
elseif ( $subm_type == 'batch_query' ) {
  $back_link = 'batch_query.php';
  // check input data
  $radio_value = $_POST["bq_radios"];
  if ( $radio_value == "bq_text" ) {
    $text = $_POST["bq_text"];
    $text = str_replace(array(" ", "_", "\n", "\r"), '', $text);
    if ( empty($text) || $text=="test" )
      $subm_type = "example-bq";
    elseif ( !ctype_alnum($text) )
      $errors[] = 'SAV coordinates can only contain ' .
                  'alphanumeric characters and underscores.';
    elseif ( strlen($text) > 500 )
      $errors[] = 'input text is too long.';
  }
  else if ( $radio_value == "bq_file" ) {
    if ( $_FILES["bq_file"]["size"] == 0 )
      $errors[] = 'Empty file';
    elseif ( $_FILES["bq_file"]["size"] > 150000 )
      $errors[] = 'Uploaded file is too large (>150KB).';
  }
  else {
    $errors[] = 'Internal error: Invalid batch query.';
  }
}
else {
  $errors[] = 'Internal error: Invalid submission type.';
  $back_link = 'index.php';
}
if ( isset($_POST["email"]) && $_POST["email"]!="" &&
     !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
  $errors[] = 'Invalid email address.';
}

if (!empty($errors)) {
  $err_msg = "";
  foreach($errors as $err) {
    $err_msg .= $err . '&#13;&#10;';
  }
  // // DEBUG: append info to error message
  // $err_msg .= "Set variables: <br>";
  // $err_msg .= print_r($_POST, true);
  // $err_msg .= "<br>Uploaded files: <br>";
  // $err_msg .= print_r($_FILES, true);

  // exit to error page
  $arr = ["err_msg" => $err_msg, "back_link" => $back_link];
  redirect("error.php", $arr);
}


// create a unique job ID and directory
$orig_dir = getcwd();
$jobid  = "";
$jobdir = "";
while ( $jobid=="" || file_exists($jobdir) ) {
  $salt = time();
  $jobid = substr(md5($salt), 0, 10);
  $jobdir = $scratch_dir . "/job_" . $jobid;
}
// store test examples in a special directory for the first time only
if ( substr($subm_type, 0, 8) == "example-") {
  $exdir = $scratch_dir . "/job_" . $subm_type;
  if ( !file_exists($exdir) ) {
    $jobid  = $subm_type;
    $jobdir = $exdir;
  }
}
mkdir($jobdir);


// write data to file
chdir($jobdir);

if ( $subm_type == 'sat_mutagen' ) {
  save2file("input-sm_query.txt", $_POST["sm_query"]);
  if ( isset($_POST["customPDB_checkbox"]) ) {
    $radio_value = $_POST["customPDB_radios"];
    if ( $radio_value == "PDBID") {
      save2file("input-PDBID.txt", $_POST["customPDBID"]);
    }
    else {
      $orig_fname = $_FILES["customPDBFile"]["name"];
      $temp_fname = $_FILES["customPDBFile"]["tmp_name"];
      if ( endsWith($orig_fname, ".pdb") )
        $new_fname = "input-PDB.pdb";
      else
        $new_fname = "input-PDB.pdb.gz";
      if (! move_uploaded_file($temp_fname, $new_fname)) {
        // exit to error page
        $err_msg = "Sorry, there was an error uploading your file";
        $arr = ["err_msg" => $err_msg, "back_link" => $back_link];
        redirect("error.php", $arr);
      }
    }
  }
}
elseif ( $subm_type == 'batch_query' ) {
  $radio_value = $_POST["bq_radios"];
  if ( $radio_value == "bq_text" ) {
    save2file("input-batch_query.txt", $_POST["bq_text"]);
  }
  else {
    $tmp_fname = $_FILES["bq_file"]["tmp_name"];
    if (! move_uploaded_file($tmp_fname, "input-batch_query.txt")) {
      // exit to error page
      $err_msg = "Sorry, there was an error uploading your file";
      $arr = ["err_msg" => $err_msg, "back_link" => $back_link];
      redirect("error.php", $arr);
    }
  }
}
elseif ( substr($subm_type, 0, 8) == "example-") {
  // try to reuse PolyPhen-2 files
  $pph2file = "../job_" . $subm_type . "/pph2-full.txt";
  if ( file_exists($pph2file) ) {
    copy($pph2file, './pph2-full.txt');
  }
  // print test query to file
  if ( $subm_type == "example-sm" ) {
    $test_query = "P01112";
    save2file("input-sm_query.txt", $test_query);
  }
  elseif ( $subm_type == "example-bq" ) {
    $test_query = "P01112 99 Q R\nEGFR_HUMAN 300 V A\n";
    save2file("input-batch_query.txt", $test_query);
  }
}
else {
  // exit to error page
  $err_msg = "Internal error: invalid submission type";
  $arr = ["err_msg" => $err_msg, "back_link" => $back_link];
  redirect("error.php", $arr);
}


if (! empty($_POST["email"]) ) {
  save2file("input-email.txt", $_POST["email"]);
}


chdir($orig_dir);


if (false) {
  // DEBUG: instead of launching the job, save variables to file and exit
  $output = print_r($_POST, true);
  echo '<pre>'; print_r($_POST); echo '</pre>';
  file_put_contents("${jobdir}/input.log", $output);
  $output = print_r($_FILES, true);
  echo '<pre>'; print_r($_FILES); echo '</pre>';
  file_put_contents("${jobdir}/input.log", $output, FILE_APPEND);
  }
else {
  // launch job in the background
  $pyscript = "${orig_dir}/src/python/rhapsody_interface.py";
  $pid_file = "${jobdir}/PID.tmp";
  exec("nohup src/bin/launch_job.sh $jobdir $pyscript < /dev/null " .
       ">> ${scratch_dir}/launch_job.err 2>&1 & echo $! > $pid_file");

  // clean workspace from old jobs
  exec("nohup src/bin/clean_workspace.sh $scratch_dir < /dev/null " .
       ">> ${scratch_dir}/old_jobs.log 2>> ${scratch_dir}/old_jobs.err &");

  // go to the progress page
  $page = "status.php?id=${jobid}";
  echo "<script type='text/javascript'> window.location.href='$page';</script>";

  // I don't understand why redirect() does not work here...
  // redirect("status.php", ["id" => $jobid]);
}


exit();
?>

<?php

$scratch_dir = "../../workspace";
$pidFile     = "PID.tmp";
$doneFile    = "rhapsody-results.zip";

include './utils.php';

function isProcessRunning($f) {
  if ( !file_exists($f) ) {
    return False;
  }
  $pid = file_get_contents($f);
  return posix_kill((int)$pid, 0);
}

function tailShell($filepath, $lines = 10) {
  ob_start();
  passthru('tail -' . $lines . ' ' . escapeshellarg($filepath));
  return trim(ob_get_clean());
}

function catShell($filepath) {
  ob_start();
  passthru('cat ' . escapeshellarg($filepath));
  return trim(ob_get_clean());
}

function returnStatus($status) {
  $logFile = 'rhapsody-log.txt';
  $statusFile = 'rhapsody-status.txt';
  $pph2File = 'pph2-log.txt';
  $pph2Log = "";
  if ( file_exists($logFile) ) {
    // number of lines below must be at least 2 less than
    // n. of rows in status.php
    $logTail = tailShell($logFile, 7);
    if ( file_exists($statusFile) ) {
      $logTail .= "\r\n\r\n" . tailShell($statusFile, 1);
    }
  }
  else {
    $logTail = "";
  }
  if ( $status == 'aborted' && file_exists($pph2File) ) {
    # read PolyPhen-2 log if 'pph2-log.txt' is mentioned in the log
    if (strpos($logTail, 'pph2-log.txt') !== false) {
      $pph2Log = catShell($pph2File);

    }
  }
  $arr = array(
    'status' => $status,
    'logTail' => $logTail,
    'pph2Log' => $pph2Log,
  );
  die( json_encode($arr) );
}


// // DEBUG:
// $arr = array('status' => "running...", 'logTail' => "something");
// die( json_encode($arr) );

$arr = check_jobid_and_jobdir($scratch_dir);
$jobid  = $arr["jobid"];
$jobdir = $arr["jobdir"];

chdir($jobdir);

if ( isProcessRunning($pidFile) ) {
  returnStatus('running...');
}
else {
  exec("rm -f $pidFile");
  if ( file_exists($doneFile)) {
    returnStatus('completed');
  }
  else {
    returnStatus('aborted');
  }
}

?>

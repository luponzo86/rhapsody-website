<!DOCTYPE html>
<html lang="en">

<?php
// determine body content based on submission type

include 'src/php/utils.php';

$scratch_dir = "./workspace";

$arr = check_jobid_and_jobdir($scratch_dir);
$jobid  = $arr["jobid"];
$jobdir = $arr["jobdir"];

$faq_link_output = faq_link('output', 'file content description...', false);
$arr += ["faq_link_output" => $faq_link_output];

// update cookies
update_cookie($scratch_dir, $jobid);

if ( file_exists("${jobdir}/input-sm_query.txt") ) {
  $subm_type = 'sm';
  // get sequence Uniprot accession number
  $f = fopen("${jobdir}/rhapsody-Uniprot2PDB.txt", 'r');
  $first_line  = fgets($f);
  $second_line = fgets($f);
  fclose($f);
  $Uniprot_acc = explode(" ", trim($second_line))[0];
}
elseif ( file_exists("${jobdir}/input-batch_query.txt") )
  $subm_type = 'bq';

# create results page
if ( $subm_type == 'sm' ) {
  $html_snippet = "";
  $js_snippet   = "";
  $img_template = '<div class="py-2"><img src="{{fname}}" alt="{{fname}}" ' .
                  'class="img" style="max-height: 480px; max-width: 100%;" ' .
                  'id="{{imgid}}" usemap="#map_{{imgid}}"></div>' . "\n";
  $img_file_list = glob("${jobdir}/rhapsody-figure*.png");
  sort($img_file_list, SORT_NATURAL);
  foreach ( $img_file_list as $fname ) {
    $basename = basename($fname, ".png");
    $imgid = str_replace('rhapsody-', '', $basename);
    // create html image
    $html_img = str_replace("{{fname}}", $fname, $img_template);
    $html_img = str_replace("{{imgid}}", $imgid, $html_img);
    // create image map too
    $html_map = file_get_contents("${jobdir}/${basename}.html");
    $html_map = str_replace('{{map_id}}', "map_${imgid}", $html_map);
    $map_attrs = '';
    $html_map = str_replace('{{map_attrs}}', $map_attrs, $html_map);
    $area_attrs = 'style="cursor: pointer;" ' .
                  'onmouseover="updateAreaSize(event)" ' .
                  'onmousemove="updateTooltip(event)" ' .
                  'onmouseout="hideTooltip(event)" ' .
                  'data-toggle="modal" data-target="#SAVmodal" ' .
                  'onclick="updateModalContent(event)"';
    $html_map = str_replace('{{area_attrs}}', $area_attrs, $html_map);
    // attach html lines
    $html_snippet .= $html_img;
    $html_snippet .= $html_map;
    // write javascript variables
    $js_vars = file_get_contents("${jobdir}/${basename}.js");
    $js_vars = str_replace('{{img_id}}', "${imgid}", $js_vars);
    $js_vars = str_replace('{{map_id}}', "map_${imgid}", $js_vars);
    $js_vars = str_replace('{{map_data}}', 'single_map', $js_vars);
    $js_snippet .= "\n" . $js_vars .
                   "AREA_DATA = Object.assign({}, AREA_DATA, single_map); \n";
  }
  // find fraction of SAVs with missing PDB structures
  $percentage_noPDB = 0;
  $searchthis = " have been mapped to PDB in ";
  $handle = @fopen("${jobdir}/rhapsody-log.txt", "r");
  if ($handle) {
    while (!feof($handle)) {
      $buffer = fgets($handle);
      if(strpos($buffer, $searchthis) !== FALSE) {
        $words = explode(" ", trim($buffer));
        $percentage_noPDB = (1 - $words[0]/$words[3])*100;
        $percentage_noPDB = round($percentage_noPDB, 0);
      }
    }
    fclose($handle);
  }
  if ($percentage_noPDB > 50) {
    # show alert
    $div_status = "inline-block";
  }
  else {
    $div_status = "none";
  }

  $arr += [
    "Uniprot_acc"     => $Uniprot_acc,
    "div_status"      => $div_status,
    "perc_noPDB"      => $percentage_noPDB,
    "images"          => $html_snippet,
    "lookup_tables"   => $js_snippet,
    "faq_link_legend" => faq_link('legend', 'more info...', false),
    "faq_link_noPDB"  => faq_link('noPDB', 'more info...', false),
  ];
}

$body = fill_template("results-${subm_type}.html", $arr);
?>


<head>
<?php
readfile("./html/header.html");
readfile("./html/js_src.html");
?>
</head>

<body>
<?php
  $currentPage = '';
  include './html/navbar.php';

  echo $body;

  readfile("./html/footer.html");
?>
</body>

</html>
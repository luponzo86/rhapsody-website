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
    $currentPage = 'FAQs';
    include './html/navbar.php';
  ?>

  <div class="jumbotron">
    <div class="container text-center">
      <h2>FAQs</h2>
    </div>
  </div>

  <div class="container">
    <div class="form-row">
      <div class="col-md"></div>

      <div class="col-md-6">
        <ol>

<li id="FAQ-general">
  <h5>What is Rhapsody?</h5>
  <p><small> Rhapsody is a machine learning tool for predicting
  the impact of amino acid substitutions in proteins.
  It consists of a random forest classifier trained
  not only on traditional conservation properties, but also
  on structural and <i>dynamical</i> properties
  of the mutation site, localized on the protein's PDB structure,
  and <i>coevolution</i> properties, extracted from Pfam sequence
  alignments.
  </small></p>
</li>
<li id="FAQ-SAV">
  <h5>What kind of variants can Rhapsody analyze?</h5>
  <p><small> Rhapsody can provide predictions for Single Amino acid
  Variants (SAVs) in <i>human</i> proteins for which PDB structures
  are available.
  </small></p>
</li>
<li id="FAQ-whyhuman">
  <h5>Why only <i>human</i> SAVs?</h5>
  <p><small> Because Rhapsody derives sequence conservation properties
  from <a href="http://genetics.bwh.harvard.edu/pph2/" target="_blank">
  PolyPhen-2</a>, which is designed to work only for human SAVs.
  </small></p>
</li>
<li id="FAQ-formats">
  <h5>What are the accepted input formats?</h5>
  <p><small> Rhapsody only accepts SAVs in Uniprot coordinates,
  with the format:<br>
  <code>
    &lt;Uniprot ID&gt; &lt;position&gt; &lt;wild-type aa&gt;
    &lt;mutated aa&gt;</code>&nbsp;.<br>
  For instance, mutation Q99R in human protein
  <a href="https://www.uniprot.org/uniprot/P01112" target="_blank">
    GTPase HRas</a> can be queried by submitting the input string
  &nbsp;<code>P01112 99 Q R</code>&nbsp; or
  &nbsp;<code>RASH_HUMAN 99 Q R</code>&nbsp;.<br>
  We provide a <a href="query_Uniprot.php">Uniprot search tool</a>
  to help with the identification of a sequence's unique accession
  number. When running an <a href="sat_mutagen.php">
    <i>in silico</i> saturation mutagenesis</a> analysis, only the
  Uniprot sequence identifier (plus, optionally, a specific position)
  should be provided.
  </small></p>
</li>
<li id="FAQ-sm">
  <h5>What does "<i>in silico</i> saturation mutagenesis" mean?</h5>
  <p><small> A complete scanning of all possible 19 amino acid
  substitutions at every position in a protein sequence. The
  result will be a "saturation mutagenesis table" (see
  <a href="./results.php?id=example-sm">example</a>) that not only
  contains predictions for individual mutations, but also provides
  a general view of the parts in the sequence that are predicted to
  be more (or less) sensitive to mutations.
  </small></p>
</li>
<li id="FAQ-bq">
  <h5>What is a "batch query"?</h5>
  <p><small> A batch query allows to submit a list of individual
  variants from a single or multiple protein sequences. The list must
  contain one variant per line, in
  <a href="#FAQ-formats">Uniprot coordinates</a>.
  </small></p>
</li>
<li id="FAQ-noPDB">
  <h5>What if there is no PDB structure for a given protein?</h5>
  <p><small> Normally, when queried with a sequence, Rhapsody searches the
  <a href="https://www.rcsb.org/" target="_blank">Protein Data Bank</a>
  for the "best" (i.e. the largest) structure available. If a
  structure is not found, the user can manually provide a custom
  protein structure, by either indicating a PDB code (for instance,
  of a homologous protein from another organism) or uploading a file
  in PDB format (e.g. downloaded from the
  <a href="https://swissmodel.expasy.org/repository" target="_blank">
  SWISS-MODEL repository</a> of homology models, see
  <a href="https://nbviewer.jupyter.org/github/prody/rhapsody-tutorials/blob/master/tutorials/6-Application_to_ROMK/ROMK_variants_analysis.ipynb">
  ROMK tutorial</a> for an example). This option can also be used
  to run predictions on a particular protein structure or conformation
  (see <a href="https://nbviewer.jupyter.org/github/prody/rhapsody-tutorials/blob/master/tutorials/4-Application_to_HRAS/RAS_variants_analysis.ipynb">
  HRAS tutorial</a> for an example).
  Please note that Rhapsody will automatically align the Uniprot sequence to
  the PDB sequence and compute predictions only for matching amino acids: if
  the two sequences are too dissimilar, the resulting predictions might be too
  sparse.
  </small></p>
</li>
<li id="FAQ-environment">
  <h5>What does it mean to include "environmental effects"?</h5>
  <p><small>When computing structural and dynamical features from a PDB
  structure, by default Rhapsody will only consider a single chain and ignore
  other chains that might be present in the PDB file. Sometimes, for instance
  in the case of multimers or other complexes, the presence of other chains
  should not be ignored and those properties should be computed for the entire
  complex. This is done by using a variant of Elastic Network Model called
  "environmental ANM" (more precisely, a "sliced" model, see <a href="about.php">
  main publication</a> and <a href="https://nbviewer.jupyter.org/github/prody/rhapsody-tutorials/blob/master/tutorials/6-Application_to_ROMK/ROMK_variants_analysis.ipynb">
  ROMK tutorial</a>). In conclusion, environmental effects should be
  included if the chain of interest is part of a "stable" complex (e.g. a
  multimer) and as such its dynamical properties are influenced and determined
  by the presence of other chains. On the other hand, computing predictions on
  large complexes will take a significantly longer time.
  </small></p>
</li>
<li id="FAQ-legend">
  <h5>What is the difference between "full" and "reduced" classifiers?</h5>
  <p><small>Both "full" and "reduced" classifiers are trained on
  sequence-, structure- and dynamics-based features. The main
  difference is that the "full" classifier also includes
  <i>coevolutionary</i> properties computed on Pfam multiple
  sequence alignments. If part of a sequence is not covered by a
  Pfam domain, predictions from the "reduced" classifier are returned
  instead.
  </small></p>
</li>
<li id="FAQ-EVmutation">
  <h5>What is the "full+EVmutation" classifier?</h5>
  <p><small>The "full+EVmutation" classifier includes in its list of features
    used for predictions the "epistatic statistical energy difference of
    mutant", computed by <a href="https://marks.hms.harvard.edu/evmutation/"
    target="_blank">EVmutation</a> and based on coevolution analysis of
    multiple sequence alignments. Although it has been shown to slightly improve
    the accuracy of predictions (see <a href="about.php">Rhapsody paper</a>),
    by default this additional feature is not included in order to provide
    predictions that are independent from those computed by EVmutation.
    EVmutation predictions alone are always displayed in the final
    results along with those from Rhapsody and
    <a href="http://genetics.bwh.harvard.edu/pph2/" target="_blank">
    PolyPhen-2</a>.
  </small></p>
</li>
<li id="FAQ-output">
  <h5>What is displayed in the output files?</h5>
  <p><small><ol type="a">

    <li><b>Rhapsody predictions (simple view):</b> contains
    "combined" predictions from "full" and "reduced" Rhapsody
    classifiers. The latter returns "backup" predictions whenever
    the primary classifier cannot be applied for lack of Pfam
    domains, used for computing coevolutionary features.
    <ul>
    <li>Column <code>training info</code> indicates whether a variant
      was never seen by the classifier (<code>new</code>), thus its
      prediction can be considered genuine, or was included in the training
      dataset (<code>known_del</code> or <code>known_neu</code>),
      thus its prediction cannot be considered unbiased.</li>
    <li>Column <code>score</code> contains the output from the random
      forest classifier, a real number between 0 and 1.</li>
    <li>Column <code>prob.</code> contains a "pathogenicity probability"
      calculated by applying a non-linear monotonic transformation to
      the random forest score that eliminates the effect of an
      imbalanced training dataset (where <code>deleterious</code> labels usually
      dominate). After this operation, the threshold between <code>neutral</code>
      and <code>deleterious</code> predictions can be set at 0.5.</li>
    <li>Column <code>class</code> provides a final classification of
      variants into <code>neutral</code> and <code>deleterious</code>.</li>
    <li>The last columns on the right contain predicted scores and
      classes from
      <a href="http://genetics.bwh.harvard.edu/pph2/" target="_blank">
      PolyPhen-2</a> and
      <a href="https://marks.hms.harvard.edu/evmutation/" target="_blank">
      EVmutation</a>.</li>
    </ul></li>

    <li><b>Rhapsody predictions (detailed view):</b> contains predicted
    scores, probabilities and classes from both the "full"
    (<code>main</code>) or "reduced" (<code>aux.</code>) classifiers,
    as explained above. A left arrow between the two sets of
    columns indicates that "reduced" predictions replace missing
    "full" predictions in the "combined" results mentioned above.
    </li>

    <li><b>PolyPhen-2 output:</b> contains the output from
    <a href="http://genetics.bwh.harvard.edu/pph2/" target="_blank">
    PolyPhen-2</a> web tool.
    </li>

    <li><b>PDB mapping:</b> contains the mapping of variants from
    Uniprot coordinates to PDB structures, if possible. The column
    on the left contains the input Uniprot coordinates,
    while the second one provides the most up-to-date sequence
    IDs, as retrieved from Uniprot.
    </li>

    <li><b>computed features:</b> lists the values of each feature for
    all input variants.
    </li>

    <li><b>log file:</b> reports the detailed log of the submitted job.
    </li>

</ol></small></p>
</li>


        </ol>
      </div>
      <div class="col-md"></div>
    </div>
  </div>


<?php readfile("./html/footer.html"); ?>
<?php readfile("./html/js_src.html"); ?>

</body>

</html>

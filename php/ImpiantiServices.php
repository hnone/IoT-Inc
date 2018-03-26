<?php
include('session.php');
include('DAOImpianto.php');
include('Impianto.php');
$DAOImpianto = new DAOImpianto();
if($_SERVER["REQUEST_METHOD"] == "POST") {
  $postdata = file_get_contents("php://input");
  $request = json_decode($postdata);
  if ($request->cod == "getNomeImpianto") {

    $impianto = $DAOImpianto->getFromId($request->id);
    $nomeImpianto = $impianto->getNome();
  }
}
echo $nomeImpianto;
?>

<?php

include_once 'config.php';
include_once 'DAOImpianto.php';
include_once 'Impianto.php';
include_once 'DAOAutorizzazione.php';
include_once 'Cliente.php';
include_once 'DAOCliente.php';
include_once 'SensoreInstallato.php';
include_once 'DAOSensoreInstallato.php';
include_once 'Rilevazione.php';
include_once 'Adattatore.php';
include_once 'TerzaParte.php';
include_once 'CreaAdattatori.php';
include_once 'DAOTerzaParte.php';
include_once 'DAORilevazione.php';
include_once 'FileReader.php';

/*
$daoAutorizzazione = new DAOAutorizzazione();
$impianti = $daoAutorizzazione->getImpianti(1);
foreach($impianti as $currentImpianto) {
  echo ($currentImpianto->getNome());
}
*/
//$blabla= new CreaAdattatori("frenni.txt",100);
//$blabla->create();
//echo('FINITO!');

//TEST DATA/ORA
/*
$daotp = new DAOTerzaParte();
$tp = $daotp->getFromId(14);
$data = $tp->getUltimoInvio();
echo ($data); //STAMPA COSI' COME STA NEL DB (string)
echo ("\n");
echo(date('Y-m-d H:i:s', strtotime($data))); //IDENTICO ALLA STAMPA DI PRIMA (sempre string)
echo ("\n");
echo(date('Y-m-d H:i:s')); //STESSO FORMATO, MA DATA ATTUALE
echo ("\n");
echo(strtotime(date('Y-m-d H:i:s'))); //DATA ATTUALE IN INTERO
echo ("\n");
echo(strtotime('now')); //DATA ATTUALE IN INTERO
*/

//ALGORITMO
//Prendo la data di ultimo invio e la converto in INTERO
/*

$dao = new DAOTerzaParte();
$terzaParte = $dao->getFromId(14);
$ultimoInvioAsInt = strtotime($terzaParte->getUltimoInvio());
//Prendo la data attuale e la converto in INTERO
$dataAttualeAsInt = strtotime('now');
//Calcolo quanti minuti sono trascorsi tra le due date (tronco i secondi senza arrotondamento)
$diffMinuti = intval((($dataAttualeAsInt - $ultimoInvioAsInt) / 60));
echo($diffMinuti);
echo("\n");
//Prendo il valore tempo (salvato il minuti)
$tempo = $terzaParte->getTempo();
//Controllo che diffMinuti sia maggiore o uguale a tempo
if ($diffMinuti >= $tempo) {
  echo('POSSO INVIARE');
  $dao->updateUltimoInvio($terzaParte->getId(), date('Y-m-d H:i:s'));
} else {
  echo("MANCANO ". ($tempo - $diffMinuti) ." MINUTI");
  echo("ATTUALE: ". date('Y-m-d H:i:s'));
}
*/

//$tp->setUltimoInvio("2019-03-22 09:58:34"); //FUNZIONA CON STRING
//$daotp->updateUltimoInvio($tp->getId(), $tp->getUltimoInvio());
//$daotp->updateUltimoInvio($tp->getId(), date('Y-m-d H:i:s'));

 //$daoCliente->insert($cliente);
 //foreach($daoCliente->getAll() as $ok) {
 //echo($ok->getId());
 //echo "\n";
 //}

 //print_r($daoCliente->getAll());
//$DAOImpianto = new DAOImpianto();
//foreach($DAOImpianto->getAll($cliente) as $ok) {
//    echo($ok->getNome());
//    echo "\n";
//}
$test = new CreaAdattatori("frenni.txt", 50);
$test->create();
$fr = new FileReader("frenni.txt");
$daoR = new DAORilevazione();
$array = $fr->readAll();
foreach ($array as $string) {
  $adattatore = new Adattatore($string);
  $rilevazione = new Rilevazione($adattatore);
  $daoR->insert($rilevazione);
};
?>

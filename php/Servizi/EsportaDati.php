<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';
require_once 'DAOTerzaParte.php';
require_once 'DAOAutorizzazione.php';
require_once 'DAORilevazione.php';
require_once 'DAOSensoreInstallato.php';
require_once 'TerzaParte.php';
require_once 'Impianto.php';
require_once 'Ambiente.php';
require_once 'SensoreInstallato.php';
require_once 'FileWriter.php';
require_once 'Rilevazione.php';
require_once 'config.php';

//Recupero tutte le terze parti
$daoTerzaParte = new DAOTerzaParte();
$terzeParti = $daoTerzaParte->getAll();

function generaFile($terzaParte)
{
    echo("ESEGUO");
    $daoAutorizzazione = new DAOAutorizzazione();
    $daoRilevazione = new DAORilevazione();
    $daoSensoreInstallato = new DAOSensoreInstallato();

    $ultimoInvio = $terzaParte->getUltimoInvio();

    $fw = new FileWriter("datiTerzaParte.txt");

    $intestazione = $terzaParte->getNome()." ".$terzaParte->getCognome()." ".date('Y-m-d H:i:s');
    $header = "Sensore\t"."Data\t\t\tValore\tErrore\tMessaggio";

    //Intestazione File
    $fw->writeLine($intestazione);
    $fw->writeLine("");

    //RILEVAZIONI IMPIANTI AUTORIZZATI DOPO L'ULTIMO INVIO
    $fw->writeLine("1) DATI IMPIANTI");
    $fw->writeLine("");
    $fw->writeLine("");

    $impianti = $daoAutorizzazione->getImpianti($terzaParte->getId());
    foreach ($impianti as $impianto) {
        $fw->writeLine("NOME IMPIANTO: ".$impianto->getNome());
        $fw->writeLine("");
        $fw->writeLine($header);
        $sensoriInstallati = $daoSensoreInstallato->getFromIdImpianto($impianto->getId());
        foreach ($sensoriInstallati as $sensoreInstallato) {
            $rilevazioni = $daoRilevazione->getRilevazioniEccezioniData($sensoreInstallato->getId(), $ultimoInvio, date('Y-m-d H:i:s'));
            foreach ($rilevazioni as $rilevazione) {
                $fw->writeLine($rilevazione->getIdSensoreInstallato()."\t".$rilevazione->getData()."\t".$rilevazione->getValore()."\t".$rilevazione->getErrore()."\t".$rilevazione->getMessaggio());
            }
        }
        $fw->writeLine("");
        $fw->writeLine("");
    }
    $fw->writeLine("");
    $fw->writeLine("");

    //RILEVAZIONI AMBIENTI AUTORIZZATI DOPO L'ULTIMO INVIO
    $fw->writeLine("2) DATI AMBIENTI");
    $fw->writeLine("");
    $fw->writeLine("");

    $ambienti = $daoAutorizzazione->getAmbienti($terzaParte->getId());
    foreach ($ambienti as $ambiente) {
        $fw->writeLine("NOME AMBIENTE: ".$ambiente->getNome());
        $fw->writeLine("");
        $fw->writeLine($header);
        $sensoriInstallati = $daoSensoreInstallato->getFromIdAmbiente($ambiente->getId());
        foreach ($sensoriInstallati as $sensoreInstallato) {
            $rilevazioni = $daoRilevazione->getRilevazioniEccezioniData($sensoreInstallato->getId(), $ultimoInvio, date('Y-m-d H:i:s'));
            foreach ($rilevazioni as $rilevazione) {
                $fw->writeLine($rilevazione->getIdSensoreInstallato()."\t".$rilevazione->getData()."\t".$rilevazione->getValore()."\t".$rilevazione->getErrore()."\t".$rilevazione->getMessaggio());
            }
        }
        $fw->writeLine("");
        $fw->writeLine("");
    }
    $fw->writeLine("");
    $fw->writeLine("");

    //RILEVAZIONI SENSORI AUTORIZZATI DOPO L'ULTIMO INVIO
    $fw->writeLine("3) DATI SENSORI");
    $fw->writeLine("");

    $fw->writeLine($header);

    $sensoriInstallati = $daoAutorizzazione->getSensoriInstallati($terzaParte->getId());
    foreach ($sensoriInstallati as $sensoreInstallato) {
        $rilevazioni = $daoRilevazione->getRilevazioniEccezioniData($sensoreInstallato->getId(), $ultimoInvio, date('Y-m-d H:i:s'));
        foreach ($rilevazioni as $rilevazione) {
            $fw->writeLine($rilevazione->getIdSensoreInstallato()."\t".$rilevazione->getData()."\t".$rilevazione->getValore()."\t".$rilevazione->getErrore()."\t".$rilevazione->getMessaggio());
        }
    }
    return "datiTerzaParte.txt";
}


//Per ogni terza parte
foreach ($terzeParti as $terzaParte) {
    //Prendo la data di ultimo invio e la converto in INTERO
    $ultimoInvioAsInt = strtotime($terzaParte->getUltimoInvio());
    //Prendo la data attuale e la converto in INTERO
    $dataAttualeAsInt = strtotime('now');
    //Calcolo quanti minuti sono trascorsi tra le due date (tronco i secondi senza arrotondamento)
    $diffMinuti = intval((($dataAttualeAsInt - $ultimoInvioAsInt) / 60));
    //Prendo il valore tempo (salvato in minuti)
    $tempo = $terzaParte->getTempo();

    if ($diffMinuti >= $tempo) { //Devo esportare i dati
        //Creo il file con i dati richiesti
        echo("GENERO FILE SU ".$terzaParte->getId());
        $file = generaFile($terzaParte);
        //Invio il file
        if (inviaEmail($terzaParte, $file)) {
            //Aggiorno la data di ultimo ultimo invio
            $daoTerzaParte->updateUltimoInvio($terzaParte->getId(), date('Y-m-d H:i:s'));
        }
    } else {
        echo("MANCANO ".($tempo - $diffMinuti)." MINUTI");
    }
}

function inviaEmail($terzaParte, $allegato)
{
    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
        //$mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'cholapizzagrossa@gmail.com';                 // SMTP username
    $mail->Password = 'Vestiti95';                           // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                    // TCP port to connect to
    //Recipients
    $mail->setFrom('cholapizzagrossa@gmail.com', 'Iot-Inc');
        $mail->addAddress($terzaParte->getEmail());     // Add a recipient
    //Attachments
    $mail->addAttachment($allegato, "Dati ".$terzaParte->getNome()." ".$terzaParte->getCognome().".txt");         // Add attachments
    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Dati Sensori';
        $mail->Body    = 'In allegato il file contenente i dati relativi ai sensori richiesti';
        $mail->AltBody = 'In allegato il file contenente i dati relativi ai sensori richiesti';
        $mail->send();

        return true;
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        return false;
    }
}

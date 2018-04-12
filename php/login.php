<?php
//include('config.php');
include('php/session.php');
include('DAOCliente.php');
include('Cliente.php');
include('DAOImpianto.php');
include('Impianto.php');

    if($_SERVER["REQUEST_METHOD"] == "POST") {
       // username and password sent from form
       $myusername = mysqli_real_escape_string($db,$_POST['username']);
       $mypassword = mysqli_real_escape_string($db,$_POST['password']);

       $DAOCliente = new DAOCliente();
       $cliente = $DAOCliente -> get($myusername, $mypassword);
       if ($cliente) {
         //setcookie('username', $myusername, time()+60*60*24*365, "/");
         //setcookie('password', $mypassword, time()+60*60*24*365, "/");
         //echo "Login successiful";
         $_SESSION['id_cliente'] = $cliente->getId();
         $_SESSION['password'] = $cliente->getId();
         if ($cliente->isAmministratore()) {
           $_SESSION['isAmministratore'] = true;
           header("location: ../dashboard.php");
         } else {
           $DAOImpianto = new DAOImpianto();
           $impianti = $DAOImpianto->getFromIdCliente($cliente->getId());
           $nImpianti = sizeOf($impianti);
           if($nImpianti <= 0) {
             $error = "Non hai impianti";
           } else {
            $_SESSION['isAmministratore'] = false;
            header("location: ../dashboard.php");
           }
         }
       } else {
         $error = "Email o password errata";
       }
    }
?>

<?php
include 'php/session.php';
include '/DAO/DAOCliente.php';
include '/DAO/DAOImpianto.php';
include '/Modelli/Cliente.php';
include '/Modelli/Impianto.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $myusername = mysqli_real_escape_string($db, $_POST['username']);
        $mypassword = mysqli_real_escape_string($db, $_POST['password']);

        $DAOCliente = new DAOCliente();
        $cliente = $DAOCliente -> get($myusername, $mypassword);
        if ($cliente) {
            $_SESSION['id_cliente'] = $cliente->getId();
            $_SESSION['password'] = $cliente->getId();
            if ($cliente->isAmministratore()) {
                $_SESSION['isAmministratore'] = true;
                header("location: ../dashboard.php");
            } else {
                $DAOImpianto = new DAOImpianto();
                $impianti = $DAOImpianto->getFromIdCliente($cliente->getId());
                $nImpianti = sizeOf($impianti);
                if ($nImpianti <= 0) {
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

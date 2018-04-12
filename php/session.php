<?php
   include('config.php');
   session_start();
   $db = Database::getInstance()->getConnection();
   if (isset($_SESSION['id_cliente'])) {
       $id_cliente = $_SESSION['id_cliente'];
       $ses_sql = mysqli_query($db, "Select * from Cliente where id = '$id_cliente' ");
       $row = mysqli_fetch_array($ses_sql, MYSQLI_ASSOC);
       $login_session = $row['nome'] . " " . $row['cognome'];
   }

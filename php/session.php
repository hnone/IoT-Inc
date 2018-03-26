<?php
   include('config.php');
   session_start();
   $db = Database::getInstance()->getConnection();
   if(isset($_SESSION['id_cliente'])) {
     $id_cliente = $_SESSION['id_cliente'];
     $ses_sql = mysqli_query($db,"Select * from Cliente where id = '$id_cliente' ");
     $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
     $login_session = $row['nome'] . " " . $row['cognome'];
   }
  /*$id_impianto = $_SESSION['id_impianto'];*/
  /*
   if(isset($_COOKIE['username'])) {
     setcookie('username', "", time() - 3600, "/");
     unset($_COOKIE["username"]);
   }

   if(!isset($_SESSION['id_cliente'])){
      //header("location: http://79.8.96.3/index.php");
   }

      if($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST['logout'])) {
          session_destroy();
          $_SESSION = array();
          setcookie('username', "", time() - 3600, "/");
          unset($_COOKIE["username"]);
          setcookie('password', "", time() - 3600, "/");
          unset($_COOKIE["password"]);
          setcookie('impianto', "", time() - 3600);
          unset($_COOKIE["impianto"]);
          console.log("we");
          header("Location: http://79.8.96.3/index.php");
          if(session_destroy()) {
           setcookie('username', "", time() - 3600, "/");
           setcookie('password', "", time() - 3600, "/");
           setcookie('impianto', "", time() - 3600);
           console.log("we");
           header("Location: http://79.8.96.3/index.php");
          }
        }
        if(isset($_POST['change'])) {
          session_destroy();
          $_SESSION = array();
          setcookie('username', "", time() - 3600, "/");
          unset($_COOKIE["username"]);
          setcookie('password', "", time() - 3600, "/");
          unset($_COOKIE["password"]);
          setcookie('impianto', "", time() - 3600);
          unset($_COOKIE["impianto"]);
          header("Location: http://79.8.96.3/soglie.php");
        }
      }



/*
   if(!isset($_SESSION['id_cliente'])){
      header("location: ../index.php");
   }

   if($_SERVER["REQUEST_METHOD"] == "POST") {
     if(session_destroy()) {
      setcookie('username', "", time()+60*60*24*365);
      setcookie('password', "", time()+60*60*24*365);
      header("Location: ../index.php");
     }
   }*/

?>

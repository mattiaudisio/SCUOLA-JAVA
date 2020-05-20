<?php
  include_once(__DIR__.'/connessione.php');
  $connesione = Connessione::apriConnessione();

  session_start();

  $errore = "";

  if(isset($_POST['accedi'])){
    if(empty($_POST['mail']) || empty($_POST['password']) ){
      $errore = "Mail o password non valida";
      header("location: login.php");
    }else{
      $mail = $_POST['mail'];
      $password = hash('sha256',$_POST['password']);

      $queryLogin = $connesione->query("SELECT Partecipante.mailPart, Partecipante.passwordPart FROM Partecipante WHERE Partecipante.mailPart='".$mail."'");
      if($row = $queryLogin->fetch_row()){
        if(password_verify($password,$row[1])){
          $_SESSION['mail_user'] = $mail;
          header("location: profilo.php");
        }else{
          $errore = "Mail o password non corrette";
          header("location: login.php");
        }
      }else{
        $errore = "Mail o password non corrette";
        header("location: login.php");
      }
    }
    $connessione->close();
  }else{
    $errore = "Mail o password non corrette";
    header("location: login.php");
  }
?>

<?php

$user     = 'root';
$password = 'root';
$port     = 3306;
$errorInvalidMail = array('message' => 'El email ingresado no es valido.', 'status' => 'error');
$errorMailTaken   = array('message' => 'El email ingresado ya fue registrado.', 'status' => 'error');
$success_saved    = array('message' => 'El email fue registrado exitosamente.', 'status' => 'success');


try {

    $db = new PDO('mysql:host=localhost;dbname=coclus', $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $mail = $_GET['email'];
    $mail = filter_var($mail, FILTER_SANITIZE_EMAIL);
    $persona = htmlentities($_GET['clicked']);

    if (!filter_var($mail, FILTER_VALIDATE_EMAIL) === false) {

      $check_email = $db->prepare("SELECT COUNT(`id`) FROM emails WHERE email = ?");
      $check_email->bindParam(1, $mail);
      $check_email->execute();
      $rows = $check_email->fetchAll();

      if ($rows[0][0] > 0) {
        echo json_encode($errorMailTaken); die();
      }

      $save_mail = $db->prepare("INSERT INTO emails (id, email, persona) VALUES (null, ?, ?)");
      $save_mail->bindParam(1, $mail);
      $save_mail->bindParam(2, $persona);
      $save_mail->execute();

      echo json_encode($success_saved);
    } else {
      echo json_encode($errorInvalidMail); die();
    }

    $db = null;
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}




// $sql = $db->prepare("INSERT INTO emails (id, email) VALUES (null, ?)");
// $sql->bindParam(1, $email);
// $sql->execute();

?>

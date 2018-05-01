<?php
  include 'global.php';
  
  class EmailService {

    function isValidEmail($email) {
        if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }

    function isValidName($name) {
        return empty($name);
    }

    function isValidContent($content) {
        return empty($content);
    }

    function send($email, $name, $content) {
        $RECEIVER_MAIL = "kontakt@beatapogoda.pl";

        $headers =  'MIME-Version: 1.0' . "\r\n";
        $headers .= 'From: '. $name .' <' . $email .'>' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        $title = wordwrap("Gabinet Kosmetyki Estetycznej - kontakt");

        return mail($RECEIVER_MAIL, $title, $content, $headers);
    }

    function deleteSession($sessionToken) {
      $sessionFilePath = getBasePath() . getSessionsPath() . '/' . $sessionToken . '.xml';

      if(file_exists($sessionFilePath)) {
        return unlink($sessionFilePath);
      } else {
        return false;
      }
    }

  }
?>

<?php
  include 'global.php';

  class LoginService {

    function getUser($name, $password) {
        $userPath = getBasePath() . getUsersPath() . '/' . strtolower($name) . '.xml';

        if(file_exists($userPath)) {
          $user = simplexml_load_file($userPath);
          if($user->password == $password) {
            return array(
              'role' => $user->role
            );
          } else {
            return NULL;
          }
        } else {
          return NULL;
        }
    }

    function generateSession() {
      $newSesionToken = bin2hex(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM));
      $newSessionPath = getBasePath() . getSessionsPath() . '/' . $newSesionToken . '.xml';

      $sessionFile = fopen($newSessionPath, "w");

      $timeoutMinutes = 2;
      $expireTime = time() + 60*$timeoutMinutes;

      fwrite($sessionFile, "<session><expire>" . "$expireTime" ."</expire></session>");
      fclose($sessionFile);

      return array(
        'token' => $newSesionToken,
        'expireIn' => 60*$timeoutMinutes
      );
    }


    function authenticate($sessionToken) {
      $sessionFilePath = getBasePath() . getSessionsPath() . '/' . $sessionToken . '.xml';

      if(file_exists($sessionFilePath)) {
        $session = simplexml_load_file($sessionFilePath);
        if($session->expire < time()) {
          deleteSession($sessionToken);
          return false;
        } else {
          return true;
        }
      } else {
        return false;
      }
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

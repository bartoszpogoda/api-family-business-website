<?php
  include '../../services/global.php';
  /**
  *   Clears outdated sessions
  */

  $sessionsDirectoryPath = getBasePath() . getSessionsPath();

  if(!$sessionsDirectory = opendir($sessionsDirectoryPath)) {
      echo 'Session directory doesnt exist';
  }

  while($sessionFile = readdir($sessionsDirectory)) {
    if(!is_dir($sessionFile)) {
      $sessionPath = $sessionsDirectoryPath . '/' . $sessionFile;
      $session = simplexml_load_file($sessionPath);
      if($session->expire < time()) {
        unlink($sessionPath);
        echo 'Deleted outdated session: ' . $session;
      }
    }
  }

?>

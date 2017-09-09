<?php
  include '../../loginService.php';

  /**
  *   Handles DELETE request to delete session with given id (log out)
  */

  /* REQUEST PARAMS */
  $headerSessionToken = 'Session-Token';

  $headers = apache_request_headers();

  $sessionToken =  $headers["$headerSessionToken"];

  $loginService = new LoginService();

  if($loginService->deleteSession($sessionToken)) {
    http_response_code(200);
  } else {
    throwErrorJSON(400);
  }

?>

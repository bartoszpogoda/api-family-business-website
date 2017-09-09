<?php
  include '../../loginService.php';
  include '../../messages.php';
  /**
  *   Handles POST request to create a session based on creditionals (log in). Accepts only secure HTTPS requests
  */

  /* REQUEST PARAMS */
  $paramLogin = 'login';
  $paramPassword = 'password';

  if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != "on") {
    throwErrorJSON(400, $messages['connectionNotSecure']);
  }

  $postdata = file_get_contents("php://input");
  $request = json_decode($postdata);

  if(!property_exists($request, $paramLogin) || !property_exists($request, $paramLogin)) {
    throwErrorJSON(400);
  }

  $login = $request->{"$paramLogin"};
  $password = $request->{"$paramPassword"};

  $loginService = new LoginService();
  $user = $loginService->getUser($login, $password);

  if(is_null($user)) {
    throwErrorJSON(400, $messages['authenticationFailed']);
  } else {
    $session = $loginService->generateSession();
    http_response_code(201);
    $sessionInfo = array(
      'sessionToken' => $session['token'],
      'expiresIn' => $session['expireIn']
    );
    echo json_encode($sessionInfo);
  }

?>

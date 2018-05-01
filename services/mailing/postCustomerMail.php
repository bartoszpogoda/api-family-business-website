<?php
  include '../emailService.php';
  include '../messages.php';

  /**
  *   Handles POST request to send email from the customer.
  */

  /* REQUEST PARAMS */
  $paramName = 'name';
  $paramEmail = 'email';
  $paramContent = 'content';

  $postdata = file_get_contents("php://input");
  $request = json_decode($postdata);

  if(!property_exists($request, $paramName) || !property_exists($request, $paramEmail) 
        || !property_exists($request, $paramContent)) {
    throwErrorJSON(400, $messages['invalidArguments']);
  }

  $name = $request->{"$paramName"};
  $email = $request->{"$paramEmail"};
  $content = $request->{"$paramContent"};


  $emailService = new EmailService();

  if($emailService->isValidEmail($email) && !empty($name) && !empty($content)) {
    if($emailService->send($email, $name, $content)) {
        http_response_code(201);
    } else {
        throwErrorJSON(500, $messages['mailServerError']);
    }
  } else {
    throwErrorJSON(400, $messages['invalidArguments']);
  }

?>

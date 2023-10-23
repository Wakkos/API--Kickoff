<?php
use Firebase\JWT\JWT;
trait PostControllerUsersTraits {


  //-----> Register User
  static public function registerNewUser($table, $data) {

    $response = GetModel::getDataFilter($table, "*","email_user", $data["email_user"], null, null, null, null);


    //-----> Check if the email exists or not.
    if (!empty($response[0]->email_user)) {
      $response = null;
      self::fncResponse($response, "registerNewUser", 409, "Ya existe ese email.");
      return;
    }

    //-----> We make sure we have password.
    if(isset($data["password_user"]) && $data["password_user"] != null) {
      $crypt = crypt($data["password_user"], '$2a$07$7b61560f4c62999371b4d3$');
      $data["password_user"] = $crypt;

      // Create a token for the email verification email
      $token = Connection::jwt($data["name_user"], $data["email_user"]);
      $jwt = JWT::encode($token, "d12sd124df3456dfw43w3fw34df", 'HS256');

      $data["email_token_user"] = $jwt;

      //-----> Create token and send email
      $verifyLink = $_ENV['FRONTEND_URL'] . "verify-email?token=$jwt";
      $email = new \SendGrid\Mail\Mail();
      $email->setFrom("noreply@testpilotpro.ai", "Daniel Martínez");
      $email->setSubject("Por favor verifica tu correo electrónico");
      $email->addTo($data["email_user"], $data["email_user"]);
      $email->addContent(
          "text/html", "<a clicktracking=off href=\"". $verifyLink . "\">". $verifyLink . "</a>"
      );
      $sendgrid = new \SendGrid($_ENV['SENDGRID_API_KEY']);

      try {
        $responseSG = $sendgrid->send($email);

      } catch (Exception $e) {
        $response["sendgrid_error"] = 'Caught exception: ' . $e->getMessage() . "\n";
      }

      $response = PostModel::postData($table, $data);

      if(isset($response["comment"]) && $response["comment"] == "Sucess data entry") {
        self::fncResponse($response, "RegisterUser");
      }
    }

    else {
      // Handle the case where no password is provided
      // TODO: User registration from external apps (Google, GitHub, Facebook, etc...)
        $response = null;
        self::fncResponse($response, "registerNewUser", 401, "No password =(");
    }
  }

}
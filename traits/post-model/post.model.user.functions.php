<?php
use Firebase\JWT\JWT;

trait PostModelUserFunctionsTraits {


  //-----> Register User
  static public function registerNewUser($table, $data) {

    $response = GetModel::getDataFilter($table, "*","email_user", $data["email_user"], null, null, null, null);


    //-----> Check if the email exists or not.
    if (!empty($response[0]->email_user)) {
      $response = array(
        "comment" => "Ya existe ese email"
      );
      return $response;
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
        $response['email_user'] = $data['email_user'];
        echo '<pre>'; print_r($data); echo '</pre>';
        echo '<pre>'; print_r($response); echo '</pre>';

        return $response;
      }
    }

    else {
      // Handle the case where no password is provided
      // TODO: User registration from external apps (Google, GitHub, Facebook, etc...)
        $response = null;
        self::fncResponse($response, "registerNewUser", 401, "No password");
    }
  }





  static public function loginUser($table, $data) {

    //-----> Validate user on DB
    $response = GetModel::getDataFilter($table, "*","email_user", $data["email_user"], null, null, null, null);
    if(!empty($response)) {

      //-----> Encrypt pass- TODO: Change for password_hash().
      $crypt = crypt($data["password_user"], '$2a$07$7b61560f4c62999371b4d3$');

      if($response[0]->password_user == $crypt) {


        $token = Connection::jwt($response[0]->id_user, $response[0]->email_user);
        $jwt = JWT::encode($token, "d12sd124df3456dfw43w3fw34df", 'HS256');
        //-----> Update database with Token
        $data = array(
          "token_user" => $jwt,
          "token_expiry_user" => $token["exp"]
        );
        $update = PutModel::putData($table, $data, $response[0]->id_user, "id_user");

        if(isset($update["comment"]) && $update["comment"] == "Edit successful") {
          $response[0]->token_user = $jwt;
          $response[0]->token_expiry_user = $token["exp"];
          $response[0]->success = true;

          return $response;
        }
      }
      else {
        return [
          'success' => false,
          'message' => "Incorrect password"
        ];
      }
    }
    else {
      return [
          'success' => false,
          'message' => "Incorrect email"
        ];
    }
  }
}
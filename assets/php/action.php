<?php
session_start();
// PHP Mailer Files
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);


require_once 'auth.php';
$user = new Auth();


// *********  Handle Register Ajax Request *********
if(isset($_POST['action']) && $_POST['action'] == 'register'){
    $name = $user->test_input($_POST['user']);
    $email = $user->test_input($_POST['email']);
    $pass = $user->test_input($_POST['password']);
    
    $hpass = password_hash($pass, PASSWORD_DEFAULT);
    if($user->user_exist($email)){
        echo $user->showMessage('warning', 'This E-Mail is already registered!');
    } else {
        if($user->register($name, $email, $hpass)){
            echo 'register';
            $_SESSION['user'] = $email;
           
            // ***** send email to register user **
            try{
                //Server settings
                            
                 $mail->isSMTP();                                            // Send using SMTP
                 $mail->Host       = 'smtp.gmail.com';   
              //   $mail->Host        = 'smtp.mail.yahoo.com';                    // Set the SMTP server to send through
                 $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                 $mail->Username   = 'Database::USERNAME';                     // SMTP username
                 $mail->Password   = 'Database::PASSWORD';                   // SMTP password
                 $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
                $mail->Port       = 587;                                    // TCP port to connect to
             //    $mail->Port       = 465;     
     
                //Recipients
                 $mail->setFrom(Database::USERNAME, 'TaguMedia');
                 $mail->addAddress($email);                                            // Add a recipient
                
                 // Content
                 $mail->isHTML(true);                                               // Set email format to HTML
                 $mail->Subject = 'E-Mail Verification';
                 $mail->Body    = '<h3> Click the link below to Verify your E-Mail.<br>
                 <a href="http://localhost/user_management_system/verify-email.php?email='.$email.'"> href="http://localhost/user_management_system/verify-email.php?email='.$email.'"  </a><br>
                   <br> Regards TaguMedia! </h3>';
     
                   /* Disable some SSL checks. */
                 $mail->SMTPOptions = array(
                     'ssl' => array(
                     'verify_peer' => false,
                     'verify_peer_name' => false,
                     'allow_self_signed' => true
                     )
                 );
     
                    $mail->send();
                    echo $user->showMessage('Succcess', 'We have sent you an E-Mail Verification link in your e-mail box, pleae check your email inbox!');
                
            } catch (Exception $e){
                echo $user->showMessage('danger', 'OPPS Something went wrong, E-email Could not be sent. Please use the link on your profile to verify your E-mail');
            }

            // --/ end send email
            
        } else {
            echo $user->showMessage('danger', 'OOPS failed to registered user! try again later!');
        }
    }
     
}

// *********  Handle LOGIN Ajax Request *********
if(isset($_POST['action']) && $_POST['action'] == 'login') {
    $email = $user->test_input($_POST['email']);
    $pass = $user->test_input($_POST['password']);

    $loggedInUser = $user->login($email);

    if($loggedInUser != null) {
        if(password_verify($pass, $loggedInUser['password'])){
            if(!empty($_POST['rem'])){
                setcookie("email", $email, time() + (86400 * 30), '/');
                setcookie("password", $pass, time() +(86400 * 30), '/');
            } else {
                setcookie("email", "", 1, '/');
                setcookie("password", "", 1, '/');
            }
            echo 'login';
            $_SESSION['user'] = $email;
        } else {
            echo $user->showMessage('danger', 'Password is incorrect!');
        }
    } else {
        echo $user->showMessage('danger', 'User not found');
    }
}

// ***** ****Handle forgot password ajax request ***********
if(isset($_POST['action']) && $_POST['action'] == 'forgot'){
  // print_r($_POST);
  
   $email = $user->test_input($_POST['email']);

   $user_found = $user->currentUser($email);
   if($user_found != null){
       $token = uniqid();
       $token =str_shuffle($token);
      
       //*** Update user, setting token into data where email = $email */
       $user->forgot_password($token,$email);

       try{
           //Server settings
                       
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';   
         //   $mail->Host        = 'smtp.mail.yahoo.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'Database::USERNAME';                     // SMTP username
            $mail->Password   = 'Database::PASSWORD';                   // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
           $mail->Port       = 587;                                    // TCP port to connect to
        //    $mail->Port       = 465;     

           //Recipients
            $mail->setFrom(Database::USERNAME, 'TaguMedia');
            $mail->addAddress($email);                                            // Add a recipient
           
            // Content
            $mail->isHTML(true);                                               // Set email format to HTML
            $mail->Subject = 'Reset Password';
            $mail->Body    = '<h3> Click the link below to reset your password.<br>
            <a href="http://localhost/user_management_system/reset-pass.php?email='.$email.'&token='.$token.'"> http://localhost/user_management_system/reset-pass.php?email='.$email.'&token='.$token.' </a><br>
              <br> Regards TaguMedia! </h3>';

              /* Disable some SSL checks. */
            $mail->SMTPOptions = array(
                'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
                )
            );

               $mail->send();
               echo $user->showMessage('Succcess', 'We have sent you the reset link in your e-mail box, pleae check your email inbox!');
           
       } catch (Exception $e){
           echo $user->showMessage('danger', 'Something went wrong, please try again later');
       }
   }
   else{
       echo $user->showMessage('info', 'This e-mail is not registered!');
   }

}

//** Checking User is logged in or not */
if(isset($_POST['action']) && $_POST['action'] == 'checkUser'){
    if(!$user->currentUser($_SESSION['user'])){
        echo 'Bye';
        unset($_SESSION['user']);
    }
}

?>
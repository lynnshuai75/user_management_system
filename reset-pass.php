

<?php
require_once 'assets/php/auth.php';
$user = new Auth();

$msg = '';

if(isset($_GET['email']) && isset($_GET['token'])){
    $email = $user->test_input($_GET['email']);
    $token = $user->test_input($_GET['token']);

    $auth_user = $user->reset_pass_auth($email, $token);

    if($auth_user != null){
        if(isset($_POST['submit'])){
            $newpass = $_POST['pass'];
            $cnewpass = $_POST['cpass'];
            $hnewpass = password_hash($newpass, PASSWORD_DEFAULT);

            if($newpass == $cnewpass){
                $user->update_new_pass($hnewpass, $email);
                $msg = "Password Changed Successfully!<br><a href='index.php'>Login Here!</a>";

            }
             else {
                 $msg = 'password did not Matched';
             }
        }
    }
     else {
         header('location: index.php');
         exit();
     }
}
 else {
    header('location: index.php');
    exit();
 }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaguMedia</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
   <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
    <div class="container"> 
       <!-- Reset Password Form Starts -->
       <div class="row justify-content-center wrapper">
         <div class="col-lg-10 my-auto">
           <div class="card-group myShadow">
              <!-- 2nd section  -->
              <div class="card justify-content-center rounded-left myColor p-4">
                 <h1 class="text-center font-weight-bold text-white"> Reset Your Password Here!</h1>

              </div>

              <div class="card rounded-right p-4" style="flex-grow:2;">
                 <h1 class="text-center font-weight-bold text-primary">Enter New Password!
                 </h1>
                 <hr class="my-3">
                 <form action="#" method="post" class="px-3">
                    <div class="text-center lead my-2"><?= $msg;?> </div>                   
                    <div class="input-group input-group-lg form-group">
                       <div class="input-group-prepend">
                          <span class="input-group-text rounded-0">
                            <i class="fas fa-key fa-lg"></i>
                          </span>
                       </div>
                       <input type="password" name="pass"  class="form-control rounded-0" placeholder="New Password" required minLength="5" >
                    </div>

                    <div class="input-group input-group-lg form-group">
                       <div class="input-group-prepend">
                          <span class="input-group-text rounded-0">
                            <i class="fas fa-key fa-lg"></i>
                          </span>
                       </div>
                       <input type="password" name="cpass"  class="form-control rounded-0" placeholder="Confirm New Password" required minLength="5" >
                    </div>

                   
                    

                    <div class="form-group">
                       <input type="submit" value="Reset Password" id="reset-btn" class="btn btn-primary btn-lg btn-block myBtn">
                    </div>
                 </form>
              </div>
              
    
             
           </div>
         </div>
       </div>
       <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
     </body>
     </html>
       <!-- Reset Password Form Ends -->
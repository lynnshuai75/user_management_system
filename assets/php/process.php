<?php
require_once 'session.php';
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

// **** Handle Add New Note Ajax Request ***
if(isset($_POST['action']) && $_POST['action'] == 'add_note'){
     $title = $cuser->test_input($_POST['title']);
     $note = $cuser->test_input($_POST['note']);

     $cuser->add_new_note($cid, $title, $note);
     $cuser->notification($cid, 'admin', 'Note added');

}

//*** Handle Display All Notes of A User */
if(isset($_POST['action']) && $_POST['action'] == 'display_notes'){
    $output ='';

    $notes = $cuser->get_notes($cid);
    
    if($notes){
        $output  .= '<div class="table-responsive" id="showNote">
                    <table class="table table-striped text-center">
                    <thead>
                        <tr>
                        <th style="width:3%"># </th>
                        <th style="width:23%">Title </th>
                        <th style="width:50%"> Note</th>
                        <th style="width:23%"> Action </th>
                        </tr>
                    </thead>
                    <tbody>';
            foreach($notes as $row){
                $output  .=' <tr>
                               <td>'.$row['id'].' </td>
                                <td> '.$row['title'].' </td>
                                <td>'.substr($row['note'],0,60 ). '...</td>
                                <td> 
                                <a href="#" id="'.$row['id'].'" title="view Details" class="text-success infoBtn">
                                <i class="fas fa-info-circle fa-lg"></i> </a> &nbsp;

                                <a href="#" id="'.$row['id'].'"  title="Edit Note" class="text-primary editBtn">
                                <i class="fas fa-edit fa-lg" data-toggle="modal" data-target="#editNoteModal"></i> </a> &nbsp;

                                <a href="#" id="'.$row['id'].'"  title="Delete Note" class="text-danger deleteBtn">
                                <i class="fas fa-trash-alt fa-lg"></i> </a>
                                </td>
                         </tr>';
                  }
                  $output  .=' </tbody></table>';
                  echo $output;
            }
             else {
                 echo '<h3 class="text-center text-secondary">:( You have not written any note yet!
                  Write your first note now! </h3>';
             }

        }

    //** Handle Edit Note of User */
    if(isset($_POST['edit_id'])) {
        //print_r($_POST);
        $id = $_POST['edit_id'];
        $row = $cuser->edit_note($id);
        echo json_encode($row);
    }

    //** Handle Update Note of A User Ajax Request */
    if(isset($_POST['action']) && $_POST['action'] == 'update_note'){
       // print_r($_POST);

       $id= $cuser->test_input($_POST['id']);
       $title = $cuser->test_input($_POST['title']);
       $note = $cuser->test_input($_POST['note']);

       $cuser->update_note($id, $title, $note);
       $cuser->notification($cid, 'admin', 'Note updated');

    }

    //** Handle Delete a Note from a user Ajax Request */
    if(isset($_POST['del_id'])){
        $id= $_POST['del_id'];

        $cuser->delete_note($id);
        $cuser->notification($cid, 'admin', 'Note Deleted');
        
    }

    //** Diplay a Note of a User Ajax request */
    if(isset($_POST['info_id'])){
        $id = $_POST['info_id'];

        $row = $cuser->edit_note($id);
        echo json_encode($row);

    }

    //**  ===== Handle Profile Update Ajax Request ======== */
    if(isset($_FILES['image'])){
       // print_r($_FILES);
        //print_r($_POST);
        $name = $cuser->test_input($_POST['name']);
        $gender = $cuser->test_input($_POST['gender']);
        $dob     = $cuser->test_input($_POST['dob']);
        $phone = $cuser->test_input($_POST['phone']);

        $oldImage = $_POST['oldimage'];
        $folder    = 'uploads/';

        if(isset($_FILES['image']['name']) && ($_FILES['image']['name'] !="")){
            $newImage = $folder.$_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $newImage);

            if($oldImage != null){
                unlink($oldImage);
            }
        }
        else {
            $newImage = $oldImage;
        }

        $cuser->update_profile($name, $gender, $dob, $phone, $newImage, $cid);
        $cuser->notification($cid, 'admin', 'Profile Updated');
        
    }

    //** Handle Change Password Ajax Request */
    if(isset($_POST['action']) && $_POST['action'] == 'change_pass'){
       // print_r($_POST);
       $currentPass= $_POST['curpass'];
       $newPass     = $_POST['newpass'];
       $cnewPass    =$_POST['cnewpass'];

       $hnewPass   = password_hash($newPass, PASSWORD_DEFAULT);

       if($newPass != $cnewPass) {
           echo $cuser->showMessage('danger', 'Password did not matched');
       }
       else {
           if(password_verify($currentPass, $cpass)){
               $cuser->change_password($hnewPass, $cid);
               echo $cuser->showMessage('success', 'Password Changed Successfully!');
               $cuser->notification($cid, 'admin', 'Password Changed');
           }
            else{
                echo $cuser->showMessage('danger', 'Current Password is wrong');
            }
       }
    }
    
    //** Handle Ajax Request Verify Email */
    if(isset($_POST['action']) && $_POST['action'] == 'verify_email'){

        //* send email
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
             $mail->addAddress($cemail);                                            // Add a recipient
            
             // Content
             $mail->isHTML(true);                                               // Set email format to HTML
             $mail->Subject = 'E-Mail Verification';
             $mail->Body    = '<h3> Click the link below to Verify your E-Mail.<br>
             <a href="http://localhost/user_management_system/verify-email.php?email='.$cemail.'"> href="http://localhost/user_management_system/verify-email.php?email='.$cemail.'"  </a><br>
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
                echo $cuser->showMessage('Succcess', 'We have sent you an E-Mail Verification link in your e-mail box, pleae check your email inbox!');
            
        } catch (Exception $e){
            echo $cuser->showMessage('danger', 'Something went wrong, please try again later');
        }
    }

    //** Handle Send Feedback to Admin Ajax Request */
    if(isset($_POST['action']) && $_POST['action'] =='feedback'){
        //print_r($_POST);

        $subject = $cuser->test_input($_POST['subject']);
        $feedback = $cuser->test_input($_POST['feedback']);

        $cuser->send_feedback($subject, $feedback, $cid);
        $cuser->notification($cid, 'admin', 'Feedback written');

    }
   
//** Handle Fetch Notification   */
if(isset($_POST['action']) && $_POST['action'] == 'fetchNotification'){
    $notification = $cuser->fetchNotification($cid);
    $output = '';
    

    if($notification){
        foreach($notification as $row){
            $output  .=' <div class="alert alert-danger" role="alert">
            <button type="button" id="'.$row['id'].'" class="close" data-dismiss="alert" aria-label="close">
               <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="alert-heading">New Notification </h4>
            <p class="mb-0 lead">'.$row['message'].'  </p>
            
            <hr class="my-2">
            <p class="mb-0 float-left"> Reply of feedback from Admin</p>
             <p class="mb-0 float-right"> '.$cuser->timeInAgo($row['created_at']).' </p>
          
             <div class="clearfix"></div>
        </div>';       
        
        }
        echo $output;
    }
    else {
        echo '<h3 class="text-center text-secondary mt-5">No new notification </h3>';
    }
}


//** Check Notification  */
if(isset($_POST['action']) && $_POST['action'] =='checkNotification'){
    if($cuser->fetchNotification($cid)){
        echo '<i class="fas fa-circle fa-sm text-danger"></i>';
    }
     else {
         echo '';
     }
}

//*** Remove Notification */
if(isset($_POST['notification_id'])){
    $id = $_POST['notification_id'];
    $cuser->remove_notification($id);
}
<?php
require_once 'assets/php/header.php';

?>
<div class="container">
   <div class="row justify-content-center">
      <div class="col-lg-10">
         <div class="card round-0 mt-3 border-primary">
            <div class="card-header border-primary">
               <ul class="nav nav-tabs card-header-tabs">

                  <li class="nav-item">
                     <a href="#profile" class="nav-link active font-weight-bold" data-toggle="tab">Profile</a>                
                  </li>

                  <li class="nav-item">
                     <a href="#editProfile" class="nav-link font-weight-bold" data-toggle="tab"> Edit Profile</a>                
                  </li>

                  <li class="nav-item">
                     <a href="#changePass" class="nav-link  font-weight-bold" data-toggle="tab">Change Password </a>                
                  </li>
                  
               </ul>
            </div> <!-- /card-header border-primary Ends -->

            <div class="card-body">
               <div class="tab-content">

                <!-- ==========  Profile Tab Starts ======  -->
                  <div class="tab-pane container active" id="profile">
                    <div id="verifyEmailAlert"> </div>
                     <div class="card-deck">
                        <div class="card border-primary">
                           <div class="card-header bg-primary text-light text-center lead">
                             User ID : <?= $cid; ?>
                           </div>
                           <div class="card-body">
                              <p class="card-text p-2 m-1 rounded" style="border:1px solid #0275d8;">
                              <b>Name : </b><?= $cname; ?></p>

                              <p class="card-text p-2 m-1 rounded" style="border:1px solid #0275d8;">
                              <b>E-mail : </b><?= $cemail; ?></p>

                              <p class="card-text p-2 m-1 rounded" style="border:1px solid #0275d8;">
                              <b>Gender : </b><?= $cgender; ?></p>

                              <p class="card-text p-2 m-1 rounded" style="border:1px solid #0275d8;">
                              <b>Date of Birth : </b><?= $cdob; ?></p>

                              <p class="card-text p-2 m-1 rounded" style="border:1px solid #0275d8;">
                              <b>Phone : </b><?= $cphone; ?></p>

                              <p class="card-text p-2 m-1 rounded" style="border:1px solid #0275d8;">
                              <b>Registered on : </b><?= $reg_on; ?></p>

                              <p class="card-text p-2 m-1 rounded" style="border:1px solid #0275d8;">
                              <b>E-Mail is Verified : </b><?= $verified; ?>
                               <?php if($verified == 'Not Verified'): ?>
                               <a href="#" id="verify-email" class="float-right"> Verify Now </a>
                               <?php endif; ?>
                              </p>
                              <div class="clear-fix"></div>
                           </div>
                        </div> <!-- card border-primary -->
                        <div class="card border-primary align-self-center">
                          <?php if(!$cphoto): ?>
                            <img src="assets/img/defaultprofile.png" class="img-thumbnail img-fluid"
                            width="408px">
                          <?php else: ?>
                          <img src="<?='assets/php/'.$cphoto; ?>" class="img-thumbnail img-fluid" width="408px">
                          <?php endif; ?>
                        </div>
                     </div> <!--/ Card-deck  -->
                  </div> <!--/tab-pane container active" id="profile Ends  -->
                 <!-- ==========/  Profile Tab Ends ======  -->

                   <!-- ==========  Edit profile Tab content Starts ======  -->
                   <div class="tab-pane container fade"  id="editProfile">

                      <div class="card-deck">

                         <div class="card border-danger align-self-center">
                         <?php if(!$cphoto): ?>
                            <img src="assets/img/defaultprofile.png" class="img-thumbnail img-fluid"
                            width="408px">
                          <?php else: ?>
                          <img src="<?='assets/php/'.$cphoto; ?>" class="img-thumbnail img-fluid" width="408px">
                          <?php endif; ?>
                         </div>
<br> <br>
                         <div class="card border-danger">
                         
                           <h2 class="text-center text-primary mt-2"> Do You need a Website ?</h2>
                           <br>
                           <h2 class="text-center text-success text-bold p-1"> We are offering FREE Website Design for the FIRST 5 clients </h2>
                           <h3 class="text-primary text-bold">Note 1: This  offer last until April 3rd </h3>
                           <br>
                           <h5 class="text-center text-primary text-bold p-1">Note 2: This offer ONLY concern websites with no database or backend </h5>
                          <br>
                           <h5 class="text-success text-bold p-2">Note 3: We offer other packages with a 30% off (CMS, E-COMMERCE etc)</h5>
                             
                           <h5 class="text-center text-white text-bold py-2 mt-3 bg-secondary">  Courtesy of <i class="fas fa-code fa-lg"></i>&nbsp; TaguMeda</h5>
                               
                              
 

                               
 

                               
                               

                              </form>
                         </div>


                      </div>
                   
                   </div> <!-- /tab-pane container fade"  id="editProfile -->

             <!-- ==========  Edit Profile  Tab  content Ends ======  -->
             <!-- ========== Change Password  Tab  content  starts ======  -->
              <div class="tab-pane container fade" id="changePass">
                 <div id="changepassAlert"></div>
                  <div class="card-deck">
                     <div class="card border-success">
                        <div class="card-header bg-success text-white text-center lead">
                         Change Password
                        </div>

                        <form action="#" method="post" class="px-mt-2" id="change-pass-form">

                          <div class="form-group m-2">
                              <label for="curpass"class="m-2 pl-2" >Enter Your Current Password </label>
                              <input type="password" name="curpass" placeholder="Enter Current Password" id="curpass" 
                              class="form-control form-control-lg" required minLength="5">
                           </div>

                           <div class="form-group m-2">
                              <label for="newpass" class="m-2 pl-2">Enter New Password </label>
                              <input type="password" name="newpass" placeholder="Enter New Password" id="newpass" 
                              class="form-control form-control-lg" required minLength="5">
                           </div>

                           <div class="form-group m-2">
                              <label for="cnewpass" class="m-2 pl-2"> Confirm New Password </label>
                              <input type="password" name="cnewpass" placeholder=" Confirm New Password" id="cnewpass" 
                              class="form-control form-control-lg" required minLength="5">
                           </div>
                           <div class="form-group">
                            <p class="text-danger" id="changepassError"></p>
                           </div>

                           <div class="form-group m-2">
                              <input type="submit" name="changepass"   id="changePassBtn" 
                              class="btn btn-success btn-block btn-lg"  value="Change Password">
                           </div>


                        </form>
                     </div>
                     <div class="card border-success align-self-center">
                        <img src="assets/img/changepass.png" class="img-thumbnail img-fluid" width="408px">
                     </div>
                  </div>
              </div>

             <!-- ==========/  Change Password Tab  content Ends ======  -->

               </div> <!-- /tab-content -->
            
            </div> <!--/ card-body Ends -->
         </div> <!--/ Card div Ends-->
      </div> <!--/End col-lg-10 -->
   </div> <!-- row justify-content-center div Ends -->
</div> <!-- End container div -->
   
       
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js"> </script>
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
 <script type="text/javascript">
 $(document).ready(function(){
    //** Profie Update Ajax Request */
    $("#profile-update-form").submit(function(e) {
       e.preventDefault();

       $.ajax({
          url:'assets/php/process.php',
          method: 'post',
          processData: false,
          contentType: false,
          cache:false,
          data: new FormData(this),
          success:function(response){
            // console.log(response);  
            location.reload();  
              }
       });
       });

   //*** Change Password Ajax Request */
   $("#changePassBtn").click(function(e){
      if($("#change-pass-form")[0].checkValidity()){
         e.preventDefault();
         $("#changePassBtn").val('Please Wait...');

         if($("#newpass").val() != $("#cnewpass").val()){
            $("#changepassError").text('*Password did not Match');
            $("#changePassBtn").val('Change Password');
         }
          else{
             $.ajax({
                url:'assets/php/process.php',
                method:'post',
                data:$("#change-pass-form").serialize()+'&action=change_pass',
                success:function(response){
                
                $("#changepassAlert").html(response);
                 $("#changePassBtn").val('Change Password');
                 $("#changepassError").text('');
                 $("#change-pass-form")[0].reset();

                    
                }
             });
          }
      }
   });

   //*** verify Email Ajax Request */
   $("#verify-email").click(function(e){
      e.preventDefault();

      $(this).text('Please Waiting ...');

      $.ajax({
         url:'assets/php/process.php',
         method:'post',
         data:{action: 'verify_email'},
         success:function(response){
            $("#verifyEmailAlert").html(response);
            $("#verify-email").text('Verify Now');
         }
      });
   });

    //** Check Notification */
       checkNotification();
       function checkNotification(){
          $.ajax({
             url: 'assets/php/process.php',
             method:'post',
             data: {action: 'checkNotification'},
             success:function(response) {
              //  console.log(response);
              $("#checkNotification").html(response);
             }
          });
       }

 });
 </script>
 
 </body>
  </html>
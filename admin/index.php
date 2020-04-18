<?php
session_start();
if(isset($_SESSION['username'])){
    header('location: admin-dashboard.php');
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title> Login | Admin </title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
   <link rel="stylesheet" type="text/css" href="assets/css/style.css">
   
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js"> </script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
<style type="text/css">
html, body{
    height: 100%;
}
</style>

</head>
<body class="bg-dark">

<div class="container h-100"> 
    <div class="row h-100 align-items-center justify-content-center">
        <div class="col-lg-5">
            <div class="card border-danger shadow-lg">
                <div class="card-header bg-danger">
                 <h3 class="m-o text-white"><i class="fas fa-user-cog"></i> &nbsp; Admin Panel Login </h3>
                </div>
                <div class="card-body">
                    <form action="" method="post" class="px-3" id="admin-login-form">
                        <div class="text-center text-danger" id="adminLoginAlert"> </div>


                        <div class="form-group">
                          <input type="text" name="username" class="form-control form-control-lg rounded-0" placeholder="Username" required autofocus>
                        </div>

                        <div class="form-group">
                          <input type="password" name="password" class="form-control form-control-lg rounded-0" placeholder="password" required>
                        </div>

                        <div class="form-group">
                          <input type="submit" name="admin-login" class="btn btn-danger btn-block btn-lg rounded-0" value="Login" id="adminLoginBtn">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




<script type="text/javascript">
$(document).ready(function(){
    $("#adminLoginBtn").click(function(e) {
        if($("#admin-login-form")[0].checkValidity()){
            e.preventDefault();
           $(this).val('Please Wait...');
           $.ajax({
               url:'assets/php/admin-action.php',
               method: 'post',
               data: $("#admin-login-form").serialize()+'&action=adminLogin',
               success:function(response){
                   //console.log(response);
                   if(response === 'adminLogin'){
                   
                   // alert("success you got");
                    window.location.href = 'admin-dashboard.php';
                    //location.replace("admin-dashboard.php");
                   // window.location.assign("admin-dashboard.php");
                    location.reload();
                   }
                   else {
                       $("#adminLoginAlert").html(response);
                   }
                   $("#adminLoginBtn").val('Login');
               }
           }); 
        }
    });
});
</script>




</body>
</html>
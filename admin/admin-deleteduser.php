<?php
require_once 'assets/php/admin-header.php';
?>
    <div class="row">
      <div class="col-lg-12">
            <div class="card my-2 border-success">
                <div class="card-header bg-danger text-white">
                 <h4 class="m-0">Total Deleted Users</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive" id="showAllDeletedUsers">
                        <p class="text-center align-self-center lead">Please Wait...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- footer Area -->
        </div> <!--/*****   col div Ends****** -->
    </div> <!--/***** 1st row Ends****** -->
</div> <!--/***** Container-fluid Ends****** -->
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script type="text/javascript">
$(document).ready(function(){

    //** Fetch all deletedUsers Ajax */
fetchAllDeletedUsers();
function fetchAllDeletedUsers(){
    $.ajax({
        url:'assets/php/admin-action.php',
        method: 'post',
        data: {action: 'fetchAllDeletedUsers'},
        success:function(response){
           // console.log(response);
           $("#showAllDeletedUsers").html(response);
           $("table").DataTable({
               order: [0, 'desc']

           });
        }
    });
}


//** Restore Delete User Ajax Request */
$("body").on("click", ".restoreUserIcon", function(e){
    e.preventDefault();
    res_id  = $(this).attr('id');

    Swal.fire({
        title: 'Are you Sure you want to restore this user?',
       
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Restore it!'
    }).then((result) =>{
        if(result.value){
            $.ajax({
                url: 'assets/php/admin-action.php',
                method: 'post',
                data: {res_id : res_id},
                success:function(response){
                    Swal.fire(
                        'Restored!',
                        'User restored successfully',
                        'success'
                    )
                    fetchAllDeletedUsers();
                }
            });
        }
    })

});


//**  Delete User Permanentlt Ajax Request */
$("body").on("click", ".removeUserIcon", function(e){
    e.preventDefault();
    remove_id  = $(this).attr('id');

    Swal.fire({
        title: 'Are you Sure you want to remove this user from the database permanently?',
       
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, I want to delete permanently!'
    }).then((result) =>{
        if(result.value){
            $.ajax({
                url: 'assets/php/admin-action.php',
                method: 'post',
                data: {remove_id : remove_id},
                success:function(response){
                    Swal.fire(
                        'Removed Permanently!',
                        'User Removed successfully',
                        'success'
                    )
                    fetchAllDeletedUsers();
                }
            });
        }
    })

});

 //** Check notification */ 
 checkNotification()
   function checkNotification(){
       $.ajax({
           url: 'assets/php/admin-action.php',
           method: 'post',
           data:{action: 'checkNotification'},
           success:function(response){
              // console.log(response);
              $("#checkNotification").html(response);
           }
       });
   }
   


});
</script> 
</body>
</html>
 
 
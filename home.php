<?php
require_once 'assets/php/header.php';
?>
<?php  date_default_timezone_set("Asia/Shanghai");
 ?>
<div class="container">
  <div class="row">
    <div class="col-lg-12">
      <?php if($verified == 'Not Verified'):   ?>
      <div class="alert alert-danger alert-dismissible text-center mt-2 m-0">
         <button class="close" type="button" data-dismiss="alert">&times;</button>
         <strong> Your E-mail is not yet verifiend! We've sent an E-mail Verification link. Check your E-mail and
          verify now. </strong>
      </div>
      <?php endif;  ?>
      <h4 class="text-center text-primary mt-2"> Write Your Notes and Access Anytime Anywhere!</h4>
      
    </div>
  </div>
  <div class="card border-primary">
      <h5 class="card-header bg-primary d-flex justify-content-between">
        <span class="text-light lead align-self-center">All Notes </span>
        <a href="#" class="btn btn-light" data-toggle="modal" data-target="#addNoteModal">
        <i class="fas fa-plus-circe fa-lg"></i>&nbsp;Add New Note </a>
      </h5>
    <div class="card-body">
        <div class="table-responsive" id="showNote">
        <p class="text-center lead mt-3"> Please Waiting ...</p>
                     
        </div>
    </div>
  </div>
  </div>  
   <!--  *************** Add New Note Model STARTS ************************  -->
   <div class="modal fade" id="addNoteModal">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

          <div class="modal-header bg-success">
             <h4 class="modal-title text-light"> Add New Note</h4>
             <button type="button" class="close text-light" data-dismiss="modal">&times;</button>
          </div>

          <div class="modal-body">
            <form action="#" method="post" id="add_note_form" class="px-3">
               <div class="form-group">
                  <input type="text" name="title" class="form-control form-control-lg" placeholder="Enter Title" required>
               </div>
               <div class="form-group">
                  <textarea name="note" class="form-control form-control-lg" placeholder="Write Your Note Here ..." rows="6" required></textarea>
               </div>

               <div class="form-group">
                  <input type="submit" name="addNote" id="addNoteBtn" value="Add Note" class="btn btn-primary btn-block">
               </div>

            </form>
          </div>

        </div>
      </div>
   </div>


   <!--  Add New Note Model ENDS  -->
 <!--  *************** Edit Note Model STARTS ************************  -->
 <div class="modal fade" id="editNoteModal">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

          <div class="modal-header bg-info">
             <h4 class="modal-title text-light"> Edit Note </h4>
             <button type="button" class="close text-light" data-dismiss="modal">&times;</button>
          </div>

          <div class="modal-body">
            <form action="#" method="post" id="edit-note-form" class="px-3">
              <input type="hidden" name="id" id="id">
               <div class="form-group">
                  <input type="text" name="title" id="title" class="form-control form-control-lg" placeholder="Enter Title" required>
               </div>
               <div class="form-group">
                  <textarea name="note" id="note" class="form-control form-control-lg" placeholder="Write Your Note Here ..." rows="6" required></textarea>
               </div>

               <div class="form-group">
                  <input type="submit" name="addNote" id="editNoteBtn" value="Update Note" class="btn btn-info btn-block">
               </div>

            </form>
          </div>

        </div>
      </div>
   </div>


   <!--  Edit Note Model ENDS  -->
       
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js"> </script>
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
 
  <script type="text/javascript">
  $(document).ready(function(){
   
    //***  Add new note Ajax Request  * /
    $("#addNoteBtn").click(function(e){ 
      if($("#add_note_form")[0].checkValidity()){
        e.preventDefault();

        $("#addNoteBtn").val('Please Waiting...');

        $.ajax({
          url:'assets/php/process.php',
          method: 'post',
          data: $("#add_note_form").serialize()+'&action=add_note',
          success:function(response){
            //console.log(response);
            $("#addNoteBtn").val('Add Note');
            $("#add_note_form")[0].reset();
            $("#addNoteModal").modal('hide');
            Swal.fire({
              title: 'Note Add Successfully!',
              type: 'success'
            
            });
            displayAllNotes();
          }
        });

      }
    });

    //*** Edit note of a User */
    $("body").on("click", ".editBtn", function(e){ 
      e.preventDefault();

      edit_id = $(this).attr('id');

      $.ajax({
        url: 'assets/php/process.php',
        method: 'post',
        data: {edit_id: edit_id},
        success:function(response){
         // console.log(response);
         data = JSON.parse(response);
        // console.log(data);
         $("#id").val(data.id);
         $("#title").val(data.title);
         $("#note").val(data.note);


        }
      });
    });

    //** Update Note of a user */
    $("#editNoteBtn").click(function(e){
      if($("#edit-note-form")[0].checkValidity()){
        e.preventDefault();

        $.ajax({

          url: 'assets/php/process.php',
          method: 'post',
          data: $("#edit-note-form").serialize()+'&action=update_note',
          success:function(response){
            //console.log(response);
            Swal.fire({
              title: 'Note Updated Successfully!',
              type: 'success'
            });
            $("#edit-note-form")[0].reset();
            $("#editNoteModal").modal('hide');
            displayAllNotes();


          }
        });
      }
    });

    //** Delete a Note from A user Ajax Request */
    $("body").on("click", ".deleteBtn", function(e){
      e.preventDefault();

      del_id = $(this).attr('id');
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.value) {

          $.ajax({
            url:'assets/php/process.php',
            method:'post',
            data:{del_id: del_id},
            success:function(response){
              Swal.fire(
            'Deleted!',
            'Note Deleted Successfully.',
            'success'
          )
          displayAllNotes();
            }
          });

          
        }
      })

    });
//** Display Detail Note of a User Ajax Request */
$("body").on("click", ".infoBtn", function(e){
  e.preventDefault();
  info_id = $(this).attr('id');
  $.ajax({
    url: 'assets/php/process.php',
    method:'post',
    data:{info_id: info_id},
    success:function(response){
      //console.log(response);
      data = JSON.parse(response);
      Swal.fire({
        title: '<strong> Note: ID('+data.id+')</strong>',
        type:'info',
        html:'<b>Title : </b>'+data.title+'<br><br><b>Note : </b>'+data.note+
        '<br><br><b>Written On: </b>'+data.created_at+'<br><br><b>Updated on: </b>'+data.updated_at,
        showcloseButton: true,
      });
    }
  });
});

    //**** display all notes for a user */
    displayAllNotes();
    function displayAllNotes(){
      $.ajax({
        url: 'assets/php/process.php',
        method: 'post',
        data: {action: 'display_notes'},
        success:function(response){
          $("#showNote").html(response);
          $("table").DataTable({
            order: [0, 'desc']
          });
        }
      });
    }

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

  //** Checking if user is logged in or not */
  $.ajax({
    url:'assets/php/action.php',
    method: 'post',
    data:{action: 'checkUser'},
    success:function(response){
      if(response === 'Bye')
         window.location = 'index.php';
    }
  });

  });
  </script>
 </body>
  </html>
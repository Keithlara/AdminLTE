<?php
  
  include_once 'connectdb.php';
  session_start();


 
  if($_SESSION['useremail']=="" OR $_SESSION['role']=="User"){

    header('location:../index.php');
  }




  if($_SESSION['role']=="Admin"){


    include_once"header.php";


    }else{

      
    include_once"headeruser.php";
    
  
  
  }

error_reporting(0);

$id=$_GET['id'];

if(isset($id)){

$delete=$pdo->prepare("delete from tbl_user where userid =".$id);

if($delete->execute()){

  $_SESSION['status']="Account deleted successfully";
  $_SESSION['status_code']="success";


}else{

  $_SESSION['status']="Account is not deleted";
  $_SESSION['status_code']="warning";




}

}





if(isset($_POST['btnsave'])){

$username = $_POST['txtname'];
$userage = $_POST['txtage'];
$useremail = $_POST['txtemail'];
$userpassword= $_POST['txtpassword'];
$usercontact = $_POST['txtcontact'];
$useraddress = $_POST['txtaddress'];
$userrole = $_POST['txtselect_option'];








if(isset($_POST['txtemail'])){

$select=$pdo->prepare("select useremail from tbl_user where useremail='$useremail'");

$select->execute();

if($select->rowCount()>0){

  

  $_SESSION['status']="Email already exists!.";
  $_SESSION['status_code']="warning";



}else{

if(isset($_POST['txtpassword'])){

$select=$pdo->prepare("select userpassword from tbl_user where userpassword='$userpassword'");

$select->execute();

if($select->rowCount()>0){

  

  $_SESSION['status']="Password already exists.";
  $_SESSION['status_code']="warning";

 


  

}else{

  $insert=$pdo->prepare("insert into tbl_user (username,userage, useremail, userpassword, usercontact, useraddress, role) values(:name,:age,:email,:password,:contact,:address,:role)");

  $insert->bindParam(':name',$username);
  $insert->bindParam(':age',$userage);
  $insert->bindParam(':email',$useremail);
  $insert->bindParam(':password',$userpassword);
  $insert->bindParam(':contact',$usercontact);
  $insert->bindParam(':address',$useraddress);
  $insert->bindParam(':role',$userrole);
  
  if($insert->execute()){
  
  
  
  $_SESSION['status']="Inserted Successfully! ";
  $_SESSION['status_code']="success";
  
  }else{
  
  
  $_SESSION['status']="Error inserting the user into the database";
  $_SESSION['status_code']="error";
  }
}

  }
}

}
}

  ?>

 
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Registration</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
       
           <div class="col-lg-12">
          <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">Registration</h5>
              </div>
              <div class="card-body">




<div class="row">

<div class="col-lg-4">

<form action="" method="post">
               
                  <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" class="form-control" placeholder="Enter Name" name="txtname" required>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputAge">Age</label>
                    <input type="number" class="form-control" placeholder="Enter Age"  min="18" max="65" name="txtage" required>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" placeholder="Enter email" name="txtemail" required>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control"  placeholder="Password" name="txtpassword" required>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputContact">Contact Number</label>
                    <input type="phone" class="form-control" placeholder="Enter Contact Number" name="txtcontact" required>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">Address</label>
                    <input type="text" class="form-control"  placeholder="Address" name="txtaddress" required>
                  </div>
                  
                  
                      <div class="form-group">
                        <label>Role</label>
                        <select class="form-control" name="txtselect_option" required>
                          <option value="" disabled selected>Select Role</option>
                          <option>Admin</option>
                          <option>User</option>
                       
                        </select>
                      </div>

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary"  name="btnsave">Save</button>
                </div>
              </form>



</div>






<div class="col-lg-8">

<table class="table table-striped table-hover">
  <thead> 
<tr>
  <td>#</td>
  <td>Name</td>
  <td>Age</td>
  <td>Email</td>
  <td>Password</td>
  <td>Contact</td>
  <td>Address</td>
  <td>Role</td>
  <td>Delete</td>
</tr>

</thead>




<tbody>
<?php 

$select = $pdo->prepare("select * from tbl_user order by userid ASC");
$select->execute();

while($row=$select->fetch(PDO::FETCH_OBJ))

{

  echo'
  <tr id="item_' .$row->userid.'">
  <td>'.$row->userid.'</td>
  <td>'.$row->username.'</td>
  <td>'.$row->userage.'</td>
  <td>'.$row->useremail.'</td>
  <td>'.$row->userpassword.'</td>
  <td>'.$row->usercontact.'</td>
  <td>'.$row->useraddress.'</td>
  <td>'.$row->role.'</td>
<td>
<button onclick="Delete('.$row->userid.')"
 type="button" class="btn btn-danger"> <i class="fa fa-trash-alt"></i></button>




</td>
</tr>';

}

?>

<script>

  
function Delete(id){
  Swal.fire({
    title: 'Are you sure?',
    text: "Are you sure you want to proceed?",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: "#d33",
    confirmButtonText:"Yes, Delete It!",
  }).then(function(result){
    if(result.value){
      $.ajax({
        url: ` delete.php?id=${id}`,
        type : 'GET',
        success : function(data) {
          Swal.fire({
            title: 'Deleted!',
            showConfirmButton: true,
            timer: 1000,
          });
          $("#item_" + id).remove();
        },
        error:function(jqXHR, textStatus, errorThrown){
          Swal.hideloading();
          Swal.fire("!Oops", "Something went wrong, try again later", "error");
        }


      });
    }
  });
}


  </script>



</table>


</div>


                

                
              </div>


              </div>
            </div>
           
         
            

            
         
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>


  <?php
  
  include_once "footer.php";
  
  
  ?>

  
<?php
if(isset($_SESSION['status']) && $_SESSION['status']!='')

{

?> 
<script>




  
      Swal.fire({
        icon: '<?php echo $_SESSION['status_code'];?>',
        title: '<?php echo $_SESSION['status'];?>'
      });

     



 </script> 
<?php

unset($_SESSION['status']);
}






?>
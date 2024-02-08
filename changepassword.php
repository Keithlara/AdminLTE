<?php

include_once'connectdb.php';
session_start();


if($_SESSION['useremail']==""){

  header('location:../index.php');
  
  
  }



  if($_SESSION['role']=="Admin"){

    include_once"header.php";
  }else{

    include_once"headeruser.php";
  }







if(isset($_POST['btnupdate'])){

$oldpassword_txt=$_POST['txt_oldpassword'];
$newpassword_txt=$_POST['txt_newpassword'];
$rnewpassword_txt=$_POST['txt_rnewpassword'];

//echo $oldpassword_txt."-".$newpassword_txt."-".$rnewpassword_txt;



$email=$_SESSION['useremail'];

$select= $pdo->prepare("select * from tbl_user where useremail='$email'");

$select->execute();
$row=$select->fetch(PDO::FETCH_ASSOC);

$useremail_db = $row['useremail'];
$password_db= $row['userpassword'];






if($oldpassword_txt==$password_db){

if($newpassword_txt==$rnewpassword_txt){


  $update=$pdo->prepare("update tbl_user set userpassword=:pass where useremail=:email");




  $update->bindParam(':pass',$rnewpassword_txt);
  $update->bindParam(':email',$email);

  if($update->execute()){

$_SESSION['status']="Password Updated Successfully";
$_SESSION['status_code']="Success";

  }else{

  $_SESSION['status']="Password Does Not Updated Successfully";
  $_SESSION['status_code']="Error";

  }

  //$_SESSION['status']="New Password Matched";
  //$_SESSION['status_code']="Success";

}else{

  $_SESSION['status']="New Password Does Not Matched";
  $_SESSION['status_code']="Error";

}





}else{


  $_SESSION['status']="Password Does Not Matched";
 $_SESSION['status_code']="Error";

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
            <h1 class="m-0">Change Password</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Starter Page</li> -->
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            

<!-- Horizontal Form -->
<div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Change Password</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal" action="" method="post">
                <div class="card-body">
                
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Old Password</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="inputPassword3" placeholder="Old Password" name="txt_oldpassword">
                    </div>
                  </div>


                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label"> New Password</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="inputPassword3" placeholder=" New Password" name="txt_newpassword">
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Repeat New Password</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="inputPassword3" placeholder="Repeat New Password" name="txt_rnewpassword">
                    </div>
                  </div>
                  

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-info" name="btnupdate">Update Password</button>
               
                </div>
                <!-- /.card-footer -->
              </form>
            </div>
            <!-- /.card -->
          
            

           
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 
 
 <?php

include_once"footer.php";


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

<?php include 'header.php'; ?>
<?php
include 'database/dbconn.php';

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    header('location:index.php');
}
elseif(isset($_SESSION['admin_id'])){
    $admin_id = $_SESSION['admin_id'];
    header('location:index.php');
}
else{

}

?>

<div class="card col-sm-4 mt-2 mx-auto shadow p-3">
<div class="container-sm ">
<form action="verification.php" method="post">
<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="alert shadow" style="background-color: black; padding: 10px;color:white;">
            <span class="closebtn" onClick="this.parentElement.remove()">&times;</span>
            '.$message.'
            </div>';
      }
   }
?>
    <h4 style="padding:5px; text-align:left; border-bottom:2px solid black; ">Forgot Password</h4>
    <div class="mb-2">
        <label for="InputEmail1" class="form-label">Email address</label>
        <input type="email" name="email" class="form-control p-1 shadow-sm bg-white rounded" id="InputEmail1" required>
    </div>
    <button type="submit" name="send_otp" class="btn btn-dark">Send OTP</button>
</form>
<div class="label fs-6">
    <label for="logIn" class="label">Login Now <a href="login.php" style="text-decoration:none;">Login</a></label>
</div>
</div>
</div>
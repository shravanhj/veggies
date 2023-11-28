<?php include 'header.php'; ?>
<?php
include 'database/dbconn.php';

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    header('location:dashboard.php');
}
elseif(isset($_SESSION['admin_id'])){
    header('location:index.php');
}
else{
    $user_id = '';
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
    <h4 style="padding:5px; text-align:left; border-bottom:2px solid black; ">Registration</h4>
    <div class="mb-2 mt-3">
        <label for="InputFullName" class="form-label">Full Name</label>
        <input type="text" name="fullname" class="form-control p-1 shadow-sm bg-white rounded" id="InputFullName" value="" required>
    </div>
    <div class="mb-2">
        <label for="InputEmail1" class="form-label">Email address</label>
        <input type="email" name="email" class="form-control p-1 shadow-sm bg-white rounded" id="InputEmail1" required>
    </div>
    <div class="mb-3">
        <label for="InputNumber" class="form-label">Phone Number</label>
        <input type="tel" name="phonenumber" class="form-control p-1 shadow-sm bg-white rounded" required>
    </div>
    <div class="mb-2">
        <label for="InputPassword1" class="form-label">Password</label>
        <input type="password" name="password" class="form-control p-1 shadow-sm bg-white rounded" onchange="onChange()" id="InputPassword1" required>
    </div>
    <div class="mb-2">
        <label for="InputPassword1" class="form-label">Confirm Password</label>
        <input type="password" name="confirm_password" class="form-control p-1 shadow-sm bg-white rounded" onchange="onChange()" id="InputPassword2" required>
    </div>
    <div class="mb-2 form-check">
        <input type="checkbox" class="form-check-input" id="Check1" checked >
        <label class="form-check-label">I have Agreed to <a >Terms & Conditions.</a></label>
    </div>
    <button type="submit" name="submit" class="btn btn-dark">Register Now</button>
</form>
<div class="label fs-6">
    <label for="logIn" class="label">Already Registered? <a href="login.php" style="text-decoration:none;">Login</a></label>
</div>
</div>
</div>
<script>
    function onChange() {
  const password = document.querySelector('input[name=password]');
  const confirm = document.querySelector('input[name=confirm_password]');
  if (confirm.value === password.value) {
    confirm.setCustomValidity('');
  } else {
    confirm.setCustomValidity('Passwords do not match');
  }
}
</script>
<?php include 'footer.php'; ?>
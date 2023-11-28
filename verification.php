
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
<?php

use PHPMailer\PHPMailer\PHPmailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if(isset($_POST['submit'])){
    $_SESSION['fullname'] = $_POST['fullname'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['phonenumber'] = $_POST['phonenumber'];
    $_SESSION['password'] = sha1($_POST['password']);
    $_SESSION['confirm_password'] = sha1($_POST['confirm_password']);
    $subject = 'VEGGIES Verification Code';
    $message = 'Your Verification code is: ';

    $check_user = $conn->prepare("SELECT * FROM `customers` WHERE Email = ? OR Phone = ?");
    $check_user->execute([$_SESSION['email'], $_SESSION['phonenumber']]);
    $select_user = $check_user->fetch(PDO::FETCH_ASSOC);

    if($check_user->rowCount() > 0){
        echo "<script type='text/javascript'>alert('Account Already Registered.');window.location.href='signup.php';</script>";  
    }
    else{
        $_SESSION['otp'] = rand(11111,99999);
        $mail = new PHPMailer(true);

        try{
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username =  'iamwilliamsmith07@gmail.com';
            $mail->Password = 'bplcpnotbaavazdy';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            
            $mail->setFrom('iamwilliamsmith07@gmail.com');
            $mail->addAddress($_SESSION['email']);
    
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $message.$_SESSION['otp'];
    
            $mail->send();
            $otp_message = 'OTP Sent Successfully';
                enter_otp($otp_message);
        }
        catch(Exception $e){
            failed();

        }
        
    }
}

if(isset($_POST['submit_otp'])){
    $verify_otp = $_POST['otp'];

    if($verify_otp == $_SESSION['otp']){
        $insert_admin = $conn->prepare("INSERT INTO `customers` (Name, Email, Phone, Password) VALUE (?, ?, ?, ?)");
        $insert_admin->execute([$_SESSION['fullname'], $_SESSION['email'], $_SESSION['phonenumber'], $_SESSION['password']]);
        
        echo "<script type='text/javascript'>alert('Registered Successfully. Click ok to Login..');window.location.href='login.php';</script>";
    }
    else{
        $otp_message = 'Wrong OTP Entered.';
        enter_otp($otp_message);
    }
}
elseif(isset($_POST['submit_forgot_otp'])){
    $verify_otp = $_POST['otp'];

    if($verify_otp == $_SESSION['otp']){
        changePassword();
    }
    else{
        $otp_message = 'Wrong OTP Entered.';
        enter_otp($otp_message);
    }
}

elseif(isset($_POST['change_password'])){
    $password = sha1($_POST['password']);
    $update_password = $conn->prepare("UPDATE `customers` SET Password = ? WHERE Email = ?");
    $update_password->execute([$password, $_SESSION['email']]);
    echo "<script type='text/javascript'>alert('Password Reset Successfully. Click ok to Login..');window.location.href='login.php';</script>";
}

elseif(isset($_POST['send_otp'])){
    $_SESSION['email'] = $_POST['email'];
    $subject = 'Reset Password';
    $message = 'Your OTP to Reset you Veggies account password is : ';

    $check_user = $conn->prepare("SELECT * FROM `customers` WHERE Email = ? ");
    $check_user->execute([$_SESSION['email']]);
    $select_user = $check_user->fetch(PDO::FETCH_ASSOC);

    if($check_user->rowCount() > 0){
        $_SESSION['otp'] = rand(11111,99999);
        $mail = new PHPMailer(true);

        try{
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username =  'iamwilliamsmith07@gmail.com';
            $mail->Password = 'bplcpnotbaavazdy';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            
            $mail->setFrom('iamwilliamsmith07@gmail.com');
            $mail->addAddress($_SESSION['email']);
    
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $message.$_SESSION['otp'];
    
            $mail->send();
            $otp_message = 'OTP Sent Successfully';
                enter_forgot_otp($otp_message);
        }
        catch(Exception $e){
            failed();

        }  
    }
    else{
        echo "<script type='text/javascript'>alert('Account Does not Exist.');window.location.href='login.php';</script>";
    }
}

function enter_otp($otp_message){
    echo '
    <div class="card col-sm-4 mt-2 mx-auto shadow p-3">
<div class="container-sm ">
<form method="post">
    <h4 style="padding:5px; text-align:left; border-bottom:2px solid black; ">OTP Verification</h4>
    <div class="alert" style="background-color: green; padding:10px; color:white;">
            <span class="closebtn" onClick="this.parentElement.remove()">&times;</span>
            '.$otp_message.'.
            </div>
    <div class="mb-2">
        <label for="InputEmail1" class="form-label">Enter OTP Received on EMail</label>
        <input type="tel" name="otp" class="form-control p-1 shadow-sm bg-white rounded" id="InputEmail1">
    </div>
    <button type="submit" name="submit_otp" class="btn btn-dark">Submit OTP</button>
    <a href="signup.php"class="btn btn-dark">Cancel</a>
</form>
</div>
</div>
    ';
}

function enter_forgot_otp($otp_message){
    echo '
    <div class="card col-sm-4 mt-2 mx-auto shadow p-3">
<div class="container-sm ">
<form method="post">
    <h4 style="padding:5px; text-align:left; border-bottom:2px solid black; ">OTP Verification</h4>
    <div class="alert" style="background-color: green; padding:10px; color:white;">
            <span class="closebtn" onClick="this.parentElement.remove()">&times;</span>
            '.$otp_message.'.
            </div>
    <div class="mb-2">
        <label for="InputEmail1" class="form-label">Enter OTP Received on EMail</label>
        <input type="tel" name="otp" class="form-control p-1 shadow-sm bg-white rounded" id="InputEmail1">
    </div>
    <button type="submit" name="submit_forgot_otp" class="btn btn-dark">Submit OTP</button>
    <a href="signup.php"class="btn btn-dark">Cancel</a>
</form>
</div>
</div>
    ';
}

function changePassword(){
    ?>
    <div class="card col-sm-4 mt-2 mx-auto shadow p-3">
<div class="container-sm ">
<form method="post">

    <h4 style="padding:5px; text-align:left; border-bottom:2px solid black; ">Change Password</h4>
    <div class="mb-2">
        <label for="InputEmail1" class="form-label">Email address</label>
        <input type="email" name="email" class="form-control p-1 shadow-sm bg-white rounded" id="InputEmail1" value="<?= $_SESSION['email'];?>" disabled>
    </div>
    <div class="mb-2">
        <label for="InputPassword1" class="form-label">Password</label>
        <input type="password" name="password" class="form-control p-1 shadow-sm bg-white rounded" onchange="onChange()" id="InputPassword1" required>
    </div>
    <div class="mb-2">
        <label for="InputPassword1" class="form-label">Confirm Password</label>
        <input type="password" name="confirm_password" class="form-control p-1 shadow-sm bg-white rounded" onchange="onChange()" id="InputPassword2" required>
    </div>
    <button type="submit" name="change_password" class="btn btn-dark">Change Password</button>
</form>
</div>
</div>
<?php
}


function failed(){
    echo '<div class="alert mx-auto" style="background-color: red; width:20%; padding:10px; color:white;">
    <span class="closebtn" onClick="this.parentElement.remove()">&times;</span>
    Failed to Send OTP.
    </div>';
}


?>

<?php include 'footer.php'; ?>
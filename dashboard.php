<?php include 'header.php'; ?>
<?php
   if(isset($message)){
      foreach($message as $message){
         echo "<script type='text/javascript'>alert('$message');</script>";
      }
   }
?>
<?php
include 'database/dbconn.php';
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}
elseif(isset($_SESSION['user_id'])){
    header('location:index.php');
}
else{
    $user_id = '';
    header('location:error.php');
}
?>
<?php
$select_user = $conn->prepare("SELECT * FROM `customers` WHERE Customer_id = ?");
$select_user->execute([$user_id]);
$row = $select_user->fetch(PDO::FETCH_ASSOC);
?>
<div class="container rounded bg-white mt-0 mb-5 mx-auto">
    <div class="row">
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150px" src="sources/profile.jpg"><span class="font-weight-bold" style="text-transform:capitalize"><?= $row['Name'] ;?></span><span class="text-black-50">Welcome to Veggies</span><span> </span></div>
        </div>
        <div class="col-md-5 border-right">
            <div class="p-3 py-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Profile</h4>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 mb-2"><label class="labels me-5">Name&emsp; &emsp; &emsp;</label>: <b style="text-transform: capitalize;"><?= $row['Name'] ;?></b></div>
                    <div class="col-md-12 mb-2"><label class="labels me-5">Mobile No&emsp;&ensp;</label>: <b style="text-transform: capitalize;"><?= $row['Phone'] ;?></b></div>
                    <div class="col-md-12 mb-2"><label class="labels me-5">Email&emsp; &ensp; &ensp; &emsp;</label>: <b style="text-transform: capitalize;"><?= $row['Email'] ;?></b></div>
                    <div class="mt-2"><a class="btn btn-dark" href="update.php">Update Profile</a></div>     
                </div>
                <div class="py-3">
                <h4 class="text-right">Default Address</h4>
                <div class="row mt-2">
                    <div class="col-md-12 mb-2"><label class="labels me-5">Address Line 1</label>: <b style="text-transform: capitalize;"><?= $row['Address_line_1'] ;?></b></div>
                    <div class="col-md-12 mb-2"><label class="labels me-5">Address Line 2</label>: <b style="text-transform: capitalize;"><?= $row['Address_line_2'] ;?></b></div>
                    <div class="col-md-12 mb-2"><label class="labels me-5">Area&emsp; &emsp; &emsp;&emsp;</label>: <b style="text-transform: capitalize;"><?= $row['Area'] ;?></b></div>
                    <div class="col-md-12 mb-2"><label class="labels me-5">City&emsp; &emsp; &emsp;&emsp;</label> : <b style="text-transform: capitalize;"><?= $row['City'],'-', $row['Pincode'] ;?></b></div>
                    <div class="col-md-12 mb-2"><label class="labels me-5">State&emsp; &emsp; &emsp;&ensp;</label> : <b style="text-transform: capitalize;"><?= $row['State'] ;?></b></div>
                    <div class="col-md-12 mb-2"><label class="labels me-5">Country&emsp; &emsp;&ensp;</label> : <b style="text-transform: capitalize;"><?= $row['Country'] ;?></b></div>
                    <div class="mt-2"><a class="btn btn-dark" href="update.php#update-address">Change Address</a></div>
                </div>
            </div>
        </div>
        </div>
        
    </div>
</div>
</div>
</div>

<?php include 'footer.php'; ?>
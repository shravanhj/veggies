<?php include 'header.php'; ?>
<?php
include '../database/dbconn.php';
if(isset($_SESSION['admin_id'])){
    $admin_id = $_SESSION['admin_id'];
}
elseif(isset($_SESSION['user_id'])){
    header('location:../index.php');
}
else{
    $admin_id = '';
    header('location:error.php');
}

?>

<?php
$select_user = $conn->prepare("SELECT * FROM `admins` WHERE Admin_id = ?");
$select_user->execute([$admin_id]);
$row = $select_user->fetch(PDO::FETCH_ASSOC);
?>
<div class="container rounded border mt-5  mx-auto">
    <div class="row">
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150px" src="../sources/profile.jpg"><span class="font-weight-bold" style="text-transform:capitalize"><?= $row['Name'] ;?></span><span class="text-black-50">Welcome to Veggies</span><span>Role: Admin</span></div>
        </div>
        <div class="col-md-5 border-right align-center">
        <div class="card">
  <div class="card-header">
    <h4>Admin Profile</h4>
  </div>
  <div class="card-body">
    <div class="col-md-12 mb-2"><label class="labels me-5">Name&emsp; &emsp; &emsp;</label>: <b style="text-transform: capitalize;"><?= $row['Name'] ;?></b></div>
                    <div class="col-md-12 mb-2"><label class="labels me-5">Mobile No&emsp;&ensp;</label>: <b style="text-transform: capitalize;"><?= $row['Phone_No'] ;?></b></div>
                    <div class="col-md-12 mb-2"><label class="labels me-5">Email&emsp; &emsp; &ensp; &ensp;</label>: <b style="text-transform: capitalize;"><?= $row['Email'] ;?></b></div>
                    <div class="mt-2"><a class="btn btn-dark" href="update.php">Update Profile</a></div>
  </div>
</div>
                <div class="py-3">
                <h4 class="text-right">Admin Responsibilites</h4>
                <div class="row mt-2">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Add Product on e-Shop</li>
                    <li class="list-group-item">Manage the product catalogue</li>
                    <li class="list-group-item">Review and Update Orders</li>
                    <li class="list-group-item">Received Payments</li>
                    <li class="list-group-item"></li>
                </ul>
                </div>
            </div>
        </div>
        </div>
        
    </div>


    <?php include 'footer.php'; ?>
<?php include 'header.php'; ?>
<?php
include '../database/dbconn.php';
if(isset($_SESSION['admin_id'])){
    $admin_id = $_SESSION['admin_id'];
}
else{
  $user_id = '';
    header('location:error.php');
}

if(isset($_POST['delete'])){
  $order_id = $_POST['order_id'];
  $delete_product = $conn->prepare("DELETE FROM `orders` WHERE Order_id = ?");
  $delete_product->execute([$order_id]);
  $message[] = 'Product Deleted Successfully';
}

if(isset($_POST['update'])){
  $order_id = $_POST['order_id'];
  $status = $_POST['status'];
  $delete_product = $conn->prepare("UPDATE `orders` set Order_Status =? WHERE Order_id = ?");
  $delete_product->execute([$status, $order_id]);
  $message[] = 'Product Deleted Successfully';
}
?>
<div class="container">
  <?php
  $pending_payment = 0;
  $received_payments = 0;
  $total_payments = 0;
$select_pending_payment = $conn->prepare("SELECT * FROM `orders` WHERE Payment_Status = 'Pending' ");
$select_pending_payment->execute();
    if($select_pending_payment->rowCount() > 0){
        while($row = $select_pending_payment->fetch(PDO::FETCH_ASSOC)){
            $pending_payment = $pending_payment + $row['Total_Price'] ;
        }
    }
    ?>
    <?php
    $select_received_payment = $conn->prepare("SELECT * FROM `orders` WHERE Payment_Status = 'Received' ");
    $select_received_payment->execute();
    if($select_received_payment->rowCount() > 0){
        while($row = $select_received_payment->fetch(PDO::FETCH_ASSOC)){
            $received_payments = $received_payments + $row['Total_Price'] ;
        }
    }
    ?>
<div class="col-md-5 border-right align-center mt-3 mx-auto">
<div class="card">
  <div class="card-header">
    <h4>Payments Information</h4>
  </div>
  <div class="card-body">
  <div class="col-md-12 mb-2"><label class="labels me-5">Pending Payments&emsp; &ensp; </label>: <b class="text-danger"style="text-transform: capitalize;">Rs. <?= $pending_payment ;?>/-</b></div>
                    <div class="col-md-12 mb-2"><label class="labels me-5">Received Payments&emsp;&ensp;</label>: <b class="text-warning" style="text-transform: capitalize;">Rs. <?= $received_payments ;?>/-</b></div>
                    <div class="col-md-12 mb-2"><label class="labels me-5">Total Payments&emsp; &ensp; &emsp;</label>: <b class="text-success" style="text-transform: capitalize;">Rs. <?= $pending_payment + $received_payments ;?>/-</b></div>
                    <div class="mt-2"><a class="btn btn-dark" href="orders.php">Update Payment-Status</a></div>  
  </div>
</div>
</div>

<?php include 'footer.php'; ?>
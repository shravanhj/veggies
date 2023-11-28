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
elseif(isset($_SESSION['admin_id'])){
    header('location:index.php');
}
else{
    $admin_id = '';
    header('location:error.php');
}

if(isset($_POST['delete'])){
  $order_id = $_POST['order_id'];
  $delete_product = $conn->prepare("DELETE FROM `orders` WHERE Order_id = ?");
  $delete_product->execute([$order_id]);
  $message[] = 'Product Deleted Successfully';
}
?>
<div class="container-xl mt-5 overflow-auto">
    <h4>Orders : </h4>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Order ID</th>
      <th scope="col">Item</th>
      <th scope="col">Name</th>
      <th scope="col">Quantity</th>
      <th scope="col">Amount</th>
      <th scope="col" width='15%'>Delivery Address</th>
      <th scope="col">Order Status</th>
      <th scope="col">Payment Status</th>
      <th scope="col">Delivery Date</th>
      <th scope="col">Cancel Order</th>
    </tr>
  </thead>
  <tbody>
  <?php
$select_product = $conn->prepare("SELECT * FROM `orders` WHERE Customer_id = ?");
$select_product->execute([$user_id]);
    if($select_product->rowCount() > 0){
        while($row = $select_product->fetch(PDO::FETCH_ASSOC)){
            $select_date = $row['order_time'];
            $date=date_create($select_date);
            date_add($date,date_interval_create_from_date_string("7 days"));
            $delivery_date = date_format($date,"l jS F");
    ?>
    <tr>
    <form method="post">
      <input type="hidden" name="order_id" value="<?= $row['Order_id'];?>">
      <td><?= $row['Order_id'];?></td>
      <td><img class="card-img-top" src="productImage/<?= $row['Image_01'];?>" width="100px" height="60px" alt="Product Image"></td>
      <td><?= $row['Product_name'];?></td>
      <td><?= $row['Quantity'];?></td>
      <td><?= $row['Total_Price'];?></td>
      <td><p><?= $row['Address_line_1'];?>, <?= $row['Address_line_2'];?>, <?= $row['Area'];?>, <?= $row['City'];?>-<?= $row['Pincode'];?></td>
      <td><?= $row['Order_Status'];?></td>
      <td><?= $row['Payment_Status'];?></td>
      <td><?= $delivery_date;?></td>
      <td>
        <?php
        if($row['Order_Status'] == 'Pending'){
          ?>
          <input type="submit" name="delete" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this?');" value="Cancel">
        <?php
        }
        else{
          ?>
          <input type="submit" name="delete" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this?');" value="Cancel" disabled>
        <?php
        }
        ?>
        </td>
    </form>
    </tr>
    <?php
   }
}
?>
  </tbody>
</table>
</div>

<?php include 'footer.php'; ?>
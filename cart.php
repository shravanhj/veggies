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
    $user_id = '';
    header('location:error.php');
}
if(isset($_POST['update_plus'])){
  $quantity = $_POST['quantity']+1;
  $cart_id = $_POST['cart_id'];
  $update_qty = $conn->prepare("UPDATE `cart` SET Quantity = ? WHERE Cart_id = ?");
  $update_qty->execute([$quantity, $cart_id ]);
}
if(isset($_POST['update_minus'])){
  $quantity = $_POST['quantity']-1;
  if($quantity < 1){
    $quantity = 1;
  }
  
  $cart_id = $_POST['cart_id'];
  $update_qty = $conn->prepare("UPDATE `cart` SET Quantity = ? WHERE Cart_id = ?");
  $update_qty->execute([$quantity, $cart_id ]);
}

if(isset($_POST['delete'])){
  $cart_id = $_POST['cart_id'];
  $update_qty = $conn->prepare("DELETE FROM `cart` WHERE Cart_id = ?");
  $update_qty->execute([$cart_id]);
  $message[] = 'Item removed succcessfully';
}
$select_product = $conn->prepare("SELECT * FROM `cart`");
$select_product->execute();
$sub_total = 0;
?>
<div class="container mt-5">
<h4 class="mx-auto">Cart Items : (<?= $select_product->rowCount() ?>)</h4>
<?php
if($select_product->rowCount()>0)
{
  ?>
<table class="table mx-auto" style="width:70%;">
  <thead>
    <tr>
      <th scope="col" style="width:15%;">Product</th>
      <th scope="col">Name</th>
      <th scope="col">Price</th>
      <th scope="col">Quantity</th>
      <th scope="col">Sub Total</th>
      <th scope="col">Delete</th>
    </tr>
  </thead>
  <tbody>
  <?php
$select_product = $conn->prepare("SELECT * FROM `cart` WHERE Customer_id = ?");
$select_product->execute([$user_id]);
    if($select_product->rowCount() > 0){
        while($row = $select_product->fetch(PDO::FETCH_ASSOC)){
    ?>
    <form method="post">
    <input type="hidden" name="cart_id" value="<?= $row['Cart_id']; ?>">
    <tr>
      <td><img class="card-img-top" src="productImage/<?= $row['Image_01'];?>" width="100px" height="100px" alt="Product Image"></td>
      <td><?= $row['Product_Name'];?></td>
      <td>Rs. <?= $row['Selling_Price'];?>/-</td>
      <td class="d-flex"><button type="submit" name="update_minus"><i class="fa fa-minus"></i></button>
          <input type="text" name="quantity" class="form-control shadow-sm bg-white rounded" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" style="width:50px" value="<?= $row['Quantity']; ?>">
          <button type="submit" name="update_plus"><i class="fa fa-plus"></i></button></td>
      <td>Rs. <?= $total = ($row['Selling_Price']) * $row['Quantity'];?>/-</td>
      <td><button type="submit" name="delete" class="btn btn-danger"><i class="fa fa-trash"></i></button></td>
    </tr>
    </form>
    <?php 
    $sub_total = $sub_total + $total;
   }
}
$select_date = date("l jS F");
$date = date_create($select_date);
    date_add($date,date_interval_create_from_date_string("7 days"));
    $delivery_date = date_format($date,"l jS F");
?>
  </tbody>
</table>
<!--
<table class="table" style="width:20%;">
<thead>
    <tr>
      <th scope="col">Checkout</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><b>Sub Total : </td>
      <td><?= 'Hi';?></td>
    </tr>
  </tbody>
</table>
-->
<div class="py-1" style="float:right">
                <h4 class="text-right">Checkout</h4>
                <div class="row mt-2 mx-auto">
                    <div class=""><label class="labels me-5">Sub Total</label>: <b class="text-right"><?= $sub_total ;?></b>.00/-</div>
                    <hr class="mt-2"style="width: 50%; border: 1px solid black">
                    <div class=""><label class="labels me-4"><b>Grand Total :</label>  <?= $sub_total;?></b>.00/-</div>
                    
                </div>
                <a href="checkout.php" class="btn btn-success block mt-2 mb-2">Proceed to Checkout <i class="fa fa-arrow-right"></i></a>
</div>
<div class="py-1" style="">
                <h4 class="text-right">Estimated Delivery Date</h4>
                <div class="row mt-2 mx-auto">
                    <div class=""><label class="labels me-5">Standard Delivery :</div>
                    <div class=""><label class="labels me-4"><b><?= $delivery_date ;?></b></div>
                </div>
            </div>
</div>
<?php
}
else{
  $delivery_date = 0;
  echo '<h4 class="mx-auto">Your Cart is Empty....</h4>
  <a href="index.php" class="btn btn-dark">Shop Now</a>';
}
?>

<?php include 'footer.php'; ?>
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
if(isset($_POST['delete'])){
    $product_id = $_POST['product_id'];
    $delete_product = $conn->prepare("DELETE FROM `products` WHERE Product_id = ?");
    $delete_product->execute([$product_id]);
    $message[] = 'Product Deleted Successfully';
  }
?>

<div class="container mt-5">
    <h4>Used Products ID's : </h4>
<table class="table w-50 mx-auto table-striped">
  <thead>
    <tr>
      <th scope="col">Product ID</th>
      <th scope="col">Image</th>
      <th scope="col">Name</th>
      <th scope="col">Delete</th>
    </tr>
  </thead>
  <tbody>
  <?php
$select_product = $conn->prepare("SELECT * FROM `products`");
$select_product->execute();
    if($select_product->rowCount() > 0){
        while($row = $select_product->fetch(PDO::FETCH_ASSOC)){
            $offer = ($row['Selling_Price']) / $row['MRP'] * 100 ;
            $newname = mb_strimwidth($row['Product_Name'], 0, 15, '');
            if($row['Stock'] > 0){
              $stock = 'In Stock';
            }
            else{
              $stock = 'Out of Stock';
            }
    ?>
    <tr>
    <form method="post">
      <input type="hidden" name="product_id" value="<?= $row['Product_id'];?>">
      <td><?= $row['Product_id'];?></td>
      <td><img class="card-img-top" src="../productImage/<?= $row['Image_01'];?>" width="20px" height="60px" alt="Product Image"></td>
      <td><?= $row['Product_Name'];?></td>
      <td><input type="submit" name="delete" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this?');" value="Delete"></td>
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
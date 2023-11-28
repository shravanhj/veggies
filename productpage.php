<?php include 'header.php'; ?>
<?php
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}
elseif(isset($_SESSION['admin_id'])){
    $admin_id = $_SESSION['admin_id'];
    $message[] ='Please Login';
    include 'logout.php';
    header('location:login.php');
}
else{
    $user_id = ' ';
    $admin_id = ' ';
}

if(isset($_GET['Product_id'])){
  singleProduct($conn);
}
elseif($_GET['Product_Category']){
  categoryWise($conn);
}
?>

<?php
if(isset($_POST['add_to_cart'])){
  if(isset($_SESSION['user_id'])){
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $offer_price = $_POST['offer_price'];
    $category = $_POST['category'];
    $stock = 1;
    $image_01 = $_POST['image'];
  
    $select_product = $conn->prepare("SELECT * FROM `cart` WHERE Product_id = ? AND Customer_id = ?");
    $select_product->execute([$product_id, $user_id]);
    $row = $select_product->fetch(PDO::FETCH_ASSOC);
  
      if($select_product->rowCount() > 0){
        $select_product = $conn->prepare("UPDATE `cart` set Quantity = ? WHERE Customer_id = ?");
        $select_product->execute([$row['Quantity']+1, $user_id]);
        $message[] = 'Product Already in Cart';
      }
      else{
          $add_product = $conn->prepare("INSERT INTO `cart` (Customer_id, Product_id, Product_name, Category, MRP, Selling_Price, Quantity , Image_01) VALUE (?, ?, ?, ?, ?, ?, ?, ?)");
          $add_product->execute([$user_id, $product_id, $product_name, $category, $price, $offer_price, $stock, $image_01]);
          $message[] = 'Product Added Successfully';
      }
  }
  else{
    echo "<script type='text/javascript'>alert('Please login to continue..');window.location.href='login.php';</script>";
  }
  }

  if(isset($_POST['buy_now'])){
    if(isset($_SESSION['user_id'])){
      $product_id = $_POST['product_id'];
      $product_name = $_POST['product_name'];
      $price = $_POST['price'];
      $offer_price = $_POST['offer_price'];
      $category = $_POST['category'];
      $stock = 1;
      $image_01 = $_POST['image'];
    
      $select_product = $conn->prepare("SELECT * FROM `cart` WHERE Product_id = ? AND Customer_id = ?");
      $select_product->execute([$product_id, $user_id]);
      $row = $select_product->fetch(PDO::FETCH_ASSOC);
    
        if($select_product->rowCount() > 0){
          $select_product = $conn->prepare("UPDATE `cart` set Quantity = ? WHERE Customer_id = ?");
          $select_product->execute([$row['Quantity']+1, $user_id]);
        }
        else{
            $add_product = $conn->prepare("INSERT INTO `cart` (Customer_id, Product_id, Product_name, Category, MRP, Selling_Price, Quantity , Image_01) VALUE (?, ?, ?, ?, ?, ?, ?, ?)");
            $add_product->execute([$user_id, $product_id, $product_name, $category, $price, $offer_price, $stock, $image_01]);
            
            echo "<script type='text/javascript'>alert('Proceed to buy?..');window.location.href='cart.php';</script>";
        }
    }
    else{
      echo "<script type='text/javascript'>alert('Please login to continue..');window.location.href='login.php';</script>";
    }
    }
?>
<?php
function singleProduct($conn){
  $product_id = $_GET['Product_id'];

$select_product = $conn->prepare("SELECT * FROM `products` WHERE Product_id = ?");
$select_product->execute([$product_id]);
if($select_product){
  while($row = $select_product->fetch(PDO::FETCH_ASSOC)){
    if($row['Stock'] > 0){
      $stock = 'In Stock';
    }
    else{
      $stock = 'Out of Stock';
    }
    ?>
    <form method="post">
                        <input type="hidden" name="product_id" value="<?= $row['Product_id']; ?>">
                        <input type="hidden" name="product_name" value="<?= $row['Product_Name']; ?>">
                        <input type="hidden" name="category" value="<?= $row['Category']; ?>">
                        <input type="hidden" name="price" value="<?= $row['MRP']; ?>">
                        <input type="hidden" name="offer_price" value="<?= $row['Selling_Price']; ?>">
                        <input type="hidden" name="stock" value="<?= $row['Stock']; ?>">
                        <input type="hidden" name="image" value="<?= $row['Image_01']; ?>">
<div class="container-fluid w-80">
<div style="width:100%;">
  <img class="" src="productImage/<?= $row['Image_01'];?>" alt="productimage" >
</div>
  <div class="card-body">
    <h1 class="card-title" style="text-transform:capitalize;"><?= $row['Product_Name'];?></h1>
    <h3 class="card-title" style="text-transform:capitalize;">Rs. <?= $row['Selling_Price'];?>.00/-</h3>
    <h6 class="card-title text-danger">Rs. <s><?= $row['MRP'];?>.00/</s></h6>
    <h6 class="card-title text-success"><?= $stock;?></h6>
    <p class="card-title">Category: <?= $row['Category'];?></p>
    <h4 class="card-text w-75"><u>Nutrient Value & Benefits of <?= $row['Product_Name'];?></u></h4>
    <p class="card-text"><?= $row['Description'];?></p>
    <input type="submit" name="add_to_cart" value="Add to Cart" class="btn btn-outline-dark">
    <input type="submit" name="buy_now" value="Buy Now" class="btn btn-dark">
  </div>
</div>
</form>
<?php
  }
} 
}

function categoryWise($conn){
  $product_category = $_GET['Product_Category'];
  ?>
  <div class="container-fluid" id="c-vegetables">
<h2 class="text-center" style="color: grey;"><?= $product_category;?></h2>
<hr class="mt-2 mb-3"  style="width:30%; margin:auto; border: 1px solid black">
        <!-- Card sizing using grid markup -->
        <div class="row mb-4 justify-content-center">
        <?php
         $select_product = $conn->prepare("SELECT * FROM `products` WHERE Category = ?");
         $select_product->execute([$product_category]);
         if($select_product->rowCount() > 0){
          while($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)){
            $offer = 100 - (($fetch_product['Selling_Price']) / $fetch_product['MRP'] * 100) ;
            $newname = mb_strimwidth($fetch_product['Product_Name'], 0, 15, '');
            if($fetch_product['Stock'] > 0){
              $stock = 'In Stock';
            }
            else{
              $stock = 'Out of Stock';
            }
            ?>
            <div class="col-sm-2">
                <div class="card-fluid mb-5">
                    <div class="card-body shadow">
                      <form method="post">
                        <input type="hidden" name="product_id" value="<?= $fetch_product['Product_id']; ?>">
                        <input type="hidden" name="product_name" value="<?= $fetch_product['Product_Name']; ?>">
                        <input type="hidden" name="category" value="<?= $fetch_product['Category']; ?>">
                        <input type="hidden" name="price" value="<?= $fetch_product['MRP']; ?>">
                        <input type="hidden" name="offer_price" value="<?= $fetch_product['Selling_Price']; ?>">
                        <input type="hidden" name="stock" value="<?= $fetch_product['Stock']; ?>">
                        <input type="hidden" name="image" value="<?= $fetch_product['Image_01']; ?>">
                        <a href="productpage.php?Product_id=<?= $fetch_product['Product_id'];?>"><img class="card-img-top img-fluid" src="productImage/<?= $fetch_product['Image_01'];?>" width="612px" height="150px" alt="Product Image"></a>
                        <h6 class="card-title" style="text-transform: capitalize"><?= $fetch_product['Product_Name'];?></h6>
                        <p class="card-text mb-0"><s class="text-muted" style="font-size:12px;">Rs.<?= $fetch_product['MRP'];?>/ </s> <b style="color:red; font-size:12px;"><?= intval($offer);?>% Off</b></p>
                        <h6 class="card-title">Rs. <?= $fetch_product['Selling_Price'];?>/- <b class="card-title" style="color:green; font-size: 12px;"><?=$stock;?></b></h6>
                        <button type="submit" name="add_to_cart" class="btn btn-dark"><i class="fa fa-shopping-cart" style="padding-right:5px;"></i>Add Cart</button>
                      </form>
                      </div>
                </div>
            </div>
            <?php
            }
          }
           ?>
        </div>
</div>
<?php
}
?>

<?php
   if(isset($message)){
      foreach($message as $message){
         echo "<script type='text/javascript'>alert('$message');</script>";
      }
   }
?>

<?php include 'footer.php'; ?>
<?php include 'header.php'; ?>
<?php

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}
elseif(isset($_SESSION['admin_id'])){

}
else{
    $user_id = ' ';
}
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
    header('Location:login.php');
  }
}
?>
<div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block mx-auto mt-3 w-75" src="sources/banner1.jpg" alt="First slide" height="300px" style="object-fit:cover; margin-top:5px; margin-bottom:5px;">
    </div>
    <div class="carousel-item">
      <img class="d-block mx-auto mt-3 w-75" src="sources/banner3.jpg" alt="First slide" height="300px" style="object-fit:cover; margin-top:5px; margin-bottom:5px;">
    </div>
    <div class="carousel-item">
      <img class="d-block mx-auto mt-3 w-75" src="sources/banner4.webp" alt="First slide" height="300px" style="object-fit:cover; margin-top:5px; margin-bottom:5px;">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<hr class="mt-4 mb-2"  style="width:40%; margin:auto; border: 1px solid black">
<div class="container-fluid" id="latest-products">
<h2 class="text-center" style="color: grey;">Latest Products</h2>
<hr class="mt-2 mb-3"  style="width:30%; margin:auto; border: 1px solid black">
        <!-- Card sizing using grid markup -->
        <div class="row mb-4 justify-content-center">
        <?php
         $select_product = $conn->prepare("SELECT * FROM `products` order by rand() LIMIT 5");
         $select_product->execute();
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
                <div class="card">
                    <div class="card-body shadow">
                      <form method="post">
                        <input type="hidden" name="product_id" value="<?= $fetch_product['Product_id']; ?>">
                        <input type="hidden" name="product_name" value="<?= $fetch_product['Product_Name']; ?>">
                        <input type="hidden" name="category" value="<?= $fetch_product['Category']; ?>">
                        <input type="hidden" name="price" value="<?= $fetch_product['MRP']; ?>">
                        <input type="hidden" name="offer_price" value="<?= $fetch_product['Selling_Price']; ?>">
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

<hr class="mt-4 mb-2"  style="width:40%; margin:auto; border: 1px solid black">
<div class="container-fluid" id="c-vegetables">
<h2 class="text-center" style="color: grey;">Vegetables</h2>
<hr class="mt-2 mb-3"  style="width:30%; margin:auto; border: 1px solid black">
        <!-- Card sizing using grid markup -->
        <div class="row mb-4 justify-content-center">
        <?php
         $select_product = $conn->prepare("SELECT * FROM `products` WHERE Category = 'Vegetables' order by rand() LIMIT 5");
         $select_product->execute();
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
                <div class="card">
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

<hr class="mt-4 mb-2"  style="width:40%; margin:auto; border: 1px solid black">
<div class="container-fluid" id="c-fruits">
<h2 class="text-center" style="color: grey;">Fruits</h2>
<hr class="mt-2 mb-3"  style="width:30%; margin:auto; border: 1px solid black">
        <!-- Card sizing using grid markup -->
        <div class="row mb-4 justify-content-center">
        <?php
         $select_product = $conn->prepare("SELECT * FROM `products` WHERE Category = 'Fruits' order by rand()   LIMIT 5");
         $select_product->execute();
         if($select_product->rowCount() > 0){
          while($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)){
            $offer = 100- (($fetch_product['Selling_Price']) / $fetch_product['MRP'] * 100) ;
            $newname = mb_strimwidth($fetch_product['Product_Name'], 0, 15, '');
            if($fetch_product['Stock'] > 0){
              $stock = 'In Stock';
            }
            else{
              $stock = 'Out of Stock';
            }
            ?>
            <div class="col-sm-2">
                <div class="card-fluid">
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
   if(isset($message)){
      foreach($message as $message){
         echo "<script type='text/javascript'>alert('$message');</script>";
      }
   }
?>

<?php include 'footer.php'; ?>
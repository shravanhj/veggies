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
if(isset($_POST['add'])){
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $price = $_POST['product_price'];
    $offer_price = $_POST['offer_price'];
    $category = $_POST['category'];
    $stock = $_POST['stock'];
    $description = $_POST['description'];
    $image_01 = $_FILES['image']['name'];

    $select_product = $conn->prepare("SELECT * FROM `products` WHERE Product_id = ?");
    $select_product->execute([$product_id]);
    $row = $select_product->fetch(PDO::FETCH_ASSOC);

    if($select_product->rowCount() > 0){
        $message[] = 'Product already exist with this ID';
    }
    elseif(($offer_price > $price)){
        $message[] = 'Offer price must be lesser than original price!';
        }
    else{
        if( $_FILES['image']['name'] != "" ) {
            $path=$_FILES['image']['name'];
            $pathto="../productImage/".$path;
            move_uploaded_file( $_FILES['image']['tmp_name'],$pathto) or die( "Could not copy file!");
        }
        else {
            die("No file specified!");
        }
        $add_product = $conn->prepare("INSERT INTO `products` (Product_id, Product_name, Category, Selling_Price, MRP, Description, Stock, Image_01, Seller) VALUE (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $add_product->execute([$product_id, $product_name, $category, $offer_price, $price, $description, $stock, $image_01, $admin_id]);
        $message[] = 'Product Added Successfully';
    }
}

?>

<div class="container">
        <div class=" text-center mt-4 ">
            <h2>Add New Product</h2> 
        </div>
    <div class="row">
      <div class="col-lg-5 mx-auto">
        <div class="card mt-2 mx-auto p-4">
            <div class="card-body">
            <div class = "container">
                <form action="" method="post" enctype="multipart/form-data">
                <div class="controls">
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
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Product ID</label>
                            <input type="text" name="product_id" class="form-control p-1 shadow-sm bg-white rounded shadow-sm bg-white rounded" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Product Name</label>
                            <input type="text" name="product_name" class="form-control p-1 shadow-sm bg-white rounded" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Price (M.R.P)</label>
                            <input type="text" name="product_price" class="form-control p-1 shadow-sm bg-white rounded" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Offer Price</label>
                            <input type="text" name="offer_price" class="form-control p-1 shadow-sm bg-white rounded" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Category</label>
                            <select name="category" class="form-select form-select-sm p-1 shadow-sm bg-white rounded" required>
                                <option selected disabled>--Select--</option>
                                <option>Vegetables</option>
                                <option>Fruits</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="form_need">No. of Stock</label>
                            <input type="text" name="stock" class="form-control p-1 shadow-sm bg-white rounded" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label>Product Short Description</label>
                            <textarea name="description" class="form-control form-control p-1 shadow-sm bg-white rounded" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="col">
                        <div class="form-group mb-3">
                            <label for="form_need">Product Image</label>
                            <input type="file" name="image" class="form-control p-1 shadow-sm bg-white rounded" required>
                        </div>
                    </div>
                    <div class="col-md-12"> 
                        <input type="submit" name="add" class="btn btn-dark block" value="Add Product" >
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
</div>
</div>
</div>

<?php include 'footer.php'; ?>
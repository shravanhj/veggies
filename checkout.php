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

?>
<?php
$select_address = $conn->prepare("SELECT * FROM `customers`  WHERE Customer_id = ?");
$select_address->execute([$user_id]);
$row = $select_address->fetch(PDO::FETCH_ASSOC);
if(isset($_POST['save'])){
    $address1 = $_POST['address_line_1'];
    $address2 = $_POST['address_line_2'];
    $area = $_POST['area'];
    $city = $_POST['city'];
    $pincode = $_POST['pincode'];
    $state = $_POST['state'];
    $country = $_POST['country'];

    if(isset($_POST['default']))
    {
        $insert_address = $conn->prepare("UPDATE `customers` SET Address_line_1 = ?, Address_line_2 = ?, Area =?, City = ?, Pincode = ?, State = ?, Country = ? WHERE Customer_id = ?");
        $insert_address->execute([$address1, $address2, $area, $city, $pincode, $state, $country, $user_id]);
    }

    $insert_address = $conn->prepare("INSERT INTO `addresses` (Customer_id, Address_line_1, Address_line_2, Area, City, Pincode, State, Country) VALUE (?, ?, ?, ?, ?, ?, ?, ?)");
    $insert_address->execute([$user_id, $address1, $address2, $area, $city, $pincode, $state, $country]);
    $message[] = 'Address saved';
}

if(isset($_POST['place_order'])){
    $select_product = $conn->prepare("SELECT * FROM `cart` WHERE Customer_id = ?");
    $select_product->execute([$user_id]);
    if($select_product->rowCount() > 0){
        while($row = $select_product->fetch(PDO::FETCH_ASSOC)){
            $product_id = $row['Product_id'];
            $product_name = $row['Product_Name'];
            $quantity = $row['Quantity'];
            $price = $row['Selling_Price'] * $row['Quantity'];
            $image = $row['Image_01'];
            $address1 = $_POST['address_line_1'];
            $address2 = $_POST['address_line_2'];
            $area = $_POST['area'];
            $city = $_POST['city'];
            $pincode = $_POST['pincode'];
            $state = $_POST['state'];
            $country = $_POST['country'];
            if(isset($_POST['default']))
            {
                $insert_address = $conn->prepare("UPDATE `customers` SET Address_line_1 = ?, Address_line_2 = ?, Area =?, City = ?, Pincode = ?, State = ?, Country = ? WHERE Customer_id = ?");
                $insert_address->execute([$address1, $address2, $area, $city, $pincode, $state, $country, $user_id]);
            }

            $insert_order = $conn->prepare("INSERT INTO `orders` (Product_id, Image_01, Customer_id, Product_Name, Quantity, Total_Price, Address_line_1, Address_line_2, Area, City, Pincode, State, Country) VALUE (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $insert_order->execute([$product_id, $image, $user_id, $product_name, $quantity, $price, $address1, $address2, $area, $city, $pincode, $state, $country]);
            if($insert_order){
                $delete_order = $conn->prepare("DELETE FROM `cart` WHERE Customer_id = ?");
                $delete_order->execute([$user_id]);
                header('Location:thankyou.php');
            }
        }
    }
}
?>

<div class="container">
        <div class=" text-center mt-4 ">
            <h2>Shipping Address</h2> 
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
                            <label>Address Line 1</label>
                            <input type="text" name="address_line_1" value="<?= $row['Address_line_1'];?>" class="form-control p-1 shadow-sm bg-white rounded shadow-sm bg-white rounded" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Address Line 2</label>
                            <input type="text" name="address_line_2" value="<?= $row['Address_line_2'];?>" class="form-control p-1 shadow-sm bg-white rounded">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Area</label>
                            <input type="text" name="area" value="<?= $row['Area'];?>" class="form-control p-1 shadow-sm bg-white rounded" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>City</label>
                            <input type="text" name="city" value="<?= $row['City'];?>" class="form-control p-1 shadow-sm bg-white rounded" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Pincode</label>
                            <input type="text" name="pincode" value="<?= $row['Pincode'];?>" class="form-control p-1 shadow-sm bg-white rounded" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>State</label>
                            <select name="state" class="form-select form-select-sm p-1 shadow-sm bg-white rounded" required>
                                <option selected>KARNATKA</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Country</label>
                            <select name="country" class="form-select form-select-sm p-1 shadow-sm bg-white rounded" required>
                                <option selected>INDIA</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Payment Type</label>
                            <select name="payment" class="form-select form-select-sm p-1 shadow-sm bg-white rounded" required>
                                <option selected>--Select--</option>
                                <option>Pay on Delivery</option>
                                <option>UPI</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mb-2 form-check">
                    <input type="checkbox" name="default" class="form-check-input" id="Check1">
                    <label class="form-check-label">Make this Default Address</label>
                </div>
                    <div class="col-md-12"> 
                        <input type="submit" name="save" class="btn btn-success block" value="Save" >
                        <input type="submit" name="place_order" class="btn btn-dark block" value="Place Order" >
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
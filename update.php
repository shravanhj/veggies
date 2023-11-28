<?php include 'header.php'; ?>

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

$select_user = $conn->prepare("SELECT * FROM `customers` WHERE Customer_id = ?");
$select_user->execute([$user_id]);
$row = $select_user->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['update_name'])){
    $name = $_POST['fullname'];

    $update_qty = $conn->prepare("UPDATE `customers` SET Name = ? WHERE Customer_id = ?");
    $update_qty->execute([$name, $user_id]);
    header("Refresh:0");
}

if(isset($_POST['update_email'])){
    $email = $_POST['email'];

    $update_qty = $conn->prepare("UPDATE `customers` SET Email = ? WHERE Customer_id = ?");
    $update_qty->execute([$email, $user_id]);
    header("Refresh:0");
}
if(isset($_POST['update_phone'])){
    $phone_no = $_POST['phonenumber'];

    $update_qty = $conn->prepare("UPDATE `customers` SET Phone = ? WHERE Customer_id = ?");
    $update_qty->execute([$phone_no, $user_id]);
    $message[] = 'Address saved';
    header("Refresh:0");
}

if(isset($_POST['save'])){
    $address1 = $_POST['address_line_1'];
    $address2 = $_POST['address_line_2'];
    $area = $_POST['area'];
    $city = $_POST['city'];
    $pincode = $_POST['pincode'];
    $state = $_POST['state'];
    $country = $_POST['country'];


        $insert_address = $conn->prepare("UPDATE `customers` SET Address_line_1 = ?, Address_line_2 = ?, Area =?, City = ?, Pincode = ?, State = ?, Country = ? WHERE Customer_id = ?");
        $insert_address->execute([$address1, $address2, $area, $city, $pincode, $state, $country, $user_id]);

    $insert_address = $conn->prepare("INSERT INTO `addresses` (Customer_id, Address_line_1, Address_line_2, Area, City, Pincode, State, Country) VALUE (?, ?, ?, ?, ?, ?, ?, ?)");
    $insert_address->execute([$user_id, $address1, $address2, $area, $city, $pincode, $state, $country]);
    
    header("Refresh:0");
}
?>

<div class="container">
        <div class=" text-center mt-4 ">
            <h2>Update Profile</h2> 
        </div>
    <div class="row">
      <div class="col-lg-6 mx-auto">
        <div class="card mt-0 mx-auto p-1">
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
                    <div class="col-md-10">
                        <div class="form-group  mb-3">
                            <label class="col-md-3 p-1">User ID :</label>
                            <input type="text" name="user_id" value="<?= $row['Customer_id']; ?>" class="form-control p-1  shadow-sm bg-white rounded shadow-sm bg-white rounded" disabled>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group  mb-3">
                            <label class="col-md-3 p-1">Full Name : </label>
                            <div class="d-flex">
                            <input type="text" name="fullname" placeholder="<?= $row['Name'] ;?>"  class="form-control p-1 shadow-sm bg-white rounded">
                            <button type="submit" name="update_name" class="btn block p-0" value="Update Email"><i class="fa fa-check"></i></button>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group mb-3">
                            <label class="col-md-3 p-1">Email : </label>
                            <div class="d-flex">
                                <input type="email" name="email" placeholder="<?= $row['Email'] ;?>" class="form-control p-1  shadow-sm bg-white rounded">
                                <button type="submit" name="update_email" class="btn block p-1" value="Update Email"><i class="fa fa-check"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group mb-3">
                            <label class="col-md-3 p-1">Phone :</label>
                            <div class="d-flex">
                            <input type="tel" name="phonenumber" placeholder="<?= $row['Phone'] ;?>" class="form-control p-1 mb-2 shadow-sm bg-white rounded">
                            <button type="submit" name="update_phone" class="btn block p-1" value="Update Email"><i class="fa fa-check"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group d-flex mb-3">
                            <a href="changepassword.php?Customer_id=<?= $row['Customer_id'] ;?>" class="link" value="Update Email">Click here to Change Password</a>
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


<div class="container">
        <div class=" text-center mt-4" id="update-address">
            <h2>Update Default Address</h2> 
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
                    <div class="col-md-12"> 
                        <input type="submit" name="save" class="btn btn-success block" value="Save" >
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
<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
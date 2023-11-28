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
    $customer_id = $_POST['customer_id'];
    $delete_Customer = $conn->prepare("DELETE FROM `customers` WHERE Customer_id = ?");
    $delete_Customer->execute([$customer_id]);
    echo "<script type='text/javascript'>alert('Customers Deleted Successfully');window.location.href='../index.php';</script>";
  }
?>

<div class="container mt-5">
    <h4>Registered Users List : </h4>
<table class="table w-50 mx-auto table-striped">
  <thead>
    <tr>
      <th scope="col">User ID</th>
      <th scope="col">Name</th>
      <th scope="col">Phone Number</th>
      <th scope="col">Email</th>
      <th scope="col">Delete</th>
    </tr>
  </thead>
  <tbody>
  <?php
$select_Customer = $conn->prepare("SELECT * FROM `customers`");
$select_Customer->execute();
    if($select_Customer->rowCount() > 0){
        while($row = $select_Customer->fetch(PDO::FETCH_ASSOC)){
    ?>
    <tr>
    <form method="post">
      <input type="hidden" name="customer_id" value="<?= $row['Customer_id'];?>">
      <td><?= $row['Customer_id'];?></td>
      <td><?= $row['Name'];?></td>
      <td><?= $row['Phone'];?></td>
      <td><?= $row['Email'];?></td>
      <td><input type="submit" name="delete" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this?');" value="Delete"></td>
    </form>
    </tr>
    <?php
   }
   
}
else{
    echo "<script type='text/javascript'>alert('No Customers Exist');window.location.href='../index.php';</script>";
   }
?>
  </tbody>
</table>
</div>

<?php include 'footer.php'; ?>
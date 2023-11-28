<?php include 'header.php'; ?>
<?php
include 'database/dbconn.php';
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}
elseif(isset($_SESSION['user_id'])){
    header('location:index.php');
}
else{
    $user_id = '';
    header('location:error.php');
}

$select_order = $conn->prepare("SELECT * FROM `orders` WHERE Customer_id = ?");
$select_order->execute([$user_id]);
if($select_order->rowCount() > 0){
    while($row = $select_order->fetch(PDO::FETCH_ASSOC)){
        $select_date = $row['order_time'];
    $date=date_create($select_date);
    date_add($date,date_interval_create_from_date_string("7 days"));
    $delivery_date = date_format($date,"l jS F");
    }
}
?>

<div class=" d-flex justify-content-center mt-5">
            <div>
                <div class="mb-4 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="text-success" width="75" height="75"
                        fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                    </svg>
                </div>
                <div class="text-center">
                    <h1>Order Placed</h1>
                    <p>Thank you for Shopping with us. Team VEGGIES</p>
                    <p>You Item will delivered on : <?=$delivery_date;?></p>
                    <a href="index.php" class="btn btn-dark">Continue Shopping</a>
                </div>
            </div>
</div>

<?php include 'footer.php'; ?>
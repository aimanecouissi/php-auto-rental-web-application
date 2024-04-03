<?php
session_start();
require 'partials/connection.php';
require 'partials/functions.php';
if (isset($_SESSION['admin'])) {
    header('Location:add_car.php');
    exit;
}
if (!isset($_SESSION['renter'])) {
    header('Location:index.php');
    exit;
}
if (!isset($_SESSION['booking'])) {
    header('Location:cars?page=1');
    exit;
}
$query = 'SELECT manufacturer.*, model.* FROM manufacturer, model WHERE manufacturer.id = model.manufacturer AND model.id = ' . $_SESSION['booking'][0];
$result = mysqli_query($con, $query);
$row = mysqli_fetch_array($result);
$query = "INSERT INTO booking (renter, model, payment_date, `start_date`, end_date, duration, total_price) VALUES (" . $_SESSION['renter'] . ", " . $_SESSION['booking'][0] . ", '" .  date("Y-m-d") . "', '" . $_SESSION['booking'][1] . "', '" . $_SESSION['booking'][2] . "', " . $_SESSION['booking'][3] . ", " . $_SESSION['booking'][4] . ")";
mysqli_query($con, $query);
$query = 'SELECT * FROM booking ORDER BY id DESC LIMIT 1';
$result = mysqli_query($con, $query);
$receipt = mysqli_fetch_array($result);
unset($_SESSION['booking']);
mysqli_close($con);
require 'partials/navbars/navbar_renter.php';
?>
<div class="min-vh-100 d-flex align-items-center justify-content-center pt bg-hero">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="col-12 text-center">
                <h1 class="fw-bold display-1 text-primary"><i class="fa-solid fa-circle-check"></i></h1>
                <h1 class="fw-bold display-1 text-uppercase text-primary">Thank You</h1>
                <p class="lead text-uppercase fw-semibold p-0 m-0">Your rent for the <span class="fw-bold"><?php echo $row[1] . ' ' . $row[5]; ?></span> was completed successfully</p>
            </div>
            <div class="col-12 text-center">
                <a href="receipt?receipt=<?php echo $receipt[0]; ?>" target="_blank" class="btn btn-primary rounded-3 btn-lg px-4 fw-semibold me-2 text-uppercase"><i class="fa-solid fa-arrow-down me-2"></i>Receipt</a>
                <a href="cars?page=1" class="btn btn-outline-primary rounded-3 btn-lg px-4 fw-semibold text-uppercase"><i class="fa-solid fa-arrow-right me-2"></i>Rent More</a>
            </div>
        </div>
    </div>
</div>
<?php require 'partials/footer.php'; ?>
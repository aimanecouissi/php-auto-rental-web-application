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
if (!isset($_GET['car'])) {
    header('Location:cars?page=1');
    exit;
}
$query = 'SELECT manufacturer.*, model.* FROM manufacturer, model WHERE manufacturer.id = model.manufacturer AND model.id = ' . $_GET['car'];
$result = mysqli_query($con, $query);
if (!$result) {
    header('Location:cars?page=1');
    exit;
}
else {
    $row = mysqli_fetch_array($result);
    $_SESSION['car'] = $row[3];
}
mysqli_close($con);
require 'partials/navbars/navbar_renter.php';
?>
<div class="min-vh-100 d-flex align-items-center pt bg-hero">
    <div class="container">
        <div class="row my-5">
            <div class="col-12 text-center">
                <h3 class="fw-semibold display-6 text-uppercase text-primary">Booking</h3>
                <p class="lead text-uppercase fw-normal p-0 m-0">Please, select the start and the end date of your rent</p>
            </div>
        </div>  
        <div class="row justify-content-center mb-5">
            <div class="col-lg-5">
                <div class="bg-white rounded-3 shadow-sm">
                    <div class="card-custom-img overflow-hidden rounded-3">
                        <img src="<?php echo $row[4]; ?>" alt="car image" class="img-fluid rounded-3">
                    </div>
                    <div class="p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <img src="<?php echo $row[2]; ?>" alt="car logo" height="50" class="me-3">
                                <div>
                                    <h5 class="fw-semibold my-0"><?php echo $row[1]; ?></h5>
                                    <h6 class="my-0"><?php echo $row[5]; ?></h6>
                                </div>
                            </div>
                            <span class="fw-semibold">$<span id="price"><?php echo $row[6]; ?></span>/DAY</span>
                        </div>
                    </div>
                    <div class="bg-light border p-4 rounded-3">
                        <form action="checkout" method="post" autocomplete="off">
                            <div class="row g-3 mb-3">
                                <div class="col-sm-6">
                                    <label for="start_date" class="form-label">Start date</label>
                                    <input type="date" id="start_date" name="start_date" class="form-control rounded-3" onchange="calculate_price();" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="end_date" class="form-label">End date</label>
                                    <input type="date" id="end_date" name="end_date" class="form-control rounded-3" onchange="calculate_price();" required>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5 text-center">
                                    <span class="fw-semibold">Duration</span>
                                </div>
                                <div class="col-2 text-center">
                                    <span class="text-primary"><i class="fa-solid fa-angle-right"></i></span>
                                </div>
                                <div class="col-5 text-center">
                                    <span class="fw-semibold"><span id="duration">1</span> Day</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-5 text-center">
                                    <span class="fw-semibold">Total Price</span>
                                </div>
                                <div class="col-2 text-center">
                                    <span class="text-primary"><i class="fa-solid fa-angle-right"></i></span>
                                </div>
                                <div class="col-5 text-center">
                                    <span class="fw-semibold">$<span id="total_price"><?php echo $row[6]; ?></span></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-grid">
                                        <input type="submit" name="proceed" value="Proceed to Checkout" class="text-uppercase rounded-3 btn btn-primary fw-semibold py-2">
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
<?php require 'partials/footer.php'; ?>
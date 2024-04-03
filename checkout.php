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
if (!isset($_SESSION['car'])) {
    header('Location:cars?page=1');
    exit;
}
$name = $number = $mm = $yy = $cvv = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['start_date']) && !empty($_POST['start_date']) && isset($_POST['end_date']) && !empty($_POST['end_date'])) {
        $start_date = htmlspecialchars($_POST['start_date']);
        $end_date = htmlspecialchars($_POST['end_date']);
        $query = 'SELECT manufacturer.*, model.* FROM manufacturer, model WHERE manufacturer.id = model.manufacturer AND model.id = ' . $_SESSION['car'];
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_array($result);
        $price = $row[6];
        $startdate = strtotime($start_date);
        $enddate = strtotime($end_date);
        $duration = ($enddate - $startdate) / 60 / 60 / 24;
        $total_price = $price * $duration;
        $_SESSION['booking'] = array($_SESSION['car'], $start_date, $end_date, $duration, $total_price);
        unset($_SESSION['car']);
        $query = "SELECT * FROM card WHERE renter = " . $_SESSION['renter'];
        $result = mysqli_query($con, $query);
        if (mysqli_num_rows($result) != 0) {
            $card = mysqli_fetch_array($result);
            $name = $card[1];
            $number = $card[2];
            $mm = $card[3];
            if ($mm < 10) {
                $mm = '0' . $mm;
            }
            $yy = $card[4];
            if ($yy < 10) {
                $yy = '0' . $yy;
            }
            $cvv = $card[5];
        }
    }
}
else
    echo '<script>history.back();</script>';
mysqli_close($con);
require 'partials/navbars/navbar_renter.php';
?>
<div class="loader d-flex align-items-center justify-content-center position-fixed top-0 start-0 d-none">
    <div class="spinner"></div>
</div>
<div class="min-vh-100 d-flex align-items-center pt bg-hero">
    <div class="container">
        <div class="row my-5">
            <div class="col-12 text-center">
                <h3 class="fw-semibold display-6 text-uppercase text-primary">Checkout</h3>
                <p class="lead text-uppercase fw-normal m-0 p-0">Currently, we accept only payment by credit cards</p>
            </div>
        </div>  
        <div class="row justify-content-center mb-5">
            <div class="col-lg-5">
                <div class="bg-white shadow-sm p-4 rounded-3">
                    <div class="row g-2 mb-4 border-bottom-dashed">
                        <div class="col-5">
                            <span class="h5">Total</span>
                        </div>
                        <div class="col-2 text-center">
                            <span class="text-primary"><i class="fa-solid fa-angle-right"></i></span>
                        </div>
                        <div class="col-5 text-end">
                            <span class="fw-semibold h5">$<?php echo $total_price; ?></span>
                        </div>
                    </div>
                    <form action="thank_you" method="post" onsubmit="load_submit(event)" autocomplete="off">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="position-relative">
                                    <input type="text" maxlength="50" value="<?php echo $name; ?>" id="name" name="name" class="form-control form-control-lg rounded-3" placeholder="Name on card" required>
                                    <div class="position-absolute top-0 start-0 form-icon text-secondary">
                                        <i class="bi bi-type"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="position-relative">
                                    <input type="number" value="<?php echo $number; ?>" id="number" name="number" minlength="16" maxlength="16" class="form-control form-control-lg rounded-3" placeholder="Card number" required>
                                    <div class="position-absolute top-0 start-0 form-icon text-secondary">
                                        <i class="bi bi-credit-card-2-front"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="position-relative">
                                    <input type="number" value="<?php echo $mm; ?>" id="mm" name="mm" min="1" max="12" class="form-control form-control-lg rounded-3" placeholder="MM" required>
                                    <div class="position-absolute top-0 start-0 form-icon text-secondary">
                                        <i class="bi bi-credit-card"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="position-relative">
                                    <input type="number" value="<?php echo $yy; ?>" id="yy" name="yy" class="form-control form-control-lg rounded-3" placeholder="YY" required>
                                    <div class="position-absolute top-0 start-0 form-icon text-secondary">
                                        <i class="bi bi-credit-card"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="position-relative">
                                    <input type="number" value="<?php echo $cvv; ?>" id="cvv" name="cvv" max="999" class="form-control form-control-lg rounded-3" placeholder="CVV" required>
                                    <div class="position-absolute top-0 start-0 form-icon text-secondary">
                                        <i class="bi bi-credit-card-2-back"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid">
                                <input type="submit" name="pay" value="Pay" class="text-uppercase fw-semibold btn btn-primary btn-lg rounded-3">
                            </div>
                            <div class="col-12 text-center">
                                <img src="assets/img/credit_cards.png" alt="" class="img-fluid" width="200">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'partials/footer.php'; ?>
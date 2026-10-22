<?php
session_start();
require 'partials/connection.php';
require 'partials/functions.php';
if (isset($_SESSION['admin'])) {
    header('Location:add_car.php');
    exit;
}
if (isset($_SESSION['renter'])) {
    header('Location:index.php');
    exit;
}
if (!isset($_SESSION['forgotten'])) {
    header('Location:forgotten_password.php');
    exit;
}
$alert = alert('primary', 'A verification code was sent to your email: ' . $_SESSION['forgotten']);
$code = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['code']) && !empty($_POST['code'])) {
        $code = filter_var($_POST['code'], FILTER_SANITIZE_NUMBER_INT);
        if (!filter_var($code, FILTER_VALIDATE_INT))
            $alert = alert('danger', 'Please, do not play with the inputs');
        else {
            $query = "SELECT verification_code FROM renter WHERE email = '" . $_SESSION['forgotten'] . "'";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_array($result);
            if ($row[0] != $code)
                $alert = alert('warning', 'Wrong verification code');
            else {
                $_SESSION['reset'] = true;
                header('Location:reset_password.php');
                exit;
            }
        }
    }
}
mysqli_close($con);
require 'partials/navbars/navbar_offline.php';
?>
<div class="min-vh-100 d-flex align-items-center rounded-3 ptb bg-hero">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-7 col-lg-5">
                <div class="bg-white p-5 rounded-3 shadow-sm">
                    <h1 class="my-0 py-0 text-center fw-bold">Aimane<span>Cars</span></h1>
                    <p class="text-uppercase mb-4 mt-0 py-0 text-center fw-bold">— Verification Code —</p>
                    <form method="post" autocomplete="off">
                        <?php echo $alert; ?>
                        <div class="position-relative">
                            <input type="number" name="code" min="100000" max="999999" value="<?php echo $code; ?>" placeholder="Enter the verification code here" class="border-0 border-bottom border-2 rounded-0 form-control form-control-lg mb-3" required>
                            <div class="position-absolute top-0 start-0 form-icon text-secondary">
                                <i class="bi bi-key"></i>
                            </div>
                        </div>
                        <div class="d-grid">
                            <input type="submit" value="Verify" class="btn btn-primary btn-lg fw-semibold rounded-3 text-uppercase">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'partials/footer.php'; ?>
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
$alert = $password = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['password']) && !empty($_POST['password'])) {
        $password = $_POST['password'];
        $query = "SELECT * FROM admin WHERE password = '$password'";
        $result = mysqli_query($con, $query);
        if (mysqli_num_rows($result) == 0)
            $alert = alert('danger', 'Incorrect password');
        else {
            $_SESSION['admin'] = true;
            header('Location:add_car.php');
            exit;
        }
    }
}
mysqli_close($con);
require 'partials/head.php';
?>
<div class="min-vh-100 bg-hero-dark d-flex align-items-center">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-7 col-lg-5">
                <div class="bg-dark text-white p-5 rounded-3 shadow-sm border border-2">
                    <h1 class="my-0 py-0 text-center fw-bold">Aimane<span>Cars</span></h1>
                    <p class="text-uppercase mb-4 mt-0 py-0 text-center fw-bold">— Admin —</p>
                    <form method="post" action="admin" autocomplete="off">
                        <?php echo $alert; ?>
                        <div class="position-relative">
                            <input type="password" name="password" maxlength="50" value="<?php echo $password; ?>" placeholder="Password" class="border-0 border-bottom border-2 rounded-0 form-control form-control-lg mb-3" required>
                            <div class="position-absolute top-0 start-0 form-icon text-light">
                                <i class="bi bi-lock"></i>
                            </div>
                        </div>
                        <div class="d-grid">
                            <input type="submit" value="Login" class="btn btn-primary btn-lg fw-semibold rounded-3 text-uppercase">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
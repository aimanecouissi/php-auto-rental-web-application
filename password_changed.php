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
if (!isset($_SESSION['changed'])) {
    header('Location:forgotten_password.php');
    exit;
}
unset($_SESSION['changed']);
require 'partials/navbars/navbar_offline.php';
?>
<div class="min-vh-100 d-flex align-items-center rounded-3 ptb bg-hero">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-7 col-lg-5">
                <div class="bg-white p-5 rounded-3 shadow-sm">
                    <h1 class="my-0 py-0 text-center fw-bold">Aimane<span>Cars</span></h1>
                    <p class="text-uppercase mb-4 mt-0 py-0 text-center fw-bold">— Password Changed —</p>
                    <div class="alert alert-success mb-3 text-center fw-semibold">
                        You password has been reset successfully. You can now login to your account with the new password.
                    </div>
                    <div class="d-grid">
                        <a href="login" class="btn btn-primary btn-lg fw-semibold rounded-3 text-uppercase">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'partials/footer.php'; ?>
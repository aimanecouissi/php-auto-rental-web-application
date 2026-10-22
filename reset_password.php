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
if (!isset($_SESSION['reset'])) {
    header('Location:forgotten_password.php');
    exit;
}
$alert;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['password1']) && isset($_POST['password2']) && !empty($_POST['password1']) && !empty($_POST['password2'])) {
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];
        if ($password1 != $password2)
            $alert = alert('warning', 'Please enter the same password twice');
        else {
            $password1 = password_hash(htmlspecialchars($_POST['password1']), PASSWORD_DEFAULT);
            $password2 = password_hash(htmlspecialchars($_POST['password2']), PASSWORD_DEFAULT);
            $query = "UPDATE renter SET password = '$password1' WHERE email = '" . $_SESSION['forgotten'] . "'";
            mysqli_query($con, $query);
            unset($_SESSION['verified']);
            unset($_SESSION['forgotten']);
            $_SESSION['changed'] = true;
            header('Location:password_changed.php');
            exit;
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
                    <p class="text-uppercase mb-4 mt-0 py-0 text-center fw-bold">— Reset Password —</p>
                    <form method="post" autocomplete="off">
                        <?php echo $alert; ?>
                        <div class="position-relative">
                            <input type="password" id="password1" minlength="8" maxlength="50" onkeyup="check_strength(this)" name="password1" placeholder="New password" class="border-0 border-bottom border-2 rounded-0 form-control form-control-lg mt-3 mb-1" required>
                            <div class="position-absolute top-0 start-0 form-icon text-secondary">
                                <i class="bi bi-lock"></i>
                            </div>
                        </div>
                        <div id="password_strength1">
                            <div class="row g-1 mt-1">
                                <div class="col-4">
                                    <div class="weak rounded-pill"></div>
                                </div>
                                <div class="col-4">
                                    <div class="medium rounded-pill"></div>
                                </div>
                                <div class="col-4">
                                    <div class="strong rounded-pill"></div>
                                </div>
                            </div>
                        </div>
                        <div class="position-relative">
                            <input type="password" id="password2" minlength="8" maxlength="50" onkeyup="check_strength(this)" name="password2" placeholder="Confirm new password" class="border-0 border-bottom border-2 rounded-0 form-control form-control-lg mt-3 mb-1" required>
                            <div class="position-absolute top-0 start-0 form-icon text-secondary">
                                <i class="bi bi-lock"></i>
                            </div>
                        </div>
                        <div id="password_strength2">
                            <div class="row g-1 mt-1">
                                <div class="col-4">
                                    <div class="weak rounded-pill"></div>
                                </div>
                                <div class="col-4">
                                    <div class="medium rounded-pill"></div>
                                </div>
                                <div class="col-4">
                                    <div class="strong rounded-pill"></div>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid mt-3">
                            <input type="submit" value="Reset" class="btn btn-primary btn-lg fw-semibold rounded-3">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'partials/footer.php'; ?>
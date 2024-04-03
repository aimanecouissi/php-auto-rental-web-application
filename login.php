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
$alert = $email = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email']) && isset($_POST['password']) && !empty($_POST['email']) && !empty($_POST['password'])) {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = htmlspecialchars($_POST['password']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            $alert = alert('danger', 'Please, do not play with the inputs');
        else {
            $query = "SELECT * FROM renter WHERE email = '$email'";
            $result = mysqli_query($con, $query);
            if (mysqli_num_rows($result) == 0)
                $alert = alert('danger', 'Incorrect email');
            else {
                $row = mysqli_fetch_array($result);
                if (!password_verify($password, $row[7]))
                    $alert = alert('danger', 'Incorrect password');
                else {
                    $_SESSION['renter'] = $row[0];
                    $_SESSION['full_name'] = $row[2] . ' ' . $row[3];
                    if (isset($_POST['remember']) && !empty($_POST['remember']) && $_POST['remember'] == true) {
                        setcookie('renter', $_SESSION['renter'], time() + 86400 * 30);
                        setcookie('full_name', $_SESSION['full_name'], time() + 86400 * 30);
                    }
                    header('Location:index.php');
                    exit;
                }
            }
        }
    }
    
}
mysqli_close($con);
require 'partials/navbars/navbar_offline.php';
?>
<div class="min-vh-100 d-flex align-items-center rounded-3 bg-hero pt">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-7 col-lg-5">
                <div class="bg-white p-5 rounded-3 shadow-sm">
                    <h1 class="my-0 py-0 text-center fw-bold">Aimane<span>Cars</span></h1>
                    <p class="text-uppercase mb-4 mt-0 py-0 text-center fw-bold">— Login —</p>
                    <form method="post" action="login" autocomplete="off">
                        <?php echo $alert; ?>
                        <div class="position-relative">
                            <input type="email" maxlength="50" value="<?php echo $email; ?>" name="email" placeholder="Email" class="border-0 border-bottom border-2 rounded-0 form-control form-control-lg mb-3" required >
                            <div class="position-absolute top-0 start-0 form-icon text-secondary">
                                <i class="bi bi-envelope"></i>
                            </div>
                        </div>
                        <div class="position-relative">
                            <input type="password" maxlength="50" name="password" placeholder="Password" class="border-0 border-bottom border-2 rounded-0 form-control form-control-lg mb-3" required>
                            <div class="position-absolute top-0 start-0 form-icon text-secondary">
                                <i class="bi bi-lock"></i>
                            </div>
                        </div>
                        <div class="mb-3 row g-3">
                            <div class="col-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">Remember me</label>
                                </div>
                            </div>
                            <div class="col-6 text-end">
                                <a href="forgotten_password">Forgotten password?</a>
                            </div>
                        </div>
                        <div class="d-grid mb-3">
                            <input type="submit" value="Login" class="btn btn-primary btn-lg fw-semibold rounded-3 text-uppercase">
                        </div>
                        <div class="row">
                            <div class="col-12 text-center">
                                <span>Don't you have an account? <a href="register" class="fw-semibold">Register</a></span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'partials/footer.php'; ?>
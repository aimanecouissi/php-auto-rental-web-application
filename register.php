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
$alert = $first_name = $last_name = $cin = $phone = $email = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['cin']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['password1']) && isset($_POST['password2'])) {
        if (!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['cin']) && !empty($_POST['phone']) && !empty($_POST['email']) && !empty($_POST['password1']) && !empty($_POST['password2'])) {
            $first_name = htmlspecialchars($_POST['first_name']);
            $last_name = htmlspecialchars($_POST['last_name']);
            $cin = htmlspecialchars($_POST['cin']);
            $phone = htmlspecialchars($_POST['phone']);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password1 = htmlspecialchars($_POST['password1']);
            $password2 = htmlspecialchars($_POST['password2']);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL))
                $alert = alert('danger', 'Please, do not play with the inputs');
            else {
                $query = "SELECT * FROM renter WHERE email = '$email'";
                $result = mysqli_query($con, $query);
                if (mysqli_num_rows($result) != 0)
                    $alert = alert('warning', 'The email you entered already exists');
                else {
                    if ($password1 != $password2)
                        $alert = alert('warning', 'Please enter the same password twice');
                    else {
                        $query = "INSERT INTO renter (first_name, last_name, cin, phone, email, `password`) VALUES ('" . ucfirst(strtolower($first_name)) . "', '" . ucfirst(strtolower($last_name)) . "', '" . strtoupper($cin) . "', '" . $phone . "', '" . strtolower($email) . "', '" . password_hash($password1, PASSWORD_DEFAULT) . "')";
                        mysqli_query($con, $query);
                        $query = "SELECT * FROM renter WHERE email = '$email'";
                        $result = mysqli_query($con, $query);
                        $row = mysqli_fetch_array($result);
                        $_SESSION['renter'] = $row[0];
                        $_SESSION['full_name'] = ucfirst(strtolower($first_name)) . ' ' . ucfirst(strtolower($last_name));
                        header('Location:index.php');
                    }
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
            <div class="col-md-8 col-lg-6">
                <div class="bg-white p-5 rounded-3 shadow-sm">
                    <h1 class="my-0 py-0 text-center fw-bold">Aimane<span>Cars</span></h1>
                    <p class="text-uppercase mb-4 mt-0 py-0 text-center fw-bold">— Register —</p>
                    <form method="post" autocomplete="off" action="register">
                        <div class="row g-3 mb-3">
                            <div class="col-12">
                                <?php echo $alert; ?>
                            </div>
                            <div class="col-lg-6">
                                <div class="position-relative">
                                    <input type="text" value="<?php echo $first_name ?>" maxlength="25" name="first_name" placeholder="First name" class="form-control form-control-lg border-0 border-bottom border-2 rounded-0" required>
                                    <div class="position-absolute top-0 start-0 form-icon text-secondary">
                                        <i class="bi bi-type"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="position-relative">
                                    <input type="text" value="<?php echo $last_name ?>" maxlength="25" name="last_name" placeholder="Last name" class="form-control form-control-lg border-0 border-bottom border-2 rounded-0" required>
                                    <div class="position-absolute top-0 start-0 form-icon text-secondary">
                                        <i class="bi bi-type"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="position-relative">
                                    <input type="text" value="<?php echo $cin ?>" maxlength="8" name="cin" placeholder="CIN" class="form-control form-control-lg border-0 border-bottom border-2 rounded-0" required>
                                    <div class="position-absolute top-0 start-0 form-icon text-secondary">
                                        <i class="bi bi-card-text"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="position-relative">
                                    <input type="tel" value="<?php echo $phone ?>" name="phone" pattern="[0-9]{10}" maxlength="15" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="E.g. 0612345789" placeholder="Phone number" class="form-control form-control-lg border-0 border-bottom border-2 rounded-0" required>
                                    <div class="position-absolute top-0 start-0 form-icon text-secondary">
                                        <i class="bi bi-telephone"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="position-relative">
                                    <input type="email" value="<?php echo $email ?>" maxlength="50" name="email" placeholder="Email" class="form-control form-control-lg border-0 border-bottom border-2 rounded-0" required>
                                    <div class="position-absolute top-0 start-0 form-icon text-secondary">
                                        <i class="bi bi-envelope"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="position-relative">
                                    <input type="password" id="password1" onkeyup="check_strength(this)" minlength="8" maxlength="50" name="password1" placeholder="Password" class="form-control form-control-lg border-0 border-bottom border-2 rounded-0" required>
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
                            </div>
                            <div class="col-lg-6">
                                <div class="position-relative">
                                    <input type="password" id="password2" onkeyup="check_strength(this)" minlength="8" maxlength="50" name="password2" required placeholder="Confirm password" class="form-control form-control-lg border-0 border-bottom border-2 rounded-0" required>
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
                            </div>
                        </div>
                        <div class="d-grid mb-3">
                            <input type="submit" value="Register" class="btn btn-primary btn-lg fw-semibold rounded-3 text-uppercase">
                        </div>
                        <div class="row">
                            <div class="col-12 text-center">
                                <span>Already have an account? <a href="login" class="fw-semibold">Login</a></span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'partials/footer.php'; ?>
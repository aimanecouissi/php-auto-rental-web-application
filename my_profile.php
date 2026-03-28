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
$alert = $first_name = $last_name = $cin = $phone = $email = $name = $number = $mm = $yy = $cvv = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['save1'])) {
        if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['cin']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['password'])) {
            if (!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['cin']) && !empty($_POST['phone']) && !empty($_POST['email']) && !empty($_POST['password'])) {
                $first_name = htmlspecialchars($_POST['first_name']);
                $last_name = htmlspecialchars($_POST['last_name']);
                $cin = htmlspecialchars($_POST['cin']);
                $phone = htmlspecialchars($_POST['phone']);
                $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                $password = htmlspecialchars($_POST['password']);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL))
                    $alert = alert('danger', 'Please, do not play with the inputs');
                else {
                    $query = "SELECT * FROM renter WHERE email = '$email' AND id != " . $_SESSION['renter'];
                    $result = mysqli_query($con, $query);
                    if (mysqli_num_rows($result) != 0)
                        $alert = alert('warning', 'The email you entered already exists');
                    else {
                        $addtional_query = '';
                        if (isset($_FILES['photo']) && !empty($_FILES['photo'])) {
                            if ($_FILES["photo"]["tmp_name"] != '') {
                                $check = getimagesize($_FILES["photo"]["tmp_name"]);
                                if($check) {
                                    if ($_FILES["image"]["tmp_name"] <= 500000) {
                                        $photo_name = uniqid('', true) . '.jpg';
                                        $photo_path = 'files/renters/photos/' . $photo_name;
                                        move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path);
                                        $addtional_query = ", photo = '" . $photo_path . "'";
                                    }
                                    else
                                        $alert = alert('warning', 'The photo size is too big');
                                }
                            }
                        }
                        $query = "UPDATE renter SET first_name = '$first_name', last_name = '$last_name', cin = '$cin', phone = '$phone', email = '$email', password = '" . password_hash($password, PASSWORD_DEFAULT) . "'$addtional_query WHERE id = " . $_SESSION['renter'];
                        mysqli_query($con, $query);
                        $_SESSION['full_name'] = ucfirst(strtolower($first_name)) . ' ' . ucfirst(strtolower($last_name));
                        setcookie('full_name', $_SESSION['full_name'], time() + 86400 * 30);
                    }
                }
            }
        }
    }
    if (isset($_POST['save2'])) {
        if (isset($_POST['name']) && isset($_POST['number']) && isset($_POST['mm']) && isset($_POST['yy']) && isset($_POST['cvv'])) {
            if (!empty($_POST['name']) && !empty($_POST['number']) && !empty($_POST['mm']) && !empty($_POST['yy']) && !empty($_POST['cvv'])) {
                $name = htmlspecialchars($_POST['name']);
                $number = htmlspecialchars($_POST['number']);
                $mm = filter_var($_POST['mm'], FILTER_SANITIZE_NUMBER_INT);
                $yy = filter_var($_POST['yy'], FILTER_SANITIZE_NUMBER_INT);
                $cvv = filter_var($_POST['cvv'], FILTER_SANITIZE_NUMBER_INT);
                if (!filter_var($yy, FILTER_VALIDATE_INT) || !filter_var($cvv, FILTER_VALIDATE_INT))
                    $alert = alert('danger', 'Please, do not play with the inputs');
                else {
                    $query = "SELECT * FROM `card` WHERE renter = " . $_SESSION['renter'];
                    $result = mysqli_query($con, $query);
                    if (mysqli_num_rows($result) != 0) {
                        $query = "UPDATE `card` SET `name` = '$name', `number` = '$number', mm = $mm, yy = $yy, cvv = $cvv WHERE renter = " . $_SESSION['renter'];
                        mysqli_query($con, $query);
                    }
                    else {
                        $query = "INSERT INTO `card` (`id`, `name`, `number`, `mm`, `yy`, `cvv`, `renter`) VALUES (NULL, '$name', '$number', '$mm', '$yy', '$cvv', '" . $_SESSION['renter'] . "')";
                        mysqli_query($con, $query);
                    }
                }
            }
        }
    }
}
$query = "SELECT * FROM renter WHERE id = " . $_SESSION['renter'];
$result = mysqli_query($con, $query);
$row = mysqli_fetch_array($result);
$photo = $row[1];
$first_name = $row[2];
$last_name = $row[3];
$cin = $row[4];
$phone = $row[5];
$email = $row[6];
$query = "SELECT * FROM card WHERE renter = " . $_SESSION['renter'];
$result = mysqli_query($con, $query);
if (mysqli_num_rows($result) != 0) {
    $row = mysqli_fetch_array($result);
    $name = $row[1];
    $number = $row[2];
    $mm = $row[3];
    if ($mm < 10) {
        $mm = '0' . $mm;
    }
    $yy = $row[4];
    if ($yy < 10) {
        $yy = '0' . $yy;
    }
    $cvv = $row[5];
}
mysqli_close($con);
require 'partials/navbars/navbar_renter.php';
?>
<div class="pt min-vh-100 d-flex align-items-center justify-content-center bg-hero">
    <div class="container">
        <div class="row my-5">
            <div class="col-12 text-center">
                <h3 class="fw-semibold display-6 text-uppercase text-primary">My Profile</h3>
                <p class="lead text-uppercase fw-normal p-0 m-0">Keep your profile updated for easy use</p>
            </div>
        </div>
        <div class="row mb-3 justify-content-center">
            <div class="col-lg-6">
                <div class="bg-white p-4 shadow-sm rounded-3">
                    <form action="my_profile" enctype="multipart/form-data" method="post" autocomplete="off">
                        <div class="row g-3">
                            <div class="col-12 mt-2">
                                <div class="bg-renter rounded-3 mt-2 p-3 border">
                                    <label for="photo_upload" style="cursor: pointer;">
                                        <img src="<?php echo $photo; ?>" id="photo_show" alt="renter image" class="rounded-3 img-thumbnail" style="object-fit: cover; width: 125px; height: 125px;">
                                    </label>
                                    <input type="file" name="photo" id="photo_upload" class="d-none" accept="image/*">
                                </div>
                            </div>
                            <?php echo $alert; ?>
                            <div class="col-lg-6">
                                <div class="position-relative">
                                    <input type="text" maxlength="25" id="first_name" name="first_name" value="<?php echo $first_name; ?>" class="form-control form-control-lg rounded-3" placeholder="First name" required>
                                    <div class="position-absolute top-0 start-0 form-icon text-secondary">
                                        <i class="bi bi-type"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="position-relative">
                                    <input type="text" maxlength="25" id="last_name" name="last_name" value="<?php echo $last_name; ?>" class="form-control form-control-lg rounded-3" placeholder="Last name" required>
                                    <div class="position-absolute top-0 start-0 form-icon text-secondary">
                                        <i class="bi bi-type"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="position-relative">
                                    <input type="text" maxlength="8" id="cin" name="cin" value="<?php echo $cin; ?>" class="form-control form-control-lg rounded-3" placeholder="CIN" required>
                                    <div class="position-absolute top-0 start-0 form-icon text-secondary">
                                        <i class="bi bi-card-text"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="position-relative">
                                    <input maxlength="15" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="E.g. 0612345789" type="tel" id="phone" name="phone" pattern="[0-9]{10}" value="<?php echo $phone; ?>" class="form-control form-control-lg rounded-3" placeholder="Phone number" required>
                                    <div class="position-absolute top-0 start-0 form-icon text-secondary">
                                        <i class="bi bi-telephone"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="position-relative">
                                    <input type="email" maxlength="50" name="email" id="email" value="<?php echo $email; ?>" class="form-control form-control-lg rounded-3" placeholder="Email" required>
                                    <div class="position-absolute top-0 start-0 form-icon text-secondary">
                                        <i class="bi bi-envelope"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="position-relative">
                                    <input maxlength="50" type="password" name="password" id="password" onkeyup="check_strength(this)" class="form-control form-control-lg rounded-3" placeholder="Password" required>
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
                            <div class="col-12 d-grid">
                                <input type="submit" value="Save Changes" name="save1" class="text-uppercase rounded-3 btn btn-primary btn-lg fw-semibold">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row mb-5 justify-content-center">
            <div class="col-lg-6">
                <div class="bg-white p-4 shadow-sm rounded-3">
                    <form action="my_profile" method="post" onsubmit="check_card(event)" autocomplete="off">
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <div class="position-relative">
                                    <input type="text" maxlength="50" name="name" id="name" value="<?php echo $name; ?>" class="form-control form-control-lg rounded-3" placeholder="Name on card" required>
                                    <div class="position-absolute top-0 start-0 form-icon text-secondary">
                                        <i class="bi bi-type"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="position-relative">
                                    <input type="number" name="number" id="number" value="<?php echo $number; ?>" class="form-control form-control-lg rounded-3 card-number" minlength="16" maxlength="16" placeholder="Card number" required>
                                    <div class="position-absolute top-0 start-0 form-icon text-secondary">
                                        <i class="bi bi-credit-card-2-front"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="position-relative">
                                    <input type="number" name="mm" id="mm" value="<?php echo $mm; ?>" class="form-control form-control-lg rounded-3" placeholder="MM" min="1" max="12" required>
                                    <div class="position-absolute top-0 start-0 form-icon text-secondary">
                                        <i class="bi bi-credit-card"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="position-relative">
                                    <input type="number" name="yy" id="yy" value="<?php echo $yy; ?>" class="form-control form-control-lg rounded-3" placeholder="YY" required>
                                    <div class="position-absolute top-0 start-0 form-icon text-secondary">
                                        <i class="bi bi-credit-card"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="position-relative">
                                    <input type="number" name="cvv" id="cvv" value="<?php echo $cvv; ?>" class="form-control form-control-lg rounded-3" placeholder="CVV" max="999" required>
                                    <div class="position-absolute top-0 start-0 form-icon text-secondary">
                                        <i class="bi bi-credit-card-2-back"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 d-grid">
                                <input type="submit" value="Save Changes" name="save2" class="text-uppercase rounded-3 btn btn-primary btn-lg fw-semibold">
                            </div>
                            <div class="col-12 text-center">
                                <img src="assets/img/credit_cards.png" alt="payment methods" class="img-fluid" width="200">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'partials/footer.php'; ?>
<?php
session_start();
require 'partials/connection.php';
require 'partials/functions.php';
if (isset($_SESSION['renter']) || !isset($_SESSION['admin'])) {
    header('Location:index.php');
    exit;
}
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location:my_cars?page=1');
    exit;
}
$query = 'SELECT * FROM renter WHERE id = ' . $_GET['id'];
$result = mysqli_query($con, $query);
if (mysqli_num_rows($result) == 0) {
    header('Location:bookings?page=1');
    exit;
}
else
    $row = mysqli_fetch_array($result);
mysqli_close($con);
require 'partials/navbars/navbar_admin.php';
?>
<div class="min-vh-100 pt bg-hero">
    <div class="container">
        <div class="row my-5">
            <div class="col-12 text-center">
                <h3 class="fw-semibold display-6 text-uppercase text-primary my-0 py-0">Renter Profile</h3>
            </div>
        </div>
        <div class="row mb-5 justify-content-center">
            <div class="col-lg-6">
                <div class="bg-white p-4 shadow-sm rounded-3">
                    <div class="row g-3">
                        <div class="col-12 mt-2">
                            <div class="bg-renter rounded-3 mt-2 p-3 border">
                                    <img src="<?php echo $row[1]; ?>" id="photo_show" alt="renter image" class="rounded-3 img-thumbnail" style="object-fit: cover; width: 125px; height: 125px;">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="position-relative">
                                <input type="text" name="first_name" value="<?php echo $row[2]; ?>" class="form-control form-control-lg rounded-3" readonly>
                                <div class="position-absolute top-0 start-0 form-icon text-secondary">
                                    <i class="bi bi-type"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="position-relative">
                                <input type="text" name="last_name" value="<?php echo $row[3]; ?>" class="form-control form-control-lg rounded-3" readonly>
                                <div class="position-absolute top-0 start-0 form-icon text-secondary">
                                    <i class="bi bi-type"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="position-relative">
                                <input type="text" name="cin" value="<?php echo $row[4]; ?>" class="form-control form-control-lg rounded-3" readonly>
                                <div class="position-absolute top-0 start-0 form-icon text-secondary">
                                    <i class="bi bi-card-text"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="position-relative">
                                <input type="tel" id="phone" value="<?php echo $row[5]; ?>" name="phone" class="form-control form-control-lg rounded-3" readonly>
                                <div class="position-absolute top-0 start-0 form-icon text-secondary">
                                    <i class="bi bi-telephone"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="position-relative">
                                <input type="email" name="email" value="<?php echo $row[6]; ?>" class="form-control form-control-lg rounded-3" readonly>
                                <div class="position-absolute top-0 start-0 form-icon text-secondary">
                                    <i class="bi bi-envelope"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'partials/footer.php'; ?>
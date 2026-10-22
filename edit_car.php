<?php
session_start();
require 'partials/connection.php';
require 'partials/functions.php';
if (isset($_SESSION['renter']) || !isset($_SESSION['admin'])) {
    header('Location:index.php');
    exit;
}
if (!isset($_GET['car']) || empty($_GET['car'])) {
    header('Location:my_cars?page=1');
    exit;
}
$query = "SELECT * FROM manufacturer";
$result_manufacturer = mysqli_query($con, $query);
$query = 'SELECT manufacturer.*, model.* FROM manufacturer, model WHERE manufacturer.id = model.manufacturer AND model.id = ' . $_GET['car'];
$result_model = mysqli_query($con, $query);
if (mysqli_num_rows($result_model) == 0) {
    header('Location:my_cars?page=1');
    exit;
}
else {
    $model = mysqli_fetch_array($result_model);
}
mysqli_close($con);
require 'partials/navbars/navbar_admin.php';
?>
<div class="min-vh-100 d-flex align-items-center justify-content-center pt bg-hero">
    <div class="container">
        <div class="row my-5">
            <div class="col-12 text-center">
                <h3 class="fw-semibold display-6 text-uppercase text-primary my-0 py-0">Edit Car</h3>
            </div>
        </div>
        <div class="row justify-content-center mb-5">
            <div class="col-lg-5">
                <div class="bg-white rounded-3 shadow-sm">
                    <form action="edit_car_back" method="post" enctype="multipart/form-data" onsubmit="delete_car(event)" autocomplete="off">
                        <input type="hidden" name="car" value="<?php echo $_GET['car']; ?>">
                        <div class="car-img rounded-3">
                            <label for="photo_upload" style="cursor: pointer;"><img src="<?php echo $model[4]; ?>" alt="" id="photo_show" class="img-fluid rounded-3"></label>
                            <input type="file" name="image" id="photo_upload" accept="image/*" class="d-none">
                        </div>
                        <div class="car-details p-4">
                            <div class="row g-3">
                                <div class="col-lg-12">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text"><i class="bi bi-car-front"></i></span>
                                        <select name="manufacturer" class="form-select form-select-lg" required>
                                            <?php
                                            while ($row_manufacturer = mysqli_fetch_array($result_manufacturer)) {
                                            ?>
                                            <option value="<?php echo $row_manufacturer[0]; ?>" <?php if ($row_manufacturer[0] == $model[0]) echo 'selected'; ?>><?php echo $row_manufacturer[1]; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text"><i class="bi bi-car-front"></i></span>
                                        <input type="text" value="<?php echo $model[5]; ?>" name="model" maxlength="25" placeholder="Model" class="form-control form-control-lg" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text"><i class="bi bi-globe"></i></span>
                                        <input type="url" value="<?php echo $model[7]; ?>" name="details" placeholder="Details page" class="form-control form-control-lg" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                                        <input type="number" value="<?php echo $model[6]; ?>" name="price" min="1" max="9999" class="form-control form-control-lg" placeholder="Price per day" required>
                                    </div>
                                </div>
                                <div class="col-lg-6 d-grid">
                                    <input type="submit" name="edit" class="btn btn-block btn-primary btn-lg text-uppercase rounded-3 fw-semibold" value="Edit" onclick="clicked = 'edit'">
                                </div>
                                <div class="col-lg-6 d-grid">
                                    <input type="submit" name="delete" class="btn btn-block btn-danger btn-lg text-uppercase rounded-3 fw-semibold" value="Detete" onclick="clicked = 'delete'">
                                </div>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'partials/footer.php'; ?>
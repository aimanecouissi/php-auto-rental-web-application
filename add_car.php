<?php
session_start();
require 'partials/connection.php';
require 'partials/functions.php';
if (isset($_SESSION['renter']) || !isset($_SESSION['admin'])) {
    header('Location:index.php');
    exit;
}
$query = 'SELECT * FROM manufacturer';
$result_manufacturer = mysqli_query($con, $query);
$alert = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['manufacturer']) && isset($_POST['model']) && isset($_POST['details']) && isset($_POST['price'])) {
        if (!empty($_POST['manufacturer']) && !empty($_POST['model']) && !empty($_POST['details']) && !empty($_POST['price'])) {
            if (isset($_FILES['image']) && !empty($_FILES['image'])) {
                if ($_FILES['image']['tmp_name'] != '') {
                    $manufacturer = htmlspecialchars($_POST['manufacturer']);
                    $model = htmlspecialchars($_POST['model']);
                    $details = filter_var($_POST['details'], FILTER_SANITIZE_URL);
                    $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT);
                    if (!filter_var($details, FILTER_VALIDATE_URL) || !filter_var($price, FILTER_VALIDATE_FLOAT))
                        $alert = '<div class="col-12">' . alert('danger', 'Please, do not play with the inputs') . '</div>';
                    else {
                        $check = getimagesize($_FILES['image']['tmp_name']);
                        if (!$check)
                            $alert = '<div class="col-12">' . alert('danger', 'Please, choose an image for the car') . '</div>';
                        else {
                            if ($_FILES['image']['tmp_name'] > 500000)
                                $alert = '<div class="col-12">' . alert('warning', 'The image size is too big') . '</div>';
                            else {
                                $image_name = uniqid('', true) . '.jpg';
                                $image_path = 'files/cars/images/' . $image_name;
                                move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
                                $query = "INSERT INTO model (image, name, price, details, manufacturer) VALUES ('$image_path', '$model', $price, '$details', $manufacturer)";
                                mysqli_query($con, $query);
                                $alert = '<div class="col-12">' . alert('success', 'The car was added successfully') . '</div>';
                            }
                        }
                    }
                }
            }
        }
    }
}
mysqli_close($con);
require 'partials/navbars/navbar_admin.php';
?>
<div class="min-vh-100 d-flex align-items-center justify-content-center pt bg-hero">
    <div class="container">
        <div class="row my-5">
            <div class="col-12 text-center">
                <h3 class="fw-semibold display-6 text-uppercase text-primary my-0 py-0">Add New Car</h3>
            </div>
        </div>
        <div class="row justify-content-center mb-5">
            <div class="col-lg-5">
                <div class="bg-white rounded-3 shadow-sm">
                    <form action="add_car" method="post" enctype="multipart/form-data" autocomplete="off">
                        <div class="car-img rounded-3 border-dashed bg-light">
                            <label for="photo_upload" style="cursor: pointer;"><img src="assets/img/add-image.png" alt="" id="photo_show" class="img-fluid rounded-3"></label>
                            <input type="file" name="image" id="photo_upload" class="d-none" accept="image/*" required>
                        </div>
                        <div class="car-details p-4">
                            <?php echo $alert; ?>
                            <div class="row g-3">
                                <div class="col-lg-12">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text"><i class="bi bi-car-front"></i></span>
                                        <select name="manufacturer" class="form-select form-select-lg" required>
                                            <?php
                                            while ($row_manufacturer = mysqli_fetch_array($result_manufacturer)) {
                                            ?>
                                            <option value="<?php echo $row_manufacturer[0]; ?>"><?php echo $row_manufacturer[1]; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text"><i class="bi bi-car-front"></i></span>
                                        <input type="text" name="model" maxlength="25" placeholder="Model" class="form-control form-control-lg" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text"><i class="bi bi-globe"></i></span>
                                        <input type="url" name="details" placeholder="Details page" class="form-control form-control-lg" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                                        <input type="number" name="price" min="1" max="9999" class="form-control form-control-lg" placeholder="Price per day" required>
                                    </div>
                                </div>
                                <div class="col-lg-12 d-grid">
                                    <input type="submit" class="btn btn-block btn-primary btn-lg text-uppercase rounded-3 fw-semibold" value="Add">
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
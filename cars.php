<?php
session_start();
require 'partials/connection.php';
require 'partials/functions.php';
if (isset($_SESSION['admin'])) {
    header('Location:add_car.php');
    exit;
}
$query = 'SELECT * FROM model';
$result = mysqli_query($con, $query);
$row_count = mysqli_num_rows($result);
$records_per_page = 12;
$number_of_pages = ceil($row_count / $records_per_page);
$page = 1;
if (isset($_GET['page']) && !empty($_GET['page']))
    $page = $_GET['page'];
$query_search = '';
if (isset($_GET['manufacturer']) && !empty($_GET['manufacturer']))
    $query_search .= " AND manufacturer.name LIKE '%" . $_GET['manufacturer'] . "%'";
if (isset($_GET['model']) && !empty($_GET['model']))
    $query_search .= " AND model.name LIKE '%" . $_GET['model'] . "%'";
if (isset($_GET['min_price']) && !empty($_GET['min_price']))
    $query_search .= ' AND model.price >= ' . $_GET['min_price'];
if (isset ($_GET['max_price']) && !empty($_GET['max_price']))
    $query_search .= ' AND model.price <= ' . $_GET['max_price'];
$query_page = ' LIMIT ' . ($page - 1) * $records_per_page . ', ' . $records_per_page;
if ($query_search != '') {
    $query_page = '';
    $page = 0;
}
$query = 'SELECT manufacturer.*, model.* FROM manufacturer, model WHERE manufacturer.id = model.manufacturer' . $query_search . ' ORDER BY model.id DESC' . $query_page;
$result = mysqli_query($con, $query);
$alert = '';
if ($result == false)
    $alert = alert('primary', 'There are no cars matching your search');
mysqli_close($con);
if (isset($_SESSION['renter']))
    require 'partials/navbars/navbar_renter.php';
else
    require 'partials/navbars/navbar_offline.php';
?>
<div class="min-vh-100 pt bg-hero">
    <div class="container">
        <div class="row my-5">
            <div class="col-12 text-center">
                <a href="cars"><h3 class="fw-semibold display-6 text-uppercase text-primary">All Cars</h3></a>
                <p class="lead text-uppercase fw-normal p-0 m-0">Search easily for your dream car with us</p>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-12">
                <form method="get" action="cars" autocomplete="off">
                    <div class="input-group input-group-lg">
                        <input type="text" maxlength="25" class="form-control" placeholder="Manufacturer" name="manufacturer">
                        <input type="text" maxlength="25" class="form-control" placeholder="Model" name="model">
                        <input type="number" class="form-control" placeholder="Minimum price" name="min_price" min="1" max="9999">
                        <input type="number" class="form-control" placeholder="Maximum price" name="max_price" min="1" max="9999">
                        <button type="submit" class="btn btn-primary fw-semibold"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row g-4 mb-5 justify-content-center">
            <div class="col-12">
                <?php echo $alert; ?>
            </div>
            <?php if ($alert == '') while ($row = mysqli_fetch_array($result)) { ?>
            <div class="col-md-6 col-lg-4" data-aos="fade-up">
                <div class="bg-white rounded-3 shadow-sm">
                    <div class="card-custom-img overflow-hidden rounded-3">
                        <a href="<?php if (isset($_SESSION['renter'])) echo 'booking?car=' . $row[3]; ?>"><img src="<?php echo $row[4]; ?>" alt="car image" class="img-fluid rounded-3"></a>
                    </div>
                    <div class="card-custom-content p-4">
                        <div class="row g-0 align-items-center">
                            <div class="col-9">
                                <div class="d-flex align-items-center">
                                    <img src="<?php echo $row[2]; ?>" alt="car logo" height="50" width="50" class="me-3">
                                    <div>
                                        <h5 class="fw-semibold my-0"><?php echo $row[1]; ?></h5>
                                        <h6 class="my-0"><?php echo $row[5]; ?></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3 text-end">
                                <span class="fw-semibold">$<?php echo $row[6]; ?>/DAY</span>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="<?php if (!isset($_SESSION['renter'])) echo 'login.php'; else echo 'booking?car=' . $row[3]; ?>" class="btn btn-primary rounded-3 w-100 mb-2 text-uppercase fw-semibold">Rent Now</a>
                            <a href="<?php echo $row[7]; ?>" class="btn btn-outline-primary rounded-3 w-100 text-uppercase fw-semibold" target="_blank">Details</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="col-12 mt-5">
                <nav>
                    <ul class="pagination pagination justify-content-center">
                    <?php
                    for ($i = 1; $i <= $number_of_pages; $i++) {
                        $active = '';
                        if ($page == $i) {
                            $active = 'active';
                        }
                        echo '<li class="page-item ' . $active . '"><a class="page-link" href="cars?page=' . $i . '">' . $i . '</a></li>';
                    }
                    ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<?php require 'partials/footer.php'; ?>
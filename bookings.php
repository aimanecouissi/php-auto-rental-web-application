<?php
session_start();
require 'partials/connection.php';
require 'partials/functions.php';
if (isset($_SESSION['renter']) || !isset($_SESSION['admin'])) {
    header('Location:index.php');
    exit;
}
$num = 0;
$query = 'SELECT * FROM booking';
$result_pagination = mysqli_query($con, $query);
$row_count = mysqli_num_rows($result_pagination);
$records_per_page = 12;
$number_of_pages = ceil($row_count / $records_per_page);
$page = 1;
if (isset($_GET['page']) && !empty($_GET['page']))
    $page = $_GET['page'];
$query_search = '';
if (isset($_GET['cin']) && !empty($_GET['cin']))
    $query_search .= " AND renter.cin LIKE '%" . $_GET['cin'] . "%'";
if (isset($_GET['end_date']) && !empty($_GET['end_date']))
    $query_search .= " AND booking.end_date = '" . $_GET['end_date'] . "'";
$query_page = ' LIMIT ' . ($page - 1) * $records_per_page . ', ' . $records_per_page;
if ($query_search != '') {
    $query_page = '';
    $page = 0;
}
$query = 'SELECT booking.*, renter.* FROM booking, renter WHERE booking.renter = renter.id' . $query_search . ' ORDER BY booking.id DESC' . $query_page;
$result = mysqli_query($con, $query);
$alert = '';
if (mysqli_num_rows($result) == 0)
    $alert = alert('primary', 'There are no rents matching your search');
require 'partials/navbars/navbar_admin.php';
?>
<div class="min-vh-100 pt bg-hero">
    <div class="container">
        <div class="row my-5">
            <div class="col-12 text-center">
                <h3 class="fw-semibold display-6 text-uppercase text-primary my-0 py-0">Bookings</h3>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-12">
                <form method="get" autocomplete="off">
                    <div class="input-group input-group-lg">
                        <input type="text" class="form-control" placeholder="Renter CIN" name="cin">
                        <input type="date" class="form-control" placeholder="End date" name="end_date">
                        <button type="submit" class="btn btn-primary fw-semibold"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <?php
            if ($alert != '')
                echo $alert;
            else {
        ?>
        <table class="w-100 rounded-3 overflow-hidden bg-light mb-5 shadow-sm text-center">
            <thead>
                <tr class="bg-primary text-uppercase">
                    <th>#</th>
                    <th>Renter CIN</th>
                    <th>Car Manufacturer</th>
                    <th>Car Model</th>
                    <th>Payment Date</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Duration</th>
                    <th>Total Price</th>
                    <th>Receipt</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_array($result)) { ?>
                <tr>
                    <td><?php echo $row[0]; ?></td>
                    <td>
                        <a target="_blank" href="renter?id=<?php echo $row[8]; ?>"><?php echo $row[12]; ?></a>
                    </td>
                    <td>
                        <?php 
                        $query = 'SELECT manufacturer.name, model.name, model.id FROM manufacturer, model WHERE manufacturer.id = model.manufacturer AND model.id = ' . $row[2];
                        $operation2 = mysqli_query($con , $query);
                        $car = mysqli_fetch_array($operation2);
                        echo $car[0];
                        ?>
                    </td>
                    <td><a target="_blank" href="edit_car?car=<?php echo $car[2]; ?>"><?php echo $car[1]; ?></a></td>
                    <td><?php echo $row[3]; ?></td>
                    <td><?php echo $row[4]; ?></td>
                    <td><?php echo $row[5]; ?></td>
                    <td><?php echo $row[6]; ?> Day</td>
                    <td>$<?php echo $row[7]; ?></td>
                    <td><a target="_blank" href="receipt?receipt=<?php echo $row[0]; ?>" class="btn btn-primary rounded-3"><i class="fa-solid fa-file-arrow-down me-2"></i>Download</a></td>
                </tr>
                <?php } mysqli_close($con); ?>
            </tbody>
        </table>
        <?php } ?>
        <nav class="mb-5">
            <ul class="pagination justify-content-center">
                <?php
                for ($i = 1; $i <= $number_of_pages; $i++) {
                    $active = '';
                    if ($page == $i) {
                        $active = 'active';
                    }
                    echo '<li class="page-item ' . $active . '"><a class="page-link" href="bookings?page=' . $i . '">' . $i . '</a></li>';
                }
                ?>
            </ul>
        </nav>
    </div>
</div>
<?php require 'partials/footer.php'; ?>
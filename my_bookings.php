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
$alert = '';
$num = 0;
$query = 'SELECT * FROM booking WHERE renter = ' . $_SESSION['renter'] . ' ORDER BY id DESC';
$result = mysqli_query($con, $query);
if(mysqli_num_rows($result) == 0)
    $alert = alert('primary', 'You have not rented any car yet');
require 'partials/navbars/navbar_renter.php';
?>
<div class="min-vh-100 pt bg-hero">
    <div class="container-fluid">
        <div class="row my-5">
            <div class="col-12 text-center">
                <h3 class="fw-semibold display-6 text-uppercase text-primary">My Bookings</h3>
                <p class="lead text-uppercase fw-normal p-0 m-0">See all your rented cars in one place</p>
            </div>
        </div>
        <?php
            if ($alert != '')
                echo $alert;
            else {
        ?>
        <table class="w-100 rounded-3 overflow-hidden bg-light mb-5 shadow-sm text-center">
            <thead>
                <tr class="bg-primary text-uppercase">
                    <th>#</th>
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
                    <td><?php echo ++$num; ?></td>
                    <td>
                        <?php 
                        $query = 'SELECT manufacturer.name, model.name, model.id FROM manufacturer, model WHERE manufacturer.id = model.manufacturer AND model.id = ' . $row[2];
                        $operation = mysqli_query($con , $query);
                        $car = mysqli_fetch_array($operation);
                        echo $car[0];
                        ?>
                    </td>
                    <td><a href="booking?car=<?php echo $car[2]; ?>"><?php echo $car[1]; ?></a></td>
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
    </div>
</div>
<?php require 'partials/footer.php'; ?>
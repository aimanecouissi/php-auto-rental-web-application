<?php
session_start();
require 'partials/connection.php';
require 'partials/functions.php';
if (!isset($_SESSION['admin']) && !isset($_SESSION['renter'])) {
    header('Location:index.php');
    exit;
}
if (!isset($_GET['receipt']) || empty($_GET['receipt'])) {
    header('Location:cars?page=1');
    exit;
}
$query = "SELECT * FROM booking WHERE id = " . $_GET['receipt'];
$result = mysqli_query($con, $query);
if (mysqli_num_rows($result) == 0) {
    header('Location:index.php');
    exit;
}
else {
    $row_booking = mysqli_fetch_array($result);
    if (isset($_SESSION['renter'])) if ($row_booking[1] != $_SESSION['renter']) header('Location:cars?page=1');
    $query = 'SELECT first_name, last_name, cin, phone FROM renter WHERE id = ' . $row_booking[1];
    $result = mysqli_query($con, $query);
    $row_renter = mysqli_fetch_array($result);
    $query = 'SELECT manufacturer.name, model.name, model.price FROM manufacturer, model WHERE manufacturer.id = model.manufacturer AND model.id = ' . $row_booking[2];
    $result = mysqli_query($con, $query);
    $row_car = mysqli_fetch_array($result);
}
mysqli_close($con);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Receipt | AimaneCars</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Bai+Jamjuree:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&display=swap");

        body {
            font-family: "Bai Jamjuree" !important;
            margin: 0;
            padding: 0;
            color: black !important;
        }

        h1 {
            font-weight: 700;
        }

        h1 span {
            color: #1b74e4;
        }

        .text-primary {
            color: #1b74e4 !important;
        }

        .bg-primary {
            background-color: #1b74e4 !important;
        }

        table {
            border-collapse: collapse;
        }

        th {
            color: white;
        }

        tr th,
        tr td {
            padding: 1.25rem;
        }

        .bg-light {
            background-color: #e7f3ff !important;
        }

        body {
            margin-top: 20px;
            color: #484b51;
        }

        .text-secondary-d1 {
            color: #728299 !important;
        }

        .page-header {
            margin: 0 0 1rem;
            padding-bottom: 1rem;
            padding-top: .5rem;
            border-bottom: 1px dotted #e2e2e2;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-pack: justify;
            justify-content: space-between;
            -ms-flex-align: center;
            align-items: center;
        }

        .page-title {
            padding: 0;
            margin: 0;
            font-size: 1.75rem;
            font-weight: 300;
        }

        .brc-default-l1 {
            border-color: #dce9f0 !important;
        }

        .ml-n1,
        .mx-n1 {
            margin-left: -.25rem !important;
        }

        .mr-n1,
        .mx-n1 {
            margin-right: -.25rem !important;
        }

        .mb-4,
        .my-4 {
            margin-bottom: 1.5rem !important;
        }

        hr {
            margin-top: 1rem;
            margin-bottom: 1rem;
            border: 0;
            border-top: 1px solid rgba(0, 0, 0, .1);
        }

        .text-grey-m2 {
            color: #888a8d !important;
        }

        .text-success-m2 {
            color: #86bd68 !important;
        }

        .font-bolder,
        .text-600 {
            font-weight: 600 !important;
        }

        .text-110 {
            font-size: 110% !important;
        }

        .text-blue {
            color: #478fcc !important;
        }

        .pb-25,
        .py-25 {
            padding-bottom: .75rem !important;
        }

        .pt-25,
        .py-25 {
            padding-top: .75rem !important;
        }

        .bgc-default-tp1 {
            background-color: rgba(121, 169, 197, .92) !important;
        }

        .bgc-default-l4,
        .bgc-h-default-l4:hover {
            background-color: #f3f8fa !important;
        }

        .page-header .page-tools {
            -ms-flex-item-align: end;
            align-self: flex-end;
        }

        .btn-light {
            color: #757984;
            background-color: #f5f6f9;
            border-color: #dddfe4;
        }

        .w-2 {
            width: 1rem;
        }

        .text-120 {
            font-size: 120% !important;
        }

        .text-primary-m1 {
            color: #4087d4 !important;
        }

        .text-danger-m1 {
            color: #dd4949 !important;
        }

        .text-blue-m2 {
            color: #68a3d5 !important;
        }

        .text-150 {
            font-size: 150% !important;
        }

        .text-60 {
            font-size: 60% !important;
        }

        .text-grey-m1 {
            color: #7b7d81 !important;
        }

        .align-bottom {
            vertical-align: bottom !important;
        }
    </style>
</head>
<body id="invoice">
<div class="page-content container">
    <div class="page-header text-blue-d2">
        <h1 class="page-title text-secondary">Invoice <small class="page-info"><i class="fa fa-angle-double-right text-80"></i> ID: #<?php echo $row_booking[0]; ?></small></h1>
    </div>
    <div class="container px-0">
        <div class="row mt-4">
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-12">
                        <div class="text-center text-150">
                            <h1>Aimane<span>Cars</span></h1>
                        </div>
                    </div>
                </div>
                <hr class="row brc-default-l1 mx-n1 mb-4"/>
                <div class="row">
                    <div class="col-sm-6">
                        <div>
                            <span class="text-sm text-grey-m2 align-middle">To:</span>
                            <span class="text-600 text-110 text-primary align-middle"><?php echo $row_renter[0] . ' ' . $row_renter[1]; ?></span>
                        </div>
                        <div class="text-grey-m2">
                            <div class="my-1"><i class="fa fa-id-card text-secondary"></i> <b class="text-600"><?php echo $row_renter[2]; ?></b></div>
                        </div>
                        <div class="text-grey-m2">
                            <div class="my-1"><i class="fa fa-phone fa-flip-horizontal text-secondary"></i> <b class="text-600"><?php echo $row_renter[3]; ?></b></div>
                        </div>
                    </div>
                    <div class="text-95 col-sm-6 align-self-start d-sm-flex justify-content-end">
                        <hr class="d-sm-none" />
                        <div class="text-grey-m2">
                            <div class="mt-1 mb-2 text-secondary-m1 text-600 text-125">Invoice</div>
                            <div class="my-2"><i class="fa fa-circle text-primary text-xs mr-1"></i> <span class="text-600 text-90">ID:</span> #<?php echo $row_booking[0]; ?></div>
                            <div class="my-2"><i class="fa fa-circle text-primary text-xs mr-1"></i> <span class="text-600 text-90">Issue Date:</span> <?php echo $row_booking[3]; ?></div>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <table class="w-100 rounded-3 overflow-hidden bg-light shadow-sm text-center">
                        <thead>
                            <tr class="bg-primary text-uppercase">
                                <th>Car Manufacturer</th>
                                <th>Car Model</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Duration</th>
                                <th>Car price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-light">
                                <td><?php echo $row_car[0]; ?></td>
                                <td><?php echo $row_car[1]; ?></td>
                                <td><?php echo $row_booking[4]; ?></td>
                                <td><?php echo $row_booking[5]; ?></td>
                                <td><?php echo $row_booking[6]; ?> Day</td>
                                <td>$<?php echo $row_car[2]; ?></td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                    <div class="row border-b-2 brc-default-l2"></div>
                    <div class="row mt-3">
                        <div class="col-12 col-sm-7 text-grey-d2 text-95 mt-2 mt-lg-0">
                        </div>
                        <div class="col-12 col-sm-5 text-grey text-90 order-first order-sm-last">
                            <div class="row my-2 align-items-center bgc-primary-l3 p-2">
                                <div class="col-7 text-right">
                                    Total Amount
                                </div>
                                <div class="col-5">
                                    <span class="text-150 text-success-d3 opacity-2">$<?php echo $row_booking[7]; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    const invoice = document.getElementById('invoice');
    var opt = {
        filename: '<?php echo $row_renter[0] . ' ' . $row_renter[1]; ?>',
        image: { type: 'jpeg', quality: 1 },
        jsPDF: { unit: 'in', format: 'A4', orientation: 'landscape' }
    };
    html2pdf().set(opt).from(invoice).save();
</script>
</body>
</html>
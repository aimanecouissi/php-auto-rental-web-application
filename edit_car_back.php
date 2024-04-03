<?php
session_start();
require 'partials/connection.php';
require 'partials/functions.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['edit'])) {
        if (isset($_POST['car']) && isset($_POST['manufacturer']) && isset($_POST['model']) && isset($_POST['details']) && isset($_POST['price'])) {
            if (!empty($_POST['car']) && !empty($_POST['manufacturer']) && !empty($_POST['model']) && !empty($_POST['details']) && !empty($_POST['price'])) {
                $car = filter_var($_POST['car'], FILTER_SANITIZE_NUMBER_INT);
                $manufacturer = htmlspecialchars($_POST['manufacturer']);
                $model = filter_var($_POST['model']);
                $details = filter_var($_POST['details'], FILTER_SANITIZE_URL);
                $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT);
                if (filter_var($car, FILTER_VALIDATE_INT) && filter_var($details, FILTER_VALIDATE_URL) && filter_var($price, FILTER_VALIDATE_FLOAT)) {
                    $addtional_query = '';
                    if (isset($_FILES['image']) && !empty($_FILES['image'])) {
                        if (!empty($_FILES["image"]["tmp_name"])) {
                            $check = getimagesize($_FILES["image"]["tmp_name"]);
                            if ($check) {
                                if ($_FILES["image"]["tmp_name"] <= 500000) {
                                    $image_name = uniqid('', true) . '.jpg';
                                    $image_path = 'files/cars/images/' . $image_name;
                                    move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
                                    $addtional_query = ", image = '" . $image_path . "'";
                                }
                            }
                        }
                    }
                    $query = "UPDATE model SET name = '$model', price = $price, details = '$details', manufacturer = '$manufacturer'$addtional_query WHERE id = " . $car;
                    mysqli_query($con, $query);
                    header('Location:edit_car?car=' . $car);
                    exit;
                }
                else {
                    header('Location:my_cars?page=1');
                }
            }
            else {
                header('Location:my_cars?page=1');
            }
        }
        else {
            header('Location:my_cars?page=1');
        }
    }
    else if (isset($_POST['delete'])) {
        if (isset($_POST['car']) && !empty($_POST['car'])) {
            $query = "DELETE FROM model WHERE id = " . $_POST['car'];
            mysqli_query($con, $query);
            header('Location:my_cars?page=1');
            exit;
        }
    }
    else {
        header('Location:my_cars?page=1');
    }
}
else {
    header('Location:my_cars?page=1');
    exit;
}
mysqli_close($con);
?>
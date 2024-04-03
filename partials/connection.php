<?php
$con = mysqli_connect('localhost', 'root', '', 'aimanecars');
if (isset($_COOKIE['renter']) && isset($_COOKIE['full_name'])) {
    $_SESSION['renter'] = $_COOKIE['renter'];
    $_SESSION['full_name'] = $_COOKIE['full_name'];
}
?>
<?php
session_start();
session_unset();
session_destroy();
unset($_COOKIE['renter']);
unset($_COOKIE['full_name']);
setcookie('renter', '', time() - 86400 * 30);
setcookie('full_name', '', time() - 86400 * 30);
header("Location:index");
exit;
?>
<?php
if (isset($_SESSION['renter']))
    require 'partials/navbars/navbar_renter.php';
elseif (isset($_SESSION['admin']))
    require 'partials/navbars/navbar_admin.php';
else
    require 'partials/navbars/navbar_offline.php';
$status = $_SERVER['REDIRECT_STATUS'];
$codes = array(
        400 => array('400 Bad Request', 'The request cannot be fulfilled due to bad syntax.'),
        401 => array('401 Login Error', 'It appears that the password and/or user-name you entered was incorrect.'),
        403 => array('403 Forbidden', 'Sorry, employees and staff only.'),
        404 => array('404 Missing', 'We\'re sorry, but the page you\'re looking for is missing, hiding, or maybe it moved somewhere else and forgot to tell you.'),
        405 => array('405 Method Not Allowed', 'The method specified in the Request-Line is not allowed for the specified resource.'),
        408 => array('408 Request Timeout', 'Your browser failed to send a request in the time allowed by the server.'),
        414 => array('414 URL To Long', 'The URL you entered is longer than the maximum length.'),
        500 => array('500 Internal Server Error', 'The request was unsuccessful due to an unexpected condition encountered by the server.'),
        502 => array('502 Bad Gateway', 'The server received an invalid response from the upstream server while trying to fulfill the request.'),
        504 => array('504 Gateway Timeout', 'The upstream server failed to send a request in the time allowed by the server.'),
);
$errortitle = $codes[$status][0];
$message = $codes[$status][1];
if ($errortitle == false) {
        $errortitle = "Unknown Error";
        $message = "An unknown error has occurred.";
}
?>
<div class="min-vh-100 d-flex align-items-center justify-content-center pt">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="col-12 text-center">
                <h1 class="fw-bold display-1 text-primary"><i class="fa-solid fa-file-circle-xmark"></i></h1>
                <h1 class="fw-bold display-1 text-uppercase text-primary"><?php echo $errortitle; ?></h1>
                <p class="lead text-uppercase fw-semibold p-0 m-0"><?php echo $message; ?></p>
            </div>
        </div>
    </div>
</div>
<?php
require 'partials/footer.php';
?>
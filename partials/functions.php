<?php
function alert($color, $message) {
    return '<div class="alert alert-' . $color . ' text-center fw-semibold" role="alert">' . $message . '</div>';
}
?>
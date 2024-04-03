<?php
session_start();
require 'partials/connection.php';
require 'partials/functions.php';
if (isset($_SESSION['admin'])) {
    header('Location:add_car.php');
    exit;
}
if (isset($_SESSION['renter'])) {
    header('Location:index.php');
    exit;
}
$alert = $email = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email']) && !empty($_POST['email'])) {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            $alert = alert('danger', 'Please, do not play with the inputs');
        else {
            $query = "SELECT * FROM renter WHERE email = '$email'";
            $result = mysqli_query($con, $query);
            if (mysqli_num_rows($result) == 0)
                $alert = alert('warning', 'The email you entered does not exist');
            else {
                $code = rand(100000, 999999);
                $query = "UPDATE renter SET verification_code = $code WHERE email = '$email'";
                mysqli_query($con, $query);
                $_SESSION['forgotten'] = $email;
                $to = $email;
                $subject = "Verification Code";
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= "From: AimaneCars <contact@aimanecouissi.com>" . "\r\n";
                $headers .= "Reply-To: contact@aimanecouissi.com" . "\r\n";
                $headers .= "X-Priority: 1 (Highest)" . "\r\n";
                $headers .= "X-MSMail-Priority: High" . "\r\n";
                $headers .= "Importance: High" . "\r\n";
                $message = '<!DOCTYPE html> <html lang="en"> <head> <meta charset="UTF-8"> <meta http-equiv="X-UA-Compatible" content="IE=edge"> <meta name="viewport" content="width=device-width, initial-scale=1.0"> <title>Verification Code | AimaneCars</title> <style>@import url("https://fonts.googleapis.com/css2?family=Bai+Jamjuree:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&display=swap"); body{font-family: "Bai Jamjuree"; background-color: #ededed; margin: 0; padding: 0; color: black;}.wrapper{max-width: 600px; background-color: white;}.header, .footer{padding: 10px; font-weight: 500; background-color: #1b74e4; color: white;}.content{padding: 100px 0px; background-image: url("assets/img/bg.svg"); background-size: cover; background-position: center;}h1 span{color: white;}a{text-decoration: none; color: white;}.code{background-color: #1b74e4; display: inline-block; padding: 10px 25px; margin: 0; border-radius: 15px; color: white;}.content p{font-size: x-large; padding: 0; margin: 0;}</style> </head> <body> <center> <div class="wrapper"> <div class="header"> <div class="logo"> <h1>Aimane<span>Cars</span></h1> </div></div><div class="content"> <p>Your password reset verification code is:</p><br><h1 class="code">' . $code . '</h1> </div><div class="footer"> <p>&copy; ' . date('Y') . ' AimaneCars. All rights reserved.</p></div></div></center> </body> </html>';
                mail($to, $subject, $message, $headers);
                header('Location:verification_code.php');
                exit;
            }
        }
    }
}
mysqli_close($con);
require 'partials/navbars/navbar_offline.php';
?>
<div class="min-vh-100 d-flex align-items-center rounded-3 ptb bg-hero">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-7 col-lg-5">
                <div class="bg-white p-5 rounded-3 shadow-sm">
                    <h1 class="my-0 py-0 text-center fw-bold">Aimane<span>Cars</span></h1>
                    <p class="text-uppercase mb-4 mt-0 py-0 text-center fw-bold">— Forgotten Password —</p>
                    <form method="post" action="forgotten_password" autocomplete="off">
                        <?php echo $alert; ?>
                        <div class="position-relative">
                            <input type="email" maxlength="50" value="<?php echo $email; ?>" name="email" placeholder="Enter you email here" class="border-0 border-bottom border-2 rounded-0 form-control form-control-lg my-3" required>
                            <div class="position-absolute top-0 start-0 form-icon text-secondary">
                                <i class="bi bi-envelope"></i>
                            </div>
                        </div>
                        <div class="d-grid">
                            <input type="submit" value="Continue" class="btn btn-primary btn-lg fw-semibold rounded-3 text-uppercase">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'partials/footer.php'; ?>
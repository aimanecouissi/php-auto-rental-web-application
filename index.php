<?php
session_start();
require 'partials/connection.php';
require 'partials/functions.php';
if (isset($_SESSION['admin'])) {
    header('Location:add_car.php');
    exit;
}
$query = 'SELECT manufacturer.*, model.* FROM manufacturer, model WHERE manufacturer.id = model.manufacturer ORDER BY model.id DESC LIMIT 6';
$result = mysqli_query($con, $query);
mysqli_close($con);
if (isset($_SESSION['renter']))
    require 'partials/navbars/navbar_renter.php';
else
    require 'partials/navbars/navbar_offline.php';
?>
<section class="min-vh-100 d-flex align-items-center rounded-3 bg-hero pt">
    <div class="container">
        <div class="row gx-lg-5 align-items-center">
            <div class="col-12 col-lg-6 text-center text-lg-start" data-aos="fade-right">
                <h2 class="text-uppercase fw-semibold">Drive your dream car with</h2>
                <h1 class="display-1 fw-bold">Aimane<span>Cars</span></h1>
                <a href="#about" class="btn btn-dark btn-lg rounded-3 px-4 text-uppercase mt-2">Learn More<i class="ms-3 fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="d-none d-lg-block col-lg-6" data-aos="fade-left">
                <img src="assets/img/illus.svg" alt="illustration" class="img-fluid floating">
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row my-5 pt-5">
            <div class="col-12 text-center">
                <h3 class="fw-semibold display-6 text-uppercase text-primary">Our Cars</h3>
                <p class="lead text-uppercase fw-normal">Find your favorite car with the cheapest price ever</p>
            </div>
        </div>
        <div class="row g-4 mb-5 justify-content-center">
            <?php while ($row = mysqli_fetch_array($result)) { ?>
            <div class="col-md-6 col-lg-4" data-aos="fade-up">
                <div class="bg-white rounded-3 shadow-sm">
                    <div class="card-custom-img overflow-hidden rounded-3">
                        <img src="<?php echo $row[4]; ?>" alt="car image" class="img-fluid rounded-3">
                    </div>
                    <div class="card-custom-content p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <img src="<?php echo $row[2]; ?>" alt="car logo" height="50" width="50" class="me-3">
                                <div>
                                    <h5 class="fw-semibold my-0"><?php echo $row[1]; ?></h5>
                                    <h6 class="my-0"><?php echo $row[5]; ?></h6>
                                </div>
                            </div>
                            <span class="fw-semibold">$<?php echo $row[6]; ?>/DAY</span>
                        </div>
                        <div class="mt-4">
                            <a href="<?php if (!isset($_SESSION['renter'])) echo 'login.php'; else echo 'booking?car=' . $row[3]; ?>" class="btn btn-primary rounded-3 w-100 mb-2 text-uppercase fw-semibold">Rent Now</a>
                            <a href="<?php echo $row[7]; ?>" class="btn btn-outline-primary rounded-3 w-100 text-uppercase fw-semibold" target="_blank">Details</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="row my-5 justify-content-center">
            <div class="col-md-6 col-lg-4 d-grid">
                <a href="cars?page=1" class="fw-bold h5 btn btn-primary rounded-3 py-2 text-uppercase shadow">View More</a>
            </div>
        </div>
        <div class="row my-5 pt-5" id="about">
            <div class="col-12 text-center">
                <h3 class="fw-semibold display-6 text-uppercase text-primary">Features</h3>
                <p class="lead text-uppercase fw-normal">The special things about us</p>
            </div>
        </div>
        <div class="row g-4 mb-5 justify-content-center">
            <div class="col-md-6 col-lg-4" data-aos="fade-up">
                <div class="bg-white rounded-3 p-4 shadow-sm card-overlay position-relative overflow-hidden">
                    <div class="feature-icon rounded-3 h5 mb-3">
                        <i class="fa-solid fa-thumbs-up"></i>
                    </div>
                    <h4 class="fw-bold text-uppercase">Easy to use</h4>
                    <p>You don't need to have any skills to use my website, it is easy and simple for everyone.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4" data-aos="fade-up">
                <div class="bg-white rounded-3 p-4 shadow-sm card-overlay position-relative overflow-hidden">
                    <div class="feature-icon rounded-3 h5 mb-3">
                        <i class="fa-solid fa-car"></i>
                    </div>
                    <h4 class="fw-bold text-uppercase">Exclusive cars</h4>
                    <p>At AimaneCars, we bring you the latest of cars from all types, from SUVs to Supercars.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4" data-aos="fade-up">
                <div class="bg-white rounded-3 p-4 shadow-sm card-overlay position-relative overflow-hidden">
                    <div class="feature-icon rounded-3 h5 mb-3">
                        <i class="fa-solid fa-dollar-sign"></i>
                    </div>
                    <h4 class="fw-bold text-uppercase">Best prices</h4>
                    <p>Compared to the quality, be sure that you won't find these prices anywhere else.</p>
                </div>
            </div>
        </div>
        <div class="row my-5 pt-5">
            <div class="col-12 text-center">
                <h3 class="fw-semibold display-6 text-uppercase text-primary">Reviews</h3>
                <p class="lead text-uppercase fw-normal">Read what our customers say about us</p>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-12">
                <div class="owl-carousel owl-theme">
                    <div class="rounded-3 bg-white p-4 shadow-sm testimonial mb-3">
                        <div class="text-warning mb-4">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <div class="mb-4">
                            <p><span class="text-primary h4 me-3"><i class="fa-solid fa-quote-left"></i></span>I had a great experience renting a car through this website! The process was easy and the customer service was outstanding. I highly recommend it to anyone in need of a rental car, it's really amazing.</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <img src="assets/img/renter.png" alt="customer image" class="rounded-circle">
                            <div class="ms-3">
                                <h5 class="my-0 fw-semibold">John Smith</h5>
                                <h6 class="my-0">Business Traveler</h6>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-3 bg-white p-4 shadow-sm testimonial mb-3">
                        <div class="text-warning mb-4">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                        </div>
                        <div class="mb-4">
                            <p><span class="text-primary h4 me-3"><i class="fa-solid fa-quote-left"></i></span>I have been using this car rental website for all of my vacation rentals and have never been disappointed. The prices are always reasonable and the cars are always in great condition. Highly recommend it!</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <img src="assets/img/renter.png" alt="customer image" class="rounded-circle">
                            <div class="ms-3">
                                <h5 class="my-0 fw-semibold">Sarah Johnson</h5>
                                <h6 class="my-0">Vacationer</h6>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-3 bg-white p-4 shadow-sm testimonial mb-3">
                        <div class="text-warning mb-4">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <div class="mb-4">
                            <p><span class="text-primary h4 me-3"><i class="fa-solid fa-quote-left"></i></span>I needed a car for a last-minute business trip and this website made it so easy to find and book a rental. The car was exactly as described and the pickup and drop-off process was a breeze.</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <img src="assets/img/renter.png" alt="customer image" class="rounded-circle">
                            <div class="ms-3">
                                <h5 class="my-0 fw-semibold">Michael Brown</h5>
                                <h6 class="my-0">Business Professional</h6>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-3 bg-white p-4 shadow-sm testimonial mb-3">
                        <div class="text-warning mb-4">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                        </div>
                        <div class="mb-4">
                            <p><span class="text-primary h4 me-3"><i class="fa-solid fa-quote-left"></i></span>I was a little hesitant to rent a car through an online website, but this one exceeded my expectations. The selection of vehicles was great and the customer service was top-notch. I will definitely be using this website again.</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <img src="assets/img/renter.png" alt="customer image" class="rounded-circle">
                            <div class="ms-3">
                                <h5 class="my-0 fw-semibold">Karen Smith</h5>
                                <h6 class="my-0">Road Tripper</h6>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-3 bg-white p-4 shadow-sm testimonial mb-3">
                        <div class="text-warning mb-4">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <div class="mb-4">
                            <p><span class="text-primary h4 me-3"><i class="fa-solid fa-quote-left"></i></span>I recently used this car rental website for a family road trip and it was a great experience. The website was easy to navigate, the cars were in great condition, and the customer service was outstanding.</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <img src="assets/img/renter.png" alt="customer image" class="rounded-circle">
                            <div class="ms-3">
                                <h5 class="my-0 fw-semibold">Emily Davis</h5>
                                <h6 class="my-0">Family Traveler</h6>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-3 bg-white p-4 shadow-sm testimonial mb-3">
                        <div class="text-warning mb-4">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                        </div>
                        <div class="mb-4">
                            <p><span class="text-primary h4 me-3"><i class="fa-solid fa-quote-left"></i></span>I have used this website multiple times for business rentals and have never had a problem. The cars are always in great condition and the customer service is always helpful. I highly recommend it to anyone in need of a rental car.</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <img src="assets/img/renter.png" alt="customer image" class="rounded-circle">
                            <div class="ms-3">
                                <h5 class="my-0 fw-semibold">David Wilson</h5>
                                <h6 class="my-0">WBusiness Traveler</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-5 pt-5">
            <div class="col-12 text-center">
                <h3 class="fw-semibold display-6 text-uppercase text-primary">Location</h3>
                <p class="lead text-uppercase fw-normal">We are open from 09:00 AM to 06:00 PM</p>
            </div>
        </div>
        <div class="row mb-5 justify-content-center">
            <div class="col-12">
                <iframe class="rounded shadow-sm w-100" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3307.573211304535!2d-6.847840584855727!3d34.00349458061931!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xda76c89d87752c9%3A0xfa1d80a264d4ba2b!2sArribat%20Center!5e0!3m2!1sen!2sma!4v1658743380537!5m2!1sen!2sma" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</section>
<?php require 'partials/footer.php'; ?>
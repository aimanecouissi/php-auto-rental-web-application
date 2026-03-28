<?php require __DIR__ . '/../head.php'; ?>
<header>
    <nav class="navbar navbar-expand-lg bg-white shadow-sm py-3 fixed-top">
        <div class="container">
            <a class="navbar-brand" href="add_car">Aimane<span>Cars</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item me-lg-3">
                        <a class="nav-link <?php if (basename($_SERVER['PHP_SELF'], '.php') == 'add_car') echo 'active'; ?>" href="add_car"><i class="fa-solid fa-circle-plus me-2"></i>Add Car</a>
                    </li>
                    <li class="nav-item me-lg-3">
                        <a class="nav-link <?php if (basename($_SERVER['PHP_SELF'], '.php') == 'my_cars') echo 'active'; ?>" href="my_cars?page=1"><i class="fa-solid fa-car me-2"></i></i>My Cars</a>
                    </li>
                    <li class="nav-item me-lg-3">
                        <a class="nav-link <?php if (basename($_SERVER['PHP_SELF'], '.php') == 'bookings') echo 'active'; ?>" href="bookings?page=1"><i class="fa-solid fa-table me-2"></i>Bookings</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php if (basename($_SERVER['PHP_SELF'], '.php') == 'my_password') echo 'active'; ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-user me-2"></i>Admin
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="logout">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<?php require __DIR__ . '/../head.php'; ?>
<header>
    <nav class="navbar navbar-expand-lg bg-white shadow-sm py-3 fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index">Aimane<span>Cars</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item me-lg-3">
                        <a class="nav-link <?php if (basename($_SERVER['PHP_SELF'], '.php') == 'index') echo 'active'; ?>" href="index"><i class="fa-solid fa-house me-2"></i>Home</a>
                    </li>
                    <li class="nav-item me-lg-3">
                        <a class="nav-link <?php if (basename($_SERVER['PHP_SELF'], '.php') == 'cars') echo 'active'; ?>" href="cars?page=1"><i class="fa-solid fa-car me-2"></i></i>Cars</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php if (basename($_SERVER['PHP_SELF'], '.php') == 'my_bookings' or basename($_SERVER['PHP_SELF'], '.php') == 'my_profile') echo 'active'; ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-user me-2"></i><?php echo $_SESSION['full_name']; ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="my_bookings">My Bookings</a></li>
                            <li><a class="dropdown-item" href="my_profile">My Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="logout">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
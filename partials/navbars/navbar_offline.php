<?php require __DIR__ . '/../head.php'; ?>
<header>
    <nav class="navbar navbar-expand-lg bg-white shadow-sm py-2 fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index">Aimane<span>Cars</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 align-items-lg-center">
                    <li class="nav-item me-lg-3">
                        <a class="nav-link <?php if (basename($_SERVER['PHP_SELF'], '.php') == 'index') echo 'active'; ?>" href="index"><i class="fa-solid fa-house me-2"></i>Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if (basename($_SERVER['PHP_SELF'], '.php') == 'cars') echo 'active'; ?>" href="cars?page=1"><i class="fa-solid fa-car me-2"></i></i>Cars</a>
                    </li>
                </ul>
                <a class="btn btn-outline-primary d-inline-block rounded-3 fw-semibold text-uppercase px-3 py-2 me-2" href="login"><i class="fa-solid fa-lock me-2"></i>Login</a>
                <a class="btn btn-primary rounded-3 d-inline-block fw-semibold text-uppercase px-3 py-2" href="register"><i class="fa-solid fa-user-plus me-2"></i>Sign-up</a>
            </div>
        </div>
    </nav>
</header>
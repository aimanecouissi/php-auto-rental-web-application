# AUTO RENTAL WEB APPLICATION 🚗

A 3rd-year internship project built with PHP and MySQL that allows users to search and book cars using various filters, manage their profiles, and download booking receipts. Administrators can manage the car inventory and review customer bookings.

## FEATURES ✨

- **Car Search** — Search the car catalog by manufacturer, model, and daily price range.
- **Booking System** — Book cars for selected dates with automatic rental duration and price calculation.
- **Receipt Download** — Download a PDF receipt for each completed booking.
- **User Authentication** — Register, log in, and recover passwords through email verification.
- **Profile Management** — View and update personal information and profile details.
- **Booking History** — Review previous reservations and access booking receipts.
- **Admin Panel** — Add, edit, and delete cars, and view customer bookings.

## TECHNOLOGIES 🚀

- **PHP** — Server-side scripting language for backend development.
- **MySQL** — Relational database for storing application data.
- **MySQLi** — PHP extension used for database connectivity.
- **HTML/CSS/JavaScript** — Frontend technologies for building the user interface.
- **Bootstrap** — Frontend framework for responsive, mobile-first design.
- **html2pdf.js** — Client-side library for generating downloadable PDF receipts.

## DEMO 🎬

Watch the demo on [YouTube](https://youtu.be/TyGrSlpxUnE).

## PREREQUISITES 📋

Before getting started, ensure you have the following:

- **PHP** — With the MySQLi extension enabled.
- **MySQL** — A local or accessible database instance.
- **Web Server** — Apache or another PHP-capable HTTP server.
- **Local Development Environment** — Such as XAMPP, WAMP, or MAMP, if preferred.
- **PHP Mail Configuration** — Required to use the email-based password recovery functionality.

The application also uses extensionless PHP URLs, so the web server must support routing requests such as `/cars` to the corresponding `cars.php` file.

## INSTALLATION ⚙️

1. Clone the repository into your local web server's document root, or configure your web server to serve the repository directory.
2. Create a MySQL database named `aimanecars`.
3. Import `aimanecars.sql` into the created database to initialize the tables and load the supplied sample data.
4. Open `partials/connection.php` and update the database connection details to match your MySQL instance.
5. Configure your web server to resolve the extensionless routes used by the application. The repository does not include an `.htaccess` or equivalent routing configuration, so this behavior must be provided by the local server.
6. Ensure `files/cars/images/` and `files/renters/photos/` exist and are writable by the PHP process for uploaded car images and renter profile photos.
7. Configure PHP's mail transport if you want to test password recovery.
8. Start your local web server and MySQL instance, then open the application's configured local URL in your browser.

The project is a plain PHP application and does not require Composer dependency installation.

The database export contains sample records, but the original server routing configuration and a complete fresh-install login procedure are not included in the repository. Additional local web server configuration may therefore be required.

## CONTRIBUTING 🤝

Contributions are welcome! Please follow these guidelines:

1. Follow the existing project structure and coding conventions.
2. Use [Conventional Commits](https://www.conventionalcommits.org/) for commit messages.
3. Test your changes locally whenever possible.
4. Update the documentation when introducing new features or changing existing functionality.

## LICENSE 📄

This project is licensed under the [MIT License](LICENSE).

## CONTACT 📧

For any questions or feedback, reach out at [contact@aimanecouissi.com](mailto:contact@aimanecouissi.com).

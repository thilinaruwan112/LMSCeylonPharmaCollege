<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<?php
// Database Connection & Other Configuration
require_once './include/configuration.php';
$PageName = "Home";
$pageId = 1;

include './include/site-data.php';
?>

<head>
    <!-- Meta Description -->
    <?php include './include/meta-description.php' ?>
    <!-- End of  Meta Description -->

    <title><?= $PageName ?> | <?= $SiteTitle ?></title>

    <!-- Common CSS -->
    <?php include './include/common-css.php' ?>
    <!-- End of Common CSS -->
</head>

<body>


    <!-- Include Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-b7pA0ytA3/5l6lK5Jo3p8NE3fo4I9q6Rd0W29kck1Ly2qdaT2l2fD/dRKTf5BIh" crossorigin="anonymous"></script>

    <!-- Dark Mode Toggle Script -->
    <script>
        function toggleDarkMode() {
            const htmlElement = document.documentElement;
            const currentTheme = htmlElement.getAttribute("data-bs-theme");
            toggleBackgrounds()

            if (currentTheme === "dark") {
                htmlElement.setAttribute("data-bs-theme", "light");
            } else {
                htmlElement.setAttribute("data-bs-theme", "dark");
            }
        }

        function toggleBackgrounds() {
            // Toggle background for the navigation element
            const navbar = document.getElementById('navbar');
            toggleBackground(navbar);

            // Toggle background for the bottom menu element
            const bottomMenu = document.getElementById('bottomMenu');
            toggleBackground(bottomMenu);

            const credits = document.getElementById('credits');
            toggleBackground(credits);
        }

        function toggleBackground(element) {
            // Check if 'bg-light' class is present, then toggle to 'bg-dark'
            if (element.classList.contains('bg-light')) {
                element.classList.remove('bg-light');
                element.classList.add('bg-dark');
            } else {
                // Otherwise, toggle to 'bg-light'
                element.classList.remove('bg-dark');
                element.classList.add('bg-light');
            }
        }
    </script>
    <!-- Pre Loader Content -->
    <?php include './include/pre-loader.php' ?>
    <!-- End of  Pre Loader Content -->
    <div class="container">

        <!-- Footer -->
        <?php include './include/nav-menu.php' ?>
        <!-- End of Footer -->
        <!-- 
        bin2hex(random_bytes(32)); // Generates a 256-bit (32-byte) random key -->

        <!-- Page Content -->
        <div id="root"></div>
        <!-- End of Page Content -->


        <!-- Footer -->
        <?php include './include/footer-menu.php' ?>
        <!-- End of Footer -->

        <!-- Footer -->
        <?php include './include/footer.php' ?>
        <!-- End of Footer -->

        <!-- Credits -->
        <?php include './include/credits.php' ?>
        <!-- End of Credits -->
    </div>

    <!-- Common scripts -->
    <?php include './include/common-scripts.php' ?>
    <!-- End of Common scripts -->

    <!-- Custom Scripts -->
    <script src="./lib/home/assets/js/home-1.0.1.js"></script>
    <!-- End of Custom Scripts -->
</body>

</html>
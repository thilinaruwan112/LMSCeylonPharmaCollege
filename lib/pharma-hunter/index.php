<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
include '../../php_handler/pharma_hunter_functions.php';

$UserLevel = $_POST['UserLevel'];
$loggedUser = $_POST['LoggedUser'];
$CourseCode = $_POST['CourseCode'];
$prescriptionList = GetPrescriptions();
?>

<style>
    .admin-card:hover {
        background-color: #000;
        color: #fff !important;
    }

    .admin-card:hover h4 {
        color: #fff !important;
    }

    .game-card:hover {
        background-color: #000;
        color: #fff !important;
    }

    .game-card:hover h4 {
        color: #fff !important;
    }
</style>

<div class="site-title">
    <?php $UserDetails =  GetUserDetails($link, $loggedUser); ?>
    <div class="row">
        <div class="col-8">
            <h2 class="greet-text">Hi <?= $UserDetails['first_name'] ?> <?= $UserDetails['last_name'] ?></h2>
            <p class="text-secondary">Let's Make this day Productive</p>
        </div>
        <div class="col-4 text-center">
            <div class="profile-image" style="background-image : url('./assets/images/user.png')"></div>
        </div>
    </div>
</div>

<div id="index-content">
    <div class="row g-3">
        <?php if ($UserLevel != "Student") { ?>
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="section-topic mt-0">Admin Panel</h4>
                            </div>

                            <div class="col-6 col-md-4 mb-2 d-flex">
                                <div class="card admin-card border-0 rounded-4 shadow-sm flex-fill clickable" onclick="AddAnswers(0)">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <i class="fa-brands fa-3x fa-wirsindhandwerk"></i>
                                                <h5 class="card-title mb-0">Answers</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        <?php } ?>
        <div class="col-12">
            <h4 class="section-topic">Let's Read Prescriptions</h4>
        </div>

        <?php
        if (!empty($prescriptionList)) {
            $loopCount = 0; // Initialize the loop count.

            foreach ($prescriptionList as $selectedArray) {
                // Reset the loop count to 0 after every 10 iterations.
                if ($loopCount == 10) {
                    $loopCount = 0;
                }

                $loopCount++; // Increment the loop count.
                $bgColor = "primary";

                // if ($UserLevel == "Student") {
                //     continue;
                // }
        ?>
                <div class="col-6 col-md-4 d-flex">
                    <div class="card clickable border-0 admin-card shadow-sm flex-fill text-center" onclick="OpenPrescription('<?= $selectedArray['prescription_id'] ?>', '<?= $loopCount ?>')">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="card-title mb-0"><?= $selectedArray['prescription_name'] ?></h4>
                                    <!-- <div class="badge badge-primary bg-<?= $bgColor ?>">Success</div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        <?php
            }
        }
        ?>
    </div>
</div>
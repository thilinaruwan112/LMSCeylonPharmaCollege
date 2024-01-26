<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
include './php_methods/pharma-hunter-methods.php';

$userLevel = $_POST['UserLevel'];
$loggedUser = $_POST['LoggedUser'];
$CourseCode = $_POST['CourseCode'];
$medicineItems = [
    1 => ['id' => 1, 'medicineName' => "Paracetamol 200mg", 'filePath' => "Panadol-Tablets.jpg"],
    2 => ['id' => 2, 'medicineName' => "Paracetamol 500mg", 'filePath' => "image1.png"]
];
$overallGrade = 23.5;

$selectedArray = $medicineItems[1];
$medicineId = $selectedArray['id'];
$medicineName = $selectedArray['medicineName'];
$filePath = $selectedArray['filePath'];

$storingGrade = rand(50, 100);
$totalScore = 50;
$totalCorrectScore = 50;

$savedStatus = 0
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

<div class="row mt-2 mb-5">
    <div class="col-12">
        <div class="card border-0 rounded-bottom-4 rounded-top-3" id="bubbleCard">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <button onclick="redirectToURL('./')" type="button" class="btn btn-light back-button">
                            <i class="fa-solid fa-arrow-left-long"></i>
                        </button>
                    </div>

                    <div class="col-6">
                        <div class="profile-image profile-image-mini" style="background-image : url('./assets/images/user.png')"></div>
                    </div>


                    <div class="col-12 text-center">
                        <div class="grade-value-container">
                            <div class="grade-value-overlay-1">
                                <div class="grade-value-overlay-2">
                                    <input type="hidden" id="gradeValue" value="<?= $overallGrade ?>">
                                    <div class="grade-value" id="counter"><?= number_format($overallGrade, 1) ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card quiz-card border-0">
            <div class="card-body">
                <div class="quiz-img-box">
                    <img src="./lib/home/assets/images/medicine.gif" class="quiz-img rounded-4">
                </div>
                <h1 class="card-title text-center mt-2 fw-bold bg-light p-3 rounded-5 mb-0">Pharma Hunter</h1>

                <?php if ($userLevel != "Student") { ?>
                    <div class="border-top mt-3"></div>
                    <h3 class="card-title mt-3 fw-bold rounded-4 mb-2">Admin Panel</h3>
                    <div class="row g-3">
                        <div class="col-12 col-md-3 col-xl-3 d-flex">
                            <button onclick="GeneratePrescription()" class="btn btn-purple w-100 p-3 flex-fill" type="button">
                                <i class="fa-solid fa-wand-magic-sparkles fa-2x"></i>
                                <h5 class="mb-0 mt-2">Generate</h5>
                            </button>
                        </div>

                        <div class="col-12 col-md-3 col-xl-3 d-flex">
                            <button onclick="NewPrescription()" class="btn btn-dark w-100 p-3 flex-fill" type="button">
                                <i class="fa-solid fa-plus fa-2x"></i>
                                <h5 class="mb-0 mt-2">Prescriptions</h5>
                            </button>
                        </div>

                        <div class="col-12 col-md-3 col-xl-3 d-flex">
                            <button onclick=" OpenControlPanel()" class="btn btn-primary w-100 p-3 flex-fill" type="button">
                                <i class="fa-solid fa-sliders fa-2x"></i>
                                <h5 class="mb-0 mt-2">Setting</h5>
                            </button>
                        </div>

                        <div class="col-12 col-md-3 col-xl-3 d-flex">
                            <button onclick="OpenSetting()" class="btn btn-success w-100 p-3 flex-fill" type="button">
                                <i class="fa-solid fa-file fa-2x"></i>
                                <h5 class="mb-0 mt-2">Results</h5>
                            </button>
                        </div>
                        <div class="col-12 col-md-3 col-xl-3 d-flex">
                            <button onclick="OpenSubmissionSetting()" class="btn btn-danger w-100 p-3 flex-fill" type="button">
                                <i class="fa-solid fa-user-xmark fa-2x"></i>
                                <h5 class="mb-0 mt-2">Submissions</h5>
                            </button>
                        </div>
                        <div class="col-12 col-md-3 col-xl-3 d-flex">
                            <button onclick="OpenPosProductPage()" class="btn btn-secondary w-100 p-3 flex-fill" type="button">
                                <i class="fa-solid fa-pills fa-2x"></i>
                                <h5 class="mb-0 mt-2">Products</h5>
                            </button>
                        </div>
                        <div class="col-12 col-md-3 col-xl-3 d-flex">
                            <button onclick="" class="btn btn-info text-white w-100 p-3 flex-fill" type="button">
                                <i class="fa-solid fa-stethoscope fa-2x"></i>
                                <h5 class="mb-0 mt-2">Counselling</h5>
                            </button>
                        </div>

                        <div class="col-12 col-md-3 col-xl-3 d-flex">
                            <button onclick="" class="btn btn-purple text-white w-100 p-3 flex-fill" type="button">
                                <i class="fa-solid fa-gear fa-2x"></i>
                                <h5 class="mb-0 mt-2">Setup</h5>
                            </button>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="row g-3 mt-4">
            <div class="col-12">
                <h5 class="border-bottom mb-2 pb-1 fw-bold">Available</h5>
            </div>
            <div class="col-12">
                <div class="card rounded-4 border-0 shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6 col-xl-6">
                                <img class="w-100 rounded-2" src="./lib/pharma-hunter/assets/images/uploads/<?= $filePath ?>" alt="<?= $medicineName ?>">
                            </div>
                            <div class="col-12 col-md-6 col-xl-6">
                                <?php
                                if ($savedStatus == 1) {
                                ?>
                                    <div class="row g-2 mt-4">
                                        <div class="col-12">
                                            <h4 class="card-title my-4 border-bottom pb-2 fw-bold"><?= $medicineName ?></h4>
                                        </div>
                                        <div class="col-3">
                                            <span class="w-100 badge btn-purple py-3"><?= $totalScore ?>/<?= $totalCorrectScore ?></span>
                                        </div>
                                        <div class="col-9">
                                            <?php
                                            if ($storingGrade < 0) {
                                                $storingGrade = 0;
                                            }
                                            $ProgressValue = number_format($storingGrade); ?>
                                            <p class="m-0"><?= $ProgressValue ?>%</p>
                                            <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="<?= $ProgressValue ?>" aria-valuemin="0" aria-valuemax="100">
                                                <div class="progress-bar" style="width: <?= $ProgressValue ?>%"><?= $ProgressValue ?>%</div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>

                                <div class="row g-4">

                                    <div class="col-12">
                                        <h5 class="border-bottom pb-2 fw-bold">Select storing Details</h5>
                                    </div>

                                    <div class="col-md-6">
                                        <p class="mb-0 text-secondary">Select Rack</p>
                                        <input required readonly type="text" name="rackId" id="rackId" class="w-100 btn btn-light" value="">
                                    </div>

                                    <div class="col-md-6">
                                        <p class="mb-0 text-secondary">Select Dosage Form</p>
                                        <input required readonly type="text" name="dosageForm" id="dosageForm" class="w-100 btn btn-light" value="">
                                    </div>

                                    <div class="col-md-6">
                                        <p class="mb-0 text-secondary">Select Drug Group</p>
                                        <input required readonly type="text" name="drugGroup" id="drugGroup" class="w-100 btn btn-light" value="">
                                    </div>

                                    <div class="col-md-6">
                                        <p class="mb-0 text-secondary">Select Category</p>
                                        <input required readonly type="text" name="drugCategory" id="drugCategory" class="w-100 btn btn-light" value="">
                                    </div>

                                    <div class="col-12 text-end mt-3">
                                        <button type="button" class="btn btn-dark"><i class="fa-solid fa-boxes-packing"></i> Save Changes</button>
                                    </div>

                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Script to add random bubbles -->
<script>
    var card = document.getElementById("bubbleCard");
    var positionPoints = [
        ['20%', '60%', '60px'],
        ['50%', '0%', '40px'],
        ['-10%', '20%', '100px'],
        ['80%', '65%', '50px'],
        ['75%', '30%', '90px'],
        ['10%', '65%', '15px']
    ];

    for (let i = 0; i < positionPoints.length; i++) {
        xPos = positionPoints[i][0];
        yPos = positionPoints[i][1];
        widthVal = positionPoints[i][2];
        createBubble(card, xPos, yPos, widthVal);
    }


    var gradeValueInput = document.getElementById('gradeValue');
    var overallDpadGrade = parseFloat(gradeValueInput.value);
    var counterElement = document.getElementById('counter')

    function updateCounter(value) {
        counterElement.textContent = value.toFixed(1);
    }

    function loadCounter() {
        let currentCounterValue = 0.0;
        const interval = 25; // Adjust the interval as needed
        const step = overallDpadGrade / (1000 / interval);

        const counterInterval = setInterval(function() {
            currentCounterValue += step;
            updateCounter(currentCounterValue);

            if (currentCounterValue >= overallDpadGrade) {
                clearInterval(counterInterval);
                updateCounter(overallDpadGrade);
            }
        }, interval);
    }

    // Call the function to start loading the counter
    loadCounter();
</script>
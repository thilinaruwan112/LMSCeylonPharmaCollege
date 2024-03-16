<?php

require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
include './php_methods/pharma-hunter-methods.php';

$userLevel = $_POST['UserLevel'];
$LoggedUser = $_POST['LoggedUser'];
$CourseCode = $_POST['CourseCode'];

$timeOfDay = getCurrentTimeOfDay();

$SettingValue = GetHunterProAttempts($link);
$SetAnswerLoopCount = $SettingValue;
$CountAnswer = $SettingValue;

$AttemptCount = 1;
if (isset($_POST['AttemptCount'])) {
    $AttemptCount = $_POST['AttemptCount'];
}

$Submissions = GetSubmissions($link, $CountAnswer, $LoggedUser);
$Medicines = GetHunterCourseMedicines($link, $CourseCode);

$UniqueMedicines = array_diff($Medicines, $Submissions);
$UniqueMedicines = array_values($UniqueMedicines);
$length = count($UniqueMedicines);
if (isset($_POST['MedicineID'])) {
    $MedicineID = $_POST['MedicineID'];

    if (in_array($MedicineID, $UniqueMedicines)) {
        if ($length > 0) {
            $selectedArray = GetMedicineByID($link, $MedicineID)[0];
        }
    }
} else {
    if ($length > 0) {
        $randomNumber = rand(0, $length - 1);
        $MedicineID = $UniqueMedicines[$randomNumber];
        $selectedArray = GetMedicineByID($link, $MedicineID)[0];
    }
}



$savedStatus = 0;
$AttemptCount = 5;
$Score = 60;
$MedicineCount = count($Medicines);

$AttemptRate = $AttemptCount / $CountAnswer;
if ($AttemptRate > $MedicineCount) {
    $AttemptRate = $MedicineCount;
}
$CompleteRate = ($MedicineCount > 0) ? ($AttemptRate / $MedicineCount) * 100 : 0;

$TotalScore = $AttemptCount * $CountAnswer * 4; //4 Selections 10 for each
$overallGrade = ($TotalScore > 0) ? ($Score / $TotalScore) * 100 : 0;


$medicineId = $selectedArray['id'];
$medicineName = $selectedArray['medicine_name'];
$filePath = $selectedArray['file_path'];

// Special for Pharma Hunter
$parts = explode("/", $filePath);
$filePath = end($parts);
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
                        <div class="p-2 text-light mt-3 fw-bold rounded-4 mb-3">Success Rate vs Complete Rate</div>
                        <div class="grade-value-container">
                            <div class="grade-value-overlay-1 mx-2">
                                <div class="grade-value-overlay-2">
                                    <input type="hidden" id="gradeValue" value="<?= $overallGrade ?>">
                                    <div class="grade-value" id="counter"><?= number_format($overallGrade, 1) ?></div>
                                </div>
                            </div>

                            <div class="grade-value-overlay-1 mx-2">
                                <div class="grade-value-overlay-2">
                                    <input type="hidden" id="gradeValue2" value="<?= $CompleteRate ?>">
                                    <div class="grade-value" id="counter2"><?= number_format($CompleteRate, 1) ?></div>
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
                            <button onclick="alert('Coming Soon.....')" class="btn btn-purple w-100 p-3 flex-fill" type="button">
                                <i class="fa-solid fa-wand-magic-sparkles fa-2x"></i>
                                <h5 class="mb-0 mt-2">Generate</h5>
                            </button>
                        </div>

                        <div class="col-12 col-md-3 col-xl-3 d-flex">
                            <button onclick="NewPrescription()" class="btn btn-dark w-100 p-3 flex-fill" type="button">
                                <i class="fa-solid fa-plus fa-2x"></i>
                                <h5 class="mb-0 mt-2">Medicine</h5>
                            </button>
                        </div>

                        <div class="col-12 col-md-3 col-xl-3 d-flex">
                            <button onclick=" OpenControlPanel()" class="btn btn-primary w-100 p-3 flex-fill" type="button">
                                <i class="fa-solid fa-sliders fa-2x"></i>
                                <h5 class="mb-0 mt-2">Setting</h5>
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
                <?php
                if (!empty($selectedArray)) {
                ?>
                    <div class="card rounded-4 border-0 shadow">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-6 col-xl-6">
                                    <img class="w-100 rounded-2" src="./lib/pharma-hunter/assets/images/hunter-pro/<?= $filePath ?>" alt="<?= $medicineName ?>">
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

                                    <form id="store-form" action="#" method="post">

                                        <div class="row g-4">
                                            <div class="col-12">
                                                <h5 class="border-bottom pb-2 fw-bold">Select storing Details</h5>
                                            </div>

                                            <div class="col-md-6">
                                                <p class="mb-0 text-secondary">Select Rack</p>
                                                <input onclick="fillDataValue('racks')" required readonly type="text" name="racks" id="racks" class="w-100 btn btn-light  p-3" value="">
                                                <input type="hidden" id="racksId" name="racksId">
                                            </div>

                                            <div class="col-md-6">
                                                <p class="mb-0 text-secondary">Select Dosage Form</p>
                                                <input onclick="fillDataValue('dosageForm')" required readonly type="text" name="dosageForm" id="dosageForm" class="w-100 btn btn-light p-3" value="">
                                                <input type="hidden" id="dosageFormId" name="dosageFormId">
                                            </div>

                                            <div class="col-md-6">
                                                <p class="mb-0 text-secondary">Select Drug Group</p>
                                                <input onclick="fillDataValue('drugGroup')" required readonly type="text" name="drugGroup" id="drugGroup" class="w-100 btn btn-light p-3" value="">
                                                <input type="hidden" id="drugGroupId" name="drugGroupId">
                                            </div>

                                            <div class="col-12">
                                                <div class="row g-2 g-md-4">
                                                    <div class="col-md-6">
                                                        <button onclick="OpenIndex()" type="button" class="btn btn-success w-100 bgn-lg p-3"><i class="fa-solid fa-forward"></i> Skip</button>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <button onclick="ValidateAnswer('<?= $medicineId ?>', '<?= $CourseCode ?>')" type="button" class="btn btn-dark  w-100 bgn-lg p-3"><i class="fa-solid fa-boxes-packing"></i> Store Drug</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                } else {
                ?>
                    <div class="alert alert-warning">Game Over</div>
                <?php
                }
                ?>
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
    var gradeValue2Input = document.getElementById('gradeValue2');

    var overallDpadGrade = parseFloat(gradeValueInput.value);
    var completeRate = parseFloat(gradeValue2Input.value);

    var counterElement = document.getElementById('counter');
    var counterElement2 = document.getElementById('counter2');

    function updateCounter(element, value) {
        element.textContent = value.toFixed(1);
    }

    function loadCounter(element, targetValue) {
        let currentCounterValue = 0.0;
        const interval = 25; // Adjust the interval as needed
        const step = targetValue / (1000 / interval);

        const counterInterval = setInterval(function() {
            currentCounterValue += step;
            updateCounter(element, currentCounterValue);

            if (currentCounterValue >= targetValue) {
                clearInterval(counterInterval);
                updateCounter(element, targetValue);
            }
        }, interval);
    }

    // Call the function to start loading the counter for counterElement
    loadCounter(counterElement, overallDpadGrade);

    // Call the function to start loading the counter for counterElement2
    loadCounter(counterElement2, completeRate);
</script>
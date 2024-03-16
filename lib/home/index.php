<?php

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
include '../../php_handler/course_functions.php';
include '../../php_handler/win-pharma-functions.php';
include '../../php_handler/old-hunter.php';
include '../../lib/quiz/php_method/quiz_methods.php';
include '../../lib/d-pad/php_methods/d-pad-methods.php';

$loggedUser = $_POST['LoggedUser'];
$courseCode = $_POST['defaultCourseCode'];

$batchCode = $courseCode;
$winPharmaLevels = GetLevels($link, $batchCode);
$getSubmissionLevelCount = GetSubmissionLevelCount($loggedUser, $batchCode);
$winPharmaLevelCount = count($winPharmaLevels);
if ($winPharmaLevelCount > 0) {
    $winPharmaPercentage = ($getSubmissionLevelCount / $winPharmaLevelCount) * 100;
} else {
    $winPharmaPercentage = 0;
}

// Payments
$studentBalanceArray = GetStudentBalance($loggedUser);
$studentBalance = $studentBalanceArray['studentBalance'];

// echo $loggedUser;
// var_dump($studentBalanceArray);
?>

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


<?php
if ($studentBalance != 0) {
?>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-warning border-2 shadow-sm" id="paymentAlert">
                You have to Pay <b>LKR <?= number_format($studentBalance, 2) ?></b>
            </div>
        </div>
    </div>
<?php
}
if ($courseCode != null) {
?>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-warning border-2 shadow-sm" id="courseAlert">

                Your Default course is <b><?= $courseCode ?> - <?= GetCourseDetails($courseCode)['course_name'] ?></b>
                <div class="text-start">
                    <button onclick="SetDefaultCourse(1)" type="button" class="btn btn-dark btn-sm">
                        <i class="fa-brands fa-slack"></i> Change Default Course
                    </button>
                    <button class="btn btn-danger btn-sm" onclick="$('#courseAlert').hide(500)">
                        <i class="fa-solid fa-xmark"></i> Close
                    </button>
                </div>


            </div>
        </div>
    </div>
<?php
} else {
    exit;
}
?>
<!-- <div class="row">
    <div class="col-12 p-3">
        <div class="card border-0 shadow-sm ranking-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-4 col-md-2 col-lg-1">
                                <img src="./lib/home/assets/images/trophy.png" class="ranking-icon">
                            </div>
                            <div class="col-8 col-md-10 col-lg-11">
                                <h2 class="rank-title">Ranking</h2>
                                <p class="rank-value">25</p>
                            </div>
                        </div>


                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-4 col-md-2 col-lg-1">
                                <img src="./lib/home/assets/images/star.png" class="ranking-icon">
                            </div>
                            <div class="col-8 col-md-10 col-lg-11">
                                <h2 class="rank-title">Points</h2>
                                <p class="rank-value">121</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->

<div class="row">
    <div class="col-12">
        <h4 class="section-topic">Common Modules</h4>
    </div>

    <div class="col-6 col-md-4 mb-2 d-flex">
        <div class="card game-card shadow-sm flex-fill" onclick="redirectToURL('course')">
            <div class="card-body text-center">
                <div class="row">
                    <div class="col-12">
                        <img src="./lib/course/assets/images/video-conference.gif" class="game-icon">
                        <h4 class="card-title">Course</h4>
                    </div>

                    <div class="col-12 mt-2">
                        <?php $ProgressValue = 0; ?>
                        <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="<?= $ProgressValue ?>" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: <?= $ProgressValue ?>%"><?= $ProgressValue ?>%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 mb-2 d-flex">
        <div class="card game-card shadow-sm flex-fill" onclick="redirectToURL('quiz')">
            <div class="card-body text-center">
                <div class="row">
                    <div class="col-12">
                        <img src="./lib/home/assets/images/question.gif" class="game-icon">
                        <h4 class="card-title">Quiz</h4>
                    </div>

                    <div class="col-12 mt-2">
                        <?php
                        $ProgressValue = number_format(GetOverallGrade($loggedUser, $courseCode));
                        if ($ProgressValue < 0) {
                            $ProgressValue = 0;
                        }
                        ?>
                        <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="<?= $ProgressValue ?>" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: <?= $ProgressValue ?>%"><?= $ProgressValue ?>%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-4 mb-2 d-flex">
        <div class="card game-card shadow-sm flex-fill" onclick="redirectToURL('course')">
            <div class="card-body text-center">
                <div class="row">
                    <div class="col-12">
                        <img src="./lib/home/assets/images/passed.gif" class="game-icon">
                        <h4 class="card-title">Exam</h4>
                    </div>

                    <div class="col-12 mt-2">
                        <?php $ProgressValue = 0; ?>
                        <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="<?= $ProgressValue ?>" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: <?= $ProgressValue ?>%"><?= $ProgressValue ?>%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <h4 class="section-topic">Let's Play</h4>
    </div>

    <div class="col-6 col-md-4 mb-2 d-flex">
        <div class="card game-card shadow-sm flex-fill">
            <div class="card-body text-center" onclick="redirectToURL('win-pharma')">
                <div class="row">
                    <div class="col-12">
                        <img src="./lib/home/assets/images/drugs.gif" class="game-icon">
                        <h4 class="card-title">Win Pharma</h4>
                    </div>

                    <div class="col-12 mt-2">
                        <?php $ProgressValue = $winPharmaPercentage; ?>
                        <p class="m-0"><?= number_format($ProgressValue) ?>%</p>
                        <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="<?= $ProgressValue ?>" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: <?= $ProgressValue ?>%"><?= number_format($ProgressValue, 2) ?>%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-4 mb-2 d-flex">
        <div class="card game-card shadow-sm flex-fill" onclick="redirectToURL('d-pad')">
            <div class="card-body text-center">
                <div class="row">
                    <div class="col-12">
                        <img src="./lib/home/assets/images/pill.gif" class="game-icon">
                        <h4 class="card-title">D Pad</h4>
                    </div>

                    <div class="col-12 mt-2">
                        <?php

                        $overallGradeDpad =  OverallGradeDpad($loggedUser)['overallGrade'];
                        $ProgressValue = number_format($overallGradeDpad); ?>
                        <p class="m-0"><?= $ProgressValue ?>%</p>
                        <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="<?= $ProgressValue ?>" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: <?= $ProgressValue ?>%"><?= $ProgressValue ?>%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-4 mb-2 d-flex">
        <div class="card game-card shadow-sm flex-fill" onclick="redirectToURL('ceylon-pharmacy')">
            <div class="card-body text-center">
                <?php
                $RecoveredPatientsCount =  GetRecoveredPatientsByCourse($link, $courseCode, $loggedUser);
                $CoursePatientsCount = count(GetCoursePatients($link, $courseCode));

                if ($CoursePatientsCount != 0) {
                    $ProgressValue = number_format(($RecoveredPatientsCount / $CoursePatientsCount) * 100);
                } else {
                    $ProgressValue = 0;
                }
                ?>
                <div class="row">
                    <div class="col-12">
                        <img src="./lib/ceylon-pharmacy/assets/images/pharmacy.gif" class="game-icon">
                        <h4 class="card-title">Ceylon Pharmacy</h4>
                    </div>

                    <div class="col-12 mt-2">
                        <p class="m-0"><?= $RecoveredPatientsCount ?> out of <?= $CoursePatientsCount ?></p>
                        <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="<?= $ProgressValue ?>" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: <?= $ProgressValue ?>%"><?= $ProgressValue ?>%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-4 mb-2 d-flex">
        <div class="card game-card shadow-sm flex-fill" onclick="redirectToURL('pharma-hunter')">
            <div class="card-body text-center">
                <div class="row">
                    <div class="col-12">
                        <img src="./lib/home/assets/images/medicine.gif" class="game-icon">
                        <h4 class="card-title">Pharma Hunter</h4>
                    </div>

                    <?php
                    // Pharma Hunter
                    $attemptPerMedicine = 10;
                    $hunterMedicines = HunterMedicines();
                    $medicineCount = count($hunterMedicines);
                    $savedCounts = HunterSavedAnswersByUser($loggedUser);

                    // echo $medicineCount;

                    $correctCount = $pendingCount = $wrongCount = $gemCount = $coinCount = 0;
                    $pendingCount = $medicineCount * $attemptPerMedicine;
                    if (isset($savedCounts[$loggedUser])) {
                        $correctCount = $savedCounts[$loggedUser]['correct_count'];
                        $pendingCount = $medicineCount * $attemptPerMedicine - $correctCount;
                        $wrongCount = $savedCounts[$loggedUser]['incorrect_count'];
                        $gemCount = $savedCounts[$loggedUser]['gem_count'];
                        $coinCount =  $savedCounts[$loggedUser]['coin_count'];

                        if ($coinCount >= 50) {
                            $gemCount = $gemCount + intval($coinCount / 50);
                            $coinCount = $coinCount % 50;
                        }
                    }

                    $ProgressValue = ($correctCount / ($medicineCount * $attemptPerMedicine)) * 100;
                    if ($ProgressValue > 100) {
                        $ProgressValue = 100;
                    }

                    ?>

                    <div class="col-12 mt-2">
                        <p class="m-0">Gem - <?= $gemCount ?> | Coin - <?= $coinCount ?></p>
                        <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="<?= $ProgressValue ?>" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: <?= $ProgressValue ?>%"><?= number_format($ProgressValue, 2) ?>%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="col-6 col-md-4 mb-2 d-flex">
        <div class="card game-card shadow-sm flex-fill" onclick="redirectToURL('pharma-reader')">
            <div class="card-body text-center">
                <div class="row">
                    <div class="col-12">

                        <img src="./lib/home/assets/images/alternative-medicine.gif" class="game-icon">
                        <h4 class="card-title">Pharma Reader</h4>
                    </div>

                    <div class="col-12 mt-2">
                        <?php $ProgressValue = 0; ?>
                        <p class="m-0"><?= $ProgressValue ?>%</p>
                        <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="<?= $ProgressValue ?>" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: <?= $ProgressValue ?>%"><?= $ProgressValue ?>%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <h4 class="section-topic">Other</h4>
    </div>

    <div class="col-12 col-md-4 mb-2 d-flex">
        <div class="card other-card shadow-sm flex-fill" onclick="redirectToURL('profile')">
            <div class="card-body">
                <div class="row">
                    <div class="col-2 text-center d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-user main-icon"></i>
                    </div>
                    <div class="col-10">
                        <h4 class="card-title  my-0">Profile</h4>
                        <p class="text-secondary my-0">Edit Profile, Reset Password, Etc</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4 mb-2 d-flex">
        <div class="card other-card shadow-sm flex-fill">
            <div class="card-body">
                <div class="row">
                    <div class="col-2 text-center d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-file-signature main-icon"></i>
                    </div>
                    <div class="col-10">
                        <h4 class="card-title  my-0">Request CV</h4>
                        <p class="text-secondary my-0">Create, Edit your Professional CV</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4 mb-2 d-flex">
        <div class="card other-card shadow-sm flex-fill">
            <div class="card-body">
                <div class="row">
                    <div class="col-2 text-center d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-user-doctor main-icon"></i>
                    </div>
                    <div class="col-10">
                        <h4 class="card-title  my-0">Apply Jobs</h4>
                        <p class="text-secondary my-0">Find the Jobs using this Portal</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4 mb-2 d-flex">
        <div class="card other-card shadow-sm flex-fill" onclick="redirectToURL('delivery')">
            <div class="card-body">
                <div class="row">
                    <div class="col-2 text-center d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-truck main-icon"></i>
                    </div>
                    <div class="col-10">
                        <h4 class="card-title  my-0">Delivery</h4>
                        <p class="text-secondary my-0">Check the Courier Status</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4 mb-2 d-flex">
        <div class="card other-card shadow-sm flex-fill" onclick="redirectToURL('logout')">
            <div class="card-body">
                <div class="row">
                    <div class="col-2 text-center d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-share-from-square main-icon"></i>
                    </div>
                    <div class="col-10">
                        <h4 class="card-title  my-0">Sign Out</h4>
                        <p class="text-secondary my-0">End the current session</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4 mb-2 d-flex">
        <div class="card other-card shadow-sm flex-fill" onclick="toggleDarkMode()">
            <div class="card-body">
                <div class="row">
                    <div class="col-2 text-center d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-toggle-on main-icon"></i>
                    </div>
                    <div class="col-10">
                        <h4 class="card-title  my-0">Change Theme</h4>
                        <p class="text-secondary my-0">Light / Dark Mode</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
<?php
require_once "../../../../include/config.php"; // Include config file   
include '../../include/functions.php'; // Winpharma functions

$UserLevel = $_POST["UserLevel"]; // User level obtained from the form
$LoggedUser = $_POST["LoggedUser"]; // Logged-in user obtained from the form

$SubmissionID = $_POST['SubmissionID'];
$grade = 0;
$grade_status = "Re-Correction";

$result = RequestReCorrection($link, $LoggedUser, $SubmissionID, $grade, $grade_status);
echo json_encode($result);

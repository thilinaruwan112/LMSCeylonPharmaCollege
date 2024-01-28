<?php

include __DIR__ . '../../../../include/configuration.php'; // Database Configuration

// Enable MySQLi error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);



function getCurrentTimeOfDay()
{
    date_default_timezone_set("Asia/Colombo");
    $currentTime = date('H:i'); // Get the current time in the format 'HH:MM'
    $morningStart = '06:00';
    $afternoonStart = '12:00';
    $eveningStart = '17:00';
    $nightStart = '20:00';

    if ($currentTime >= $morningStart && $currentTime < $afternoonStart) {
        return 'Morning';
    } elseif ($currentTime >= $afternoonStart && $currentTime < $eveningStart) {
        return 'Afternoon';
    } elseif ($currentTime >= $eveningStart && $currentTime < $nightStart) {
        return 'Evening';
    } else {
        return 'Night';
    }
}


function GetSubmissions($link, $CountAnswer, $UserName)
{
    $ArrayResult = array();
    $sql = "SELECT `medicine_id` FROM `hunter_saveanswer` WHERE `index_number` LIKE '$UserName' GROUP BY `index_number`, `medicine_id` HAVING COUNT(*) > $CountAnswer ORDER BY COUNT(*) DESC";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[] = $row["medicine_id"];
        }
    }
    return $ArrayResult;;
}

function GetMedicines($link)
{
    $ArrayResult = array();
    $sql = "SELECT `id`, `category_id`, `product_code`, `medicine_name`, `file_path`, `active_status`, `created_at`, `created_by` FROM `hunter_medicine` WHERE `active_status` LIKE 'Active'";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['id']] = $row["id"];
        }
    }
    return $ArrayResult;
}

function GetMedicineByID($link, $medicineId)
{
    $ArrayResult = array();
    $sql = "SELECT `id`, `category_id`, `product_code`, `medicine_name`, `file_path`, `active_status`, `created_at`, `created_by` FROM `hunter_medicine` WHERE `id` LIKE '$medicineId'";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[] = $row;
        }
    }
    return $ArrayResult;
}

function GetHunterCourseMedicines($link, $CourseCode)
{
    $ArrayResult = array();
    $sql = "SELECT `id`, `CourseCode`, `MediID`, `status` FROM `hunter_course` WHERE `status` LIKE 'Active' AND `CourseCode` LIKE '$CourseCode'";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['MediID']] = $row["MediID"];
        }
    }
    return $ArrayResult;
}

function GetHunterProAttempts($link)
{
    $ArrayResult = 0;
    $sql = "SELECT `id`, `setting`, `value` FROM `settings` WHERE `setting` LIKE 'HunterProAttempt'";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult = $row["value"];
        }
    }
    return $ArrayResult;
}

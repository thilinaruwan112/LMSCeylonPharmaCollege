<?php

include __DIR__ . '../../../../include/configuration.php'; // Database Configuration

// Enable MySQLi error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function GetSource($sourceType)
{

    if ($sourceType == "racks") {
        $sql = "SELECT `id`, `name`, `is_active`, `created_by`, `created_at` FROM `hp_racks`";
    } else if ($sourceType == 'dosageForm') {
        $sql = "SELECT `id`, `name`, `is_active`, `created_by`, `created_at` FROM `hp_dosage_forms`";
    } else if ($sourceType == 'drugCategory') {
        $sql = "SELECT `id`, `name`, `is_active`, `created_by`, `created_at` FROM `hp_categories`";
    } else if ($sourceType == 'drugGroup') {
        $sql = "SELECT `id`, `name`, `is_active`, `created_by`, `created_at` FROM `hp_drug_types`";
    }
    global $link;
    $ArrayResult = array();

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['id']] = $row;
        }
    }

    return $ArrayResult;
}

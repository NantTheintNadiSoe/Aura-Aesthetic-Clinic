<?php

if (session_status() === PHP_SESSION_NONE) session_start();
include('connect.php');
header('Content-Type: application/json');

if (!isset($_SESSION['sid']) || !isset($_SESSION['position'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in as staff']);
    exit;
}

$role = $_SESSION['position'];
$errors = [];


$tables_to_update = [];
if ($role === 'Admin' || $role === 'Receptionist') {
    $tables_to_update[] = ['table' => 'appointment', 'date_field' => 'AppointmentDate'];
    $tables_to_update[] = ['table' => 'orders', 'date_field' => 'OrderDate'];
}

if ($role === 'Aesthetic Doctor') {
    $tables_to_update[] = ['table' => 'consultation', 'date_field' => 'ConsultationDate'];
    $tables_to_update[] = ['table' => 'skinassessment', 'date_field' => 'AssessmentDate'];
}

if ($role === 'Nurse') {
    $tables_to_update[] = ['table' => 'treatment', 'date_field' => 'Date'];
    $tables_to_update[] = ['table' => 'skinassessment', 'date_field' => 'AssessmentDate'];
}


foreach ($tables_to_update as $t) {


    $q = "UPDATE {$t['table']} SET IsNotified = 1 WHERE IsNotified = 0";


    if (!mysqli_query($connect, $q)) {
        $errors[] = "Error updating {$t['table']}: " . mysqli_error($connect);
    }
}

if (empty($errors)) {
    echo json_encode(['success' => true]);
} else {

    error_log("Staff Notification Read Errors: " . implode(", ", $errors));
    echo json_encode(['success' => false, 'errors' => $errors]);
}

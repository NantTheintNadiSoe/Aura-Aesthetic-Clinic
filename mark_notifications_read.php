<?php
// mark_notifications_read.php
if (session_status() === PHP_SESSION_NONE) session_start();
include('connect.php');
header('Content-Type: application/json');

if (!isset($_SESSION['pid'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in as patient']);
    exit;
}
$pid = mysqli_real_escape_string($connect, $_SESSION['pid']);
$errors = [];

// Update recommendation linked to this patient
$q1 = "UPDATE recommendation r
       JOIN skinassessment sa ON r.AssessmentCode = sa.AssessmentCode
       SET r.IsNotified = 0
       WHERE sa.PatientID = '$pid' AND r.IsNotified = 1";
if (!mysqli_query($connect, $q1)) $errors[] = mysqli_error($connect);

// Update appointments for patient
$q2 = "UPDATE appointment SET IsNotified = 0 WHERE PatientID = '$pid' AND IsNotified = 1";
if (!mysqli_query($connect, $q2)) $errors[] = mysqli_error($connect);

// Update orders for patient
$q3 = "UPDATE orders SET IsNotified = 0 WHERE PatientID = '$pid' AND IsNotified = 1";
if (!mysqli_query($connect, $q3)) $errors[] = mysqli_error($connect);

// Update skinassessment for patient
$q4 = "UPDATE skinassessment SET IsNotified = 0 WHERE PatientID = '$pid' AND IsNotified = 1";
if (!mysqli_query($connect, $q4)) $errors[] = mysqli_error($connect);

if (empty($errors)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'errors' => $errors]);
}

<?php
// make_staff_notifications_read.php
if (session_status() === PHP_SESSION_NONE) session_start();
include('connect.php');
header('Content-Type: application/json');

if (!isset($_SESSION['sid'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in as staff']);
    exit;
}

$errors = [];

// Update unread notifications for staff (set IsNotified = 0)
$q1 = "UPDATE appointment SET IsNotified = 1 WHERE IsNotified = 0";
if (!mysqli_query($connect, $q1)) $errors[] = mysqli_error($connect);

$q2 = "UPDATE orders SET IsNotified = 1 WHERE IsNotified = 0";
if (!mysqli_query($connect, $q2)) $errors[] = mysqli_error($connect);

$q3 = "UPDATE consultation SET IsNotified = 1 WHERE IsNotified = 0";
if (!mysqli_query($connect, $q3)) $errors[] = mysqli_error($connect);

$q4 = "UPDATE skinassessment SET IsNotified = 1 WHERE IsNotified = 0";
if (!mysqli_query($connect, $q4)) $errors[] = mysqli_error($connect);

if (empty($errors)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'errors' => $errors]);
}

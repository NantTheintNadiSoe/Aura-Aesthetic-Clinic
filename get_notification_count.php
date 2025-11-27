<?php
// get_notification_count.php
if (session_status() === PHP_SESSION_NONE) session_start();
include('connect.php');
header('Content-Type: application/json');

if (!isset($_SESSION['sid'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in as staff']);
    exit;
}


header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

try {
    // Get current unread notification count
    $notificationCount = 0;
    $notificationQuery = "
        SELECT 
            (SELECT COUNT(*) FROM appointment WHERE IsNotified = 0) +
            (SELECT COUNT(*) FROM orders WHERE IsNotified = 0) +
            (SELECT COUNT(*) FROM consultation WHERE IsNotified = 0) +
            (SELECT COUNT(*) FROM skinassessment WHERE IsNotified = 0) AS total_unread
    ";

    $notificationResult = mysqli_query($connect, $notificationQuery);
    if ($notificationResult) {
        $notificationData = mysqli_fetch_assoc($notificationResult);
        $notificationCount = (int)$notificationData['total_unread'];
    }

    echo json_encode([
        'success' => true,
        'count' => $notificationCount,
        'timestamp' => time()
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}

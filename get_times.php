<?php
include('connect.php');

if (isset($_GET['date'])) {
    $date = $_GET['date'];
    $result = mysqli_query($connect, "SELECT ConsultationTime FROM consultation WHERE ConsultationDate='$date'");
    $booked = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $booked[] = $row['ConsultationTime'];
    }
    echo json_encode($booked);
}

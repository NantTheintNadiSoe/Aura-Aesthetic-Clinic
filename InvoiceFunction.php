<?php
function AddTreatment($tid, $qty)
{
    include('connect.php');

    // Sanitize inputs to avoid SQL injection (if not done elsewhere)
    $tid = mysqli_real_escape_string($connect, $tid);
    $qty = intval($qty);

    if ($qty <= 0) {
        return; // Do not add if quantity is zero or negative
    }

    $query = mysqli_query($connect, "SELECT * FROM treatment WHERE TreatmentCode='$tid'");
    if ($row = mysqli_fetch_assoc($query)) {
        $data = [
            'TreatmentCode' => $tid,
            'TreatmentName' => $row['TreatmentName'],
            'Price' => $row['Price'],
            'Quantity' => $qty
        ];

        if (!isset($_SESSION['Invoice_Function'])) {
            $_SESSION['Invoice_Function'] = [];
        }

        $found = false;
        foreach ($_SESSION['Invoice_Function'] as &$item) {
            if ($item['TreatmentCode'] == $tid) {
                // Increase quantity if treatment already added
                $item['Quantity'] += $qty;
                $found = true;
                break;
            }
        }
        unset($item); // break reference with last element

        if (!$found) {
            $_SESSION['Invoice_Function'][] = $data;
        }
    }
}

function RemoveTreatment($tid)
{
    if (!isset($_SESSION['Invoice_Function'])) return; // Avoid warning if session not set

    foreach ($_SESSION['Invoice_Function'] as $key => $item) {
        if ($item['TreatmentCode'] == $tid) {
            unset($_SESSION['Invoice_Function'][$key]);
            // Re-index array so keys remain sequential
            $_SESSION['Invoice_Function'] = array_values($_SESSION['Invoice_Function']);
            break;
        }
    }
}

function CalculateTotalAmount()
{
    if (!isset($_SESSION['Invoice_Function'])) {
        return 0; // If no treatments added, total is zero
    }

    $total = 0;
    foreach ($_SESSION['Invoice_Function'] as $item) {
        $total += $item['Price'] * $item['Quantity'];
    }
    return $total;
}

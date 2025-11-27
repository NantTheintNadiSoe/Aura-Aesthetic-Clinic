<?php
function AddTreatment($tid, $qty)
{
    include('connect.php');


    $tid = mysqli_real_escape_string($connect, $tid);
    $qty = intval($qty);

    if ($qty <= 0) {
        return;
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

                $item['Quantity'] += $qty;
                $found = true;
                break;
            }
        }
        unset($item);

        if (!$found) {
            $_SESSION['Invoice_Function'][] = $data;
        }
    }
}

function RemoveTreatment($tid)
{
    if (!isset($_SESSION['Invoice_Function'])) return;

    foreach ($_SESSION['Invoice_Function'] as $key => $item) {
        if ($item['TreatmentCode'] == $tid) {
            unset($_SESSION['Invoice_Function'][$key]);

            $_SESSION['Invoice_Function'] = array_values($_SESSION['Invoice_Function']);
            break;
        }
    }
}

function CalculateTotalAmount()
{
    if (!isset($_SESSION['Invoice_Function'])) {
        return 0;
    }

    $total = 0;
    foreach ($_SESSION['Invoice_Function'] as $item) {
        $total += $item['Price'] * $item['Quantity'];
    }
    return $total;
}

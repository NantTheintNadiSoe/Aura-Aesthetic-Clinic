<?php
session_start();
include('connect.php');


if (!isset($_SESSION['sid'])) {
    echo "<script>alert('Access denied! Please log in.'); window.location='stafflogin.php';</script>";
    exit();
}


if (!isset($_GET['code'])) {
    echo "<script>alert('Invoice code not found.'); window.location='ViewInvoice.php';</script>";
    exit();
}

$invoice_code = $_GET['code'];

// Get invoice details
$query_invoice = mysqli_query($connect, "
    SELECT i.*, p.Name AS PatientName, p.Email, s.Name AS StaffName, a.AppointmentDate
    FROM invoice i
    JOIN patientregister p ON i.PatientID = p.PatientID
    JOIN staffregister s ON i.StaffID = s.StaffID
    JOIN appointment a ON i.AppointmentCode = a.AppointmentCode
    WHERE i.InvoiceCode = '$invoice_code'
");
$invoice = mysqli_fetch_assoc($query_invoice);

if (!$invoice) {
    echo "<script>alert('Invoice not found.'); window.location='ViewInvoice.php';</script>";
    exit();
}

// Get invoice treatment details
$query_details = mysqli_query($connect, "
    SELECT d.*, t.TreatmentName
    
    FROM invoicedetail d
    JOIN treatment t ON d.TreatmentCode = t.TreatmentCode
    WHERE d.InvoiceCode = '$invoice_code'
");

// Handle sending invoice (mark as sent)
if (isset($_POST['send'])) {
    mysqli_query($connect, "UPDATE invoice SET Status = 'Sent' WHERE InvoiceCode = '$invoice_code'");
    echo "<script>alert('Invoice has been sent to the patient.'); window.location='CreateInvoice.php';</script>";
    exit();
}

include 'header.php';
?>

<body class="bg-[#F7EFEF] text-[#4A2C35] font-sans min-h-screen">
    <?php include 'navbar.php'; ?>

    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow rounded border border-[#EBD5DC] mb-10">
        <h2 class="text-2xl font-bold text-center text-[#916D7A] mb-6">Invoice Details</h2>

        <div class="space-y-4">
            <p><strong>Invoice Code:</strong> <?= $invoice['InvoiceCode'] ?></p>
            <p><strong>Appointment Code:</strong> <?= $invoice['AppointmentCode'] ?></p>
            <p><strong>Appointment Date:</strong> <?= $invoice['AppointmentDate'] ?></p>
            <p><strong>Invoice Date:</strong> <?= $invoice['InvoiceDate'] ?></p>
            <p><strong>Patient Name:</strong> <?= $invoice['PatientName'] ?></p>
            <p><strong>Patient Email:</strong> <?= $invoice['Email'] ?></p>
            <p><strong>Staff Name:</strong> <?= $invoice['StaffName'] ?></p>
            <p><strong>Status:</strong> <?= $invoice['Status'] ?></p>
        </div>

        <h3 class="text-xl font-semibold mt-6 mb-4">Treatments</h3>
        <div class="overflow-x-auto border border-[#EBD5DC] rounded">
            <table class="min-w-full bg-white">
                <thead class="bg-[#EBD5DC] text-[#4A2C35]">
                    <tr>
                        <th class="py-3 px-4 border-b border-[#EBD5DC]">Treatment Name</th>
                        <th class="py-3 px-4 border-b border-[#EBD5DC]">Quantity</th>
                        <th class="py-3 px-4 border-b border-[#EBD5DC]">Unit Price</th>
                        <th class="py-3 px-4 border-b border-[#EBD5DC]">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    while ($detail = mysqli_fetch_assoc($query_details)) {
                        $subtotal = $detail['Quantity'] * $detail['UnitPrice'];
                        $total += $subtotal;
                        echo "<tr class='text-center border-b border-[#EBD5DC]'>
                            <td class='py-2 px-4'>{$detail['TreatmentName']}</td>
                            <td class='py-2 px-4'>{$detail['Quantity']}</td>
                            <td class='py-2 px-4'>{$detail['UnitPrice']} MMK</td>
                            <td class='py-2 px-4'>{$subtotal} MMK</td>
                          </tr>";
                    }
                    ?>
                    <tr class="font-semibold text-[#916D7A]">
                        <td colspan="3" class="text-right py-3 px-4">Total Amount</td>
                        <td class="py-3 px-4"><?= $total ?> MMK</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex flex-col items-center space-y-4">
            <?php if ($invoice['Status'] != 'Sent'): ?>
                <form method="post">
                    <button type="submit" name="send"
                        class="px-6 py-2 bg-[#916D7A] text-white rounded hover:bg-[#6E4B57] transition font-semibold">
                        Send Invoice to Patient
                    </button>
                </form>
            <?php else: ?>
                <div class="text-green-600 font-semibold">
                    Invoice has been sent to the patient.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>
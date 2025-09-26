<?php
session_start();
include('connect.php');
include 'header.php';

// Ensure patient is logged in
if (!isset($_SESSION['pid'])) {
    echo "<script>alert('Access denied! Please log in.'); window.location='patientlogin.php';</script>";
    exit();
}

$invoice_code = $_GET['code'] ?? null;

if (!$invoice_code) {
    echo "<script>alert('Invoice code not provided.'); window.location='patientdashboard.php';</script>";
    exit();
}

// Get invoice info
$query_invoice = mysqli_query($connect, "
    SELECT i.*, p.Name AS PatientName, p.Email, s.Name AS StaffName, a.AppointmentDate
    FROM invoice i
    JOIN patientregister p ON i.PatientID = p.PatientID
    JOIN staffregister s ON i.StaffID = s.StaffID
    JOIN appointment a ON i.AppointmentCode = a.AppointmentCode
    WHERE i.InvoiceCode = '" . mysqli_real_escape_string($connect, $invoice_code) . "'
");
$invoice = mysqli_fetch_assoc($query_invoice);

if (!$invoice) {
    echo "<script>alert('Invoice not found.'); window.location='patientdashboard.php';</script>";
    exit();
}

// Security check: patient can only view own invoice
if ($invoice['PatientID'] != $_SESSION['pid']) {
    echo "<script>alert('Access denied. You can only view your own invoice.'); window.location='patientdashboard.php';</script>";
    exit();
}

// Get treatments for this invoice
$query_details = mysqli_query($connect, "
    SELECT d.*, t.TreatmentName
    FROM invoicedetail d
    JOIN treatment t ON d.TreatmentCode = t.TreatmentCode
    WHERE d.InvoiceCode = '" . mysqli_real_escape_string($connect, $invoice_code) . "'
");
?>

<body class="bg-[#F7EFEF] text-[#4A2C35] font-sans min-h-screen">
    <?php include 'navbar.php'; ?>

    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow rounded border border-[#EBD5DC] mb-10">
        <h2 class="text-3xl font-bold text-center text-[#916D7A] mb-6">Invoice</h2>

        <!-- Invoice Info -->
        <div class="space-y-3 mb-6">
            <p><strong>Invoice Code:</strong> <?= htmlspecialchars($invoice['InvoiceCode']) ?></p>
            <p><strong>Appointment Code:</strong> <?= htmlspecialchars($invoice['AppointmentCode']) ?></p>
            <p><strong>Appointment Date:</strong> <?= htmlspecialchars($invoice['AppointmentDate']) ?></p>
            <p><strong>Invoice Date:</strong> <?= htmlspecialchars($invoice['InvoiceDate']) ?></p>
            <p><strong>Issued By (Staff):</strong> <?= htmlspecialchars($invoice['StaffName']) ?></p>
            <p><strong>Status:</strong> <?= htmlspecialchars($invoice['Status']) ?></p>
        </div>

        <!-- Treatments Table -->
        <h3 class="text-xl font-semibold mb-4">Treatments</h3>
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
                    ?>
                        <tr class="text-center border-b border-[#EBD5DC]">
                            <td class="py-2 px-4"><?= htmlspecialchars($detail['TreatmentName']) ?></td>
                            <td class="py-2 px-4"><?= htmlspecialchars($detail['Quantity']) ?></td>
                            <td class="py-2 px-4"><?= number_format($detail['UnitPrice']) ?> MMK</td>
                            <td class="py-2 px-4"><?= number_format($subtotal) ?> MMK</td>
                        </tr>
                    <?php } ?>
                    <tr class="font-semibold text-[#916D7A]">
                        <td colspan="3" class="text-right py-3 px-4">Total Amount</td>
                        <td class="py-3 px-4"><?= number_format($total) ?> MMK</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Back Button -->
        <div class="text-center mt-8">
            <a href="patientdashboard.php" class="inline-block px-6 py-2 bg-[#916D7A] text-white font-semibold rounded hover:bg-[#7e5a68] transition">
                ← Back to Dashboard
            </a>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>
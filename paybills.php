<?php
session_start();
include('connect.php');

if (!isset($_GET['invoice'])) {
    echo "<script>alert('Invalid request.'); window.location='patientdashboard.php';</script>";
    exit();
}

$invoiceCode = mysqli_real_escape_string($connect, $_GET['invoice']);

// Fetch invoice (only unpaid)
$query = mysqli_query($connect, "
    SELECT i.*, p.Name, p.Email, p.PhoneNumber, i.AppointmentCode
    FROM invoice i
    JOIN patientregister p ON i.PatientID = p.PatientID
    WHERE i.InvoiceCode='$invoiceCode' AND i.Payment='Unpaid'
");
$invoice = mysqli_fetch_assoc($query);

if (!$invoice) {
    echo "<script>alert('Invoice not found or already paid.'); window.location='patientdashboard.php';</script>";
    exit();
}

if (isset($_POST['btnsubmit'])) {
    $invoiceCode = $_POST['invoice_code'];
    $patientID = $_SESSION['pid'];
    $appointmentCode = $_POST['appointment_code'];
    $paymentDate = $_POST['payment_date'];
    $paymentMethod = $_POST['payment_method'];

    // Handle payment screenshot upload
    $paymentImage = '';
    if (isset($_FILES['payment_screenshot']) && $_FILES['payment_screenshot']['error'] == 0) {
        $fileExt = pathinfo($_FILES['payment_screenshot']['name'], PATHINFO_EXTENSION);
        $paymentImage = uniqid("pay_") . "." . $fileExt;
        $uploadDir = "uploads/payments/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        move_uploaded_file($_FILES['payment_screenshot']['tmp_name'], $uploadDir . $paymentImage);
    }

    // Insert payment record into bill table
    $insert = "INSERT INTO bill 
        (InvoiceCode, PatientID, AppointmentCode, PaymentDate, PaymentMethod, PaymentImage, Status)
        VALUES 
        ('$invoiceCode', '$patientID', '$appointmentCode', '$paymentDate', '$paymentMethod', '$paymentImage', 'Paid')";

    $query = mysqli_query($connect, $insert);

    if ($query) {
        // Update the invoice payment status
        $updateInvoice = "UPDATE invoice SET Payment='Paid' WHERE InvoiceCode='$invoiceCode' AND PatientID='$patientID'";
        mysqli_query($connect, $updateInvoice);

        echo "<script>alert('Payment submitted successfully!'); window.location='patientdashboard.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error occurred while submitting payment.');</script>";
    }
}
?>
<?php include 'header.php'; ?>

<body class="bg-[#F7EFEF] text-[#4A2C35] font-sans min-h-screen">
    <?php include 'navbar.php'; ?>
    <div class="max-w-lg mx-auto mt-10 p-6 bg-white rounded-lg shadow-md border border-[#EBD5DC]">
        <h1 class="text-3xl font-semibold mb-4 text-[#916D7A]">Pay Invoice: <?= htmlspecialchars($invoiceCode) ?></h1>

        <!-- Patient Info -->
        <div class="mb-4">
            <p><strong>Name:</strong> <?= htmlspecialchars($invoice['Name']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($invoice['Email']) ?></p>
            <p><strong>Phone:</strong> <?= htmlspecialchars($invoice['PhoneNumber']) ?></p>
        </div>

        <p class="mb-4 text-[#4A2C35]">Amount: <strong><?= number_format($invoice['TotalAmount'], 2) ?> MMK</strong></p>

        <!-- Payment Form -->
        <form method="post" enctype="multipart/form-data" class="space-y-6">
            <!-- Hidden fields -->
            <input type="hidden" name="invoice_code" value="<?= htmlspecialchars($invoiceCode) ?>">
            <input type="hidden" name="appointment_code" value="<?= htmlspecialchars($invoice['AppointmentCode']) ?>">

            <div>
                <label class="block mb-2 font-semibold">Payment Date</label>
                <input type="date" name="payment_date" class="border border-[#EBD5DC] rounded w-full px-3 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-[#916D7A]" required>
            </div>

            <div>
                <label class="block mb-2 font-semibold">Payment Method</label>
                <select name="payment_method" class="border border-[#EBD5DC] rounded w-full px-3 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-[#916D7A]" required>
                    <option value="">Select</option>
                    <option value="Cash">Cash</option>
                    <option value="Kpay">Kpay</option>
                    <option value="Wavepay">Wavepay</option>
                    <option value="Aya Pay">Aya Pay</option>
                </select>
            </div>

            <div>
                <label class="block mb-2 font-semibold">Upload Payment Screenshot</label>
                <input type="file" name="payment_screenshot" accept="image/*" class="border border-[#EBD5DC] rounded w-full px-3 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-[#916D7A]" required>
            </div>

            <button type="submit" name="btnsubmit" class="bg-[#916D7A] hover:bg-[#6E4B57] text-white px-4 py-2 rounded shadow w-full transition">
                Submit Payment
            </button>
        </form>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>
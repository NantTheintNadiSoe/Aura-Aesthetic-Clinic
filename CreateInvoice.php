<?php
session_start();
include('connect.php');
include('AutoIDFunction.php');
include('InvoiceFunction.php');

// Ensure staff is logged in
if (!isset($_SESSION['sid'])) {
    echo "<script>alert('Access denied! Please login first.'); window.location='stafflogin.php';</script>";
    exit();
}

// Add treatment to invoice session
if (isset($_POST['btnadd'])) {
    $tid = $_POST['cbotreatment'];
    $qty = $_POST['txtquantity'];
    if ($qty > 0) {
        AddTreatment($tid, $qty);
    }
}

// Remove treatment from session
if (isset($_GET['tid'])) {
    RemoveTreatment($_GET['tid']);
}

// Save invoice
if (isset($_POST['btnsave'])) {
    if (empty($_SESSION['Invoice_Function'])) {
        echo "<script>alert('Please add at least one treatment before saving.');</script>";
    } else {
        $invoice_id = $_POST['txtinvoiceid'];
        $appointment_id = $_POST['appointment_id'];
        $patient_id = $_POST['patient_id'];
        $staff_id = $_POST['staff_id'];
        $date = date('Y-m-d');
        $total_amount = CalculateTotalAmount();
        $payment = 'Unpaid';
        $status = 'Unpaid';

        // Insert invoice
        $insert_invoice = "INSERT INTO invoice 
            (InvoiceCode, AppointmentCode, PatientID, StaffID, InvoiceDate, TotalAmount, Status, Payment)
            VALUES 
            ('$invoice_id', '$appointment_id', '$patient_id', '$staff_id', '$date', '$total_amount','$status','$payment')";
        $result = mysqli_query($connect, $insert_invoice);

        if ($result) {
            // Insert invoice details
            foreach ($_SESSION['Invoice_Function'] as $item) {
                $tid = $item['TreatmentCode'];
                $qty = $item['Quantity'];
                $price = $item['Price'];
                $subtotal = $price * $qty;

                $insert_detail = "INSERT INTO invoicedetail 
                    (InvoiceCode, TreatmentCode, Quantity, UnitPrice, Subtotal)
                    VALUES 
                    ('$invoice_id', '$tid', '$qty', '$price', '$subtotal')";
                mysqli_query($connect, $insert_detail);
            }

            unset($_SESSION['Invoice_Function']);
            echo "<script>alert('Invoice generated successfully.'); window.location='SendInvoice.php?code=$invoice_id';</script>";
            exit();
        } else {
            echo "Error: " . mysqli_error($connect);
        }
    }
}
?>


<?php include 'header.php'; ?>


<body class="bg-[#F7EFEF] text-[#4A2C35] font-sans min-h-screen">
    <?php include 'navbar.php'; ?>
    <div class="max-w-4xl mx-auto mt-10 p-8 bg-white rounded-lg shadow-md border border-[#EBD5DC] mb-20">

        <h2 class="text-3xl font-semibold mb-8 text-[#916D7A] border-b pb-3">Create Treatment Invoice</h2>

        <form action="CreateInvoice.php" method="POST" class="space-y-6">

            <!-- Invoice ID and Appointment -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block font-medium mb-1">Invoice ID</label>
                    <input type="text" name="txtinvoiceid" value="<?= AutoID('invoice', 'InvoiceCode', 'INV_', 6); ?>" readonly
                        class="w-full px-4 py-2 border border-[#EBD5DC] rounded bg-white focus:outline-none focus:ring-2 focus:ring-[#916D7A]" />
                </div>

                <div>
                    <label class="block font-medium mb-1">Appointment</label>
                    <select name="appointment_id" required
                        class="w-full px-4 py-2 border border-[#EBD5DC] rounded bg-white focus:outline-none focus:ring-2 focus:ring-[#916D7A]">
                        <option value="">Select Appointment</option>
                        <?php
                        $appointments = mysqli_query($connect, "
                        SELECT AppointmentCode 
                        FROM appointment
                        WHERE AppointmentCode NOT IN (
                            SELECT AppointmentCode 
                            FROM invoice
                        )
                    ");

                        while ($row = mysqli_fetch_assoc($appointments)) {
                            $selected = (isset($_POST['appointment_id']) && $_POST['appointment_id'] == $row['AppointmentCode']) ? 'selected' : '';
                            echo "<option value='{$row['AppointmentCode']}' $selected>{$row['AppointmentCode']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Staff Name -->
                <div>
                    <label class="block font-medium mb-1">Staff Name</label>
                    <select name="staff_id" required
                        class="w-full px-4 py-2 border border-[#EBD5DC] rounded bg-white focus:outline-none focus:ring-2 focus:ring-[#916D7A]">
                        <option value="">Select Staff</option>
                        <?php
                        $staffs = mysqli_query($connect, "SELECT StaffID, Name FROM staffregister");
                        while ($row = mysqli_fetch_assoc($staffs)) {
                            $selected = (isset($_POST['staff_id']) && $_POST['staff_id'] == $row['StaffID']) ? 'selected' : '';
                            echo "<option value='{$row['StaffID']}' $selected>{$row['Name']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Patient Name -->
                <div>
                    <label class="block font-medium mb-1">Patient Name</label>
                    <select name="patient_id" required
                        class="w-full px-4 py-2 border border-[#EBD5DC] rounded bg-white focus:outline-none focus:ring-2 focus:ring-[#916D7A]">
                        <option value="">Select Patient</option>
                        <?php
                        $patients = mysqli_query($connect, "SELECT PatientID, Name FROM patientregister");
                        while ($row = mysqli_fetch_assoc($patients)) {
                            $selected = (isset($_POST['patient_id']) && $_POST['patient_id'] == $row['PatientID']) ? 'selected' : '';
                            echo "<option value='{$row['PatientID']}' $selected>{$row['Name']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <!-- Treatment and Quantity -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-end">
                <div>
                    <label class="block font-medium mb-1">Treatment</label>
                    <select name="cbotreatment"
                        class="w-full px-4 py-2 border border-[#EBD5DC] rounded bg-white focus:outline-none focus:ring-2 focus:ring-[#916D7A]">
                        <option value="" disabled selected>Choose Treatment</option>
                        <?php
                        $treatments = mysqli_query($connect, "SELECT * FROM treatment");
                        while ($row = mysqli_fetch_assoc($treatments)) {
                            echo "<option value='{$row['TreatmentCode']}'>{$row['TreatmentName']} - {$row['Price']} MMK</option>";
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label class="block font-medium mb-1">Quantity</label>
                    <input type="number" name="txtquantity" min="1"
                        class="w-full px-4 py-2 border border-[#EBD5DC] rounded bg-white focus:outline-none focus:ring-2 focus:ring-[#916D7A]" />
                </div>
            </div>

            <div>
                <button type="submit" name="btnadd"
                    class="bg-[#916D7A] hover:bg-[#6E4B57] transition text-white font-semibold px-6 py-2 rounded shadow">
                    Add Treatment
                </button>
            </div>

            <!-- Selected Treatments Table -->
            <?php
            if (!empty($_SESSION['Invoice_Function'])) {
                echo "<div class='mt-10'>";
                echo "<h3 class='text-xl font-semibold mb-4'>Selected Treatments</h3>";
                echo "<div class='overflow-x-auto border border-[#EBD5DC] rounded'>";
                echo "<table class='min-w-full bg-white'>";
                echo "<thead class='bg-[#EBD5DC] text-[#4A2C35]'>";
                echo "<tr>
                <th class='py-3 px-4 border-b border-[#EBD5DC]'>Treatment Name</th>
                <th class='py-3 px-4 border-b border-[#EBD5DC]'>Unit Price</th>
                <th class='py-3 px-4 border-b border-[#EBD5DC]'>Quantity</th>
                <th class='py-3 px-4 border-b border-[#EBD5DC]'>Subtotal</th>
                <th class='py-3 px-4 border-b border-[#EBD5DC]'>Action</th>
              </tr>";
                echo "</thead>";
                echo "<tbody>";

                $total = 0;
                foreach ($_SESSION['Invoice_Function'] as $item) {
                    $name = $item['TreatmentName'];
                    $price = $item['Price'];
                    $qty = $item['Quantity'];
                    $subtotal = $price * $qty;
                    $total += $subtotal;
                    $tid = $item['TreatmentCode'];

                    echo "<tr class='text-center border-b border-[#EBD5DC]'>
                  <td class='py-2 px-4'>$name</td>
                  <td class='py-2 px-4'>$price</td>
                  <td class='py-2 px-4'>$qty</td>
                  <td class='py-2 px-4'>$subtotal</td>
                  <td class='py-2 px-4'>
                    <a href='CreateInvoice.php?tid=$tid' 
                       class='text-[#916D7A] hover:text-[#6E4B57] underline'
                       onclick=\"return confirm('Remove this treatment?')\">Remove</a>
                  </td>
                </tr>";
                }

                echo "<tr class='font-semibold text-[#916D7A]'>
                <td colspan='3' class='text-right py-3 px-4'>Total Amount</td>
                <td colspan='2' class='py-3 px-4'>$total MMK</td>
              </tr>";

                echo "</tbody>";
                echo "</table>";
                echo "</div>";

                echo "<div class='mt-6'>";
                echo "<button type='submit' name='btnsave' class='bg-[#4A2C35] hover:bg-[#916D7A] text-white px-6 py-2 rounded shadow font-semibold transition'>Save Invoice</button>";
                echo "</div>";
                echo "</div>";
            } else {
                echo "<p class='text-[#916D7A] mt-6 font-medium'>No treatments added yet.</p>";
            }
            ?>

        </form>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>
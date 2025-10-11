<?php
session_start();
include('connect.php');
if (!isset($_SESSION['sid']) || !isset($_SESSION['position'])) {
    echo "<script>alert('Access denied! Please log in as staff.'); window.location='login.php';</script>";
    exit();
}
$role = $_SESSION['position'];

// Handle appointment deletion
if (isset($_GET['delete_appointment'])) {
    $delID = mysqli_real_escape_string($connect, $_GET['delete_appointment']);
    $delQuery = mysqli_query($connect, "DELETE FROM appointment WHERE AppointmentCode='$delID'");
    if ($delQuery) {
        echo "<script>alert('Appointment deleted successfully!'); window.location='appointmentlist.php';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to delete appointment.');</script>";
    }
}
// Handle appointment confirmation
if (isset($_GET['confirm_appointment'])) {
    $confID = mysqli_real_escape_string($connect, $_GET['confirm_appointment']);
    $confQuery = mysqli_query($connect, "UPDATE appointment SET Status='Confirmed', IsNotified=1 WHERE AppointmentCode='$confID'");
    if ($confQuery) {
        echo "<script>alert('Appointment confirmed!'); window.location='appointmentlist.php';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to confirm appointment.');</script>";
    }
}

include('header.php');
include('navbar.php');
?>

<body class="bg-[#F7EFEF] text-[#4A2C35] font-sans">
    <div class="max-w-7xl mx-auto mt-10 px-4 mb-16">
        <h1 class="text-3xl font-bold text-[#916D7A] mb-6">Appointment List</h1>
        <table class="min-w-full bg-white border border-[#EBD5DC] rounded shadow-md">
            <thead>
                <tr class="bg-[#FAF2F5] text-[#916D7A]">
                    <th class="py-2 px-4 border-b">Patient Name</th>
                    <th class="py-2 px-4 border-b">Date</th>
                    <th class="py-2 px-4 border-b">Time</th>
                    <th class="py-2 px-4 border-b">Status</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $apptQuery = mysqli_query($connect, "SELECT a.*, p.Name AS PatientName FROM appointment a LEFT JOIN patientregister p ON a.PatientID = p.PatientID ORDER BY AppointmentDate DESC, AppointmentTime DESC");
                if ($apptQuery && mysqli_num_rows($apptQuery) > 0):
                    while ($a = mysqli_fetch_assoc($apptQuery)):
                ?>
                        <tr class="text-center hover:bg-[#F7EFEF]">
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($a['PatientName']) ?></td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($a['AppointmentDate']) ?></td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($a['AppointmentTime']) ?></td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($a['Status']) ?></td>
                            <td class="py-2 px-4 border-b text-center">
                                <?php if ($a['Status'] !== 'Confirmed'): ?>
                                    <a href="appointmentlist.php?confirm_appointment=<?= urlencode($a['AppointmentCode']) ?>" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-700 mr-2" onclick="return confirm('Confirm this appointment?');">Confirm</a>
                                <?php endif; ?>
                                <a href="appointmentlist.php?delete_appointment=<?= urlencode($a['AppointmentCode']) ?>" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-700" onclick="return confirm('Delete this appointment?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile;
                else: ?>
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 py-4">No appointments found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
<?php include('footer.php'); ?>
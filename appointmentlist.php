<?php
session_start();
include('connect.php');

// --- Check Staff Login ---
if (!isset($_SESSION['sid']) || !isset($_SESSION['position'])) {
    echo "<script>alert('Access denied! Please log in as staff.'); window.location='login.php';</script>";
    exit();
}

$role = $_SESSION['position'];

if (isset($_GET['delete_appointment'])) {
    if ($role !== 'Admin') {
        echo "<script>alert('Access denied! Only Admin can delete appointments.'); window.location='appointmentlist.php';</script>";
        exit();
    }

    $delID = mysqli_real_escape_string($connect, $_GET['delete_appointment']);
    $delQuery = mysqli_query($connect, "DELETE FROM appointment WHERE AppointmentCode='$delID'");

    if ($delQuery) {
        echo "<script>alert('Appointment deleted successfully!'); window.location='appointmentlist.php';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to delete appointment.');</script>";
    }
}


if (isset($_GET['confirm_appointment'])) {
    if (!in_array($role, ['Admin', 'Receptionist'])) {
        echo "<script>alert('Access denied! Only Admin or Receptionist can confirm appointments.'); window.location='appointmentlist.php';</script>";
        exit();
    }

    $confID = mysqli_real_escape_string($connect, $_GET['confirm_appointment']);
    $confQuery = mysqli_query($connect, "
        UPDATE appointment 
        SET Status='Confirmed', IsNotified=1 
        WHERE AppointmentCode='$confID'
    ");

    if ($confQuery) {
        echo "<script>alert('Appointment confirmed successfully!'); window.location='appointmentlist.php';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to confirm appointment.');</script>";
    }
}

include('header.php');
include('navbar.php');
?>

<body class="bg-[#F7EFEF] text-[#4A2C35] font-sans">
    <div class="max-w-7xl mx-auto mt-6 lg:mt-10 px-3 sm:px-4 mb-8 lg:mb-16">
        <h1 class="text-2xl lg:text-3xl font-bold text-[#916D7A] mb-4 lg:mb-6">Appointment List</h1>

        <div class="overflow-x-auto">
            <table class="w-full bg-white border border-[#EBD5DC] rounded shadow-md text-sm lg:text-base">
                <thead>
                    <tr class="bg-[#FAF2F5] text-[#916D7A]">
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Patient Name</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Date</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Time</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Status</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $apptQuery = mysqli_query($connect, "
                        SELECT a.*, p.Name AS PatientName
                        FROM appointment a
                        LEFT JOIN patientregister p 
                        ON a.PatientID = p.PatientID
                        ORDER BY AppointmentDate DESC, AppointmentTime DESC
                    ");

                    if ($apptQuery && mysqli_num_rows($apptQuery) > 0):
                        while ($a = mysqli_fetch_assoc($apptQuery)):
                    ?>
                            <tr class="hover:bg-[#F7EFEF]">
                                <td class="py-2 px-2 sm:px-4 border-b"><?= htmlspecialchars($a['PatientName']) ?></td>
                                <td class="py-2 px-2 sm:px-4 border-b"><?= htmlspecialchars($a['AppointmentDate']) ?></td>
                                <td class="py-2 px-2 sm:px-4 border-b"><?= htmlspecialchars($a['AppointmentTime']) ?></td>
                                <td class="py-2 px-2 sm:px-4 border-b">
                                    <span class="inline-block px-2 py-1 rounded text-xs font-semibold 
                                        <?= $a['Status'] === 'Confirmed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' ?>">
                                        <?= htmlspecialchars($a['Status']) ?>
                                    </span>
                                </td>

                                <td class="py-2 px-2 sm:px-4 border-b">
                                    <div class="flex flex-col sm:flex-row gap-1 sm:gap-2">
                                        <!-- CONFIRM BUTTON -->
                                        <?php if ($a['Status'] !== 'Confirmed'): ?>
                                            <?php if (in_array($role, ['Admin', 'Receptionist'])): ?>
                                                <a href="appointmentlist.php?confirm_appointment=<?= urlencode($a['AppointmentCode']) ?>"
                                                    class="bg-green-500 text-white px-2 sm:px-4 py-1 sm:py-2 rounded hover:bg-green-700 text-xs sm:text-sm text-center"
                                                    onclick="return confirm('Confirm this appointment?');">
                                                    Confirm
                                                </a>
                                            <?php else: ?>
                                                <button class="bg-gray-400 text-white px-2 sm:px-4 py-1 sm:py-2 rounded cursor-not-allowed text-xs sm:text-sm w-full sm:w-auto"
                                                    onclick="alert('Access denied! You cannot confirm appointments.')">
                                                    Confirm
                                                </button>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <!-- DELETE BUTTON -->
                                        <?php if ($role === 'Admin'): ?>
                                            <a href="appointmentlist.php?delete_appointment=<?= urlencode($a['AppointmentCode']) ?>"
                                                class="bg-red-500 text-white px-2 sm:px-4 py-1 sm:py-2 rounded hover:bg-red-700 text-xs sm:text-sm text-center"
                                                onclick="return confirm('Delete this appointment?');">
                                                Delete
                                            </a>
                                        <?php else: ?>
                                            <button class="bg-gray-400 text-white px-2 sm:px-4 py-1 sm:py-2 rounded cursor-not-allowed text-xs sm:text-sm w-full sm:w-auto"
                                                onclick="alert('Access denied! You cannot delete appointments.')">
                                                Delete
                                            </button>
                                        <?php endif; ?>
                                    </div>
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
    </div>
</body>

<?php include('footer.php'); ?>
<?php
session_start();
include('connect.php');
if (!isset($_SESSION['sid']) || !isset($_SESSION['position'])) {
    echo "<script>alert('Access denied! Please log in as staff.'); window.location='login.php';</script>";
    exit();
}

$role = $_SESSION['position'];

// Handle consultation deletion
if (isset($_GET['delete_consultation'])) {
    $delID = mysqli_real_escape_string($connect, $_GET['delete_consultation']);
    $delQuery = mysqli_query($connect, "DELETE FROM consultation WHERE ConsultationCode='$delID'");
    if ($delQuery) {
        echo "<script>alert('Consultation deleted successfully!'); window.location='consultationlist.php';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to delete consultation.');</script>";
    }
}

// Handle consultation confirmation
if (isset($_GET['confirm_consultation'])) {
    $confID = mysqli_real_escape_string($connect, $_GET['confirm_consultation']);
    $confQuery = mysqli_query($connect, "UPDATE consultation SET Status='Confirmed', IsNotified=1 WHERE ConsultationCode='$confID'");
    if ($confQuery) {
        echo "<script>alert('Consultation confirmed!'); window.location='consultationlist.php';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to confirm consultation.');</script>";
    }
}

include('header.php');
include('navbar.php');
?>

<body class="bg-[#F7EFEF] text-[#4A2C35] font-sans">
    <div class="max-w-7xl mx-auto mt-10 px-4 mb-16">
        <h1 class="text-3xl font-bold text-[#916D7A] mb-6">Consultation List</h1>
        <table class="min-w-full bg-white border border-[#EBD5DC] rounded shadow-md">
            <thead>
                <tr class="bg-[#FAF2F5] text-[#916D7A]">
                    <th class="py-2 px-4 border-b">Patient Name</th>
                    <th class="py-2 px-4 border-b">Type</th>
                    <th class="py-2 px-4 border-b">Date</th>
                    <th class="py-2 px-4 border-b">Time</th>
                    <th class="py-2 px-4 border-b">Status</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $consultQuery = mysqli_query($connect, "SELECT c.*, p.Name AS PatientName FROM consultation c LEFT JOIN patientregister p ON c.PatientID = p.PatientID ORDER BY ConsultationDate DESC, ConsultationTime DESC");
                if ($consultQuery && mysqli_num_rows($consultQuery) > 0):
                    while ($c = mysqli_fetch_assoc($consultQuery)):
                ?>
                        <tr class="text-center hover:bg-[#F7EFEF]">
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($c['PatientName']) ?></td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($c['ConsultationType']) ?></td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($c['ConsultationDate']) ?></td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($c['ConsultationTime']) ?></td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($c['Status']) ?></td>
                            <td class="py-2 px-4 border-b text-center">
                                <?php if ($c['Status'] !== 'Confirmed'): ?>
                                    <a href="consultationlist.php?confirm_consultation=<?= urlencode($c['ConsultationCode']) ?>" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-700 mr-2" onclick="return confirm('Confirm this consultation?');">Confirm</a>
                                <?php endif; ?>
                                <a href="consultationlist.php?delete_consultation=<?= urlencode($c['ConsultationCode']) ?>" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-700" onclick="return confirm('Delete this consultation?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile;
                else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 py-4">No consultations found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
<?php include('footer.php'); ?>
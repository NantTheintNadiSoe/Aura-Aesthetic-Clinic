<?php
session_start();
include('connect.php');
if (!isset($_SESSION['sid']) || !isset($_SESSION['position'])) {
    echo "<script>alert('Access denied! Please log in as staff.'); window.location='login.php';</script>";
    exit();
}
$role = $_SESSION['position'];

// Handle patient deletion
if (isset($_GET['delete_patient'])) {
    $delID = mysqli_real_escape_string($connect, $_GET['delete_patient']);
    $delQuery = mysqli_query($connect, "DELETE FROM patientregister WHERE PatientID='$delID'");
    if ($delQuery) {
        echo "<script>alert('Patient deleted successfully!'); window.location='patientlist.php';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to delete patient.');</script>";
    }
}

include('header.php');
include('navbar.php');
?>

<body class="bg-[#F7EFEF] text-[#4A2C35] font-sans">
    <div class="max-w-7xl mx-auto mt-10 px-4 mb-16">
        <h1 class="text-3xl font-bold text-[#916D7A] mb-6">Patient List</h1>
        <table class="min-w-full bg-white border border-[#EBD5DC] rounded shadow-md">
            <thead>
                <tr class="bg-[#FAF2F5] text-[#916D7A]">
                    <th class="py-2 px-4 border-b">Name</th>
                    <th class="py-2 px-4 border-b">Email</th>
                    <th class="py-2 px-4 border-b">Phone</th>
                    <th class="py-2 px-4 border-b">Gender</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $patientQuery = mysqli_query($connect, "SELECT * FROM patientregister ORDER BY PatientID DESC");
                if ($patientQuery && mysqli_num_rows($patientQuery) > 0):
                    while ($p = mysqli_fetch_assoc($patientQuery)):
                ?>
                        <tr class="text-center hover:bg-[#F7EFEF]">
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($p['Name']) ?></td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($p['Email']) ?></td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($p['PhoneNumber']) ?></td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($p['Gender']) ?></td>
                            <td class="py-2 px-4 border-b text-center">
                                <a href="patientlist.php?delete_patient=<?= urlencode($p['PatientID']) ?>" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-700" onclick="return confirm('Delete this patient?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile;
                else: ?>
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 py-4">No patients found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
<?php include('footer.php'); ?>
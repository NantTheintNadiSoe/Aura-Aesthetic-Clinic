<?php
session_start();
include('connect.php');
if (!isset($_SESSION['sid']) || !isset($_SESSION['position'])) {
    echo "<script>alert('Access denied! Please log in as staff.'); window.location='login.php';</script>";
    exit();
}
$role = $_SESSION['position'];


// Handle skin assessment deletion
if (isset($_GET['delete_assessment'])) {
    $delID = mysqli_real_escape_string($connect, $_GET['delete_assessment']);
    $delQuery = mysqli_query($connect, "DELETE FROM skinassessment WHERE AssessmentCode='$delID'");
    if ($delQuery) {
        echo "<script>alert('Skin assessment deleted successfully!'); window.location='skinassessmentlist.php';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to delete skin assessment.');</script>";
    }
}

// Handle skin assessment confirmation
if (isset($_GET['confirm_assessment'])) {
    $confID = mysqli_real_escape_string($connect, $_GET['confirm_assessment']);
    $confQuery = mysqli_query($connect, "UPDATE skinassessment SET Status='Confirmed', IsNotified=1 WHERE AssessmentCode='$confID'");
    if ($confQuery) {
        echo "<script>alert('Skin assessment confirmed!'); window.location='skinassessmentlist.php';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to confirm skin assessment.');</script>";
    }
}

include('header.php');
include('navbar.php');
?>

<body class="bg-[#F7EFEF] text-[#4A2C35] font-sans">
    <div class="max-w-7xl mx-auto mt-10 px-4 mb-16">
        <h1 class="text-3xl font-bold text-[#916D7A] mb-6">Skin Assessment List</h1>
        <table class="min-w-full bg-white border border-[#EBD5DC] rounded shadow-md">
            <thead>
                <tr class="bg-[#FAF2F5] text-[#916D7A]">
                    <th class="py-2 px-4 border-b">Patient Name</th>
                    <th class="py-2 px-4 border-b">Assessment Date</th>
                    <th class="py-2 px-4 border-b">Skin Concern</th>
                    <th class="py-2 px-4 border-b">Skin Condition</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $assessQuery = mysqli_query($connect, "SELECT sa.*, p.Name AS PatientName FROM skinassessment sa LEFT JOIN patientregister p ON sa.PatientID = p.PatientID ORDER BY AssessmentDate DESC");
                if ($assessQuery && mysqli_num_rows($assessQuery) > 0):
                    while ($a = mysqli_fetch_assoc($assessQuery)):
                ?>
                        <tr class="text-center hover:bg-[#F7EFEF]">
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($a['PatientName']) ?></td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($a['AssessmentDate']) ?></td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($a['SkinConcern']) ?></td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($a['SkinCondition']) ?></td>
                            <td class="py-2 px-4 border-b text-center">
                                <a href="view_skinassessment.php?code=<?= urlencode($a['AssessmentCode']) ?>" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-700 mr-2">View</a>
                                <a href="skinassessmentlist.php?delete_assessment=<?= urlencode($a['AssessmentCode']) ?>" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-700" onclick="return confirm('Delete this skin assessment?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile;
                else: ?>
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 py-4">No skin assessments found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
<?php include('footer.php'); ?>
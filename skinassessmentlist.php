<?php
session_start();
include('connect.php');


if (!isset($_SESSION['sid']) || !isset($_SESSION['position'])) {
    echo "<script>alert('Access denied! Please log in as staff.'); window.location='login.php';</script>";
    exit();
}
$role = $_SESSION['position'];

// --- Handle skin assessment deletion (Admin only)
if (isset($_GET['delete_assessment'])) {
    if ($role !== 'Admin') {
        echo "<script>alert('Access denied! Only Admin can delete skin assessments.'); window.location='skinassessmentlist.php';</script>";
        exit();
    }

    $delID = mysqli_real_escape_string($connect, $_GET['delete_assessment']);
    $delQuery = mysqli_query($connect, "DELETE FROM skinassessment WHERE AssessmentCode='$delID'");
    if ($delQuery) {
        echo "<script>alert('Skin assessment deleted successfully!'); window.location='skinassessmentlist.php';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to delete skin assessment.');</script>";
    }
}


if (isset($_GET['confirm_assessment'])) {
    if (!in_array($role, ['Admin', 'Receptionist'])) {
        echo "<script>alert('Access denied! You cannot confirm skin assessments.'); window.location='skinassessmentlist.php';</script>";
        exit();
    }

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
    <div class="max-w-7xl mx-auto mt-6 lg:mt-10 px-3 sm:px-4 mb-8 lg:mb-16">
        <h1 class="text-2xl lg:text-3xl font-bold text-[#916D7A] mb-4 lg:mb-6">Skin Assessment List</h1>

        <div class="overflow-x-auto">
            <table class="w-full bg-white border border-[#EBD5DC] rounded shadow-md text-sm lg:text-base">
                <thead>
                    <tr class="bg-[#FAF2F5] text-[#916D7A]">
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Patient Name</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Assessment Date</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Skin Concern</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Skin Condition</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $assessQuery = mysqli_query($connect, "
                        SELECT sa.*, p.Name AS PatientName 
                        FROM skinassessment sa 
                        LEFT JOIN patientregister p ON sa.PatientID = p.PatientID 
                        ORDER BY AssessmentDate DESC
                    ");

                    if ($assessQuery && mysqli_num_rows($assessQuery) > 0):
                        while ($a = mysqli_fetch_assoc($assessQuery)):
                    ?>
                            <tr class="hover:bg-[#F7EFEF]">
                                <td class="py-2 px-2 sm:px-4 border-b"><?= htmlspecialchars($a['PatientName'] ?? '') ?></td>
                                <td class="py-2 px-2 sm:px-4 border-b"><?= htmlspecialchars($a['AssessmentDate'] ?? '') ?></td>
                                <td class="py-2 px-2 sm:px-4 border-b truncate max-w-xs"><?= htmlspecialchars($a['SkinConcern'] ?? '') ?></td>
                                <td class="py-2 px-2 sm:px-4 border-b truncate max-w-xs"><?= htmlspecialchars($a['SkinCondition'] ?? '') ?></td>
                                <td class="py-2 px-2 sm:px-4 border-b">
                                    <div class="flex flex-col sm:flex-row gap-1 sm:gap-2">
                                        <!-- View button (everyone can view) -->
                                        <a href="view_skinassessment.php?code=<?= urlencode($a['AssessmentCode']) ?>"
                                            class="bg-blue-500 text-white px-2 sm:px-4 py-1 sm:py-2 rounded hover:bg-blue-700 text-xs sm:text-sm text-center">View</a>

                                        <!-- Confirm button (Admin + Receptionist) -->
                                        <?php if (($a['Status'] ?? '') !== 'Confirmed'): ?>
                                            <?php if (in_array($role, ['Admin', 'Receptionist'])): ?>
                                                <a href="skinassessmentlist.php?confirm_assessment=<?= urlencode($a['AssessmentCode']) ?>"
                                                    class="bg-green-500 text-white px-2 sm:px-4 py-1 sm:py-2 rounded hover:bg-green-700 text-xs sm:text-sm text-center"
                                                    onclick="return confirm('Confirm this skin assessment?');">Confirm</a>
                                            <?php else: ?>
                                                <button class="bg-gray-400 text-white px-2 sm:px-4 py-1 sm:py-2 rounded text-xs sm:text-sm w-full sm:w-auto"
                                                    onclick="alert('Access denied! You cannot confirm skin assessments.')">Confirm</button>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <!-- Delete button (Admin only) -->
                                        <?php if ($role === 'Admin'): ?>
                                            <a href="skinassessmentlist.php?delete_assessment=<?= urlencode($a['AssessmentCode']) ?>"
                                                class="bg-red-500 text-white px-2 sm:px-4 py-1 sm:py-2 rounded hover:bg-red-700 text-xs sm:text-sm text-center"
                                                onclick="return confirm('Delete this skin assessment?');">Delete</a>
                                        <?php else: ?>
                                            <button class="bg-gray-400 text-white px-2 sm:px-4 py-1 sm:py-2 rounded text-xs sm:text-sm w-full sm:w-auto"
                                                onclick="alert('Access denied! Only Admin can delete skin assessments.')">Delete</button>
                                        <?php endif; ?>
                                    </div>
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
    </div>
</body>
<?php include('footer.php'); ?>
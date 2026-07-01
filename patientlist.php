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
    if ($role !== 'Admin') {
        echo "<script>alert('Access denied! Only Admin can delete patients.'); window.location='patientlist.php';</script>";
        exit();
    }

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
    <div class="max-w-7xl mx-auto mt-6 lg:mt-10 px-3 sm:px-4 mb-8 lg:mb-16">
        <h1 class="text-2xl lg:text-3xl font-bold text-[#916D7A] mb-4 lg:mb-6">Patient List</h1>

        <div class="overflow-x-auto">
            <table class="w-full bg-white border border-[#EBD5DC] rounded shadow-md text-sm lg:text-base">
                <thead>
                    <tr class="bg-[#FAF2F5] text-[#916D7A]">
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Name</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Email</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Phone</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Gender</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $patientQuery = mysqli_query($connect, "SELECT * FROM patientregister ORDER BY PatientID DESC");
                    if ($patientQuery && mysqli_num_rows($patientQuery) > 0):
                        while ($p = mysqli_fetch_assoc($patientQuery)):
                    ?>
                            <tr class="hover:bg-[#F7EFEF]">
                                <td class="py-2 px-2 sm:px-4 border-b"><?= htmlspecialchars($p['Name']) ?></td>
                                <td class="py-2 px-2 sm:px-4 border-b truncate max-w-xs"><?= htmlspecialchars($p['Email']) ?></td>
                                <td class="py-2 px-2 sm:px-4 border-b"><?= htmlspecialchars($p['PhoneNumber']) ?></td>
                                <td class="py-2 px-2 sm:px-4 border-b">
                                    <span class="inline-block px-2 py-1 rounded text-xs font-semibold 
                                        <?= $p['Gender'] === 'Male' ? 'bg-blue-100 text-blue-800' : ($p['Gender'] === 'Female' ? 'bg-pink-100 text-pink-800' :
                                            'bg-gray-100 text-gray-800') ?>">
                                        <?= htmlspecialchars($p['Gender']) ?>
                                    </span>
                                </td>
                                <td class="py-2 px-2 sm:px-4 border-b">
                                    <div class="flex justify-center">
                                        <?php if ($role === 'Admin'): ?>
                                            <a href="patientlist.php?delete_patient=<?= urlencode($p['PatientID']) ?>"
                                                class="bg-red-500 text-white px-2 sm:px-3 py-1 sm:py-2 rounded hover:bg-red-700 text-xs sm:text-sm text-center"
                                                onclick="return confirm('Delete this patient?');">Delete</a>
                                        <?php else: ?>
                                            <button class="bg-gray-400 text-white px-2 sm:px-3 py-1 sm:py-2 rounded text-xs sm:text-sm w-full sm:w-auto"
                                                onclick="alert('Access denied! Only Admin can delete patients.')">Delete</button>
                                        <?php endif; ?>
                                    </div>
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
    </div>
</body>

<?php include('footer.php'); ?>
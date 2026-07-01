<?php
session_start();
include('connect.php');

if (!isset($_SESSION['sid']) || !isset($_SESSION['position'])) {
    echo "<script>alert('Access denied! Please log in as staff.'); window.location='login.php';</script>";
    exit();
}
$role = $_SESSION['position'];

// Handle staff deletion
if (isset($_GET['delete_staff'])) {
    if ($role !== 'Admin') {
        echo "<script>alert('Access denied! Only Admin can delete staff.'); window.location='stafflist.php';</script>";
        exit();
    }

    $delID = mysqli_real_escape_string($connect, $_GET['delete_staff']);
    $delQuery = mysqli_query($connect, "DELETE FROM staffregister WHERE StaffID='$delID'");
    if ($delQuery) {
        echo "<script>alert('Staff deleted successfully!'); window.location='stafflist.php';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to delete staff.');</script>";
    }
}

include('header.php');
include('navbar.php');
?>

<body class="bg-[#F7EFEF] text-[#4A2C35] font-sans">
    <div class="max-w-7xl mx-auto mt-6 lg:mt-10 px-3 sm:px-4 mb-8 lg:mb-16">
        <h1 class="text-2xl lg:text-3xl font-bold text-[#916D7A] mb-4 lg:mb-6">Staff List</h1>

        <div class="overflow-x-auto">
            <table class="w-full bg-white border border-[#EBD5DC] rounded shadow-md text-sm lg:text-base">
                <thead>
                    <tr class="bg-[#FAF2F5] text-[#916D7A]">
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Name</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Username</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Email</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Phone</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Position</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $staffQuery = mysqli_query($connect, "SELECT * FROM staffregister ORDER BY StaffID DESC");
                    if ($staffQuery && mysqli_num_rows($staffQuery) > 0):
                        while ($s = mysqli_fetch_assoc($staffQuery)):
                    ?>
                            <tr class="hover:bg-[#F7EFEF]">
                                <td class="py-2 px-2 sm:px-4 border-b"><?= htmlspecialchars($s['Name'] ?? '') ?></td>
                                <td class="py-2 px-2 sm:px-4 border-b"><?= htmlspecialchars($s['UserName'] ?? '') ?></td>
                                <td class="py-2 px-2 sm:px-4 border-b truncate max-w-xs"><?= htmlspecialchars($s['Email'] ?? '') ?></td>
                                <td class="py-2 px-2 sm:px-4 border-b"><?= htmlspecialchars($s['PhoneNumber'] ?? '') ?></td>
                                <td class="py-2 px-2 sm:px-4 border-b">
                                    <span class="inline-block px-2 py-1 rounded text-xs font-semibold 
                                        <?= $s['Position'] === 'Admin' ? 'bg-purple-100 text-purple-800' : ($s['Position'] === 'Aesthetic Doctor' ? 'bg-blue-100 text-blue-800' : ($s['Position'] === 'Receptionist' ? 'bg-green-100 text-green-800' :
                                                    'bg-gray-100 text-gray-800')) ?>">
                                        <?= htmlspecialchars($s['Position'] ?? '') ?>
                                    </span>
                                </td>
                                <td class="py-2 px-2 sm:px-4 border-b">
                                    <div class="flex flex-col sm:flex-row gap-1 sm:gap-2">
                                        <?php if ($role === 'Admin'): ?>
                                            <a href="edit_staff.php?staff_id=<?= urlencode($s['StaffID']) ?>"
                                                class="bg-yellow-500 text-white px-2 sm:px-4 py-1 sm:py-2 rounded hover:bg-yellow-700 text-xs sm:text-sm text-center">Edit</a>
                                            <a href="stafflist.php?delete_staff=<?= urlencode($s['StaffID']) ?>"
                                                class="bg-red-500 text-white px-2 sm:px-4 py-1 sm:py-2 rounded hover:bg-red-700 text-xs sm:text-sm text-center"
                                                onclick="return confirm('Delete this staff member?');">Delete</a>
                                        <?php else: ?>
                                            <button class="bg-gray-400 text-white px-2 sm:px-4 py-1 sm:py-2 rounded text-xs sm:text-sm w-full sm:w-auto"
                                                onclick="alert('Access denied! Only Admin can edit staff.')">Edit</button>
                                            <button class="bg-gray-400 text-white px-2 sm:px-4 py-1 sm:py-2 rounded text-xs sm:text-sm w-full sm:w-auto"
                                                onclick="alert('Access denied! Only Admin can delete staff.')">Delete</button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile;
                    else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-gray-500 py-4">No staff members found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

<?php include('footer.php'); ?>
<?php
session_start();
include('connect.php');
include('header.php');

if (!isset($_SESSION['sid']) || !isset($_SESSION['position'])) {
    echo "<script>alert('Access denied! Please log in as staff.'); window.location='login.php';</script>";
    exit();
}

$role = $_SESSION['position'];

// Handle delete action
if (isset($_GET['delete'])) {
    if ($role !== 'Admin') {
        echo "<script>alert('Access denied! Only Admin can delete treatments.'); window.location='treatmentlist.php';</script>";
        exit();
    }

    $deleteCode = mysqli_real_escape_string($connect, $_GET['delete']);
    $delQuery = "DELETE FROM treatment WHERE TreatmentCode = '$deleteCode'";
    mysqli_query($connect, $delQuery);
    echo "<script>alert('Treatment deleted successfully!');window.location='treatmentlist.php';</script>";
    exit();
}

// Fetch all treatments
$query = "SELECT * FROM treatment ORDER BY CreatedDate DESC";
$result = mysqli_query($connect, $query);
?>

<body class="bg-[#F7EFEF] text-[#4A2C35] font-sans">
    <?php include 'navbar.php'; ?>

    <div class="max-w-7xl mx-auto mt-6 lg:mt-10 px-3 sm:px-4 mb-8 lg:mb-16">
        <h1 class="text-2xl lg:text-3xl font-bold text-[#916D7A] mb-4 lg:mb-6">Treatment List</h1>

        <div class="overflow-x-auto">
            <table class="w-full bg-white border border-[#EBD5DC] rounded shadow-md text-sm lg:text-base">
                <thead>
                    <tr class="bg-[#FAF2F5] text-[#916D7A]">
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Image</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Name</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Category</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Price</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Status</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr class="hover:bg-[#F7EFEF]">
                            <td class="py-2 px-2 sm:px-4 border-b">
                                <img src="<?= htmlspecialchars($row['TreatmentImage']) ?>" alt="Image" class="w-12 h-12 lg:w-16 lg:h-16 object-cover rounded mx-auto border" />
                            </td>
                            <td class="py-2 px-2 sm:px-4 border-b"><?= htmlspecialchars($row['TreatmentName']) ?></td>
                            <td class="py-2 px-2 sm:px-4 border-b"><?= htmlspecialchars($row['Category']) ?></td>
                            <td class="py-2 px-2 sm:px-4 border-b">MMK <?= number_format($row['Price']) ?></td>
                            <td class="py-2 px-2 sm:px-4 border-b">
                                <span class="inline-block px-2 py-1 rounded text-xs font-semibold 
                                    <?= $row['Status'] === 'Active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                    <?= htmlspecialchars($row['Status']) ?>
                                </span>
                            </td>
                            <td class="py-2 px-2 sm:px-4 border-b">
                                <div class="flex flex-col sm:flex-row gap-1 sm:gap-2">
                                    <?php if (in_array($role, ['Admin', 'Aesthetic Doctor'])): ?>
                                        <a href="treatmentedit.php?code=<?= urlencode($row['TreatmentCode']) ?>" class="bg-blue-500 text-white px-2 sm:px-3 py-1 rounded hover:bg-blue-700 text-xs sm:text-sm text-center">Edit</a>
                                    <?php else: ?>
                                        <button class="bg-gray-400 text-white px-2 sm:px-3 py-1 rounded text-xs sm:text-sm w-full sm:w-auto" onclick="alert('Access denied! You cannot edit treatments.')">Edit</button>
                                    <?php endif; ?>

                                    <?php if ($role === 'Admin'): ?>
                                        <a href="treatmentlist.php?delete=<?= urlencode($row['TreatmentCode']) ?>" onclick="return confirm('Are you sure you want to delete this treatment?');" class="bg-red-500 text-white px-2 sm:px-3 py-1 rounded hover:bg-red-700 text-xs sm:text-sm text-center">Delete</a>
                                    <?php else: ?>
                                        <button class="bg-gray-400 text-white px-2 sm:px-3 py-1 rounded text-xs sm:text-sm w-full sm:w-auto" onclick="alert('Access denied! Only Admin can delete treatments.')">Delete</button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

<?php include 'footer.php'; ?>
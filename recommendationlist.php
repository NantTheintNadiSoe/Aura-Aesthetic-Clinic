<?php
session_start();
include('connect.php');
include('header.php');


$role = $_SESSION['position'] ?? '';


if (isset($_GET['delete'])) {

    if ($role !== 'Aesthetic Doctor') {
        echo "<script>alert('Access denied! Only Aesthetic Doctors can delete recommendations.'); 
              window.location='recommendationlist.php';</script>";
        exit();
    }

    $deleteCode = mysqli_real_escape_string($connect, $_GET['delete']);
    $delQuery = mysqli_query($connect, "DELETE FROM recommendation WHERE RecommendationCode='$deleteCode'");

    if ($delQuery) {
        echo "<script>alert('Recommendation deleted successfully!');window.location='recommendationlist.php';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to delete recommendation.');</script>";
    }
}


$query = "SELECT * FROM recommendation ORDER BY RecommendationDate DESC";
$result = mysqli_query($connect, $query);
?>

<body class="bg-[#F7EFEF] text-[#4A2C35] font-sans">
    <?php include 'navbar.php'; ?>

    <div class="max-w-7xl mx-auto mt-6 lg:mt-10 px-3 sm:px-4 mb-8 lg:mb-16">
        <h1 class="text-2xl lg:text-3xl font-bold text-[#916D7A] mb-4 lg:mb-6">Recommendation List</h1>

        <div class="overflow-x-auto">
            <table class="w-full bg-white border border-[#EBD5DC] rounded shadow-md text-sm lg:text-base">
                <thead>
                    <tr class="bg-[#FAF2F5] text-[#916D7A]">
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Code</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Date</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Staff</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Skin Type</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Status</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <?php

                        $canEdit = ($role === 'Aesthetic Doctor');
                        $canDelete = ($role === 'Aesthetic Doctor');
                        ?>

                        <tr class="hover:bg-[#F7EFEF]">
                            <td class="py-2 px-2 sm:px-4 border-b"><?= htmlspecialchars($row['RecommendationCode']); ?></td>
                            <td class="py-2 px-2 sm:px-4 border-b"><?= htmlspecialchars($row['RecommendationDate']); ?></td>
                            <td class="py-2 px-2 sm:px-4 border-b"><?= htmlspecialchars($row['UserName']); ?></td>
                            <td class="py-2 px-2 sm:px-4 border-b"><?= htmlspecialchars($row['SkinType']); ?></td>
                            <td class="py-2 px-2 sm:px-4 border-b">
                                <span class="inline-block px-2 py-1 rounded text-xs font-semibold 
                                    <?= $row['Status'] === 'Active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' ?>">
                                    <?= htmlspecialchars($row['Status']); ?>
                                </span>
                            </td>

                            <td class="py-2 px-2 sm:px-4 border-b">
                                <div class="flex flex-col sm:flex-row gap-1 sm:gap-2">
                                    <!-- EDIT BUTTON -->
                                    <?php if ($canEdit) { ?>
                                        <a href="recommendationedit.php?code=<?= urlencode($row['RecommendationCode']); ?>"
                                            class="bg-blue-500 text-white px-2 sm:px-3 py-1 sm:py-2 rounded hover:bg-blue-700 text-xs sm:text-sm text-center">
                                            Edit
                                        </a>
                                    <?php } else { ?>
                                        <button class="bg-gray-400 cursor-not-allowed text-white px-2 sm:px-3 py-1 sm:py-2 rounded text-xs sm:text-sm w-full sm:w-auto"
                                            onclick="alert('Only Aesthetic Doctors can edit recommendations.')">
                                            Edit
                                        </button>
                                    <?php } ?>

                                    <!-- DELETE BUTTON -->
                                    <?php if ($canDelete) { ?>
                                        <a href="recommendationlist.php?delete=<?= urlencode($row['RecommendationCode']); ?>"
                                            onclick="return confirm('Are you sure you want to delete this recommendation?');"
                                            class="bg-red-500 text-white px-2 sm:px-3 py-1 sm:py-2 rounded hover:bg-red-700 text-xs sm:text-sm text-center">
                                            Delete
                                        </a>
                                    <?php } else { ?>
                                        <button class="bg-gray-400 cursor-not-allowed text-white px-2 sm:px-3 py-1 sm:py-2 rounded text-xs sm:text-sm w-full sm:w-auto"
                                            onclick="alert('Only Aesthetic Doctors can delete recommendations.')">
                                            Delete
                                        </button>
                                    <?php } ?>
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
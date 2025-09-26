<?php
session_start();
include('connect.php');
include('header.php');

// Access control (optional, add as needed)
// if (!isset($_SESSION['sid'])) { ... }

// Handle delete action
if (isset($_GET['delete'])) {
    $deleteCode = mysqli_real_escape_string($connect, $_GET['delete']);
    $delQuery = mysqli_query($connect, "DELETE FROM recommendation WHERE RecommendationCode='$deleteCode'");
    if ($delQuery) {
        echo "<script>alert('Recommendation deleted successfully!');window.location='recommendationlist.php';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to delete recommendation.');</script>";
    }
}

// Fetch all recommendations
$query = "SELECT * FROM recommendation ORDER BY RecommendationDate DESC";
$result = mysqli_query($connect, $query);
?>

<body class="bg-[#F7EFEF] text-[#4A2C35] font-sans">
    <?php include 'navbar.php'; ?>
    <div class="max-w-7xl mx-auto mt-10 px-4 mb-16">
        <h1 class="text-3xl font-bold text-[#916D7A] mb-6">Recommendation List</h1>
        <table class="min-w-full bg-white border border-[#EBD5DC] rounded shadow-md">
            <thead>
                <tr class="bg-[#FAF2F5] text-[#916D7A]">
                    <th class="py-2 px-4 border-b">Code</th>
                    <th class="py-2 px-4 border-b">Date</th>
                    <th class="py-2 px-4 border-b">Patient</th>
                    <th class="py-2 px-4 border-b">Staff</th>
                    <th class="py-2 px-4 border-b">Skin Type</th>
                    <th class="py-2 px-4 border-b">Status</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr class="text-center hover:bg-[#F7EFEF]">
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['RecommendationCode']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['RecommendationDate']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['UserName']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['Name']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['SkinType']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['Status']); ?></td>
                        <td class="py-2 px-4 border-b">
                            <a href="recommendationedit.php?code=<?php echo urlencode($row['RecommendationCode']); ?>" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-700 mr-2">Edit</a>
                            <a href="recommendationlist.php?delete=<?php echo urlencode($row['RecommendationCode']); ?>" onclick="return confirm('Are you sure you want to delete this recommendation?');" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-700">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
<?php include 'footer.php'; ?>
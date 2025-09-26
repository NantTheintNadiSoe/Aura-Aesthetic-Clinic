<?php
include('connect.php');
include('header.php');

// Handle delete action
if (isset($_GET['delete'])) {
    $deleteCode = $_GET['delete'];
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

    <div class="max-w-7xl mx-auto mt-10 px-4 mb-16">
        <h1 class="text-3xl font-bold text-[#916D7A] mb-6">Treatment List</h1>
        <table class="min-w-full bg-white border border-[#EBD5DC] rounded shadow-md">
            <thead>
                <tr class="bg-[#FAF2F5] text-[#916D7A]">
                    <th class="py-2 px-4 border-b">Image</th>
                    <th class="py-2 px-4 border-b">Name</th>
                    <th class="py-2 px-4 border-b">Category</th>
                    <th class="py-2 px-4 border-b">Price</th>
                    <th class="py-2 px-4 border-b">Status</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr class="text-center hover:bg-[#F7EFEF]">
                        <td class="py-2 px-4 border-b">
                            <img src="<?php echo $row['TreatmentImage']; ?>" alt="Image" class="w-16 h-16 object-cover rounded mx-auto border" />
                        </td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['TreatmentName']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['Category']); ?></td>
                        <td class="py-2 px-4 border-b">MMK <?php echo number_format($row['Price']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['Status']); ?></td>
                        <td class="py-2 px-4 border-b">
                            <a href="treatmentedit.php?code=<?php echo $row['TreatmentCode']; ?>" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-700 mr-2">Edit</a>
                            <a href="treatmentlist.php?delete=<?php echo $row['TreatmentCode']; ?>" onclick="return confirm('Are you sure you want to delete this treatment?');" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-700">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>
<?php include 'footer.php'; ?>
<?php
session_start();
include('connect.php');
if (!isset($_SESSION['sid']) || !isset($_SESSION['position'])) {
    echo "<script>alert('Access denied! Please log in as staff.'); window.location='login.php';</script>";
    exit();
}
$role = $_SESSION['position'];

// Handle product deletion
if (isset($_GET['delete_product'])) {
    $delCode = mysqli_real_escape_string($connect, $_GET['delete_product']);
    $delQuery = mysqli_query($connect, "DELETE FROM product WHERE ProductCode='$delCode'");
    if ($delQuery) {
        echo "<script>alert('Product deleted successfully!'); window.location='productlist.php';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to delete product.');</script>";
    }
}

include('header.php');
include('navbar.php');
?>

<body class="bg-[#F7EFEF] text-[#4A2C35] font-sans">
    <div class="max-w-7xl mx-auto mt-10 px-4 mb-16">
        <h1 class="text-3xl font-bold text-[#916D7A] mb-6">Product List</h1>
        <table class="min-w-full bg-white border border-[#EBD5DC] rounded shadow-md">
            <thead>
                <tr class="bg-[#FAF2F5] text-[#916D7A]">
                    <th class="py-2 px-4 border-b">Image</th>
                    <th class="py-2 px-4 border-b">Name</th>
                    <th class="py-2 px-4 border-b">Type</th>
                    <th class="py-2 px-4 border-b">Price</th>
                    <th class="py-2 px-4 border-b">Status</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $productQuery = mysqli_query($connect, "SELECT * FROM product ORDER BY ProductCode DESC");
                if ($productQuery && mysqli_num_rows($productQuery) > 0):
                    while ($p = mysqli_fetch_assoc($productQuery)):
                ?>
                        <tr class="text-center hover:bg-[#F7EFEF]">
                            <td class="py-2 px-4 border-b text-center">
                                <img src="<?= htmlspecialchars($p['ProductImage']) ?>" alt="<?= htmlspecialchars($p['ProductName']) ?>" class="h-12 w-12 object-cover rounded mx-auto" />
                            </td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($p['ProductName']) ?></td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($p['ProductType']) ?></td>
                            <td class="py-2 px-4 border-b">MMK <?= number_format($p['Price']) ?></td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($p['Status']) ?></td>
                            <td class="py-2 px-4 border-b text-center">
                                <a href="productedit.php?code=<?= urlencode($p['ProductCode']) ?>" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-700 mr-2">Edit</a>
                                <a href="productlist.php?delete_product=<?= urlencode($p['ProductCode']) ?>" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-700" onclick="return confirm('Delete this product?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile;
                else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 py-4">No products found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
<?php include('footer.php'); ?>
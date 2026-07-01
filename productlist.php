<?php
session_start();
include('connect.php');

if (!isset($_SESSION['sid']) || !isset($_SESSION['position'])) {
    echo "<script>alert('Access denied! Please log in as staff.'); window.location='login.php';</script>";
    exit();
}

$role = $_SESSION['position'];

// --- Handle Product Deletion ---
if (isset($_GET['delete_product'])) {
    // Only Admin can delete
    if ($role !== 'Admin') {
        echo "<script>alert('Access denied! You do not have permission to delete products.'); window.location='productlist.php';</script>";
        exit();
    }

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
    <div class="max-w-7xl mx-auto mt-6 lg:mt-10 px-3 sm:px-4 mb-8 lg:mb-16">
        <h1 class="text-2xl lg:text-3xl font-bold text-[#916D7A] mb-4 lg:mb-6">Product List</h1>
        
        <div class="overflow-x-auto">
            <table class="w-full bg-white border border-[#EBD5DC] rounded shadow-md text-sm lg:text-base">
                <thead>
                    <tr class="bg-[#FAF2F5] text-[#916D7A]">
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Image</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Name</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Type</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Price</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Status</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $productQuery = mysqli_query($connect, "SELECT * FROM product ORDER BY ProductCode DESC");
                    if ($productQuery && mysqli_num_rows($productQuery) > 0):
                        while ($p = mysqli_fetch_assoc($productQuery)):
                    ?>
                            <tr class="hover:bg-[#F7EFEF]">
                                <td class="py-2 px-2 sm:px-4 border-b">
                                    <img src="<?= htmlspecialchars($p['ProductImage']) ?>" alt="<?= htmlspecialchars($p['ProductName']) ?>" class="h-10 w-10 lg:h-12 lg:w-12 object-cover rounded mx-auto" />
                                </td>
                                <td class="py-2 px-2 sm:px-4 border-b"><?= htmlspecialchars($p['ProductName']) ?></td>
                                <td class="py-2 px-2 sm:px-4 border-b"><?= htmlspecialchars($p['ProductType']) ?></td>
                                <td class="py-2 px-2 sm:px-4 border-b">MMK <?= number_format($p['Price']) ?></td>
                                <td class="py-2 px-2 sm:px-4 border-b">
                                    <span class="inline-block px-2 py-1 rounded text-xs font-semibold 
                                        <?= $p['Status'] === 'Active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                        <?= htmlspecialchars($p['Status']) ?>
                                    </span>
                                </td>
                                <td class="py-2 px-2 sm:px-4 border-b">
                                    <div class="flex flex-col sm:flex-row gap-1 sm:gap-2">
                                        <?php if ($role === 'Admin'): ?>
                                            <a href="productedit.php?code=<?= urlencode($p['ProductCode']) ?>" class="bg-blue-500 text-white px-2 sm:px-3 py-1 rounded hover:bg-blue-700 text-xs sm:text-sm text-center">Edit</a>
                                            <a href="productlist.php?delete_product=<?= urlencode($p['ProductCode']) ?>" class="bg-red-500 text-white px-2 sm:px-3 py-1 rounded hover:bg-red-700 text-xs sm:text-sm text-center" onclick="return confirm('Delete this product?');">Delete</a>
                                        <?php else: ?>
                                            <button class="bg-gray-400 text-white px-2 sm:px-3 py-1 rounded text-xs sm:text-sm w-full sm:w-auto" onclick="alert('Access denied! You cannot edit products.')">Edit</button>
                                            <button class="bg-gray-400 text-white px-2 sm:px-3 py-1 rounded text-xs sm:text-sm w-full sm:w-auto" onclick="alert('Access denied! You cannot delete products.')">Delete</button>
                                        <?php endif; ?>
                                    </div>
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
    </div>
</body>

<?php include('footer.php'); ?>
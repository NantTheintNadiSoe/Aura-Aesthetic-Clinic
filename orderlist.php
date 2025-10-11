<?php
session_start();
include('connect.php');
if (!isset($_SESSION['sid']) || !isset($_SESSION['position'])) {
    echo "<script>alert('Access denied! Please log in as staff.'); window.location='login.php';</script>";
    exit();
}
$role = $_SESSION['position'];

// Handle order deletion
if (isset($_GET['delete_order'])) {
    $delID = mysqli_real_escape_string($connect, $_GET['delete_order']);
    $delQuery = mysqli_query($connect, "DELETE FROM `orders` WHERE OrderCode='$delID'");
    if ($delQuery) {
        echo "<script>alert('Order deleted successfully!'); window.location='orderlist.php';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to delete order.');</script>";
    }
}
// Handle order confirmation
if (isset($_GET['confirm_order'])) {
    $confID = mysqli_real_escape_string($connect, $_GET['confirm_order']);
    $confQuery = mysqli_query($connect, "UPDATE orders SET Status='Confirmed', IsNotified=1 WHERE OrderCode='$confID'");
    if ($confQuery) {
        echo "<script>alert('Order confirmed!'); window.location='orderlist.php';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to confirm order.');</script>";
    }
}

include('header.php');
include('navbar.php');
?>

<body class="bg-[#F7EFEF] text-[#4A2C35] font-sans">
    <div class="max-w-7xl mx-auto mt-10 px-4 mb-16">
        <h1 class="text-3xl font-bold text-[#916D7A] mb-6">Order List</h1>
        <table class="min-w-full bg-white border border-[#EBD5DC] rounded shadow-md">
            <thead>
                <tr class="bg-[#FAF2F5] text-[#916D7A]">
                    <th class="py-2 px-4 border-b">Order ID</th>
                    <th class="py-2 px-4 border-b">Patient Name</th>
                    <th class="py-2 px-4 border-b">Order Date</th>
                    <th class="py-2 px-4 border-b">Total Amount</th>
                    <th class="py-2 px-4 border-b">Status</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $orderQuery = mysqli_query($connect, "SELECT o.*, p.Name AS PatientName FROM `orders` o LEFT JOIN patientregister p ON o.PatientID = p.PatientID ORDER BY o.OrderDate DESC");
                if ($orderQuery && mysqli_num_rows($orderQuery) > 0):
                    while ($o = mysqli_fetch_assoc($orderQuery)):
                ?>
                        <tr class="text-center hover:bg-[#F7EFEF]">
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($o['OrderCode']) ?></td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($o['PatientName']) ?></td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($o['OrderDate']) ?></td>
                            <td class="py-2 px-4 border-b">MMK <?= number_format($o['TotalAmount'], 2) ?></td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($o['Status']) ?></td>
                            <td class="py-2 px-4 border-b text-center">
                                <?php if ($o['Status'] !== 'Confirmed'): ?>
                                    <a href="orderlist.php?confirm_order=<?= urlencode($o['OrderCode']) ?>" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-700 mr-2" onclick="return confirm('Confirm this order?');">Confirm</a>
                                <?php endif; ?>
                                <a href="orderlist.php?delete_order=<?= urlencode($o['OrderCode']) ?>" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-700" onclick="return confirm('Delete this order?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile;
                else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 py-4">No orders found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
<?php include('footer.php'); ?>
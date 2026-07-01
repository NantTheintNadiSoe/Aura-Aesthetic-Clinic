<?php
session_start();
include('connect.php');

if (!isset($_SESSION['sid']) || !isset($_SESSION['position'])) {
    echo "<script>alert('Access denied! Please log in as staff.'); window.location='login.php';</script>";
    exit();
}
$role = $_SESSION['position'];

// --- Handle order deletion (Admin only)
if (isset($_GET['delete_order'])) {
    if ($role !== 'Admin') {
        echo "<script>alert('Access denied! Only Admin can delete orders.'); window.location='orderlist.php';</script>";
        exit();
    }

    $delID = mysqli_real_escape_string($connect, $_GET['delete_order']);
    $delQuery = mysqli_query($connect, "DELETE FROM `orders` WHERE OrderCode='$delID'");
    if ($delQuery) {
        echo "<script>alert('Order deleted successfully!'); window.location='orderlist.php';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to delete order.');</script>";
    }
}


if (isset($_GET['confirm_order'])) {
    if (!in_array($role, ['Admin', 'Receptionist'])) {
        echo "<script>alert('Access denied! You cannot confirm orders.'); window.location='orderlist.php';</script>";
        exit();
    }

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
    <div class="max-w-7xl mx-auto mt-6 lg:mt-10 px-3 sm:px-4 mb-8 lg:mb-16">
        <h1 class="text-2xl lg:text-3xl font-bold text-[#916D7A] mb-4 lg:mb-6">Order List</h1>

        <div class="overflow-x-auto">
            <table class="w-full bg-white border border-[#EBD5DC] rounded shadow-md text-sm lg:text-base">
                <thead>
                    <tr class="bg-[#FAF2F5] text-[#916D7A]">
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Order ID</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Name</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Order Date</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Total Amount</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Status</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $orderQuery = mysqli_query($connect, "
                        SELECT o.*, p.Name AS PatientName 
                        FROM `orders` o 
                        LEFT JOIN `patientregister` p 
                        ON o.PatientID = p.PatientID
                        ORDER BY o.OrderDate DESC
                    ");

                    if ($orderQuery && mysqli_num_rows($orderQuery) > 0):
                        while ($o = mysqli_fetch_assoc($orderQuery)):
                    ?>
                            <tr class="hover:bg-[#F7EFEF]">
                                <td class="py-2 px-2 sm:px-4 border-b"><?= htmlspecialchars($o['OrderCode'] ?? '') ?></td>
                                <td class="py-2 px-2 sm:px-4 border-b"><?= htmlspecialchars($o['Name'] ?? 'Unknown') ?></td>
                                <td class="py-2 px-2 sm:px-4 border-b"><?= htmlspecialchars($o['OrderDate'] ?? '') ?></td>
                                <td class="py-2 px-2 sm:px-4 border-b">MMK <?= number_format($o['TotalAmount'] ?? 0, 2) ?></td>
                                <td class="py-2 px-2 sm:px-4 border-b">
                                    <span class="inline-block px-2 py-1 rounded text-xs font-semibold 
                                        <?= ($o['Status'] ?? '') === 'Confirmed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' ?>">
                                        <?= htmlspecialchars($o['Status'] ?? '') ?>
                                    </span>
                                </td>
                                <td class="py-2 px-2 sm:px-4 border-b">
                                    <div class="flex flex-col sm:flex-row gap-1 sm:gap-2">
                                        <?php if (($o['Status'] ?? '') !== 'Confirmed'): ?>
                                            <?php if (in_array($role, ['Admin', 'Receptionist'])): ?>
                                                <a href="orderlist.php?confirm_order=<?= urlencode($o['OrderCode'] ?? '') ?>"
                                                    class="bg-green-500 text-white px-2 sm:px-3 py-1 sm:py-2 rounded hover:bg-green-700 text-xs sm:text-sm text-center"
                                                    onclick="return confirm('Confirm this order?');">Confirm</a>
                                            <?php else: ?>
                                                <button class="bg-gray-400 text-white px-2 sm:px-3 py-1 sm:py-2 rounded text-xs sm:text-sm w-full sm:w-auto"
                                                    onclick="alert('Access denied! You cannot confirm orders.')">Confirm</button>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <?php if ($role === 'Admin'): ?>
                                            <a href="orderlist.php?delete_order=<?= urlencode($o['OrderCode'] ?? '') ?>"
                                                class="bg-red-500 text-white px-2 sm:px-3 py-1 sm:py-2 rounded hover:bg-red-700 text-xs sm:text-sm text-center"
                                                onclick="return confirm('Delete this order?');">Delete</a>
                                        <?php else: ?>
                                            <button class="bg-gray-400 text-white px-2 sm:px-3 py-1 sm:py-2 rounded text-xs sm:text-sm w-full sm:w-auto"
                                                onclick="alert('Access denied! Only Admin can delete orders.')">Delete</button>
                                        <?php endif; ?>
                                    </div>
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
    </div>
</body>

<?php include('footer.php'); ?>
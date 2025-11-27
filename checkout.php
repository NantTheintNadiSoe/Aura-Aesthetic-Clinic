<?php
session_start();
include('connect.php');
include('ShoppingCartFunction.php'); // include cart functions
include('AutoIDFunction.php');

// Check if user is logged in (patient or staff)
if (!isset($_SESSION['pid']) && !isset($_SESSION['sid'])) {
    echo "<script>alert('Please login first!'); window.location='login.php';</script>";
    exit();
}


$cartName = isset($_SESSION['sid']) ? 'StaffCart' : 'ShoppingCart';

// Redirect if cart is empty
if (!isset($_SESSION[$cartName]) || count($_SESSION[$cartName]) == 0) {
    echo "<script>alert('Your cart is empty!'); window.location='productview.php';</script>";
    exit();
}


$orderCode = AutoID("orders", "OrderCode", "Ord_", 6);

// Handle order submission
if (isset($_POST['btnPlaceOrder'])) {
    $userID = isset($_SESSION['pid']) ? $_SESSION['pid'] : $_SESSION['sid'];
    $orderCodeInput = mysqli_real_escape_string($connect, $_POST['order_code']);
    $Name = mysqli_real_escape_string($connect, $_POST['Name']);
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $phone = mysqli_real_escape_string($connect, $_POST['phone']);
    $address = mysqli_real_escape_string($connect, $_POST['address']);
    $paymentMethod = mysqli_real_escape_string($connect, $_POST['paymentMethod']);

    // Handle payment screenshot upload
    $paymentImage = '';
    if (isset($_FILES['payment_screenshot']) && $_FILES['payment_screenshot']['error'] == 0) {
        $fileExt = pathinfo($_FILES['payment_screenshot']['name'], PATHINFO_EXTENSION);
        $paymentImage = uniqid("pay_") . "." . $fileExt;
        $uploadDir = "uploads/payments/";
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        if (!move_uploaded_file($_FILES['payment_screenshot']['tmp_name'], $uploadDir . $paymentImage)) {
            echo "<script>alert('Failed to upload payment screenshot.'); window.history.back();</script>";
            exit();
        }
        $paymentImage = $uploadDir . $paymentImage;
    } else {
        echo "<script>alert('Please upload payment screenshot.'); window.history.back();</script>";
        exit();
    }

    $totalQty = CalculateTotalQuantity();
    $grandTotal = CalculateTotalAmount();

    // Insert into orders table
    $orderQuery = "INSERT INTO orders 
        (OrderCode, PatientID, Name, Email, Phone, DeliveryAddress, TotalQuantity, TotalAmount, OrderDate, PaymentMethod, PaymentImage, Status)
        VALUES
        ('$orderCodeInput', '$userID', '$Name', '$email', '$phone', '$address', $totalQty, $grandTotal, NOW(), '$paymentMethod', '$paymentImage', 'Pending')";
    mysqli_query($connect, $orderQuery);
    $orderID = mysqli_insert_id($connect);

    // Insert order details
    foreach ($_SESSION[$cartName] as $item) {
        $pid = $item['ProductCode'];
        $qty = $item['Quantity'];
        $price = $item['Price'];
        $discount = $item['Discount'];
        $discountedPrice = $price - ($price * $discount / 100);

        $detailQuery = "INSERT INTO order_details (OrderCode, ProductCode, Quantity, Price)
                        VALUES ('$orderCodeInput', '$pid', $qty, $discountedPrice)";
        mysqli_query($connect, $detailQuery);
    }

    // Clear cart
    unset($_SESSION[$cartName]);

    echo "<script>alert('Your order has been placed successfully!'); window.location='productview.php';</script>";
    exit();
}
?>

<?php include 'header.php'; ?>

<body class="bg-[#F7EFEF] text-[#4A2C35] font-sans">
    <?php include 'navbar.php'; ?>

    <section class="max-w-4xl mx-auto mt-12 px-6 mb-20">
        <h1 class="text-4xl font-extrabold text-[#916D7A] mb-10 border-b border-[#EBD5DC] pb-4">Checkout</h1>

        <!-- Cart Table -->
        <div class="overflow-x-auto mb-8 w-full">
            <table class="w-full bg-white rounded-lg shadow-md border border-[#EBD5DC]">
                <thead class="bg-[#FAF2F5] text-[#916D7A]">
                    <tr>
                        <th class="p-4 text-left border-b border-[#EBD5DC]">Image</th>
                        <th class="p-4 text-left border-b border-[#EBD5DC]">Name</th>
                        <th class="p-4 text-left border-b border-[#EBD5DC]">Size</th>
                        <th class="p-4 text-right border-b border-[#EBD5DC]">Price</th>
                        <th class="p-4 text-center border-b border-[#EBD5DC]">Discount</th>
                        <th class="p-4 text-center border-b border-[#EBD5DC]">Quantity</th>
                        <th class="p-4 text-right border-b border-[#EBD5DC]">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $grandTotal = 0;
                    foreach ($_SESSION[$cartName] as $item):
                        $discountedPrice = $item['Price'] - ($item['Price'] * $item['Discount'] / 100);
                        $total = $discountedPrice * $item['Quantity'];
                        $grandTotal += $total;
                    ?>
                        <tr class="hover:bg-[#F3D9E0] transition">
                            <td class="p-4 border-b border-[#EBD5DC]">
                                <img src="<?php echo $item['ProductImage']; ?>" alt="<?php echo htmlspecialchars($item['ProductName']); ?>" class="w-20 h-20 object-cover rounded-lg border border-[#EBD5DC] shadow-sm" />
                            </td>
                            <td class="p-4 border-b border-[#EBD5DC] font-semibold text-[#916D7A]"><?php echo htmlspecialchars($item['ProductName']); ?></td>
                            <td class="p-4 border-b border-[#EBD5DC]"><?php echo htmlspecialchars($item['ProductSize']); ?></td>
                            <td class="p-4 border-b border-[#EBD5DC] text-right font-mono">MMK <?php echo number_format($item['Price']); ?></td>
                            <td class="p-4 border-b border-[#EBD5DC] text-center text-red-600 font-semibold"><?php echo $item['Discount']; ?>%</td>
                            <td class="p-4 border-b border-[#EBD5DC] text-center"><?php echo $item['Quantity']; ?></td>
                            <td class="p-4 border-b border-[#EBD5DC] text-right font-mono">MMK <?php echo number_format($total); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

   
        <div class="bg-white p-6 rounded-lg shadow-md border border-[#EBD5DC] w-full mb-10">
            <p class="text-lg font-semibold text-[#4A2C35] mb-2">
                Total Quantity: <span class="font-mono"><?php echo CalculateTotalQuantity(); ?></span>
            </p>
            <p class="text-xl font-extrabold text-[#916D7A]">
                Grand Total: <span class="font-mono">MMK <?php echo number_format($grandTotal); ?></span>
            </p>
        </div>

        <!-- Customer Info Form -->
        <form method="POST" action="checkout.php" enctype="multipart/form-data" class="bg-white p-8 rounded-xl shadow-lg border border-[#EBD5DC] w-full">
            <input type="hidden" name="order_code" value="<?php echo $orderCode; ?>" />

            <h2 class="text-3xl font-semibold text-[#916D7A] mb-6 text-center">Customer Information</h2>
            <div class="flex flex-col gap-5">
                <input type="text" name="Name" placeholder="Full Name" required class="border border-[#EBD5DC] px-5 py-3 rounded-lg text-[#4A2C35] focus:outline-none focus:ring-2 focus:ring-[#916D7A]" />
                <input type="email" name="email" placeholder="Email" required class="border border-[#EBD5DC] px-5 py-3 rounded-lg text-[#4A2C35] focus:outline-none focus:ring-2 focus:ring-[#916D7A]" />
                <input type="text" name="phone" placeholder="Phone Number" required class="border border-[#EBD5DC] px-5 py-3 rounded-lg text-[#4A2C35] focus:outline-none focus:ring-2 focus:ring-[#916D7A]" />
                <textarea name="address" placeholder="Delivery Address" required rows="4" class="border border-[#EBD5DC] px-5 py-3 rounded-lg text-[#4A2C35] focus:outline-none focus:ring-2 focus:ring-[#916D7A] resize-none"></textarea>

                <select name="paymentMethod" class="border border-[#EBD5DC] px-5 py-3 rounded-lg text-[#4A2C35] focus:outline-none focus:ring-2 focus:ring-[#916D7A]" required>
                    <option value="">Select Payment Method</option>
                    <option value="KPay">KPay</option>
                    <option value="WavePay">WavePay</option>
                    <option value="Aya Pay">Aya Pay</option>
                    <option value="AYA Bank">AYA Bank</option>
                    <option value="KBZ Bank">KBZ Bank</option>
                </select>

                <label class="block mb-2 font-semibold">Upload Payment Screenshot</label>
                <input type="file" name="payment_screenshot" accept="image/*" required class="border border-[#EBD5DC] px-5 py-3 rounded-lg text-[#4A2C35] focus:outline-none focus:ring-2 focus:ring-[#916D7A]" />

                <button type="submit" name="btnPlaceOrder" class="bg-[#916D7A] text-white py-3 rounded-lg hover:bg-[#6E4B57] transition font-semibold shadow-md">Place Order</button>
            </div>
        </form>
    </section>

    <?php include 'footer.php'; ?>
</body>

</html>
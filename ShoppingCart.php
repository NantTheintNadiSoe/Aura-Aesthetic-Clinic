<?php
session_start();
include('connect.php');
include('ShoppingCartFunction.php');

if (!isset($_SESSION['pid']) && !isset($_SESSION['sid'])) {
    echo "<script>window.alert('Cannot Access Data Please Login!')</script>";
    echo "<script>window.location='login.php'</script>";
    exit();
}
// Handle add product
if (isset($_POST['btnadd'])) {
    $PID = $_POST['txtproductid'];
    $qty = $_POST['txtquantity'];
    AddProduct($PID, $qty);

    header("Location: ShoppingCart.php");
    exit();
}

// Handle remove product
if (isset($_GET['PID'])) {
    $PID = $_GET['PID'];
    RemoveProduct($PID);
}
?>

<?php include 'header.php'; ?>

<body class="bg-[#F7EFEF] text-[#4A2C35] font-sans">
    <?php include 'navbar.php'; ?>

    <section class="max-w-6xl mx-auto mt-12 px-6 mb-20">
        <h1 class="text-4xl font-extrabold text-[#916D7A] mb-8 border-b border-[#EBD5DC] pb-4">Shopping Cart</h1>

        <?php
        // Use correct cart for staff or patient
        $cartName = isset($_SESSION['sid']) ? 'StaffCart' : 'ShoppingCart';
        if (!isset($_SESSION[$cartName]) || count($_SESSION[$cartName]) == 0): ?>
            <p class="text-center text-[#6E4B57] text-lg mt-20">Your cart is empty.</p>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg shadow-md border border-[#EBD5DC]">
                    <thead class="bg-[#FAF2F5] text-[#916D7A]">
                        <tr>
                            <th class="p-4 text-left border-b border-[#EBD5DC]">Image</th>
                            <th class="p-4 text-left border-b border-[#EBD5DC]">Name</th>
                            <th class="p-4 text-left border-b border-[#EBD5DC]">Size</th>
                            <th class="p-4 text-right border-b border-[#EBD5DC]">Price</th>
                            <th class="p-4 text-center border-b border-[#EBD5DC]">Discount</th>
                            <th class="p-4 text-center border-b border-[#EBD5DC]">Quantity</th>
                            <th class="p-4 text-right border-b border-[#EBD5DC]">Total</th>
                            <th class="p-4 text-center border-b border-[#EBD5DC]">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $grandTotal = 0;
                        foreach ($_SESSION[$cartName] as $item):
                            $PID = $item['ProductCode'];
                            $PName = $item['ProductName'];
                            $PImage = $item['ProductImage'];
                            $Price = $item['Price'];
                            $Discount = $item['Discount'];
                            $Qty = $item['Quantity'];
                            $Size = $item['ProductSize'];

                            $discountedPrice = $Price - ($Price * $Discount / 100);
                            $total = $discountedPrice * $Qty;
                            $grandTotal += $total;
                        ?>
                            <tr class="hover:bg-[#F3D9E0] transition">
                                <td class="p-4 border-b border-[#EBD5DC]">
                                    <img src="<?php echo $PImage; ?>" alt="<?php echo htmlspecialchars($PName); ?>" class="w-20 h-20 object-cover rounded-lg border border-[#EBD5DC] shadow-sm" />
                                </td>
                                <td class="p-4 border-b border-[#EBD5DC] font-semibold text-[#916D7A]"><?php echo htmlspecialchars($PName); ?></td>
                                <td class="p-4 border-b border-[#EBD5DC]"><?php echo htmlspecialchars($Size); ?></td>
                                <td class="p-4 border-b border-[#EBD5DC] text-right font-mono">MMK <?php echo number_format($Price); ?></td>
                                <td class="p-4 border-b border-[#EBD5DC] text-center text-red-600 font-semibold"><?php echo $Discount; ?>%</td>
                                <td class="p-4 border-b border-[#EBD5DC] text-center"><?php echo $Qty; ?></td>
                                <td class="p-4 border-b border-[#EBD5DC] text-right font-mono">MMK <?php echo number_format($total); ?></td>
                                <td class="p-4 border-b border-[#EBD5DC] text-center">
                                    <a href="ShoppingCart.php?PID=<?php echo $PID; ?>" class="text-red-600 hover:underline font-semibold">Remove</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-8 bg-white p-6 rounded-lg shadow-md border border-[#EBD5DC] max-w-md mx-auto">
                <p class="text-lg font-semibold text-[#4A2C35] mb-2">
                    Total Quantity: <span class="font-mono"><?php echo CalculateTotalQuantity(); ?></span>
                </p>
                <p class="text-lg font-semibold text-[#4A2C35] mb-4">
                    Grand Total: <span class="font-mono">MMK <?php echo number_format($grandTotal); ?></span>
                </p>
                <a href="checkout.php"
                    class="block text-center bg-[#916D7A] text-white py-3 rounded-lg hover:bg-[#6E4B57] transition font-semibold shadow-lg">
                    Proceed to Checkout
                </a>
            </div>
        <?php endif; ?>
    </section>

    <?php include 'footer.php'; ?>
</body>

</html>
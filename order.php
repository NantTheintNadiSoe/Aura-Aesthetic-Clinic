<?php
session_start();
include('connect.php');
include('AutoIDFunction.php');

// Access control
if (!isset($_SESSION['pid'])) {
    echo "<script>alert('Cannot access order page. Please login as patient.');</script>";
    echo "<script>window.location='login.php';</script>";
    exit();
}


$patient_id = $_SESSION['pid'];
$patient_name = $_SESSION['pname'];


$orderCode = AutoID("orders", "OrderCode", "Or_", 6);

// Handle form submission
if (isset($_POST['btnsubmit'])) {

    if (!$patient_id) {
        echo "<script>alert('Error: Missing Patient ID. Please login again.');</script>";
        echo "<script>window.location='login.php';</script>";
        exit();
    }

    $order_date = date("Y-m-d");
    $status = $_POST['status'];

    
    $insertOrder = "
        INSERT INTO orders (OrderCode, PatientID, OrderDate, Status)
        VALUES ('$orderCode', '$patient_id', '$order_date', '$status')
    ";
    $queryOrder = mysqli_query($connect, $insertOrder);

    if ($queryOrder) {

       
        foreach ($_POST['product_id'] as $index => $pid) {
            $qty = $_POST['quantity'][$index];
            $price = $_POST['price'][$index];
            $discount = $_POST['discount'][$index];

            $insertDetail = "
                INSERT INTO orderdetails (OrderCode, ProductID, Quantity, Price, Discount)
                VALUES ('$orderCode', '$pid', '$qty', '$price', '$discount')
            ";
            mysqli_query($connect, $insertDetail);
        }

        echo "<script>alert('Order Placed Successfully!')</script>";
        echo "<script>window.location='order.php'</script>";
        exit();
    } else {
        echo "<script>alert('Error while saving order!')</script>";
    }
}
?>

<?php include 'header.php'; ?>

<body class="bg-[#F7EFEF] text-[#4A2C35] font-sans">
    <?php include 'navbar.php'; ?>

    <div class="text-center py-10">
        <h1 class="text-3xl font-bold text-[#916D7A]">Create Order</h1>
    </div>

    <div class="max-w-3xl mx-auto bg-white p-8 rounded shadow-md border border-[#EBD5DC] mb-20">
        <form action="order.php" method="POST" class="space-y-6">

            <!-- Order Code -->
            <div>
                <label class="block font-medium mb-1">Order Code</label>
                <input type="text" name="order_id" value="<?php echo $orderCode; ?>"
                    class="w-full px-4 py-2 border border-[#EBD5DC] bg-[#FAF2F5] rounded" readonly>
            </div>

            <!-- Patient Name (readonly) -->
            <div>
                <label class="block font-medium mb-1">Patient</label>
                <input type="text" value="<?php echo $patient_name; ?>"
                    class="w-full px-4 py-2 border border-[#EBD5DC] bg-[#FAF2F5] rounded" readonly>
            </div>

            <!-- Products -->
            <div id="product-list">
                <label class="block font-medium mb-1">Products</label>

                <div class="grid grid-cols-5 gap-2 mb-3">
                    <select name="product_id[]" class="col-span-2 border px-2 py-1 rounded" required>
                        <option value="" disabled selected>Select Product</option>
                        <?php
                        $productQuery = mysqli_query($connect, "SELECT * FROM product");
                        while ($prow = mysqli_fetch_array($productQuery)) {
                            echo "<option value='{$prow['ProductCode']}'>{$prow['ProductName']}</option>";
                        }
                        ?>
                    </select>

                    <input type="number" name="quantity[]" placeholder="Qty" class="border px-2 py-1 rounded" required />
                    <input type="number" name="price[]" placeholder="Price" class="border px-2 py-1 rounded" required />
                    <input type="number" name="discount[]" placeholder="Discount" class="border px-2 py-1 rounded" value="0" />
                </div>
            </div>

            <!-- Add More Product Button -->
            <div>
                <button type="button" onclick="addProductRow()"
                    class="px-4 py-2 bg-[#916D7A] text-white rounded hover:bg-[#6E4B57] transition">
                    + Add Product
                </button>
            </div>

            <!-- Order Status -->
            <div>
                <label class="block font-medium mb-1">Order Status</label>
                <select name="status" required class="w-full px-4 py-2 border border-[#EBD5DC] rounded bg-white">
                    <option value="Pending">Pending</option>
                    <option value="Confirmed">Confirmed</option>
                    <option value="Completed">Completed</option>
                </select>
            </div>

            <div class="text-center pt-4">
                <button type="submit" name="btnsubmit"
                    class="px-6 py-2 bg-[#916D7A] text-white rounded hover:bg-[#6E4B57] transition font-semibold">
                    Submit Order
                </button>
            </div>
        </form>
    </div>

    <script>
        function addProductRow() {
            const productList = document.getElementById("product-list");
            const newRow = document.createElement("div");
            newRow.classList = "grid grid-cols-5 gap-2 mb-3";
            newRow.innerHTML = `
                <select name="product_id[]" class="col-span-2 border px-2 py-1 rounded" required>
                    <option value="" disabled selected>Select Product</option>
                    <?php
                    $productQuery = mysqli_query($connect, "SELECT * FROM product");
                    while ($prow = mysqli_fetch_array($productQuery)) {
                        echo "<option value='{$prow['ProductCode']}'>{$prow['ProductName']}</option>";
                    }
                    ?>
                </select>
                <input type="number" name="quantity[]" placeholder="Qty" class="border px-2 py-1 rounded" required />
                <input type="number" name="price[]" placeholder="Price" class="border px-2 py-1 rounded" required />
                <input type="number" name="discount[]" placeholder="Discount" class="border px-2 py-1 rounded" value="0" />
            `;
            productList.appendChild(newRow);
        }
    </script>

    <?php include 'footer.php'; ?>
</body>

</html>
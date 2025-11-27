<?php
session_start();
include('connect.php');
include('AutoIDFunction.php');

$position = $_SESSION['position'] ?? '';

// Access control
if (!isset($_SESSION['sid']) || !in_array($position, ['Admin', 'Receptionist', 'Aesthetic Doctor'])) {
    echo "<script>alert('Access denied! Please log in as an authorized staff.');</script>";
    echo "<script>window.location='login.php';</script>";
    exit();
}

$productCode = AutoID("product", "ProductCode", "Pr_", 6);
if (isset($_POST['btnsubmit'])) {
    $product_name = $_POST['product_name'];
    $type = $_POST['type'];
    $price = $_POST['price'];
    $mdate = $_POST['mdate'];
    $edate = $_POST['edate'];
    $size = $_POST['size'];
    $quantity = $_POST['quantity'];
    $discount = $_POST['discount'];
    $description = $_POST['description'];
    $status = 'Available';  

    // Handle image upload
    if (isset($_FILES['fileimage'])) {
        $img1 = $_FILES['fileimage']['name'];
        $folder = "UploadedImage/";
        $productImage = $folder . "_" . $img1;

        $copy = copy($_FILES['fileimage']['tmp_name'], $productImage);

        if (!$copy) {
            echo "<p>Cannot upload Treatment Type Image</p>";
            exit();
        }
    }

    $select = "SELECT * FROM product WHERE ProductName='$product_name'";
    $query1 = mysqli_query($connect, $select);
    $count = mysqli_num_rows($query1);

    if ($count > 0) {
        echo "<script>window.alert('Product already exists!')</script>";
        echo "<script>window.location='product.php'</script>";
    } else {

        $insert = "INSERT INTO product (
           ProductCode, ProductName, ProductType, ProductImage, Price, ManufactureDate, ExpiryDate, ProductSize, ProductQuantity, Discount, Description, Status, ModifiedDate
        ) VALUES (
            '$productCode', '$product_name', '$type', '$productImage', '$price', '$mdate', '$edate', '$size', '$quantity', '$discount', '$description', '$status', NOW()
        )";

        $query = mysqli_query($connect, $insert);
        if ($query) {
            echo "<script>alert('Product Added Successfully!')</script>";
            echo "<script>window.location='product.php'</script>";
        } else {
            echo "<script>alert('Error while saving product!')</script>";
        }
    }
}
?>

<?php include 'header.php'; ?>

<body class="bg-[#F7EFEF] text-[#4A2C35] font-sans min-h-screen flex flex-col">
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>

    <main class="flex-1 py-6 px-4 sm:px-6 lg:px-8">
        <!-- Page Title -->
        <div class="text-center py-8 sm:py-10">
            <h1 class="text-2xl sm:text-3xl font-bold text-[#916D7A]">Product</h1>
        </div>

        <!-- Form Container -->
        <div class="max-w-md sm:max-w-lg md:max-w-xl lg:max-w-4xl mx-auto bg-white p-4 sm:p-6 lg:p-8 rounded-lg shadow-md border border-[#EBD5DC] mb-8 sm:mb-12 lg:mb-20">
            <form action="product.php" method="POST" class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-x-6 lg:gap-y-5" enctype="multipart/form-data">

                <!-- Product Code -->
                <div>
                    <label class="block font-medium mb-1 text-sm sm:text-base">Product Code</label>
                    <input type="text" name="product_code"
                        value="<?php echo AutoID('product', 'ProductCode', 'Pr_', 6); ?>"
                        class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] bg-[#FAF2F5] rounded focus:outline-none focus:ring-2 focus:ring-[#916D7A] focus:border-transparent text-sm sm:text-base" readonly />
                </div>

                <!-- Product Name -->
                <div>
                    <label class="block font-medium mb-1 text-sm sm:text-base">Product Name</label>
                    <input type="text" name="product_name"
                        class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded focus:outline-none focus:ring-2 focus:ring-[#916D7A] focus:border-transparent text-sm sm:text-base" required />
                </div>

                <!-- Product Type -->
                <div>
                    <label class="block font-medium mb-1 text-sm sm:text-base">Product Type</label>
                    <select name="type" required
                        class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded bg-white focus:outline-none focus:ring-2 focus:ring-[#916D7A] focus:border-transparent text-sm sm:text-base">
                        <option value="" disabled selected>Select Product Type</option>

                        <!-- Skincare -->
                        <optgroup label="Skincare">
                            <option value="Facial Foam">Facial Foam</option>
                            <option value="Toner">Toner</option>
                            <option value="Moisturizer">Moisturizer</option>
                            <option value="Serum">Serum</option>
                            <option value="Sun Cream">Sun Cream</option>
                            <option value="Face Mask">Face Mask</option>
                            <option value="Soothing Gel">Soothing Gel</option>
                        </optgroup>

                        <!-- Cosmetics -->
                        <optgroup label="Cosmetics">
                            <option value="Lip Balm">Lip Balm</option>
                            <option value="Lipstick">Lipstick</option>
                            <option value="Foundation">Foundation</option>
                            <option value="BB Cream">BB Cream</option>
                            <option value="Compact Powder">Compact Powder</option>
                            <option value="Eyeliner">Eyeliner</option>
                            <option value="Mascara">Mascara</option>
                        </optgroup>

                        <!-- Haircare -->
                        <optgroup label="Haircare">
                            <option value="Shampoo">Shampoo</option>
                            <option value="Conditioner">Conditioner</option>
                            <option value="Hair Oil">Hair Oil</option>
                            <option value="Hair Serum">Hair Serum</option>
                            <option value="Hair Mask">Hair Mask</option>
                        </optgroup>

                        <!-- Health & Wellness -->
                        <optgroup label="Health & Wellness">
                            <option value="Collagen Drink">Collagen Drink</option>
                            <option value="Skin Supplement">Skin Supplement</option>
                            <option value="Detox Supplement">Detox Supplement</option>
                        </optgroup>

                        <!-- Body Care -->
                        <optgroup label="Body Care">
                            <option value="Body Lotion">Body Lotion</option>
                            <option value="Body Scrub">Body Scrub</option>
                            <option value="Hand Cream">Hand Cream</option>
                            <option value="Shower Gel">Shower Gel</option>
                        </optgroup>

                        <!-- Others -->
                        <optgroup label="Others">
                            <option value="Beauty Tools">Beauty Tools</option>
                            <option value="Accessories">Accessories</option>
                        </optgroup>
                    </select>
                </div>

                <!-- Product Image -->
                <div>
                    <label class="block font-medium mb-1 text-sm sm:text-base">Product Image</label>
                    <input type="file" name="fileimage" required
                        class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded bg-white focus:outline-none focus:ring-2 focus:ring-[#916D7A] focus:border-transparent text-sm sm:text-base file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#916D7A] file:text-white hover:file:bg-[#6E4B57]" />
                </div>

                <!-- Price -->
                <div>
                    <label class="block font-medium mb-1 text-sm sm:text-base">Price (MMK)</label>
                    <input type="number" name="price"
                        class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded focus:outline-none focus:ring-2 focus:ring-[#916D7A] focus:border-transparent text-sm sm:text-base" required />
                </div>

                <!-- Manufacture Date -->
                <div>
                    <label class="block font-medium mb-1 text-sm sm:text-base">Manufacture Date</label>
                    <input type="date" name="mdate"
                        class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded focus:outline-none focus:ring-2 focus:ring-[#916D7A] focus:border-transparent text-sm sm:text-base" required />
                </div>

                <!-- Expiry Date -->
                <div>
                    <label class="block font-medium mb-1 text-sm sm:text-base">Expiry Date</label>
                    <input type="date" name="edate"
                        class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded focus:outline-none focus:ring-2 focus:ring-[#916D7A] focus:border-transparent text-sm sm:text-base" required />
                </div>

                <!-- Product Size -->
                <div>
                    <label class="block font-medium mb-1 text-sm sm:text-base">Product Size</label>
                    <input type="name" name="size"
                        class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded focus:outline-none focus:ring-2 focus:ring-[#916D7A] focus:border-transparent text-sm sm:text-base" required />
                </div>

                <!-- Product Quantity -->
                <div>
                    <label class="block font-medium mb-1 text-sm sm:text-base">Product Quantity</label>
                    <input type="number" name="quantity"
                        class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded focus:outline-none focus:ring-2 focus:ring-[#916D7A] focus:border-transparent text-sm sm:text-base" />
                </div>

                <!-- Discount -->
                <div>
                    <label class="block font-medium mb-1 text-sm sm:text-base">Discount (%)</label>
                    <input type="number" name="discount"
                        class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded focus:outline-none focus:ring-2 focus:ring-[#916D7A] focus:border-transparent text-sm sm:text-base" />
                </div>

                <!-- Description  -->
                <div class="lg:col-span-2">
                    <label class="block font-medium mb-1 text-sm sm:text-base">Description</label>
                    <textarea name="description" rows="4"
                        class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded focus:outline-none focus:ring-2 focus:ring-[#916D7A] focus:border-transparent text-sm sm:text-base resize-none"></textarea>
                </div>

                <!-- Submit Button -->
                <div class="lg:col-span-2 text-center pt-4">
                    <button type="submit" name="btnsubmit"
                        class="px-4 sm:px-6 py-2 bg-[#916D7A] text-white rounded hover:bg-[#6E4B57] transition font-semibold text-sm sm:text-base w-full">
                        Submit
                    </button>
                </div>

            </form>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>

</html>
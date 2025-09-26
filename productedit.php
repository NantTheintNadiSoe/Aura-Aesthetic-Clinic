<?php
session_start();
include('connect.php');
include('header.php');

if (!isset($_GET['code'])) {
    echo "<p class='text-center mt-10 text-red-600 font-semibold'>No product selected for edit.</p>";
    exit();
}

$productCode = $_GET['code'];

// Handle update
if (isset($_POST['btnupdate'])) {
    $product_name = $_POST['product_name'];
    $product_type = $_POST['product_type'];
    $product_size = $_POST['product_size'];
    $product_quantity = $_POST['product_quantity'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $modified_date = date('Y-m-d H:i:s');

    // Handle image upload (optional)
    if (isset($_FILES['fileimage']) && $_FILES['fileimage']['name'] != '') {
        $img1 = $_FILES['fileimage']['name'];
        $folder = "UploadedImage/";
        $productImage = $folder . "_" . $img1;
        $copy = copy($_FILES['fileimage']['tmp_name'], $productImage);
        if (!$copy) {
            echo "<p>Cannot upload Product Image</p>";
            exit();
        }
        $img_sql = ", ProductImage='$productImage'";
    } else {
        $img_sql = '';
    }

    $update = "UPDATE product SET ProductName='$product_name', ProductType='$product_type', ProductSize='$product_size', ProductQuantity='$product_quantity', Price='$price', Discount='$discount', Description='$description', Status='$status', ModifiedDate='$modified_date' $img_sql WHERE ProductCode='$productCode'";
    $query = mysqli_query($connect, $update);
    if ($query) {
        echo "<script>alert('Product updated successfully!');window.location='productlist.php';</script>";
        exit();
    } else {
        echo "<p class='text-center mt-10 text-red-600 font-semibold'>Update failed.</p>";
    }
}

// Fetch product data
$query = "SELECT * FROM product WHERE ProductCode = '$productCode'";
$result = mysqli_query($connect, $query);
if (mysqli_num_rows($result) === 0) {
    echo "<p class='text-center mt-10 text-red-600 font-semibold'>Product not found.</p>";
    exit();
}
$data = mysqli_fetch_assoc($result);
?>

<body class="bg-[#F7EFEF] text-[#4A2C35] font-sans">
    <?php include 'navbar.php'; ?>
    <div class="max-w-2xl mx-auto bg-white mt-10 p-8 rounded shadow-md border border-[#EBD5DC] mb-16">
        <h1 class="text-2xl font-bold text-[#916D7A] mb-6">Edit Product</h1>
        <form action="" method="POST" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label class="block font-medium mb-1">Product Name</label>
                <input type="text" name="product_name" value="<?php echo htmlspecialchars($data['ProductName']); ?>" required class="w-full px-4 py-2 border rounded" />
            </div>
            <div>
                <label class="block font-medium mb-1">Product Type</label>
                <input type="text" name="product_type" value="<?php echo htmlspecialchars($data['ProductType']); ?>" required class="w-full px-4 py-2 border rounded" />
            </div>
            <div>
                <label class="block font-medium mb-1">Product Size</label>
                <input type="text" name="product_size" value="<?php echo htmlspecialchars($data['ProductSize']); ?>" class="w-full px-4 py-2 border rounded" />
            </div>
            <div>
                <label class="block font-medium mb-1">Quantity</label>
                <input type="number" name="product_quantity" value="<?php echo htmlspecialchars($data['ProductQuantity']); ?>" class="w-full px-4 py-2 border rounded" />
            </div>
            <div>
                <label class="block font-medium mb-1">Price</label>
                <input type="number" name="price" value="<?php echo htmlspecialchars($data['Price']); ?>" required class="w-full px-4 py-2 border rounded" />
            </div>
            <div>
                <label class="block font-medium mb-1">Discount (%)</label>
                <input type="number" name="discount" value="<?php echo htmlspecialchars($data['Discount']); ?>" class="w-full px-4 py-2 border rounded" />
            </div>
            <div>
                <label class="block font-medium mb-1">Description</label>
                <textarea name="description" class="w-full px-4 py-2 border rounded"><?php echo htmlspecialchars($data['Description']); ?></textarea>
            </div>
            <div>
                <label class="block font-medium mb-1">Status</label>
                <select name="status" class="w-full px-4 py-2 border rounded">
                    <option value="Active" <?php if ($data['Status'] == 'Active') echo 'selected'; ?>>Active</option>
                    <option value="Inactive" <?php if ($data['Status'] == 'Inactive') echo 'selected'; ?>>Inactive</option>
                </select>
            </div>
            <div>
                <label class="block font-medium mb-1">Product Image (optional)</label>
                <input type="file" name="fileimage" class="w-full px-4 py-2 border rounded" />
                <?php if ($data['ProductImage']) { ?>
                    <img src="<?php echo $data['ProductImage']; ?>" alt="Current Image" class="w-24 h-24 object-cover mt-2 border rounded" />
                <?php } ?>
            </div>
            <button type="submit" name="btnupdate" class="px-6 py-2 bg-[#916D7A] text-white rounded hover:bg-[#6E4B57]">Update Product</button>
        </form>
    </div>
</body>
<?php include 'footer.php'; ?>
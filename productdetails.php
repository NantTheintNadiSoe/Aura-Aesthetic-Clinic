<?php
session_start();
include('connect.php');
include('header.php');

if (!isset($_GET['code'])) {
    echo "<p class='text-center mt-10 text-red-600 font-semibold'>No product selected.</p>";
    exit();
}

$productCode = $_GET['code'];
$query = "SELECT * FROM product WHERE ProductCode = '$productCode'";
$result = mysqli_query($connect, $query);

if (mysqli_num_rows($result) === 0) {
    echo "<p class='text-center mt-10 text-red-600 font-semibold'>Product not found.</p>";
    exit();
}

$data = mysqli_fetch_assoc($result);
?>

<body class="bg-[#F7EFEF] text-[#4A2C35] font-sans">
    <?php include('navbar.php'); ?>

    <section class="max-w-5xl mx-auto bg-white mt-12 p-10 rounded-2xl shadow-lg border border-[#EBD5DC] mb-20">
        <div class="flex flex-col md:flex-row gap-10">
            <!-- Product Image -->
            <div class="md:w-1/2 flex justify-center items-center">
                <img src="<?php echo $data['ProductImage']; ?>" alt="Product Image"
                    class="w-full max-h-96 object-cover rounded-xl border border-[#EBD5DC] shadow-sm" />
            </div>

            <!-- Product Info -->
            <div class="md:w-1/2 flex flex-col justify-between">
                <div>
                    <h1 class="text-4xl font-extrabold text-[#916D7A] mb-4 leading-tight"><?php echo $data['ProductName']; ?></h1>
                    <p class="text-[#6E4B57] mb-6 text-lg leading-relaxed"><?php echo nl2br(htmlspecialchars($data['Description'])); ?></p>
                </div>

                <div class="space-y-3 text-sm text-[#4A2C35] font-medium">
                    <p><span class="font-semibold text-[#916D7A]">Type:</span> <?php echo $data['ProductType']; ?></p>
                    <p><span class="font-semibold text-[#916D7A]">Size:</span> <?php echo $data['ProductSize']; ?></p>
                    <p><span class="font-semibold text-[#916D7A]">Quantity Available:</span> <?php echo $data['ProductQuantity']; ?></p>
                    <p><span class="font-semibold text-[#916D7A]">Discount:</span> <?php echo $data['Discount']; ?>%</p>
                    <p>
                        <span class="font-semibold text-[#916D7A]">Price:</span>
                        <span class="text-lg">
                            MMK <?php echo number_format($data['Price']); ?>
                        </span>
                    </p>
                </div>

                <!-- Add to Cart Form -->
                <form method="POST" action="ShoppingCart.php" class="mt-8 flex flex-wrap items-center gap-4">
                    <input type="hidden" name="txtproductid" value="<?php echo $data['ProductCode']; ?>">
                    <label for="quantity" class="sr-only">Quantity</label>
                    <input id="quantity" type="number" name="txtquantity" value="1" min="1"
                        class="w-20 border border-[#EBD5DC] rounded-lg px-3 py-2 text-[#4A2C35] focus:outline-none focus:ring-2 focus:ring-[#916D7A]" />
                    <button type="submit" name="btnadd"
                        class="px-8 py-3 bg-[#916D7A] text-white rounded-lg hover:bg-[#6E4B57] transition font-semibold shadow-md">Add to Cart</button>
                    <a href="productview.php"
                        class="px-8 py-3 bg-[#EBD5DC] text-[#6E4B57] rounded-lg hover:bg-[#D4B9C0] transition font-semibold shadow-md">Back to Products</a>
                </form>
            </div>
        </div>
    </section>

    <?php include('footer.php'); ?>
</body>


</html>
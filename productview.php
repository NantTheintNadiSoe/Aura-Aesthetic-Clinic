<?php
session_start();
include('connect.php');
?>

<?php include 'header.php'; ?>

<body class="bg-[#F7EFEF] text-[#4A2C35] font-sans">
    <?php include 'navbar.php'; ?>

    <!-- Page Title -->
    <section class="text-center mt-12 px-6 max-w-3xl mx-auto">
        <h1 class="text-4xl font-extrabold text-[#916D7A] tracking-wide">Our Products</h1>
        <p class="text-[#6E4B57] mt-3 text-lg">Browse our high-quality skincare, cosmetics, and wellness products</p>
    </section>

    <!-- Search Bar -->
    <section class="max-w-4xl mx-auto mt-10 px-6">
        <form method="GET" action="productview.php" class="flex flex-col sm:flex-row gap-4">
            <input type="text" name="search" placeholder="Search product name..."
                value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
                class="flex-1 px-5 py-3 border border-[#EBD5DC] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#916D7A] text-[#4A2C35] placeholder-[#BFA6B0]" />
            <button type="submit"
                class="px-8 py-3 bg-[#916D7A] text-white rounded-lg hover:bg-[#6E4B57] transition font-semibold shadow-md">Search</button>
        </form>
    </section>

    <!-- Products Grid -->
    <section class="max-w-7xl mx-auto mt-12 px-6 mb-20">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            <?php
            $filter = "WHERE 1=1";

            if (isset($_GET['search']) && $_GET['search'] != "") {
                $searchTerm = mysqli_real_escape_string($connect, $_GET['search']);
                $filter .= " AND ProductName LIKE '%$searchTerm%'";
            }

            if (isset($_GET['category']) && $_GET['category'] != "") {
                $categoryFilter = mysqli_real_escape_string($connect, $_GET['category']);
                $filter .= " AND ProductType = '$categoryFilter'";
            }

            $query = "SELECT * FROM product $filter ORDER BY ProductCode DESC";
            $result = mysqli_query($connect, $query);

            if (mysqli_num_rows($result) === 0) {
                echo "<p class='col-span-full text-center text-[#6E4B57] text-lg font-medium'>No products found.</p>";
            } else {
                while ($row = mysqli_fetch_assoc($result)) {
                    $code = $row['ProductCode'];
                    $name = $row['ProductName'];
                    $description = mb_strimwidth($row['Description'], 0, 70, "...");
                    $price = number_format($row['Price']);
                    $discount = $row['Discount'];
                    $imagePath = $row['ProductImage'];

                    // Calculate discounted price if discount exists
                    if ($discount > 0) {
                        $discountedPrice = number_format($row['Price'] * (1 - $discount / 100));
                    }

                    echo "
                        <div class='bg-white rounded-xl shadow-lg hover:shadow-xl transition p-5 flex flex-col'>
                            <div class='relative h-48 w-full mb-4 rounded-lg overflow-hidden bg-[#FAF2F5]'>
                                <img src='{$imagePath}' alt='{$name}' class='w-full h-full object-cover transform transition duration-300 hover:scale-110'>
                                " . ($discount > 0 ? "<span class='absolute top-3 left-3 bg-[#EBD5DC] text-[#916D7A] text-xs font-semibold px-2 py-1 rounded'>-{$discount}%</span>" : "") . "
                            </div>
                            <h3 class='text-xl font-semibold text-[#916D7A] mb-2 truncate' title='{$name}'>{$name}</h3>
                            <p class='text-[#6E4B57] text-sm flex-grow'>{$description}</p>
                            <div class='mt-4'>
                                " . ($discount > 0 ? "
                                    <p class='text-sm text-gray-400 line-through'>MMK {$price}</p>
                                    <p class='text-lg font-bold text-[#4A2C35]'>MMK {$discountedPrice}</p>
                                " : "
                                    <p class='text-lg font-bold text-[#4A2C35]'>MMK {$price}</p>
                                ") . "
                            </div>
                            <a href='productdetails.php?code={$code}' class='mt-5 inline-block text-center bg-[#916D7A] text-white py-2 rounded-lg hover:bg-[#6E4B57] transition font-semibold'>See Details</a>
                        </div>
                    ";
                }
            }
            ?>
        </div>
    </section>

    <?php include 'footer.php'; ?>
</body>

</html>
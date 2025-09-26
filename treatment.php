<?php
session_start();
include('connect.php');
?>

<?php include 'header.php'; ?>

<body class="bg-[#F7EFEF] text-[#4A2C35] font-sans">
    <?php include 'navbar.php'; ?>

    <!-- Page Title -->
    <section class="text-center mt-10 px-4">
        <h1 class="text-3xl font-bold text-[#916D7A]">Our Treatments</h1>
        <p class="text-gray-600 mt-2">Explore our range of professional treatments to enhance your beauty</p>
    </section>

    <!-- Search Bar -->
    <section class="max-w-4xl mx-auto mt-8 px-4">
        <form method="GET" action="treatment.php" class="flex flex-col sm:flex-row gap-4">
            <input type="text" name="search" placeholder="Search treatment name..."
                value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
                class="flex-1 px-4 py-2 border border-[#EBD5DC] rounded focus:outline-none focus:ring-2 focus:ring-[#916D7A]" />
            <button type="submit"
                class="px-6 py-2 bg-[#916D7A] text-white rounded hover:bg-[#6E4B57] transition">Search</button>
        </form>
    </section>
    <!-- Category Filter Buttons (5 per row, compact width) -->
    <section class="max-w-7xl mx-auto mt-10 px-4 mb-16">
        <div class="grid grid-cols-2 md:grid-cols-5 gap-2 mt-4">
            <?php
            $categories = [
                "Injectables",
                "Laser Treatments",
                "Facial Treatments",
                "Skin Rejuvenation",
                "Body Contouring",
                "Hair Restoration",
                "Anti-Aging",
                "Peels & Exfoliation",
                "Wellness & IV Drips",
                "Acne Treatments"
            ];

            foreach ($categories as $cat) {
                $active = (isset($_GET['category']) && $_GET['category'] === $cat)
                    ? 'bg-[#916D7A] text-white'
                    : 'bg-[#FAF2F5] text-[#4A2C35] hover:bg-[#EBD5DC]';

                echo "<a href='?category=" . urlencode($cat) . "'
            class='text-sm text-center px-2 py-2 border border-[#EBD5DC] rounded $active whitespace-nowrap truncate'>
            $cat
          </a>";
            }

            if (isset($_GET['category'])) {
                echo "<a href='treatment.php' 
            class='text-sm text-center px-2 py-2 border border-[#EBD5DC] bg-red-100 text-red-800 rounded col-span-2 md:col-span-5'>
            Clear Filter ✕
          </a>";
            }
            ?>
        </div>
    </section>



    <!-- Treatments Grid -->
    <section class="max-w-7xl mx-auto mt-10 px-4 mb-16">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php
            $filter = "WHERE 1=1";

            if (isset($_GET['search']) && $_GET['search'] != "") {
                $searchTerm = mysqli_real_escape_string($connect, $_GET['search']);
                $filter .= " AND TreatmentName LIKE '%$searchTerm%'";
            }

            if (isset($_GET['category']) && $_GET['category'] != "") {
                $categoryFilter = mysqli_real_escape_string($connect, $_GET['category']);
                $filter .= " AND Category = '$categoryFilter'";
            }

            $query = "SELECT * FROM treatment $filter ORDER BY CreatedDate DESC";
            $result = mysqli_query($connect, $query);

            if (mysqli_num_rows($result) === 0) {
                echo "<p class='col-span-full text-center text-gray-500'>No treatments found.</p>";
            } else {
                while ($row = mysqli_fetch_assoc($result)) {
                    $name = $row['TreatmentName'];
                    $description = mb_strimwidth($row['Descriptions'], 0, 60, "...");
                    $price = number_format($row['Price']);
                    $imagePath = $row['TreatmentImage'];
                    echo "
                        <div class='border border-[#EBD5DC] bg-white rounded shadow hover:shadow-md transition'>
                            <div class='h-40 w-full mb-3 overflow-hidden rounded-t bg-[#FAF2F5]'>
                                <img src='{$imagePath}' alt='{$name}' class='w-full h-full object-cover transform transition duration-300 hover:scale-105'>
                            </div>
                            <div class='p-3'>
                                <h3 class='font-semibold text-lg text-[#916D7A]'>$name</h3>
                                <p class='text-sm text-gray-600 mb-2'>$description</p>
                                <p class='text-sm font-semibold text-[#4A2C35]'>Price: MMK $price</p>
                                <a href='treatmentdetails.php?code={$row['TreatmentCode']}' class='mt-2 inline-block text-sm text-[#916D7A] hover:underline'>See Details</a>
                            </div>
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
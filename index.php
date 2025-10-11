<?php
session_start();
include('connect.php');
include 'header.php'; ?>

<body class="font-sans bg-[#FFF8F5] text-[#4C2A36] min-h-screen">

    <!-- Navbar -->
    <?php include 'navbar.php'; ?>


    <!-- Hero Section -->
    <section class="relative w-full h-[450px] md:h-[600px]">
        <img src="./image/model2.jpg" alt="Model" class="absolute inset-0 w-full h-full object-cover object-center" />
        <div class="absolute inset-0 bg-black bg-opacity-30"></div>
        <div class="relative z-10 h-full flex items-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                <div class="max-w-xl text-left text-white">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4 text-[#FFD1DC] leading-tight">
                        Reveal Your Natural Glow
                    </h1>
                    <p class="mb-6 text-base md:text-lg leading-relaxed">
                        Personalized skincare & expert consultations from certified aestheticians
                    </p>


                    <div class="flex flex-col md:flex-row gap-3 md:gap-4">

                        <a class="px-4 py-2 bg-[#5B3F4E] text-white rounded hover:bg-[#4A2C35] transition
                         text-sm font-normal h-[36px]
                         sm:text-base sm:font-semibold sm:h-auto whitespace-nowrap w-full md:w-auto text-center" href="skinassessment.php">Take Skin Assessment</a>
                        <a class="px-4 py-2 border border-white text-white rounded hover:bg-white hover:text-[#916D7A] transition
                         text-sm font-normal h-[36px]
                         sm:text-base sm:font-semibold sm:h-auto whitespace-nowrap w-full md:w-auto text-center" href="appointment.php">Book Appointment</a>

                    </div>

                </div>
            </div>
        </div>
    </section>



    <!-- Our Services -->
    <section class="py-10 md:py-12 bg-[#FFF8F5]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl md:text-3xl font-bold mb-6 md:mb-8 text-[#BA9EA8]">Our Services</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Service 1 -->
                <a href="consultation.php" class="block p-6 border rounded bg-[#FFF8F5] shadow-sm hover:shadow-md transition">
                    <img src="./image/AestheticConsultation.jpg" class="w-full h-[180px] md:h-[200px] object-cover rounded mb-4 transform transition duration-300 hover:scale-105" />
                    <p class="font-semibold text-[#4C2A36] text-base md:text-lg">Virtual & In-person Consultations</p>
                </a>

                <!-- Service 2 -->
                <a href="skinassessment.php" class="block p-6 border rounded bg-[#FFF8F5] shadow-sm hover:shadow-md transition">
                    <img src="./image/skinanalysis.jpg" alt="Skin Assessments" class="w-full h-[180px] md:h-[200px] object-cover rounded mb-4 transform transition duration-300 hover:scale-105" />
                    <p class="font-semibold text-[#4C2A36] text-base md:text-lg">Skin Assessments</p>
                </a>

                <!-- Service 3 -->
                <a href="skincare_treatments.php" class="block p-6 border rounded bg-[#FFF8F5] shadow-sm hover:shadow-md transition">
                    <img src="./image/skincare2.webp" alt="Skincare Treatments" class="w-full h-[180px] md:h-[200px] object-cover rounded mb-4 transform transition duration-300 hover:scale-105" />
                    <p class="font-semibold text-[#4C2A36] text-base md:text-lg">Personalized Skincares</p>
                </a>
            </div>
        </div>
    </section>

    <!-- Latest Treatments Section -->
    <section class="py-10 md:py-12 bg-[#FFF8F5]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl md:text-3xl font-bold mb-6 md:mb-8 text-[#BA9EA8]">Latest Treatments</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

                <?php
                $query = "SELECT * FROM treatment ORDER BY CreatedDate DESC LIMIT 8";
                $result = mysqli_query($connect, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $name = $row['TreatmentName'];
                        $description = mb_strimwidth($row['Descriptions'], 0, 60, "...");
                        $price = number_format($row['Price']);
                        $image = $row['TreatmentImage'];
                        $code = $row['TreatmentCode'];

                        echo "
                    <div class='border border-[#EBD5DC] bg-white rounded shadow hover:shadow-md transition'>
                        <div class='h-[160px] md:h-40 w-full mb-3 overflow-hidden rounded-t bg-[#FAF2F5]'>
                            <img src='{$image}' alt='{$name}' class='w-full h-full object-cover transform transition duration-300 hover:scale-105'>
                        </div>
                        <div class='p-3'>
                            <h3 class='font-semibold text-base md:text-lg text-[#916D7A] leading-tight'>$name</h3>
                            <p class='text-sm text-gray-600 mb-2 line-clamp-2'>$description</p>
                            <p class='text-sm font-semibold text-[#4A2C35]'>Price: MMK $price</p>
                            <a href='treatmentdetails.php?code=$code' class='mt-2 inline-block text-sm text-[#916D7A] hover:underline'>See Details</a>
                        </div>
                    </div>
                    ";
                    }
                } else {
                    echo "<p class='text-gray-600 col-span-full'>No treatments available right now.</p>";
                }
                ?>

            </div>

            <!-- Optional: Link to full treatments page -->
            <div class="mt-8">
                <a href="treatment.php"
                    class="inline-block px-6 py-2 bg-[#916D7A] text-white rounded hover:bg-[#6E4B57] transition font-semibold shadow">
                    View All Treatments
                </a>
            </div>
    </section>



    <!-- Shop Section -->
    <section class="py-10 md:py-12 bg-[#FFF8F5]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl md:text-3xl font-bold mb-6 md:mb-8 text-[#BA9EA8]">Shop Our Skincare Products</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

                <?php
                $query = "SELECT * FROM product ORDER BY ProductCode DESC LIMIT 8";
                $result = mysqli_query($connect, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $name = $row['ProductName'];
                        $description = mb_strimwidth($row['Description'], 0, 60, "...");
                        $price = number_format($row['Price']);
                        $image = $row['ProductImage'];
                        $code = $row['ProductCode'];

                        echo "
                    <div class='border border-[#EBD5DC] bg-white rounded shadow hover:shadow-md transition'>
                        <div class='h-[160px] md:h-40 w-full mb-3 overflow-hidden rounded-t bg-[#FAF2F5]'>
                            <img src='{$image}' alt='{$name}' class='w-full h-full object-cover transform transition duration-300 hover:scale-105'>
                        </div>
                        <div class='p-3'>
                            <h3 class='font-semibold text-base md:text-lg text-[#916D7A] leading-tight'>$name</h3>
                            <p class='text-sm text-gray-600 mb-2 line-clamp-2'>$description</p>
                            <p class='text-sm font-semibold text-[#4A2C35]'>Price: MMK $price</p>
                            <a href='productdetails.php?code=$code' class='mt-2 inline-block text-sm text-[#916D7A] hover:underline'>See Details</a>
                        </div>
                    </div>
                    ";
                    }
                } else {
                    echo "<p class='text-gray-600 col-span-full'>No products available right now.</p>";
                }
                ?>
            </div>

            <!-- Optional: Link to full products page -->
            <div class="mt-8">
                <a href="productview.php"
                    class="inline-block px-6 py-2 bg-[#916D7A] text-white rounded hover:bg-[#6E4B57] transition font-semibold shadow">
                    View All Products
                </a>
            </div>
        </div>
    </section>


    <!-- Our Doctors Section -->
    <section class="py-10 md:py-12 bg-[#FFF8F5]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl md:text-3xl font-bold mb-6 md:mb-8 text-[#BA9EA8]">Meet Our Doctors</h2>
            <div>
                <?php
                $query = "SELECT * FROM staffregister 
                      WHERE Position IN ('Aesthetic Doctor', 'Dermatologist', 'Aesthetician')";
                $result = mysqli_query($connect, $query);
                $count = mysqli_num_rows($result);

                if ($count == 0) {
                    echo "<p class='text-gray-600'>No staff found for the selected positions.</p>";
                } else {
                    echo "<div class='grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 p-6'>";
                    while ($data = mysqli_fetch_assoc($result)) {
                        $name = $data['Name'];
                        $position = $data['Position'];
                        $email = $data['Email'];
                        $qualification = $data['Qualification'];
                        $imagePath = $data['ProfileImage'];

                        echo "
                    <div class='border border-[#EBD5DC] bg-white rounded shadow hover:shadow-md transition'>
                        <div class='w-full aspect-[3/2] mb-3 overflow-hidden rounded-t bg-[#FAF2F5]'>
                            <img src='{$imagePath}' alt='{$name}' class='w-full h-full object-cover transform transition duration-300 hover:scale-105 object-top' onerror=\"this.src='default.jpg'\">
                        </div>
                        <div class='p-3'>
                            <h3 class='font-semibold text-base md:text-lg text-[#916D7A] leading-tight'>$name</h3>
                            <p class='text-sm text-gray-600 mb-2 line-clamp-1'>$position</p>
                            <p class='text-sm text-gray-600 mb-2 line-clamp-1'>$email</p>
                            <p class='text-sm text-gray-600 mb-2 line-clamp-1'>$qualification</p>
                        </div>
                    </div>
                    ";
                    }
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </section>



    <!-- Testimonials -->
    <section class="py-10 md:py-12 bg-[#FFF8F5]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl md:text-3xl font-bold mb-6 md:mb-8 text-[#BA9EA8]">What Our Clients Say</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="p-6 border rounded bg-[#FFF8F5] shadow-sm text-base md:text-lg">"Great Consultation Service"<br /><strong class="text-[#4A2C35]">Anna</strong></div>
                <div class="p-6 border rounded bg-[#FFF8F5] shadow-sm text-base md:text-lg">"My skin has improved so much"<br /><strong class="text-[#4A2C35]">Lily</strong></div>
                <div class="p-6 border rounded bg-[#FFF8F5] shadow-sm text-base md:text-lg">"Aura changed my skin!"<br /><strong class="text-[#4A2C35]">Caro</strong></div>
                <div class="p-6 border rounded bg-[#FFF8F5] shadow-sm text-base md:text-lg">"Friendly staff!"<br /><strong class="text-[#4A2C35]">Ella</strong></div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

</body>

</html>
<?php include 'header.php'; ?>

<body class="font-sans bg-[#F7EFEF] text-[#4A2C35]">

    <?php include 'navbar.php'; ?>

    <main class="px-6 py-12 max-w-7xl mx-auto">

        <h1 class="text-3xl font-bold text-center text-[#916D7A] mb-10">Personalized Recommendations</h1>


        <div class="bg-white border border-[#EBD5DC] p-6 rounded shadow mb-12">
            <h2 class="text-xl font-semibold text-[#916D7A] mb-4">Patient Information</h2>
            <p><strong>Name:</strong> Anna</p>
            <p><strong>Assessment Date:</strong> 11/06/2025</p>
            <p><strong>Skin Concerns:</strong> Dryness, Wrinkles</p>
            <p><strong>Allergies:</strong> None</p>
        </div>

        <!-- Recommended Treatments -->
        <section class="mb-16">
            <h2 class="text-2xl font-semibold text-center text-[#916D7A] mb-6">Recommended Treatments</h2>
            <p class="text-center text-[#4A2C35] text-opacity-70 mb-8 max-w-2xl mx-auto">
                Based on your assessment, we recommend the following treatments to help rejuvenate and hydrate your skin.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <?php for ($i = 0; $i < 2; $i++): ?>
                    <div class="bg-white border border-[#EBD5DC] p-6 rounded shadow hover:shadow-md transition">
                        <div class="w-full h-48 bg-gray-200 rounded mb-4 flex items-center justify-center text-gray-400">Image</div>
                        <p class="text-lg font-semibold text-[#4A2C35]">Hydrating Facial</p>
                        <p class="text-sm text-gray-600 mb-4">Deep hydration therapy to restore moisture levels and improve skin texture.</p>
                        <button class="px-4 py-2 bg-[#916D7A] text-white rounded hover:bg-[#6E4B57] transition">
                            View Details
                        </button>
                    </div>
                <?php endfor; ?>
            </div>
        </section>

        <!-- Recommended Skincare Products -->
        <section class="mb-20">
            <h2 class="text-2xl font-semibold text-center text-[#916D7A] mb-6">Recommended Skincare Products</h2>
            <p class="text-center text-[#4A2C35] text-opacity-70 mb-8 max-w-2xl mx-auto">
                These products are selected to support your daily skincare routine and address your concerns.
            </p>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                <?php for ($i = 0; $i < 3; $i++): ?>
                    <div class="bg-white border border-[#EBD5DC] p-6 rounded shadow hover:shadow-md transition">
                        <div class="w-full h-48 bg-gray-200 rounded mb-4 flex items-center justify-center text-gray-400">Product</div>
                        <p class="text-lg font-semibold text-[#4A2C35]">Rose Water Toner</p>
                        <p class="text-sm text-gray-600 mb-4">Balances pH and hydrates sensitive skin with a calming rose formula.</p>
                        <button class="px-4 py-2 bg-[#916D7A] text-white rounded hover:bg-[#6E4B57] transition">
                            View Details
                        </button>
                    </div>
                <?php endfor; ?>
            </div>
        </section>

        <!-- Submit Button -->
        <div class="text-center mb-10">
            <button class="px-6 py-3 bg-[#916D7A] text-white rounded hover:bg-[#6E4B57] transition font-semibold">
                Submit
            </button>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>

</html>
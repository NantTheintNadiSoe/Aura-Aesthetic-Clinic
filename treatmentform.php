<?php
include('connect.php');
include('AutoIDFunction.php');

$treatmentCode = AutoID("treatment", "TreatmentCode", "Tr_", 6);
if (isset($_POST['btnsubmit'])) {
    $treatment_name = $_POST['treatment_name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];
    $description = $_POST['description'];
    $sessions = $_POST['sessions'];
    $recovery = $_POST['recovery'];
    $duration_effect = $_POST['duration_effect'];
    $discount = $_POST['discount'];
    $prerequisites = $_POST['prerequisites'];
    $contraindications = $_POST['contraindications'];
    $aftercare = $_POST['aftercare'];
    $expected_results = $_POST['expected_results'];
    $side_effects = $_POST['side_effects'];
    $status = "Active";
    $created_date = date('Y-m-d H:i:s');
    $modified_date = date('Y-m-d H:i:s');

    // Handle image upload
    if (isset($_FILES['fileimage'])) {
        $img1 = $_FILES['fileimage']['name'];
        $folder = "UploadedImage/";
        $treatmentImage = $folder . "_" . $img1;

        $copy = copy($_FILES['fileimage']['tmp_name'], $treatmentImage);

        if (!$copy) {
            echo "<p>Cannot upload Treatment Type Image</p>";
            exit();
        }
    }

    $select = "SELECT * FROM treatment WHERE TreatmentName='$treatment_name'";
    $query1 = mysqli_query($connect, $select);
    $count = mysqli_num_rows($query1);

    if ($count > 0) {
        echo "<script>window.alert('Treatment already exists!')</script>";
        echo "<script>window.location='treatmentform.php'</script>";
    } else {
        $insert = "INSERT INTO treatment (
            TreatmentCode, TreatmentName, TreatmentImage, Category, CreatedDate, ModifiedDate, Price, Duration, Descriptions, 
            Sessions, RecoveryTime, DurationOfEffect, Discount, Prerequisites, Contraindications,
            AftercareInstructions, ExpectedResults, SideEffects,Status
        ) VALUES (
            '$treatmentCode', '$treatment_name', '$treatmentImage', '$category', '$created_date', '$modified_date', '$price', '$duration', '$description',
            '$sessions', '$recovery', '$duration_effect', '$discount', '$prerequisites', '$contraindications',
            '$aftercare', '$expected_results', '$side_effects', '$status'
        )";

        $query = mysqli_query($connect, $insert);
        if ($query) {
            echo "<script>alert('Treatment Added Successfully!')</script>";
            echo "<script>window.location='treatmentform.php'</script>";
        } else {
            echo "<script>alert('Error while saving treatment!')</script>";
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
            <h1 class="text-2xl sm:text-3xl font-bold text-[#916D7A]">Treatment</h1>
        </div>

        <!-- Form Container -->
        <div class="max-w-md sm:max-w-lg md:max-w-xl lg:max-w-4xl mx-auto bg-white p-4 sm:p-6 lg:p-8 rounded-lg shadow-md border border-[#EBD5DC] mb-8 sm:mb-12 lg:mb-20">
            <form action="treatmentform.php" method="POST" class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-x-6 lg:gap-y-5" enctype="multipart/form-data">

                <!-- Treatment Code (readonly, full width on lg+) -->
                <div class="lg:col-span-2">
                    <label class="block font-medium mb-1 text-sm sm:text-base">Treatment Code</label>
                    <input type="text" name="treatment_code"
                        value="<?php echo AutoID('treatment', 'TreatmentCode', 'Tr_', 6); ?>"
                        class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] bg-[#FAF2F5] rounded focus:outline-none focus:ring-2 focus:ring-[#916D7A] focus:border-transparent text-sm sm:text-base" readonly />
                </div>

                <!-- Treatment Name -->
                <div>
                    <label class="block font-medium mb-1 text-sm sm:text-base">Treatment Name</label>
                    <input type="text" name="treatment_name"
                        class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded focus:outline-none focus:ring-2 focus:ring-[#916D7A] focus:border-transparent text-sm sm:text-base" required />
                </div>

                <!-- Category -->
                <div>
                    <label class="block font-medium mb-1 text-sm sm:text-base">Category</label>
                    <select name="category" required
                        class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded bg-white focus:outline-none focus:ring-2 focus:ring-[#916D7A] focus:border-transparent text-sm sm:text-base">
                        <option value="" disabled selected>Select category</option>
                        <option value="Injectables">Injectables</option>
                        <option value="Laser Treatments">Laser Treatments</option>
                        <option value="Facial Treatments">Facial Treatments</option>
                        <option value="Skin Rejuvenation">Skin Rejuvenation</option>
                        <option value="Body Contouring">Body Contouring</option>
                        <option value="Hair Restoration">Hair Restoration</option>
                        <option value="Anti-Aging">Anti-Aging</option>
                        <option value="Peels & Exfoliation">Peels & Exfoliation</option>
                        <option value="Wellness & IV Drips">Wellness & IV Drips</option>
                        <option value="Acne Treatments">Acne Treatments</option>
                    </select>
                </div>

                <!-- Treatment Image (full width on lg+) -->
                <div class="lg:col-span-2">
                    <label class="block font-medium mb-1 text-sm sm:text-base">Treatment Image</label>
                    <input type="file" name="fileimage" required
                        class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded bg-white focus:outline-none focus:ring-2 focus:ring-[#916D7A] focus:border-transparent text-sm sm:text-base file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#916D7A] file:text-white hover:file:bg-[#6E4B57]" />
                </div>

                <!-- Price -->
                <div>
                    <label class="block font-medium mb-1 text-sm sm:text-base">Price (MMK)</label>
                    <input type="text" name="price"
                        class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded focus:outline-none focus:ring-2 focus:ring-[#916D7A] focus:border-transparent text-sm sm:text-base" required />
                </div>

                <!-- Duration -->
                <div>
                    <label class="block font-medium mb-1 text-sm sm:text-base">Duration</label>
                    <input type="text" name="duration"
                        class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded focus:outline-none focus:ring-2 focus:ring-[#916D7A] focus:border-transparent text-sm sm:text-base" required />
                </div>

                <!-- Sessions -->
                <div>
                    <label class="block font-medium mb-1 text-sm sm:text-base">No. of Sessions</label>
                    <input type="number" name="sessions" placeholder="e.g., 3"
                        class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded focus:outline-none focus:ring-2 focus:ring-[#916D7A] focus:border-transparent text-sm sm:text-base" />
                </div>

                <!-- Recovery Time -->
                <div>
                    <label class="block font-medium mb-1 text-sm sm:text-base">Recovery Time</label>
                    <input type="text" name="recovery" placeholder="e.g., 2 days"
                        class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded focus:outline-none focus:ring-2 focus:ring-[#916D7A] focus:border-transparent text-sm sm:text-base" />
                </div>

                <!-- Duration of Effect -->
                <div>
                    <label class="block font-medium mb-1 text-sm sm:text-base">Duration of Effect</label>
                    <input type="text" name="duration_effect" placeholder="e.g., 3 months"
                        class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded focus:outline-none focus:ring-2 focus:ring-[#916D7A] focus:border-transparent text-sm sm:text-base" />
                </div>

                <!-- Discount -->
                <div>
                    <label class="block font-medium mb-1 text-sm sm:text-base">Discount (%)</label>
                    <input type="number" name="discount" placeholder="e.g., 10"
                        class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded focus:outline-none focus:ring-2 focus:ring-[#916D7A] focus:border-transparent text-sm sm:text-base" />
                </div>

                <!-- Prerequisites -->
                <div>
                    <label class="block font-medium mb-1 text-sm sm:text-base">Prerequisites</label>
                    <textarea name="prerequisites" rows="2"
                        class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded focus:outline-none focus:ring-2 focus:ring-[#916D7A] focus:border-transparent text-sm sm:text-base resize-none"></textarea>
                </div>

                <!-- Contraindications -->
                <div>
                    <label class="block font-medium mb-1 text-sm sm:text-base">Contraindications</label>
                    <textarea name="contraindications" rows="2"
                        class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded focus:outline-none focus:ring-2 focus:ring-[#916D7A] focus:border-transparent text-sm sm:text-base resize-none"></textarea>
                </div>

                <!-- Aftercare Instructions -->
                <div>
                    <label class="block font-medium mb-1 text-sm sm:text-base">Aftercare Instructions</label>
                    <textarea name="aftercare" rows="2"
                        class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded focus:outline-none focus:ring-2 focus:ring-[#916D7A] focus:border-transparent text-sm sm:text-base resize-none"></textarea>
                </div>

                <!-- Expected Results -->
                <div>
                    <label class="block font-medium mb-1 text-sm sm:text-base">Expected Results</label>
                    <textarea name="expected_results" rows="2"
                        class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded focus:outline-none focus:ring-2 focus:ring-[#916D7A] focus:border-transparent text-sm sm:text-base resize-none"></textarea>
                </div>

                <!-- Side Effects (full width on lg+) -->
                <div class="lg:col-span-2">
                    <label class="block font-medium mb-1 text-sm sm:text-base">Side Effects</label>
                    <textarea name="side_effects" rows="2"
                        class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded focus:outline-none focus:ring-2 focus:ring-[#916D7A] focus:border-transparent text-sm sm:text-base resize-none"></textarea>
                </div>

                <!-- Description (full width on lg+) -->
                <div class="lg:col-span-2">
                    <label class="block font-medium mb-1 text-sm sm:text-base">Description</label>
                    <textarea name="description" rows="4"
                        class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded focus:outline-none focus:ring-2 focus:ring-[#916D7A] focus:border-transparent text-sm sm:text-base resize-none"></textarea>
                </div>

                <input type="hidden" name="status" value="Active">

                <!-- Submit Button (full width on lg+) -->
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
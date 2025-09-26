<?php
include('connect.php');
include('header.php');

if (!isset($_GET['code'])) {
    echo "<p class='text-center mt-10 text-red-600 font-semibold'>No treatment selected.</p>";
    exit();
}

$treatmentCode = $_GET['code'];
$query = "SELECT * FROM treatment WHERE TreatmentCode = '$treatmentCode'";
$result = mysqli_query($connect, $query);

if (mysqli_num_rows($result) === 0) {
    echo "<p class='text-center mt-10 text-red-600 font-semibold'>Treatment not found.</p>";
    exit();
}

$data = mysqli_fetch_assoc($result);
?>

<body class="bg-[#F7EFEF] text-[#4A2C35] font-sans">
    <?php include('navbar.php'); ?>

    <section class="max-w-4xl mx-auto bg-white mt-10 p-8 rounded shadow-md border border-[#EBD5DC] mb-16">
        <div class="flex flex-col md:flex-row gap-6">
            <div class="md:w-1/2">
                <img src="<?php echo $data['TreatmentImage']; ?>" alt="Treatment Image"
                    class="w-full h-72 object-cover rounded border border-[#EBD5DC]">
            </div>
            <div class="md:w-1/2">
                <h1 class="text-3xl font-bold text-[#916D7A] mb-2"><?php echo $data['TreatmentName']; ?></h1>
                <p class="text-sm text-gray-600 mb-2">Category: <span class="text-[#4A2C35] font-medium"><?php echo $data['Category']; ?></span></p>
                <p class="text-sm text-gray-600 mb-2">Price: <span class="text-[#4A2C35] font-medium">MMK <?php echo number_format($data['Price']); ?></span></p>
                <p class="text-sm text-gray-600 mb-2">Duration: <span class="text-[#4A2C35] font-medium"><?php echo $data['Duration']; ?></span></p>
                <p class="text-sm text-gray-600 mb-2">Sessions: <span class="text-[#4A2C35] font-medium"><?php echo $data['Sessions']; ?></span></p>
                <p class="text-sm text-gray-600 mb-2">Recovery Time: <span class="text-[#4A2C35] font-medium"><?php echo $data['RecoveryTime']; ?></span></p>
                <p class="text-sm text-gray-600 mb-2">Duration of Effect: <span class="text-[#4A2C35] font-medium"><?php echo $data['DurationOfEffect']; ?></span></p>
                <p class="text-sm text-gray-600 mb-2">Discount: <span class="text-[#4A2C35] font-medium"><?php echo $data['Discount']; ?>%</span></p>
            </div>
        </div>

        <div class="mt-8 space-y-4">
            <div>
                <h2 class="text-lg font-semibold text-[#916D7A]">Description</h2>
                <p class="text-sm text-[#4A2C35]"><?php echo nl2br($data['Descriptions']); ?></p>
            </div>

            <div>
                <h2 class="text-lg font-semibold text-[#916D7A]">Prerequisites</h2>
                <p class="text-sm text-[#4A2C35]"><?php echo nl2br($data['Prerequisites']); ?></p>
            </div>

            <div>
                <h2 class="text-lg font-semibold text-[#916D7A]">Contraindications</h2>
                <p class="text-sm text-[#4A2C35]"><?php echo nl2br($data['Contraindications']); ?></p>
            </div>

            <div>
                <h2 class="text-lg font-semibold text-[#916D7A]">Aftercare Instructions</h2>
                <p class="text-sm text-[#4A2C35]"><?php echo nl2br($data['AftercareInstructions']); ?></p>
            </div>

            <div>
                <h2 class="text-lg font-semibold text-[#916D7A]">Expected Results</h2>
                <p class="text-sm text-[#4A2C35]"><?php echo nl2br($data['ExpectedResults']); ?></p>
            </div>

            <div>
                <h2 class="text-lg font-semibold text-[#916D7A]">Side Effects</h2>
                <p class="text-sm text-[#4A2C35]"><?php echo nl2br($data['SideEffects']); ?></p>
            </div>
        </div>

        <div class="mt-6 flex justify-center gap-5">
            <a href="treatment.php" class="px-6 py-2 bg-[#916D7A] text-white rounded hover:bg-[#6E4B57] transition">Back to Treatments</a>
            <a href="consultation.php" class="px-6 py-2 bg-[#916D7A] text-white rounded hover:bg-[#6E4B57] transition">Book Consultation</a>
        </div>

    </section>

    <?php include('footer.php'); ?>
</body>
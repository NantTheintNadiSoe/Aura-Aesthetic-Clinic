<?php
include('connect.php');
include 'header.php';

$code = $_GET['code'];
$query = "SELECT * FROM recommendation WHERE RecommendationCode = '$code'";
$result = mysqli_query($connect, $query);
$data = mysqli_fetch_assoc($result);

// Treatments
$treatments = array_map('trim', explode(',', $data['RecommendedTreatments']));
$treatmentNamesEscaped = array_map(function ($name) use ($connect) {
    return "'" . mysqli_real_escape_string($connect, $name) . "'";
}, $treatments);
$treatmentNamesString = implode(',', $treatmentNamesEscaped);
$treatmentQuery = mysqli_query($connect, "SELECT * FROM treatment WHERE TreatmentName IN ($treatmentNamesString)");
?>

<body class="bg-[#F7EFEF] text-[#4A2C35] font-sans">
    <?php include 'navbar.php'; ?>

    <div class="max-w-6xl mx-auto px-6 py-10">
        <h1 class="text-3xl font-bold text-center text-[#916D7A] mb-10">Personalized Skin Recommendation</h1>

        <!-- Patient Info -->
        <div class="bg-white border border-[#EBD5DC] p-6 rounded shadow mb-8">
            <h2 class="text-xl font-semibold text-[#916D7A] mb-4">Patient Information</h2>
            <p><strong>Name:</strong> <?= htmlspecialchars($data['Name']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($data['Email']) ?></p>
            <p><strong>Skin Type:</strong> <?= htmlspecialchars($data['SkinType']) ?></p>
            <p><strong>Assessment Code:</strong> <?= htmlspecialchars($data['AssessmentCode']) ?></p>
            <p><strong>Recommendation Date:</strong> <?= htmlspecialchars($data['RecommendationDate']) ?></p>
        </div>

        <!-- Observations -->
        <div class="bg-white border border-[#EBD5DC] p-6 rounded shadow mb-8">
            <h2 class="text-xl font-semibold text-[#916D7A] mb-4">Observations</h2>
            <p><?= nl2br(htmlspecialchars($data['Observations'])) ?></p>
        </div>

        <!-- Recommended Treatments -->
        <section class="mb-12">
            <h2 class="text-2xl font-semibold text-center text-[#916D7A] mb-6">Recommended Treatments</h2>

            <?php if (mysqli_num_rows($treatmentQuery) > 0): ?>
                <div class="flex flex-wrap justify-center gap-6">
                    <?php while ($t = mysqli_fetch_assoc($treatmentQuery)): ?>
                        <div class="w-full sm:w-[300px] bg-white border border-[#EBD5DC] rounded shadow hover:shadow-md transition">
                            <div class="h-48 bg-[#FAF2F5] overflow-hidden rounded-t">
                                <img src="<?= $t['TreatmentImage'] ?>" alt="<?= $t['TreatmentName'] ?>" class="w-full h-full object-cover">
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-lg text-[#916D7A] mb-1"><?= $t['TreatmentName'] ?></h3>
                                <p class="text-sm text-gray-600 mb-2"><?= mb_strimwidth($t['Descriptions'], 0, 60, "...") ?></p>
                                <p class="text-sm font-semibold text-[#4A2C35]">Price: MMK <?= number_format($t['Price']) ?></p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p class="text-center text-gray-500">No treatments recommended.</p>
            <?php endif; ?>
        </section>

        <!-- Skincare Products -->
        <?php if (!empty($data['RecommendedProducts'])): ?>
            <div class="bg-white border border-[#EBD5DC] p-6 rounded shadow mb-8">
                <h2 class="text-xl font-semibold text-[#916D7A] mb-4">Recommended Skincare Products</h2>
                <p><?= nl2br(htmlspecialchars($data['RecommendedProducts'])) ?></p>
            </div>
        <?php endif; ?>

        <!-- Lifestyle Advice -->
        <?php if (!empty($data['LifestyleAdvice'])): ?>
            <div class="bg-white border border-[#EBD5DC] p-6 rounded shadow mb-8">
                <h2 class="text-xl font-semibold text-[#916D7A] mb-4">Lifestyle Advice</h2>
                <p><?= nl2br(htmlspecialchars($data['LifestyleAdvice'])) ?></p>
            </div>
        <?php endif; ?>

        <!-- Follow-up Date -->
        <?php if (!empty($data['FollowUpDate'])): ?>
            <div class="bg-white border border-[#EBD5DC] p-6 rounded shadow mb-8">
                <h2 class="text-xl font-semibold text-[#916D7A] mb-4">Follow-up Appointment</h2>
                <p><strong>Date:</strong> <?= htmlspecialchars($data['FollowUpDate']) ?></p>
            </div>
        <?php endif; ?>
    </div>

    <?php include 'footer.php'; ?>
</body>
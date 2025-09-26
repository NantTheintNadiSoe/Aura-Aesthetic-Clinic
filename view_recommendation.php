<?php
session_start();
include('connect.php');
include 'header.php';

$code = $_GET['code'] ?? null;

if (!$code) {
    echo "<script>alert('Invalid request'); window.location='index.php';</script>";
    exit();
}

// Fetch recommendation
$query = "
    SELECT 
        r.*, 
        sa.Name AS PatientName, 
        sa.Email AS PatientEmail, 
        r.SkinType, 
        r.Name,
        sa.SkinConcern, 
        sa.SkinPhoto,
        sa.AssessmentDate,
        sa.PatientID,
        p.PhoneNumber
    FROM recommendation r
    JOIN skinassessment sa ON r.AssessmentCode = sa.AssessmentCode
    JOIN patientregister p ON sa.PatientID = p.PatientID
    WHERE r.RecommendationCode = '" . mysqli_real_escape_string($connect, $code) . "'
";

$result = mysqli_query($connect, $query);
$data = mysqli_fetch_assoc($result);

// Access Control
$isStaff = isset($_SESSION['sid']) && in_array($_SESSION['position'], ['Admin', 'Dermatologist', 'Aesthetic Doctor']);
$isPatient = isset($_SESSION['pid']);

if (!$data) {
    echo "<script>alert('Recommendation not found'); window.location='index.php';</script>";
    exit();
}

if ($isPatient && $_SESSION['pid'] != $data['PatientID']) {
    echo "<script>alert('Access denied. You can only view your own recommendation.'); window.location='patientdashboard.php';</script>";
    exit();
}

if (!$isStaff && !$isPatient) {
    echo "<script>alert('Access denied. Please login first.'); window.location='patientlogin.php';</script>";
    exit();
}

// Mark as read for patient
if ($isPatient && $data['IsNotified'] == 1) {
    $safeCode = mysqli_real_escape_string($connect, $code);
    mysqli_query($connect, "UPDATE recommendation SET IsNotified = 0 WHERE RecommendationCode = '$safeCode'");
}

// Recommended Treatments
$treatmentQuery = false;
if (!empty($data['RecommendedTreatments'])) {
    $treatments = array_map('trim', explode(',', $data['RecommendedTreatments']));
    $escaped = array_map(function ($t) use ($connect) {
        return "'" . mysqli_real_escape_string($connect, $t) . "'";
    }, $treatments);
    $treatmentNames = implode(',', $escaped);
    $treatmentQuery = mysqli_query($connect, "SELECT * FROM treatment WHERE TreatmentName IN ($treatmentNames)");
}
?>

<body class="bg-[#F7EFEF] text-[#4A2C35] font-sans">
    <?php include 'navbar.php'; ?>

    <div class="max-w-6xl mx-auto px-6 py-10">
        <h1 class="text-3xl font-bold text-center text-[#916D7A] mb-10">Personalized Skin Recommendation</h1>

        <!-- Patient Info -->
        <div class="bg-white border border-[#EBD5DC] p-6 rounded shadow mb-8">
            <h2 class="text-xl font-semibold text-[#916D7A] mb-4">Patient Information</h2>
            <p><strong>Name:</strong> <?= htmlspecialchars($data['PatientName']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($data['PatientEmail']) ?></p>
            <p><strong>Phone:</strong> <?= htmlspecialchars($data['PhoneNumber']) ?></p>
            <p><strong>Skin Type:</strong> <?= htmlspecialchars($data['SkinType']) ?></p>
            <p><strong>Skin Concerns:</strong> <?= htmlspecialchars($data['SkinConcern']) ?></p>
            <p><strong>Assessment Date:</strong> <?= htmlspecialchars($data['AssessmentDate']) ?></p>
            <p><strong>Recommendation Date:</strong> <?= htmlspecialchars($data['RecommendationDate']) ?></p>
            <p><strong>Recommended By (Staff):</strong> <?= htmlspecialchars($data['Name']) ?></p>
        </div>

        <!-- Skin Photo -->
        <?php if (!empty($data['SkinPhoto'])): ?>
            <div class="mb-12 text-center">
                <h2 class="text-xl font-semibold text-[#916D7A] mb-4">Your Skin Photo</h2>
                <div class="inline-block border border-[#EBD5DC] rounded-lg shadow-lg overflow-hidden">
                    <img src="<?= htmlspecialchars($data['SkinPhoto']) ?>" alt="Skin Photo"
                        class="max-w-full w-[400px] sm:w-[500px] md:w-[600px] object-cover rounded" />
                </div>
            </div>
        <?php endif; ?>

        <!-- Recommended Treatments -->
        <section class="mb-12">
            <h2 class="text-2xl font-semibold text-center text-[#916D7A] mb-6">Recommended Treatments</h2>
            <?php if ($treatmentQuery && mysqli_num_rows($treatmentQuery) > 0): ?>
                <div class="grid gap-6 grid-cols-[repeat(auto-fit,minmax(250px,1fr))]">
                    <?php while ($t = mysqli_fetch_assoc($treatmentQuery)): ?>
                        <div class="bg-white border border-[#EBD5DC] rounded shadow hover:shadow-md transition">
                            <div style="max-width: 100%; overflow: auto; text-align: center;">
                                <img
                                    src="<?= htmlspecialchars($t['TreatmentImage']) ?>" alt="<?= htmlspecialchars($t['TreatmentName']) ?>"
                                    style="max-width: 100%; height: auto; display: block; margin: 0 auto; border: 1px solid #ccc; border-radius: 8px;" />
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-lg text-[#916D7A] mb-1"><?= htmlspecialchars($t['TreatmentName']) ?></h3>
                                <p class="text-sm text-gray-600 mb-2"><?= htmlspecialchars(mb_strimwidth($t['Descriptions'], 0, 60, "...")) ?></p>
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

        <!-- Observations -->
        <div class="bg-white border border-[#EBD5DC] p-6 rounded shadow mb-8">
            <h2 class="text-xl font-semibold text-[#916D7A] mb-4">Observations</h2>
            <p><?= nl2br(htmlspecialchars($data['Observations'])) ?></p>
        </div>

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
    <?php if ($isPatient): ?>
        <div class="text-center mt-8">
            <a href="patientdashboard.php" class="inline-block px-6 py-2 bg-[#916D7A] text-white font-semibold rounded hover:bg-[#7e5a68] transition">
                ← Back to Dashboard
            </a>
        </div>
    <?php endif; ?>

    <?php include 'footer.php'; ?>
</body>

</html>
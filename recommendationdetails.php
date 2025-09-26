<?php
session_start();
include('connect.php');

// Check login
if (!isset($_SESSION['sid'])) {
    echo "<script>alert('Access denied! Please log in.');</script>";
    echo "<script>window.location='stafflogin.php';</script>";
    exit();
}

// Get recommendation code
if (!isset($_GET['code'])) {
    echo "<script>alert('Recommendation code not found.'); window.location='recommendation.php';</script>";
    exit();
}

$code = $_GET['code'];
$query = mysqli_query($connect, "SELECT * FROM recommendation WHERE RecommendationCode = '$code'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "<script>alert('No recommendation found.'); window.location='recommendation.php';</script>";
    exit();
}

// Send recommendation to patient
if (isset($_POST['notify'])) {
    mysqli_query($connect, "UPDATE recommendation SET IsNotified = 1, Status = 'Sent' WHERE RecommendationCode = '$code'");
    echo "<script>alert('Recommendation sent to patient.'); window.location='recommendation.php';</script>";
    exit();
}
?>

<?php include 'header.php'; ?>

<body class="bg-[#F7EFEF] text-[#4A2C35] font-sans">
    <?php include 'navbar.php'; ?>

    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow rounded border border-[#EBD5DC] mb-10">
        <h2 class="text-2xl font-bold text-center text-[#916D7A] mb-6">Recommendation Details</h2>

        <div class="space-y-4">
            <p><strong>Recommendation Code:</strong> <?= $data['RecommendationCode'] ?></p>
            <p><strong>Assessment Code:</strong> <?= $data['AssessmentCode'] ?></p>
            <p><strong>Date:</strong> <?= $data['RecommendationDate'] ?></p>
            <p><strong>Skin Type:</strong> <?= $data['SkinType'] ?></p>
            <p><strong>Observations:</strong><br><?= nl2br($data['Observations']) ?></p>
            <p><strong>Treatments:</strong><br><?= nl2br($data['RecommendedTreatments']) ?></p>
            <p><strong>Products:</strong><br><?= nl2br($data['RecommendedProducts']) ?></p>
            <p><strong>Lifestyle Advice:</strong><br><?= nl2br($data['LifestyleAdvice']) ?></p>
            <p><strong>Follow-Up Date:</strong> <?= $data['FollowUpDate'] ?: 'None' ?></p>
            <p><strong>Status:</strong> <?= $data['Status'] ?></p>
        </div>

        <div class="mt-6 flex flex-col items-center space-y-4">
            <?php if ($data['IsNotified'] == 0): ?>
                <form method="post">
                    <button type="submit" name="notify" class="px-6 py-2 bg-[#916D7A] text-white rounded hover:bg-[#6E4B57] transition font-semibold">
                        Send to Patient
                    </button>
                </form>
            <?php else: ?>
                <div class="text-green-600 font-semibold">
                    Recommendation has been sent to the patient.
                </div>
            <?php endif; ?>

            <!-- <a href="recommendation.php" class="inline-block px-6 py-2 bg-gray-300 text-[#4A2C35] rounded hover:bg-gray-400 transition font-medium">
                ← Back to Recommendations
            </a> -->
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
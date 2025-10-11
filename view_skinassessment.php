<?php
session_start();
include('connect.php');
if (!isset($_SESSION['sid']) || !isset($_SESSION['position'])) {
    echo "<script>alert('Access denied! Please log in as staff.'); window.location='login.php';</script>";
    exit();
}
if (!isset($_GET['code'])) {
    echo "<script>alert('No assessment selected.'); window.location='skinassessmentlist.php';</script>";
    exit();
}
$code = mysqli_real_escape_string($connect, $_GET['code']);
$query = mysqli_query($connect, "SELECT sa.*, p.Name AS PatientName, p.DateofBirth, p.Gender FROM skinassessment sa LEFT JOIN patientregister p ON sa.PatientID = p.PatientID WHERE sa.AssessmentCode='$code'");
if (!$query || mysqli_num_rows($query) == 0) {
    echo "<script>alert('Skin assessment not found.'); window.location='skinassessmentlist.php';</script>";
    exit();
}
$a = mysqli_fetch_assoc($query);
include('header.php');
include('navbar.php');
?>

<body class="bg-[#F7EFEF] text-[#4A2C35] font-sans">
    <div class="max-w-2xl mx-auto mt-10 px-4 mb-16 bg-white rounded shadow-md border border-[#EBD5DC]">
        <h1 class="text-2xl font-bold text-[#916D7A] mb-6">Skin Assessment Details</h1>
        <div class="mb-4"><span class="font-semibold">Patient Name:</span> <?= htmlspecialchars($a['PatientName']) ?></div>
        <div class="mb-4"><span class="font-semibold">Date of Birth :</span> <?= htmlspecialchars($a['DateofBirth']) ?></div>
        <div class="mb-4"><span class="font-semibold">Gender:</span> <?= htmlspecialchars($a['Gender']) ?></div>
        <div class="mb-4"><span class="font-semibold">Assessment Date:</span> <?= htmlspecialchars($a['AssessmentDate']) ?></div>
        <div class="mb-4"><span class="font-semibold">Skin Concern:</span> <?= htmlspecialchars($a['SkinConcern']) ?></div>
        <div class="mb-4"><span class="font-semibold">Skin Condition:</span> <?= htmlspecialchars($a['SkinCondition']) ?></div>
        <div class="mb-4"><span class="font-semibold">Status:</span> <?= htmlspecialchars($a['Status']) ?></div>
        <div class="mt-8 flex justify-end">
            <a href="recommendation.php?assessment=<?= urlencode($a['AssessmentCode']) ?>" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-800 font-semibold">Write Recommendation</a>
        </div>
    </div>
</body>
<?php include('footer.php'); ?>
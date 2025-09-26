<?php
session_start();
include('connect.php');
include('AutoIDFunction.php');

// Access control
if (!isset($_SESSION['sid']) || !in_array($_SESSION['position'], ['Admin', 'Dermatologist', 'Aesthetic Doctor'])) {
    echo "<script>alert('Access denied! Please log in as an authorized staff.');</script>";
    echo "<script>window.location='stafflogin.php';</script>";
    exit();
}

$recommendationCode = AutoID("recommendation", "RecommendationCode", "R_", 6);

// Handle form submission
if (isset($_POST['btnsubmit'])) {
    $assessmentCode = $_POST['assessmentcode'];
    $staffID = $_SESSION['sid'];
    $name = $_SESSION['sname'];
    $username = $_SESSION['username'];
    $email = $_SESSION['semail'];
    $date = $_POST['date'];
    $skin_type = $_POST['skin_type'];
    $observations = $_POST['observations'];
    $treatments = !empty($_POST['recommended_treatments']) ? implode(", ", $_POST['recommended_treatments']) : '';
    $products = !empty($_POST['products']) ? trim($_POST['products']) : '';
    $advice = !empty($_POST['advice']) ? trim($_POST['advice']) : '';
    $followup = isset($_POST['no_followup']) ? null : $_POST['followup'];

    $insert = "INSERT INTO recommendation 
        (RecommendationCode, AssessmentCode, StaffID, Name, UserName, Email, RecommendationDate, SkinType, Observations, RecommendedTreatments, RecommendedProducts, LifestyleAdvice, FollowUpDate, IsNotified, Status)
        VALUES 
        ('$recommendationCode','$assessmentCode', '$staffID', '$name', '$username', '$email', '$date', '$skin_type', '$observations', '$treatments', '$products', '$advice', " .
        ($followup ? "'$followup'" : "NULL") . ", 0, 'Pending')";

    $query = mysqli_query($connect, $insert);

    if ($query) {
        echo "<script>
            alert('Recommendation submitted successfully!');
            window.location.href = 'recommendationdetails.php?code=$recommendationCode';
        </script>";
        exit();
    } else {
        echo "<script>alert('Error occurred while submitting: " . mysqli_error($connect) . "');</script>";
    }
}
?>

<?php include 'header.php'; ?>

<body class="bg-[#F7EFEF] text-[#4A2C35] font-sans">
    <?php include 'navbar.php'; ?>

    <div class="max-w-3xl mx-auto mt-10 p-6 mb-20 bg-white rounded shadow border border-[#EBD5DC]">
        <h2 class="text-2xl font-bold text-[#916D7A] mb-6 text-center">Write Recommendation</h2>

        <form action="recommendation.php" method="POST">
            <div class="mb-4">
                <label class="font-medium block mb-1">Recommendation Code</label>
                <input type="text" name="RecommendationCode" value="<?php echo $recommendationCode; ?>" readonly class="w-full px-4 py-2 border border-[#EBD5DC] rounded bg-gray-100">
            </div>

            <div class="mb-4">
                <label class="font-medium block mb-1">Assessment Code</label>
                <select name="assessmentcode" required class="w-full px-4 py-2 border border-[#EBD5DC] rounded">
                    <option>Select Assessment Code</option>
                    <?php
                    $select = "SELECT * FROM skinassessment WHERE AssessmentCode NOT IN (SELECT AssessmentCode FROM recommendation)";
                    $query = mysqli_query($connect, $select);
                    while ($fetch = mysqli_fetch_array($query)) {
                        $acode = $fetch['AssessmentCode'];
                        echo "<option value='$acode'>$acode</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-4">
                <label class="font-medium block mb-1">Name</label>
                <input type="text" value="<?= htmlspecialchars($_SESSION['sname']) ?>" readonly class="w-full px-4 py-2 border border-[#EBD5DC] bg-gray-100 rounded">
            </div>
            <div class="mb-4">
                <label class="font-medium block mb-1">Username</label>
                <input type="text" value="<?= htmlspecialchars($_SESSION['username']) ?>" readonly class="w-full px-4 py-2 border border-[#EBD5DC] bg-gray-100 rounded">
            </div>
            <div class="mb-4">
                <label class="font-medium block mb-1">Email</label>
                <input type="email" value="<?= htmlspecialchars($_SESSION['semail']) ?>" readonly class="w-full px-4 py-2 border border-[#EBD5DC] bg-gray-100 rounded">
            </div>

            <div class="mb-4">
                <label class="font-medium block mb-1">Recommendation Date</label>
                <input type="date" name="date" required class="w-full px-4 py-2 border border-[#EBD5DC] rounded">
            </div>

            <div class="mb-4">
                <label class="font-medium block mb-1">Skin Type</label>
                <select name="skin_type" required class="w-full px-4 py-2 border border-[#EBD5DC] rounded">
                    <option value="" disabled selected>Select skin type</option>
                    <option value="Oily">Oily</option>
                    <option value="Dry">Dry</option>
                    <option value="Combination">Combination</option>
                    <option value="Sensitive">Sensitive</option>
                    <option value="Normal">Normal</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="font-medium block mb-1">Observations</label>
                <textarea name="observations" rows="4" required class="w-full px-4 py-2 border border-[#EBD5DC] rounded"></textarea>
            </div>

            <div class="mb-4">
                <label class="font-medium block mb-1">Recommended Treatments <span class="text-sm text-gray-500">(optional)</span></label>
                <div class="grid grid-cols-2 gap-2 text-sm">
                    <?php
                    $treatmentQuery = mysqli_query($connect, "SELECT TreatmentName FROM treatment ORDER BY TreatmentName ASC");
                    while ($row = mysqli_fetch_assoc($treatmentQuery)) {
                        $treatmentName = $row['TreatmentName'];
                        echo "<label class='flex items-center'><input type='checkbox' name='recommended_treatments[]' value='$treatmentName' class='mr-2'>$treatmentName</label>";
                    }
                    ?>
                </div>
            </div>

            <div class="mb-4">
                <label class="font-medium block mb-1">Skincare Products or Ingredients <span class="text-sm text-gray-500">(optional)</span></label>
                <textarea name="products" rows="2" class="w-full px-4 py-2 border border-[#EBD5DC] rounded"></textarea>
            </div>

            <div class="mb-4">
                <label class="font-medium block mb-1">Lifestyle Advice</label>
                <textarea name="advice" rows="2" class="w-full px-4 py-2 border border-[#EBD5DC] rounded"></textarea>
            </div>

            <div class="mb-4">
                <label class="font-medium block mb-1">Follow-up Date</label>
                <input type="date" name="followup" id="followup_date" class="w-full px-4 py-2 border border-[#EBD5DC] rounded">
                <label class="flex items-center mt-2 text-sm text-gray-600">
                    <input type="checkbox" name="no_followup" id="no_followup" class="mr-2" onclick="toggleFollowup()">
                    No follow-up needed
                </label>
            </div>

            <script>
                function toggleFollowup() {
                    const checkbox = document.getElementById('no_followup');
                    const dateInput = document.getElementById('followup_date');
                    dateInput.disabled = checkbox.checked;
                    if (checkbox.checked) {
                        dateInput.value = '';
                    }
                }
            </script>

            <div class="text-center">
                <button type="submit" name="btnsubmit" class="px-6 py-2 bg-[#916D7A] text-white rounded hover:bg-[#6E4B57] transition font-semibold">
                    Save Recommendation
                </button>
            </div>
        </form>
    </div>

    <?php include 'footer.php'; ?>
</body>
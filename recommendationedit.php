<?php
session_start();
include('connect.php');
include('header.php');

if (!isset($_GET['code'])) {
    echo "<p class='text-center mt-10 text-red-600 font-semibold'>No recommendation selected for edit.</p>";
    exit();
}

$recommendationCode = $_GET['code'];

// Handle update
if (isset($_POST['btnupdate'])) {
    $skin_type = $_POST['skin_type'];
    $observations = $_POST['observations'];
    $treatments = $_POST['recommended_treatments'];
    $products = $_POST['products'];
    $advice = $_POST['advice'];
    $followup = $_POST['followup'];
    $status = $_POST['status'];


    $update = "UPDATE recommendation SET SkinType='$skin_type', Observations='$observations', RecommendedTreatments='$treatments', RecommendedProducts='$products', LifestyleAdvice='$advice', FollowUpDate='$followup', Status='$status' WHERE RecommendationCode='$recommendationCode'";
    $query = mysqli_query($connect, $update);
    if ($query) {
        echo "<script>alert('Recommendation updated successfully!');window.location='recommendationlist.php';</script>";
        exit();
    } else {
        echo "<p class='text-center mt-10 text-red-600 font-semibold'>Update failed.</p>";
    }
}

// Fetch recommendation data
$query = "SELECT * FROM recommendation WHERE RecommendationCode = '$recommendationCode'";
$result = mysqli_query($connect, $query);
if (mysqli_num_rows($result) === 0) {
    echo "<p class='text-center mt-10 text-red-600 font-semibold'>Recommendation not found.</p>";
    exit();
}
$data = mysqli_fetch_assoc($result);
?>

<body class="bg-[#F7EFEF] text-[#4A2C35] font-sans">
    <?php include 'navbar.php'; ?>
    <div class="max-w-2xl mx-auto bg-white mt-10 p-8 rounded shadow-md border border-[#EBD5DC] mb-16">
        <h1 class="text-2xl font-bold text-[#916D7A] mb-6">Edit Recommendation</h1>
        <form action="" method="POST" class="space-y-4">
            <div>
                <label class="block font-medium mb-1">Skin Type</label>
                <input type="text" name="skin_type" value="<?php echo htmlspecialchars($data['SkinType']); ?>" class="w-full px-4 py-2 border rounded" />
            </div>
            <div>
                <label class="block font-medium mb-1">Observations</label>
                <textarea name="observations" class="w-full px-4 py-2 border rounded"><?php echo htmlspecialchars($data['Observations']); ?></textarea>
            </div>
            <div>
                <label class="block font-medium mb-1">Recommended Treatments</label>
                <input type="text" name="recommended_treatments" value="<?php echo htmlspecialchars($data['RecommendedTreatments']); ?>" class="w-full px-4 py-2 border rounded" />
            </div>
            <div>
                <label class="block font-medium mb-1">Recommended Products</label>
                <input type="text" name="products" value="<?php echo htmlspecialchars($data['RecommendedProducts']); ?>" class="w-full px-4 py-2 border rounded" />
            </div>
            <div>
                <label class="block font-medium mb-1">Lifestyle Advice</label>
                <textarea name="advice" class="w-full px-4 py-2 border rounded"><?php echo htmlspecialchars($data['LifestyleAdvice']); ?></textarea>
            </div>
            <div>
                <label class="block font-medium mb-1">Follow Up Date</label>
                <input type="date" name="followup" value="<?php echo htmlspecialchars($data['FollowUpDate']); ?>" class="w-full px-4 py-2 border rounded" />
            </div>
            <div>
                <label class="block font-medium mb-1">Status</label>
                <select name="status" class="w-full px-4 py-2 border rounded">
                    <option value="Pending" <?php if ($data['Status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                    <option value="Completed" <?php if ($data['Status'] == 'Completed') echo 'selected'; ?>>Completed</option>
                </select>
            </div>
            <button type="submit" name="btnupdate" class="px-6 py-2 bg-[#916D7A] text-white rounded hover:bg-[#6E4B57]">Update Recommendation</button>
        </form>
    </div>
</body>
<?php include 'footer.php'; ?>
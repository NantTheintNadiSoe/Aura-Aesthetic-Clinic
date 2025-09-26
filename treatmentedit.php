<?php
include('connect.php');
include('header.php');

if (!isset($_GET['code'])) {
    echo "<p class='text-center mt-10 text-red-600 font-semibold'>No treatment selected for edit.</p>";
    exit();
}

$treatmentCode = $_GET['code'];

// Handle update
if (isset($_POST['btnupdate'])) {
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
    $status = $_POST['status'];
    $modified_date = date('Y-m-d H:i:s');

    // Handle image upload (optional)
    if (isset($_FILES['fileimage']) && $_FILES['fileimage']['name'] != '') {
        $img1 = $_FILES['fileimage']['name'];
        $folder = "UploadedImage/";
        $treatmentImage = $folder . "_" . $img1;
        $copy = copy($_FILES['fileimage']['tmp_name'], $treatmentImage);
        if (!$copy) {
            echo "<p>Cannot upload Treatment Image</p>";
            exit();
        }
        $img_sql = ", TreatmentImage='$treatmentImage'";
    } else {
        $img_sql = '';
    }

    $update = "UPDATE treatment SET TreatmentName='$treatment_name', Category='$category', Price='$price', Duration='$duration', Descriptions='$description', Sessions='$sessions', RecoveryTime='$recovery', DurationOfEffect='$duration_effect', Discount='$discount', Prerequisites='$prerequisites', Contraindications='$contraindications', AftercareInstructions='$aftercare', ExpectedResults='$expected_results', SideEffects='$side_effects', Status='$status', ModifiedDate='$modified_date' $img_sql WHERE TreatmentCode='$treatmentCode'";
    $query = mysqli_query($connect, $update);
    if ($query) {
        echo "<script>alert('Treatment updated successfully!');window.location='treatmentlist.php';</script>";
        exit();
    } else {
        echo "<p class='text-center mt-10 text-red-600 font-semibold'>Update failed.</p>";
    }
}

// Fetch treatment data
$query = "SELECT * FROM treatment WHERE TreatmentCode = '$treatmentCode'";
$result = mysqli_query($connect, $query);
if (mysqli_num_rows($result) === 0) {
    echo "<p class='text-center mt-10 text-red-600 font-semibold'>Treatment not found.</p>";
    exit();
}
$data = mysqli_fetch_assoc($result);
?>

<body class="bg-[#F7EFEF] text-[#4A2C35] font-sans">
    <?php include 'navbar.php'; ?>
    <div class="max-w-2xl mx-auto bg-white mt-10 p-8 rounded shadow-md border border-[#EBD5DC] mb-16">
        <h1 class="text-2xl font-bold text-[#916D7A] mb-6">Edit Treatment</h1>
        <form action="" method="POST" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label class="block font-medium mb-1">Treatment Name</label>
                <input type="text" name="treatment_name" value="<?php echo htmlspecialchars($data['TreatmentName']); ?>" required class="w-full px-4 py-2 border rounded" />
            </div>
            <div>
                <label class="block font-medium mb-1">Category</label>
                <input type="text" name="category" value="<?php echo htmlspecialchars($data['Category']); ?>" required class="w-full px-4 py-2 border rounded" />
            </div>
            <div>
                <label class="block font-medium mb-1">Price</label>
                <input type="number" name="price" value="<?php echo htmlspecialchars($data['Price']); ?>" required class="w-full px-4 py-2 border rounded" />
            </div>
            <div>
                <label class="block font-medium mb-1">Duration</label>
                <input type="text" name="duration" value="<?php echo htmlspecialchars($data['Duration']); ?>" class="w-full px-4 py-2 border rounded" />
            </div>
            <div>
                <label class="block font-medium mb-1">Description</label>
                <textarea name="description" class="w-full px-4 py-2 border rounded"><?php echo htmlspecialchars($data['Descriptions']); ?></textarea>
            </div>
            <div>
                <label class="block font-medium mb-1">Sessions</label>
                <input type="text" name="sessions" value="<?php echo htmlspecialchars($data['Sessions']); ?>" class="w-full px-4 py-2 border rounded" />
            </div>
            <div>
                <label class="block font-medium mb-1">Recovery Time</label>
                <input type="text" name="recovery" value="<?php echo htmlspecialchars($data['RecoveryTime']); ?>" class="w-full px-4 py-2 border rounded" />
            </div>
            <div>
                <label class="block font-medium mb-1">Duration of Effect</label>
                <input type="text" name="duration_effect" value="<?php echo htmlspecialchars($data['DurationOfEffect']); ?>" class="w-full px-4 py-2 border rounded" />
            </div>
            <div>
                <label class="block font-medium mb-1">Discount (%)</label>
                <input type="number" name="discount" value="<?php echo htmlspecialchars($data['Discount']); ?>" class="w-full px-4 py-2 border rounded" />
            </div>
            <div>
                <label class="block font-medium mb-1">Prerequisites</label>
                <textarea name="prerequisites" class="w-full px-4 py-2 border rounded"><?php echo htmlspecialchars($data['Prerequisites']); ?></textarea>
            </div>
            <div>
                <label class="block font-medium mb-1">Contraindications</label>
                <textarea name="contraindications" class="w-full px-4 py-2 border rounded"><?php echo htmlspecialchars($data['Contraindications']); ?></textarea>
            </div>
            <div>
                <label class="block font-medium mb-1">Aftercare Instructions</label>
                <textarea name="aftercare" class="w-full px-4 py-2 border rounded"><?php echo htmlspecialchars($data['AftercareInstructions']); ?></textarea>
            </div>
            <div>
                <label class="block font-medium mb-1">Expected Results</label>
                <textarea name="expected_results" class="w-full px-4 py-2 border rounded"><?php echo htmlspecialchars($data['ExpectedResults']); ?></textarea>
            </div>
            <div>
                <label class="block font-medium mb-1">Side Effects</label>
                <textarea name="side_effects" class="w-full px-4 py-2 border rounded"><?php echo htmlspecialchars($data['SideEffects']); ?></textarea>
            </div>
            <div>
                <label class="block font-medium mb-1">Status</label>
                <select name="status" class="w-full px-4 py-2 border rounded">
                    <option value="Active" <?php if ($data['Status'] == 'Active') echo 'selected'; ?>>Active</option>
                    <option value="Inactive" <?php if ($data['Status'] == 'Inactive') echo 'selected'; ?>>Inactive</option>
                </select>
            </div>
            <div>
                <label class="block font-medium mb-1">Treatment Image (optional)</label>
                <input type="file" name="fileimage" class="w-full px-4 py-2 border rounded" />
                <?php if ($data['TreatmentImage']) { ?>
                    <img src="<?php echo $data['TreatmentImage']; ?>" alt="Current Image" class="w-24 h-24 object-cover mt-2 border rounded" />
                <?php } ?>
            </div>
            <button type="submit" name="btnupdate" class="px-6 py-2 bg-[#916D7A] text-white rounded hover:bg-[#6E4B57]">Update Treatment</button>
        </form>
    </div>
</body>
<?php include 'footer.php'; ?>
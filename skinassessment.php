<?php
session_start();
include('connect.php');
include('AutoIDFunction.php');

if (!isset($_SESSION['pid']) && !isset($_SESSION['sid'])) {
    echo "<script>window.alert('Cannot Access Data Please Login!')</script>";
    echo "<script>window.location='login.php'</script>";
    exit();
}
$assessmentCode = AutoID("skinassessment", "AssessmentCode", "SA_", 6);

if (isset($_POST['btnsubmit'])) {
    // $assessmentCode = $_POST['AssessmentCode'];
    $patientID = $_SESSION['pid'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $assessment_date = $_POST['assessment_date'];
    $allergies = $_POST['allergies'];
    $routine = $_POST['routine'];
    $costs = $_POST['costs'];
    $concerns = isset($_POST['concerns']) ? implode(', ', $_POST['concerns']) : '';
    $condition = $_POST['condition'];
    $status = "Active";

    $skin_photo = '';
    if (isset($_FILES['skin_photo'])) {
        $img = $_FILES['skin_photo']['name'];
        $folder = "UploadedImage/";
        $skin_photo = $folder . "_" . $img;

        $copy = copy($_FILES['skin_photo']['tmp_name'], $skin_photo);
        if (!$copy) {
            echo "<p>Cannot upload skin photo.</p>";
            exit();
        }
    }

    $insert = "INSERT INTO skinassessment 
    (AssessmentCode, PatientID, Name, Email, PhoneNumber, DateOfBirth, Gender, AssessmentDate, Allergies, SkincareRoutine, SkincareCost, SkinPhoto, SkinConcern, SkinCondition, Status)
    VALUES
    ('$assessmentCode', '$patientID','$name', '$email', '$phone', '$dob', '$gender', '$assessment_date', '$allergies', '$routine', '$costs', ' $skin_photo', '$concerns', '$condition', '$status')";

    $query = mysqli_query($connect, $insert);
    if ($query) {
        echo "<script>alert('Skin assessment submitted successfully!');</script>";
    } else {
        echo "<script>alert('Error occurred while submitting.');</script>";
    }
}
?>


<?php include 'header.php'; ?>

<body class="bg-[#F7EFEF] text-[#4A2C35] font-sans">
    <?php include 'navbar.php'; ?>

    <!-- Page Title -->
    <div class="text-center py-8 sm:py-10 px-4">
        <h1 class="text-2xl sm:text-3xl font-bold text-[#916D7A]">Online Skin Assessment</h1>
    </div>

    <!-- Form Container -->
    <div class="max-w-4xl mx-auto bg-white p-4 sm:p-8 rounded-lg shadow-md border border-[#EBD5DC] mb-10 sm:mb-20">
        <form action="skinassessment.php?code=<?php echo $assessmentCode; ?>" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <input type="hidden" name="AssessmentCode" value="<?php echo $assessmentCode; ?>">

            <!-- Left Column: Personal Information -->
            <div class="space-y-4 lg:space-y-6">
                <!-- Name -->
                <div>
                    <label class="block font-medium mb-1 text-sm sm:text-base">Name</label>
                    <input type="text" name="name"
                        value="<?php
                                if (isset($_SESSION['pid'])) {
                                    echo $_SESSION['pname'];
                                } else {
                                    echo ''; // 
                                }
                                ?>"
                        class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded bg-white focus:outline-none focus:ring-2 focus:ring-[#916D7A] text-sm sm:text-base"
                        required />
                </div>

                <!-- Email -->
                <div>
                    <label class="block font-medium mb-1 text-sm sm:text-base">Email</label>
                    <input type="email" name="email"
                        value="<?php
                                if (isset($_SESSION['pid'])) {
                                    echo $_SESSION['pemail'];
                                } else {
                                    echo '';
                                }
                                ?>"
                        class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded bg-white focus:outline-none focus:ring-2 focus:ring-[#916D7A] text-sm sm:text-base"
                        required />
                </div>

                <!-- Phone -->
                <div>
                    <label class="block font-medium mb-1 text-sm sm:text-base">Phone Number</label>
                    <input type="text" name="phone"
                        value="<?php
                                if (isset($_SESSION['pid'])) {
                                    echo $_SESSION['pphone'];
                                } else {
                                    echo '';
                                }
                                ?>"
                        class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded bg-white focus:outline-none focus:ring-2 focus:ring-[#916D7A] text-sm sm:text-base"
                        required />
                </div>

                <!-- Date Of Birth -->
                <div>
                    <label class="block font-medium mb-1 text-sm sm:text-base">Date Of Birth</label>
                    <input type="date" name="dob"
                        class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded bg-white focus:outline-none focus:ring-2 focus:ring-[#916D7A] text-sm sm:text-base"
                        required />
                </div>

                <!-- Gender -->
                <div>
                    <label class="block font-medium mb-1 text-sm sm:text-base">Gender</label>
                    <select name="gender"
                        class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded bg-white focus:outline-none focus:ring-2 focus:ring-[#916D7A] text-sm sm:text-base"
                        required>
                        <option value="" disabled selected>Select gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>

        
            <div class="space-y-4 lg:space-y-6">
                <!-- Assessment Date -->
                <div>
                    <label class="block font-medium mb-1 text-sm sm:text-base">Assessment Date</label>
                    <input type="date" name="assessment_date" value="<?php echo date('Y-m-d'); ?>"
                        class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded bg-white focus:outline-none focus:ring-2 focus:ring-[#916D7A] text-sm sm:text-base"
                        required />
                </div>

                <!-- Allergies -->
                <div>
                    <label class="block font-medium mb-1 text-sm sm:text-base">Allergies</label>
                    <input type="text" name="allergies"
                        class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded bg-white focus:outline-none focus:ring-2 focus:ring-[#916D7A] text-sm sm:text-base" />
                </div>

                <!-- Skincare Routine -->
                <div>
                    <label class="block font-medium mb-1 text-sm sm:text-base">Skincare Routine</label>
                    <input type="text" name="routine" required
                        class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded bg-white focus:outline-none focus:ring-2 focus:ring-[#916D7A] text-sm sm:text-base" />
                </div>

                <!-- Skincare Cost -->
                <div>
                    <label class="block font-medium mb-1 text-sm sm:text-base">Spend Skincare Costs (MMK)</label>
                    <input type="text" name="costs" required
                        class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded bg-white focus:outline-none focus:ring-2 focus:ring-[#916D7A] text-sm sm:text-base" />
                </div>
            </div>

         
            <!-- Skin Concerns -->
            <div class="lg:col-span-2">
                <label class="block font-medium mb-1 text-sm sm:text-base">Skin Concern</label>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-2 text-sm" required>
                    <?php
                    $concerns = ['Rough Skin', 'Oiliness', 'Dryness', 'Sun damage', 'Dark eye circles', 'Redness', 'Acne', 'Wrinkles', 'Dehydration', 'Other'];
                    foreach ($concerns as $c) {
                        echo "<label class='flex items-center'><input type='checkbox' name='concerns[]' value='$c' class='mr-2'>$c</label>";
                    }
                    ?>
                </div>
            </div>

            <!-- Skin Condition -->
            <div class="lg:col-span-2">
                <label class="block font-medium mb-1 text-sm sm:text-base">Skin Condition</label>
                <textarea name="condition" rows="4"
                    class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded bg-white focus:outline-none focus:ring-2 focus:ring-[#916D7A] text-sm sm:text-base resize-vertical"
                    required></textarea>
            </div>

            <!-- Skin Photo -->
            <div class="lg:col-span-2">
                <label class="block font-medium mb-1 text-sm sm:text-base">Skin Photo</label>
                <input type="file" name="skin_photo" accept="image/*" required
                    class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded bg-white focus:outline-none focus:ring-2 focus:ring-[#916D7A] text-sm sm:text-base file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-[#916D7A] file:text-white hover:file:bg-[#6E4B57]" />
            </div>

            <!-- Submit -->
            <div class="lg:col-span-2 text-center pt-4 sm:pt-6">
                <button type="submit" name="btnsubmit"
                    class="w-full sm:w-auto px-6 py-2 bg-[#916D7A] text-white rounded hover:bg-[#6E4B57] transition font-semibold text-sm sm:text-base">
                    Submit
                </button>
            </div>
        </form>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>
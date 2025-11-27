<?php
session_start();
include('connect.php');
include 'header.php';

if (!isset($_SESSION['pid'])) {
    echo "<script>alert('Please log in to view your profile.'); window.location='patientlogin.php';</script>";
    exit();
}
$patientID = $_SESSION['pid'];

// Handle profile update
$updateMsg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $name = mysqli_real_escape_string($connect, $_POST['name']);
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $phone = mysqli_real_escape_string($connect, $_POST['phone']);
    $dob = mysqli_real_escape_string($connect, $_POST['dob']);
    $gender = mysqli_real_escape_string($connect, $_POST['gender']);
    $address = mysqli_real_escape_string($connect, $_POST['address']);

    $updateQuery = "UPDATE patientregister SET Name='$name', UserName='$username', Email='$email', PhoneNumber='$phone', DateOfBirth='$dob', Gender='$gender', Address='$address' WHERE PatientID='$patientID'";
    if (mysqli_query($connect, $updateQuery)) {
        $updateMsg = '<div class="text-green-600 text-center mb-4">Profile updated successfully!</div>';
    } else {
        $updateMsg = '<div class="text-red-600 text-center mb-4">Failed to update profile. Please try again.</div>';
    }
}


$query = "SELECT Name, UserName, Email, PhoneNumber, DateOfBirth, Gender, Address FROM patientregister WHERE PatientID = '" . mysqli_real_escape_string($connect, $patientID) . "' LIMIT 1";
$result = mysqli_query($connect, $query);
$patient = mysqli_fetch_assoc($result);
?>

<body class="bg-gradient-to-br from-[#f7efef] to-[#e3c3d3] min-h-screen font-sans text-[#4A2C35]">
    <?php include 'navbar.php'; ?>

    <div class="max-w-4xl mx-auto mt-6 lg:mt-10 px-4 sm:px-6 mb-8 lg:mb-12">
        <div class="bg-white rounded-2xl shadow-xl border border-[#EBD5DC] p-6 lg:p-8">
            <h1 class="text-2xl lg:text-3xl font-bold text-[#916D7A] text-center mb-6 lg:mb-8 tracking-wide">My Profile</h1>

            <?php if ($updateMsg) echo $updateMsg; ?>

            <?php if ($patient): ?>
                <form method="POST" autocomplete="off">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
                        <!-- Left Column -->
                        <div class="space-y-4 lg:space-y-6">
                            <div>
                                <label class="block mb-2 font-semibold text-[#916D7A]" for="name">Name</label>
                                <input type="text" id="name" name="name" value="<?= htmlspecialchars($patient['Name']) ?>"
                                    class="w-full px-4 py-3 rounded-lg border border-[#EBD5DC] focus:outline-none focus:ring-2 focus:ring-[#916D7A] focus:border-transparent transition-all" required>
                            </div>

                            <div>
                                <label class="block mb-2 font-semibold text-[#916D7A]" for="username">Username</label>
                                <input type="text" id="username" name="username" value="<?= htmlspecialchars($patient['UserName']) ?>"
                                    class="w-full px-4 py-3 rounded-lg border border-[#EBD5DC] focus:outline-none focus:ring-2 focus:ring-[#916D7A] focus:border-transparent transition-all" required>
                            </div>

                            <div>
                                <label class="block mb-2 font-semibold text-[#916D7A]" for="email">Email</label>
                                <input type="email" id="email" name="email" value="<?= htmlspecialchars($patient['Email']) ?>"
                                    class="w-full px-4 py-3 rounded-lg border border-[#EBD5DC] focus:outline-none focus:ring-2 focus:ring-[#916D7A] focus:border-transparent transition-all" required>
                            </div>

                            <div>
                                <label class="block mb-2 font-semibold text-[#916D7A]" for="phone">Phone</label>
                                <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($patient['PhoneNumber']) ?>"
                                    class="w-full px-4 py-3 rounded-lg border border-[#EBD5DC] focus:outline-none focus:ring-2 focus:ring-[#916D7A] focus:border-transparent transition-all" required>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-4 lg:space-y-6">
                            <div>
                                <label class="block mb-2 font-semibold text-[#916D7A]" for="dob">Date of Birth</label>
                                <input type="date" id="dob" name="dob" value="<?= htmlspecialchars($patient['DateOfBirth']) ?>"
                                    class="w-full px-4 py-3 rounded-lg border border-[#EBD5DC] focus:outline-none focus:ring-2 focus:ring-[#916D7A] focus:border-transparent transition-all" required>
                            </div>

                            <div>
                                <label class="block mb-2 font-semibold text-[#916D7A]" for="gender">Gender</label>
                                <select id="gender" name="gender"
                                    class="w-full px-4 py-3 rounded-lg border border-[#EBD5DC] focus:outline-none focus:ring-2 focus:ring-[#916D7A] focus:border-transparent transition-all" required>
                                    <option value="Male" <?= $patient['Gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                                    <option value="Female" <?= $patient['Gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
                                    <option value="Other" <?= $patient['Gender'] == 'Other' ? 'selected' : '' ?>>Other</option>
                                </select>
                            </div>

                            <div>
                                <label class="block mb-2 font-semibold text-[#916D7A]" for="address">Address</label>
                                <textarea id="address" name="address" rows="3"
                                    class="w-full px-4 py-3 rounded-lg border border-[#EBD5DC] focus:outline-none focus:ring-2 focus:ring-[#916D7A] focus:border-transparent transition-all resize-none" required><?= htmlspecialchars($patient['Address']) ?></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mt-8 lg:mt-10">
                        <button type="submit" name="update_profile"
                            class="px-8 py-3 bg-[#916D7A] text-white rounded-lg shadow-lg hover:bg-[#7e5a68] hover:shadow-xl transition-all duration-300 font-semibold text-lg w-full sm:w-auto text-center">
                            Update Profile
                        </button>
                        <a href="patientdashboard.php"
                            class="px-6 py-3 bg-[#916D7A] text-white rounded-lg hover:bg-[#7e5a68] transition-all duration-300 font-semibold w-full sm:w-auto text-center">
                            Back to Dashboard
                        </a>
                    </div>
                </form>
            <?php else: ?>
                <p class="text-center text-red-600 text-lg">Profile not found.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>
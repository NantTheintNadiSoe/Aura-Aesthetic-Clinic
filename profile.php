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

// Fetch patient info
$query = "SELECT Name, UserName, Email, PhoneNumber, DateOfBirth, Gender, Address FROM patientregister WHERE PatientID = '" . mysqli_real_escape_string($connect, $patientID) . "' LIMIT 1";
$result = mysqli_query($connect, $query);
$patient = mysqli_fetch_assoc($result);
?>

<body style="background: linear-gradient(135deg, #f7efef 0%, #e3c3d3 100%); min-height: 100vh; font-family: 'Segoe UI', sans-serif; color: #4A2C35;">
    <?php include 'navbar.php'; ?>
    <div style="max-width: 600px; margin: 3rem auto 5rem auto; background: #fff; border-radius: 1.5rem; box-shadow: 0 8px 32px rgba(145,109,122,0.12); border: 1px solid #EBD5DC; padding: 2.5rem 2rem;">
        <h1 style="font-size: 2.2rem; font-weight: bold; color: #916D7A; text-align: center; margin-bottom: 2rem; letter-spacing: 1px;">My Profile</h1>
        <?php if ($updateMsg) echo $updateMsg; ?>
        <?php if ($patient): ?>
            <form method="POST" autocomplete="off">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div>
                        <label class="block mb-1 font-semibold" for="name">Name</label>
                        <input type="text" id="name" name="name" value="<?= htmlspecialchars($patient['Name']) ?>" class="w-full px-3 py-2 rounded border border-[#EBD5DC] focus:outline-none focus:ring-2 focus:ring-[#916D7A]" required>
                        <label class="block mt-4 mb-1 font-semibold" for="username">Username</label>
                        <input type="text" id="username" name="username" value="<?= htmlspecialchars($patient['UserName']) ?>" class="w-full px-3 py-2 rounded border border-[#EBD5DC] focus:outline-none focus:ring-2 focus:ring-[#916D7A]" required>
                        <label class="block mt-4 mb-1 font-semibold" for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($patient['Email']) ?>" class="w-full px-3 py-2 rounded border border-[#EBD5DC] focus:outline-none focus:ring-2 focus:ring-[#916D7A]" required>
                        <label class="block mt-4 mb-1 font-semibold" for="phone">Phone</label>
                        <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($patient['PhoneNumber']) ?>" class="w-full px-3 py-2 rounded border border-[#EBD5DC] focus:outline-none focus:ring-2 focus:ring-[#916D7A]" required>
                    </div>
                    <div>
                        <label class="block mb-1 font-semibold" for="dob">Date of Birth</label>
                        <input type="date" id="dob" name="dob" value="<?= htmlspecialchars($patient['DateOfBirth']) ?>" class="w-full px-3 py-2 rounded border border-[#EBD5DC] focus:outline-none focus:ring-2 focus:ring-[#916D7A]" required>
                        <label class="block mt-4 mb-1 font-semibold" for="gender">Gender</label>
                        <select id="gender" name="gender" class="w-full px-3 py-2 rounded border border-[#EBD5DC] focus:outline-none focus:ring-2 focus:ring-[#916D7A]" required>
                            <option value="Male" <?= $patient['Gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                            <option value="Female" <?= $patient['Gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
                            <option value="Other" <?= $patient['Gender'] == 'Other' ? 'selected' : '' ?>>Other</option>
                        </select>
                        <label class="block mt-4 mb-1 font-semibold" for="address">Address</label>
                        <textarea id="address" name="address" rows="3" class="w-full px-3 py-2 rounded border border-[#EBD5DC] focus:outline-none focus:ring-2 focus:ring-[#916D7A]" required><?= htmlspecialchars($patient['Address']) ?></textarea>
                    </div>
                </div>
                <div style="text-align: center; margin-top: 2.5rem;">
                    <button type="submit" name="update_profile" class="px-8 py-2 bg-[#916D7A] text-white rounded-lg shadow hover:bg-[#7e5a68] transition font-semibold text-lg">Update Profile</button>
                </div>
            </form>
            <div style="text-align: center; margin-top: 2rem;">
                <a href="patientdashboard.php" class="inline-block px-6 py-2 bg-[#916D7A] text-white rounded hover:bg-[#7e5a68] transition font-semibold">Back to Dashboard</a>
            </div>
        <?php else: ?>
            <p style="text-align: center; color: #e53e3e;">Profile not found.</p>
        <?php endif; ?>
    </div>
    <?php include 'footer.php'; ?>
</body>

</html>
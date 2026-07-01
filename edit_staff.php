<?php
session_start();
include('connect.php');
include('header.php');

if (!isset($_GET['staff_id'])) {
    echo "<p class='text-center mt-10 text-red-600 font-semibold'>No staff selected for edit.</p>";
    exit();
}

$staffID = $_GET['staff_id'];

// Handle update
if (isset($_POST['btnupdate'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $position = $_POST['position'];
    $experience = $_POST['experience'];
    $qualification = $_POST['qualification'];
    $address = $_POST['address'];

    // Handle profile image upload
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['name'] != '') {
        $img1 = $_FILES['profile_image']['name'];
        $folder = "UploadedImage/";
        $profile_image = $folder . "_" . $img1;
        $copy = copy($_FILES['profile_image']['tmp_name'], $profile_image);
        if (!$copy) {
            echo "<p>Cannot upload Profile Image</p>";
            exit();
        }
        $img_sql = ", ProfileImage='$profile_image'";
    } else {
        $img_sql = '';
    }

    $update = "UPDATE staffregister SET 
        Name='$name',
        UserName='$username',
        Email='$email',
        PhoneNumber='$phone',
        DateOfBirth='$dob',
        Position='$position',
        Experience='$experience',
        Qualification='$qualification',
        Address='$address'
        $img_sql
        WHERE StaffID='$staffID'";

    $query = mysqli_query($connect, $update);
    if ($query) {
        echo "<script>alert('Staff updated successfully!'); window.location='stafflist.php';</script>";
        exit();
    } else {
        echo "<p class='text-center mt-10 text-red-600 font-semibold'>Update failed.</p>";
    }
}

// Fetch staff data
$query = "SELECT * FROM staffregister WHERE StaffID = '$staffID'";
$result = mysqli_query($connect, $query);
if (mysqli_num_rows($result) === 0) {
    echo "<p class='text-center mt-10 text-red-600 font-semibold'>Staff not found.</p>";
    exit();
}
$data = mysqli_fetch_assoc($result);
?>

<body class="bg-[#F7EFEF] text-[#4A2C35] font-sans">
    <?php include 'navbar.php'; ?>
    <div class="max-w-2xl mx-auto bg-white mt-10 p-8 rounded shadow-md border border-[#EBD5DC] mb-16">
        <h1 class="text-2xl font-bold text-[#916D7A] mb-6">Edit Staff</h1>
        <form action="" method="POST" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label class="block font-medium mb-1">Name</label>
                <input type="text" name="name" value="<?= htmlspecialchars($data['Name'] ?? '') ?>" required class="w-full px-4 py-2 border rounded" />
            </div>
            <div>
                <label class="block font-medium mb-1">Username</label>
                <input type="text" name="username" value="<?= htmlspecialchars($data['UserName'] ?? '') ?>" required class="w-full px-4 py-2 border rounded" />
            </div>
            <div>
                <label class="block font-medium mb-1">Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($data['Email'] ?? '') ?>" required class="w-full px-4 py-2 border rounded" />
            </div>
            <div>
                <label class="block font-medium mb-1">Phone Number</label>
                <input type="text" name="phone" value="<?= htmlspecialchars($data['PhoneNumber'] ?? '') ?>" class="w-full px-4 py-2 border rounded" />
            </div>
            <div>
                <label class="block font-medium mb-1">Date of Birth</label>
                <input type="date" name="dob" value="<?= htmlspecialchars($data['DateOfBirth'] ?? '') ?>" class="w-full px-4 py-2 border rounded" />
            </div>
            <div>
                <label class="block font-medium mb-1">Position</label>
                <select name="position" class="w-full px-4 py-2 border rounded">
                    <?php
                    $positions = ['Aesthetic Doctor', 'Dermatologist', 'Nurse', 'Admin', 'Receptionist', 'Clinic Manager'];
                    foreach ($positions as $pos) {
                        $selected = ($data['Position'] == $pos) ? 'selected' : '';
                        echo "<option value='$pos' $selected>$pos</option>";
                    }
                    ?>
                </select>
            </div>
            <div>
                <label class="block font-medium mb-1">Experience</label>
                <input type="text" name="experience" value="<?= htmlspecialchars($data['Experience'] ?? '') ?>" class="w-full px-4 py-2 border rounded" />
            </div>
            <div>
                <label class="block font-medium mb-1">Qualification</label>
                <textarea name="qualification" class="w-full px-4 py-2 border rounded"><?= htmlspecialchars($data['Qualification'] ?? '') ?></textarea>
            </div>
            <div>
                <label class="block font-medium mb-1">Address</label>
                <textarea name="address" class="w-full px-4 py-2 border rounded"><?= htmlspecialchars($data['Address'] ?? '') ?></textarea>
            </div>
            <div>
                <label class="block font-medium mb-1">Profile Image (optional)</label>
                <input type="file" name="profile_image" class="w-full px-4 py-2 border rounded" />
                <?php if ($data['ProfileImage']) { ?>
                    <img src="<?= htmlspecialchars($data['ProfileImage']) ?>" alt="Profile Image" class="w-24 h-24 object-cover mt-2 border rounded" />
                <?php } ?>
            </div>
            <button type="submit" name="btnupdate" class="px-6 py-2 bg-[#916D7A] text-white rounded hover:bg-[#6E4B57]">Update Staff</button>
        </form>
    </div>
</body>
<?php include 'footer.php'; ?>
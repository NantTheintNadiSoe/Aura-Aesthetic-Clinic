<?php
include('connect.php');

if (isset($_POST['btnsubmit'])) {
    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmpassword = trim($_POST['confirmpassword']);
    $phone = trim($_POST['phone']);
    $dob = trim($_POST['dob']);
    $position = trim($_POST['position']);
    $experience = trim($_POST['experience']);
    $qualification = trim($_POST['qualification']);
    $address = trim($_POST['address']);


    if (isset($_FILES['profile_image'])) {
        $img1 = $_FILES['profile_image']['name'];
        $folder = "UploadedImage/";
        $profile_image = $folder . "_" . $img1;

        $copy = copy($_FILES['profile_image']['tmp_name'], $profile_image);

        if (!$copy) {
            echo "<p>Cannot upload Treatment Type Image</p>";
            exit();
        }
    }

    $number = preg_match('@[0-9]@', $password);
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $special = preg_match('@[^\w]@', $password);



    // Check for existing email or username
    $checkEmail = "SELECT * FROM staffregister WHERE Email='$email'";
    $checkUsername = "SELECT * FROM staffregister WHERE UserName='$username'";

    $emailResult = mysqli_query($connect, $checkEmail);
    $usernameResult = mysqli_query($connect, $checkUsername);

    if (mysqli_num_rows($emailResult) > 0) {
        echo "<script>alert('Email already exists!'); window.location='staffregister.php';</script>";
    } elseif (mysqli_num_rows($usernameResult) > 0) {
        echo "<script>alert('Username already exists!'); window.location='staffregister.php';</script>";
    } elseif ($password !== $confirmpassword) {
        echo "<script>alert('Passwords do not match!'); window.location='staffregister.php';</script>";
    } elseif (strlen($password) < 8 || !$number || !$uppercase || !$lowercase || !$special) {
        echo "<script>alert('Password must be at least 8 characters and contain upper, lower, number, and special character.'); window.location='staffregister.php';</script>";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $insert = "INSERT INTO staffregister 
        (Name, ProfileImage, UserName, Email, Password, PhoneNumber, DateOfBirth, Position, Experience, Qualification, Address) 
        VALUES 
        ('$name', '$profile_image', '$username', '$email', '$hashedPassword', '$phone', '$dob', '$position', '$experience', '$qualification', '$address')";

        $query = mysqli_query($connect, $insert);
        if ($query) {
            echo "<script>alert('Registration successful!'); window.location='stafflogin.php';</script>";
        } else {
            echo "<script>alert('Registration failed! Please try again.'); window.location='staffregister.php';</script>";
        }
    }
}
?>

<?php include 'header.php'; ?>

<body class="bg-[#F7EFEF] text-[#4A2C35] font-sans">
    <?php include 'navbar.php'; ?>

    <div class="text-center py-10">
        <h1 class="text-3xl font-bold text-[#916D7A]">Staff Registration</h1>
    </div>

    <div class="max-w-xl mx-auto bg-white p-8 rounded shadow-md border border-[#EBD5DC] mb-20">
        <form action="staffregister.php" method="POST" enctype="multipart/form-data" class="space-y-5" onsubmit="return validatePassword();">

            <div>
                <label class="block font-medium mb-1">Name</label>
                <input type="text" name="name" required class="w-full px-4 py-2 border border-[#EBD5DC] rounded focus:ring-2 focus:ring-[#916D7A]" />
            </div>
            <div>
                <label class="block font-medium mb-1">Profile Image</label>
                <input type="file" name="profile_image" accept="image/*"
                    class="w-full px-4 py-2 border border-[#EBD5DC] rounded bg-white focus:ring-2 focus:ring-[#916D7A]" />
            </div>
            <div>
                <label class="block font-medium mb-1">UserName</label>
                <input type="text" name="username" required class="w-full px-4 py-2 border border-[#EBD5DC] rounded focus:ring-2 focus:ring-[#916D7A]" />
            </div>

            <div>
                <label class="block font-medium mb-1">Email</label>
                <input type="email" name="email" required class="w-full px-4 py-2 border border-[#EBD5DC] rounded focus:ring-2 focus:ring-[#916D7A]" />
            </div>

            <div>
                <label class="block font-medium mb-1">Password</label>
                <input type="password" name="password" id="password" required class="w-full px-4 py-2 border border-[#EBD5DC] rounded focus:ring-2 focus:ring-[#916D7A]" />
            </div>

            <div>
                <label class="block font-medium mb-1">Confirm Password</label>
                <input type="password" name="confirmpassword" id="confirmpassword" required class="w-full px-4 py-2 border border-[#EBD5DC] rounded focus:ring-2 focus:ring-[#916D7A]" />
            </div>

            <div>
                <label class="block font-medium mb-1">Phone Number</label>
                <input type="text" name="phone" required class="w-full px-4 py-2 border border-[#EBD5DC] rounded focus:ring-2 focus:ring-[#916D7A]" />
            </div>

            <div>
                <label class="block font-medium mb-1">Date Of Birth</label>
                <input type="date" name="dob" required class="w-full px-4 py-2 border border-[#EBD5DC] rounded focus:ring-2 focus:ring-[#916D7A]" />
            </div>

            <div>
                <label class="block font-medium mb-1">Position</label>
                <select name="position" required
                    class="w-full px-4 py-2 border border-[#EBD5DC] rounded bg-white focus:outline-none focus:ring-2 focus:ring-[#916D7A]">
                    <option value="" disabled selected>Select Position</option>
                    <option value="Aesthetic Doctor">Aesthetic Doctor</option>
                    <option value="Dermatologist">Dermatologist</option>
                    <option value="Aesthetician">Aesthetician</option>
                    <option value="Admin">Admin</option>
                    <option value="Receptionist">Receptionist</option>
                    <option value="Clinic Manager">Clinic Manager</option>

                </select>
                <!-- <input type="text" name="position" required class="w-full px-4 py-2 border border-[#EBD5DC] rounded focus:ring-2 focus:ring-[#916D7A]" /> -->
            </div>

            <div>
                <label class="block font-medium mb-1">Experience</label>
                <input type="text" name="experience" required class="w-full px-4 py-2 border border-[#EBD5DC] rounded focus:ring-2 focus:ring-[#916D7A]" />
            </div>

            <div>
                <label class="block font-medium mb-1">Qualification</label>
                <input type="text" name="qualification" required class="w-full px-4 py-2 border border-[#EBD5DC] rounded focus:ring-2 focus:ring-[#916D7A]" />
            </div>

            <div>
                <label class="block font-medium mb-1">Address</label>
                <textarea name="address" rows="3" required class="w-full px-4 py-2 border border-[#EBD5DC] rounded focus:ring-2 focus:ring-[#916D7A]"></textarea>
            </div>

            <div class="flex items-center">
                <input type="checkbox" required class="mr-2">
                <label class="text-sm">Accept Terms and Privacy Policy</label>
            </div>

            <div class="text-center pt-4">
                <button type="submit" name="btnsubmit" class="px-6 py-2 bg-[#916D7A] text-white rounded hover:bg-[#6E4B57] transition font-semibold">
                    Register
                </button>
            </div>

            <p class="text-sm text-center text-gray-600 pt-2">Already have an account? <a href="stafflogin.php" class="text-[#916D7A] underline">Login</a></p>

        </form>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        function validatePassword() {
            const pass = document.getElementById('password').value;
            const confirm = document.getElementById('confirmpassword').value;

            if (pass !== confirm) {
                alert("Password and Confirm Password must match.");
                return false;
            }
            return true;
        }
    </script>
</body>

</html>
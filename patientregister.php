<?php
include('connect.php');

if (isset($_POST['btnsubmit'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirmpassword = trim($_POST['confirmpassword']);
    $phone = trim($_POST['phone']);
    $dob = trim($_POST['dob']);
    $gender = trim($_POST['gender']);
    $address = trim($_POST['address']);

    // Password format validation
    $number = preg_match('@[0-9]@', $password);
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $special = preg_match('@[^\w]@', $password);

    // Check for existing email or username
    $checkEmail = "SELECT * FROM staffregister WHERE Email='$email'";
    $checkUsername = "SELECT * FROM staffregister WHERE UserName='$username'";

    $emailResult = mysqli_query($connect, $checkEmail);
    $usernameResult = mysqli_query($connect, $checkUsername);


    // Check if email already exists
    $check = "SELECT * FROM patientregister WHERE Email='$email'";
    $result = mysqli_query($connect, $check);
    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Email already exists!'); window.location='patientregister.php';</script>";
    } elseif ($password !== $confirmpassword) {
        echo "<script>alert('Password and Confirm Password do not match!'); window.location='patientregister.php';</script>";
    } elseif (strlen($password) < 8 || !$number || !$uppercase || !$lowercase || !$special) {
        echo "<script>alert('Password must be at least 8 characters and contain upper, lower, number, and special character.'); window.location='patientregister.php';</script>";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $insert = "INSERT INTO patientregister(Name, UserName, Email, Password, PhoneNumber, DateOfBirth, Gender, Address) 
                   VALUES ('$name', '$username', '$email', '$hashedPassword', '$phone', '$dob', '$gender', '$address')";

        $query = mysqli_query($connect, $insert);
        if ($query) {
            echo "<script>alert('Registration successful!'); window.location='patientlogin.php';</script>";
        } else {
            echo "<script>alert('Registration failed. Please try again.'); window.location='patientregister.php';</script>";
        }
    }
}
?>


<?php include 'header.php'; ?>

<body class="bg-[#F7EFEF] text-[#4A2C35] font-sans">
    <?php include 'navbar.php'; ?>

    <div class="text-center py-10">
        <h1 class="text-3xl font-bold text-[#916D7A]">Patient Registration</h1>
    </div>

    <div class="max-w-xl mx-auto bg-white p-8 rounded shadow-md border border-[#EBD5DC] mb-20">
        <form action="patientregister.php" method="POST" class="space-y-5" enctype="multipart/form-data" onsubmit="return validatePassword();">

            <div>
                <label class="block font-medium mb-1">Name</label>
                <input type="text" name="name" required class="w-full px-4 py-2 border border-[#EBD5DC] rounded focus:ring-2 focus:ring-[#916D7A]" />
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
                <label class="block font-medium mb-1">Phone</label>
                <input type="text" name="phone" class="w-full px-4 py-2 border border-[#EBD5DC] rounded focus:ring-2 focus:ring-[#916D7A]" />
            </div>

            <div>
                <label class="block font-medium mb-1">Date of Birth</label>
                <input type="date" name="dob" class="w-full px-4 py-2 border border-[#EBD5DC] rounded focus:ring-2 focus:ring-[#916D7A]" />
            </div>

            <div>
                <label class="block font-medium mb-1">Gender</label>
                <select name="gender" class="w-full px-4 py-2 border border-[#EBD5DC] rounded bg-white focus:ring-2 focus:ring-[#916D7A]">
                    <option value="" disabled selected>Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>

            <div>
                <label class="block font-medium mb-1">Address</label>
                <textarea name="address" rows="3" class="w-full px-4 py-2 border border-[#EBD5DC] rounded focus:ring-2 focus:ring-[#916D7A]"></textarea>
            </div>

            <div class="text-center pt-4">
                <button type="submit" name="btnsubmit" class="px-6 py-2 bg-[#916D7A] text-white rounded hover:bg-[#6E4B57] transition font-semibold">
                    Register
                </button>
            </div>
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
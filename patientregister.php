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
            echo "<script>alert('Registration successful!'); window.location='login.php';</script>";
        } else {
            echo "<script>alert('Registration failed. Please try again.'); window.location='patientregister.php';</script>";
        }
    }
}
?>


<?php include 'header.php'; ?>

<body class="bg-[#F7EFEF] text-[#4A2C35] font-sans min-h-screen flex flex-col">
    <?php include 'navbar.php'; ?>

    <main class="flex-1 py-6 px-4 sm:px-6 lg:px-8">
        <div class="text-center py-8 sm:py-10">
            <h1 class="text-2xl sm:text-3xl font-bold text-[#916D7A]">Patient Registration</h1>
        </div>

        <div class="max-w-md sm:max-w-lg md:max-w-xl lg:max-w-4xl mx-auto bg-white p-4 sm:p-6 lg:p-8 rounded-lg shadow-md border border-[#EBD5DC] mb-8 sm:mb-12 lg:mb-20">
            <form action="patientregister.php" method="POST" class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-x-6 lg:gap-y-5" enctype="multipart/form-data" onsubmit="return validatePassword();">

                <div>
                    <label class="block font-medium mb-1 text-sm sm:text-base">Name</label>
                    <input type="text" name="name" required class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded focus:ring-2 focus:ring-[#916D7A] focus:border-transparent text-sm sm:text-base" />
                </div>
                <div>
                    <label class="block font-medium mb-1 text-sm sm:text-base">UserName</label>
                    <input type="text" name="username" required class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded focus:ring-2 focus:ring-[#916D7A] focus:border-transparent text-sm sm:text-base" />
                </div>

                <div>
                    <label class="block font-medium mb-1 text-sm sm:text-base">Email</label>
                    <input type="email" name="email" required class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded focus:ring-2 focus:ring-[#916D7A] focus:border-transparent text-sm sm:text-base" />
                </div>

                <div>
                    <label class="block font-medium mb-1 text-sm sm:text-base">Password</label>
                    <input type="password" name="password" id="password" required class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded focus:ring-2 focus:ring-[#916D7A] focus:border-transparent text-sm sm:text-base" />
                </div>

                <div>
                    <label class="block font-medium mb-1 text-sm sm:text-base">Confirm Password</label>
                    <input type="password" name="confirmpassword" id="confirmpassword" required class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded focus:ring-2 focus:ring-[#916D7A] focus:border-transparent text-sm sm:text-base" />
                </div>

                <div>
                    <label class="block font-medium mb-1 text-sm sm:text-base">Phone</label>
                    <input type="text" name="phone" required class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded focus:ring-2 focus:ring-[#916D7A] focus:border-transparent text-sm sm:text-base" />
                </div>

                <div>
                    <label class="block font-medium mb-1 text-sm sm:text-base">Date of Birth</label>
                    <input type="date" name="dob" required class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded focus:ring-2 focus:ring-[#916D7A] focus:border-transparent text-sm sm:text-base" />
                </div>

                <div>
                    <label class="block font-medium mb-1 text-sm sm:text-base">Gender</label>
                    <select name="gender" required class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded bg-white focus:ring-2 focus:ring-[#916D7A] focus:border-transparent text-sm sm:text-base">
                        <option value="" disabled selected>Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>

                <div class="lg:col-span-2">
                    <label class="block font-medium mb-1 text-sm sm:text-base">Address</label>
                    <textarea name="address" required rows="3" class="w-full px-3 sm:px-4 py-2 border border-[#EBD5DC] rounded focus:ring-2 focus:ring-[#916D7A] focus:border-transparent text-sm sm:text-base resize-none"></textarea>
                </div>

                <div class="lg:col-span-2 text-center pt-4">
                    <button type="submit" name="btnsubmit" class="px-4 sm:px-6 py-2 bg-[#916D7A] text-white rounded hover:bg-[#6E4B57] transition font-semibold text-sm sm:text-base w-full">
                        Register
                    </button>
                </div>

                <div class="lg:col-span-2 text-xs sm:text-sm text-center text-gray-600 pt-2">
                    Already have an account? <a href="login.php" class="text-[#916D7A] underline hover:text-[#6E4B57] transition">Login</a>
                </div>

            </form>
        </div>
    </main>

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